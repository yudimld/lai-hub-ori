<?php

namespace App\Http\Controllers;

use App\Models\Delivery;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use MongoDB\Client as MongoDBClient;
use Illuminate\Support\Facades\DB;
use MongoDB\BSON\ObjectId;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class DeliveryController extends Controller
{
    // Halaman utama
    public function index()
    {
        session(['active_menu' => 'delivery']);
        return view('supplychain.delivery.spk.spk-delivery');
    }

    // API untuk mendapatkan semua data delivery
    public function getAllDeliveries()
    {
        try {
            // Set sesi untuk menu aktif
            session(['active_menu' => 'salesmarketing']);
    
            // Ambil semua data delivery dari database
            $deliveries = Delivery::orderBy('updated_at', 'desc')->get();
    
            // DEBUG: Pastikan data mentah benar-benar ada
            if ($deliveries->isEmpty()) {
                
                return response()->json(['data' => [], 'message' => 'No deliveries found.'], 200);
            }
    
    
            // Lakukan transformasi data untuk response
            $transformedDeliveries = $deliveries->map(function ($item) {
                $transformedItem = [
                    'id' => $item->id,
                    'po_number' => $item->po_number,
                    'so_number' => $item->so_number,
                    'tanggal_tiba' => $item->tanggal_tiba,
                    'customer' => $item->customer,
                    'material' => $item->material,
                    'nama_barang_asli' => $item->nama_barang_asli,
                    'nama_barang_jual' => $item->nama_barang_jual,
                    'qty' => $item->qty,
                    'uom' => $item->uom,
                    'alamat_kirim' => $item->alamat_kirim,
                    'kemasan' => $item->kemasan,
                    'gudang_pengambilan' => $item->gudang_pengambilan,
                    'status' => ucfirst($item->status),
                    'revision_date' => $item->revision_date ?? null,
                    'reason' => $item->reason_reject ?? null,
                    'reason_reject' => $item->reason ?? null,
                    'delivery_date' => $item->delivery_date ?? null,
                    'arriving_date' => $item->arriving_date ?? null,
                    'file_name' => $item->file_name ?? null,
                    'file_name_delivery' => $item->file_name_delivery ?? null,  // Menambahkan file_name_delivery
                    'file_pendukung_delivery' => $item->file_pendukung_delivery 
                        ? asset('storage/' . $item->file_pendukung_delivery) 
                        : 'No file available',
    
                    'updated_at' => $item->updated_at ? $item->updated_at->format('Y-m-d H:i:s') : null,
                    'created_at' => $item->created_at ? $item->created_at->format('Y-m-d H:i:s') : null,
                ];
    
                return $transformedItem;
            });
    
    
            return response()->json(['data' => $transformedDeliveries], 200);
    
        } catch (\Exception $e) {
            // DEBUG: Log error jika ada masalah
            \Log::error('Error fetching deliveries:', ['error' => $e->getMessage()]);
            return response()->json(['error' => 'Failed to retrieve deliveries. Please try again later.'], 500);
        }
    }
 
    
    // deliver status
    public function updateStatusToDelivery(Request $request)
    {
        $request->validate([
            'po_number' => 'required|string',
            'delivery_date' => 'required|date',
            'arriving_date' => 'required|date|after_or_equal:delivery_date',
        ]);

        $delivery = Delivery::where('po_number', $request->po_number)->first();

        if (!$delivery) {
            return response()->json(['message' => 'Delivery not found.'], 404);
        }

        $delivery->delivery_date = $request->delivery_date;
        $delivery->arriving_date = $request->arriving_date;
        $delivery->status = 'deliver';
        $delivery->save();

        return response()->json(['message' => 'Delivery and arriving dates updated successfully.']);
    }

    // Fungsi untuk memperbarui status menjadi 'close' dengan alasan
    public function closeDelivery(Request $request)
    {
        try {
            // Validasi input
            $request->validate([
                'po_number' => 'required|string', // Validasi nomor PO
                'reason' => 'required|string',    // Validasi alasan
            ]);

            // Cari data berdasarkan po_number
            $delivery = Delivery::where('po_number', $request->po_number)->first();

            if (!$delivery) {
                return response()->json(['message' => 'Delivery data not found.'], 404);
            }

            // Pastikan status saat ini adalah 'delivery'
            if ($delivery->status !== 'delivery') {
                return response()->json(['message' => 'Only deliveries with status "delivery" can be closed.'], 400);
            }

            // Update alasan dan status
            $delivery->update([
                'reason' => $request->reason,
                'status' => 'close',
                'updated_at' => now(), // Perbarui timestamp
            ]);

            return response()->json(['message' => 'Delivery closed successfully.'], 200);
        } catch (\Exception $e) {
            Log::error('Error closing delivery: ' . $e->getMessage());
            return response()->json(['message' => 'An error occurred.', 'error' => $e->getMessage()], 500);
        }
    }

    // Fungsi memperbarui status menjadi revision date 
    public function updateRevision(Request $request, $id)
    {
        try {
            // Validasi input
            $validated = $request->validate([
                'revision_date' => 'required|date',
                'reason_revision' => 'required|string|max:255',
            ]);
    
            // Cari data delivery berdasarkan ID
            $delivery = Delivery::findOrFail($id);
    
            // Update data revision
            $delivery->update([
                'revision_date' => $validated['revision_date'],
                'reason_revision' => $validated['reason_revision'],
                'status' => 'revision',
            ]);
    
            return response()->json(['message' => 'Revision details updated successfully.']);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to update revision details.'], 500);
        }
    }

    // fungsi memperbarui status mdari revision ke open
    public function customerAccept($id)
    {
        try {
            \Log::info('Customer Accept Request Received for PO Number: ' . $id);
    
            $delivery = Delivery::where('po_number', $id)->firstOrFail();
            \Log::info('Delivery Found: ' . $delivery->toJson());
    
            $delivery->update(['status' => 'open']);
    
            return response()->json(['message' => 'Revision accepted successfully. Status has been reopened.']);
        } catch (ModelNotFoundException $e) {
            \Log::error('Delivery data not found for PO Number: ' . $id);
            return response()->json(['message' => 'Delivery data not found.'], 404);
        } catch (\Exception $e) {
            \Log::error('Customer Accept Error: ' . $e->getMessage());
            return response()->json(['message' => 'Failed to accept revision.'], 500);
        }
    }

    // fungsi untuk status reject
    public function rejectDelivery(Request $request, $poNumber)
    {
        try {
            // Validasi input
            $validated = $request->validate([
                'reason' => 'required|string|max:255',
            ]);

            // Cari delivery berdasarkan PO Number
            $delivery = Delivery::where('po_number', $poNumber)->firstOrFail();

            // Perbarui status dan alasan reject
            $delivery->update([
                'status' => 'rejected',
                'reason' => $validated['reason'],
            ]);

            return response()->json(['message' => 'Delivery has been rejected successfully.']);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to reject delivery.'], 500);
        }
    }

    // fungsi status arriving
    public function uploadAttachment(Request $request, $poNumber)
    {
        try {
            \Log::info('Upload started for PO Number: ' . $poNumber);
    
            // Validasi input
            $validated = $request->validate([
                'file' => 'required|file|mimes:pdf,jpg,jpeg,png,docx|max:2048',
            ]);
    
            \Log::info('File validated successfully.');
    
            // Cari delivery berdasarkan PO Number
            $delivery = Delivery::where('po_number', $poNumber)->firstOrFail();
    
            // Simpan file
            $file = $request->file('file');
            $filePath = $file->store('file_arriving', 'public'); // Simpan di direktori 'attachments' (public)
    
            \Log::info('File saved successfully: ' . $filePath);
    
            // Perbarui data delivery dengan path file
            $delivery->update([
                'file_arriving' => $filePath, // Simpan ke kolom file_arriving
                'file_name' => $file->getClientOriginalName(),
                'status' => 'arriving',
            ]);
    
            return response()->json(['message' => 'Attachment uploaded successfully.']);
        } catch (\Exception $e) {
            \Log::error('Error during file upload: ' . $e->getMessage());
            return response()->json(['message' => 'Failed to upload attachment.'], 500);
        }
    }
    
    


    

    
}
