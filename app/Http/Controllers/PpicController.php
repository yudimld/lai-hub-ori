<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Opportunity;
use Illuminate\Support\Facades\Session;
use MongoDB\Client as MongoDBClient;
use Illuminate\Support\Facades\DB;
use MongoDB\BSON\ObjectId;
use Carbon\Carbon;

class PpicController extends Controller
{
    
    // Menampilkan halaman data.blade.php
    public function index()
    {
        session(['active_menu' => 'ppic']);
        return view('supplychain.ppic.eticket.data');
    }

    public function showPpicData()
    {
        session(['active_menu' => 'ppic']);
        $opportunities = Opportunity::whereNotNull('status') // Ambil data dengan status
            ->where('status', '!=', 'draft')
            ->get([
                'no_po',
                'status',
                'incoterm',
                'customer',
                'material',
                'nama_barang_asli',
                'nama_barang_jual',
                'qty',
                'uom',
                'alamat_kirim',
                'kemasan',
                'tanggal_tiba',
                'gudang_pengambilan',
                'created_at',
                'products'
            ]);
    
        return response()->json($opportunities);
    }

    public function updateStatusToPreparing(Request $request)
    {
        session(['active_menu' => 'ppic']);
    
        \Log::info($request->all()); // Debug untuk memastikan data diterima
    
        // Validasi data yang diterima
        $validatedData = $request->validate([
            'no_po' => 'required|string',
            'loading_date' => 'required|date',
            'arriving_date' => 'required|date',
            'sales_order_type' => 'required|string',
            'status' => 'required|string',
        ], [
            'no_po.required' => 'No PO is required.',
            'loading_date.required' => 'Loading Date is required.',
            'loading_date.date' => 'Loading Date must be a valid date.',
            'arriving_date.required' => 'Arriving Date is required.',
            'arriving_date.date' => 'Arriving Date must be a valid date.',
            'sales_order_type.required' => 'Sales Order Type is required.',
            'status.required' => 'Status is required.',
        ]);
    
        // Cari data berdasarkan no_po
        $opportunity = Opportunity::where('no_po', $validatedData['no_po'])->first();
    
        if ($opportunity) {
            // Perbarui data opportunity
            $opportunity->update([
                'status' => $validatedData['status'], // Status 'preparing'
                'agree_loading_date' => $validatedData['loading_date'], // Isi dengan loading_date
                'agree_arriving_date' => $validatedData['arriving_date'], // Isi dengan arriving_date
                'sales_order_type' => $validatedData['sales_order_type'], // Isi dengan sales_order_type
            ]);
    
            return response()->json(['message' => 'Status updated to Preparing successfully.']);
        }
    
        return response()->json(['message' => 'Data not found.'], 404);
    }
    

    public function notAcceptReason(Request $request)
    {

        try {
            // Validasi input
            $validatedData = $request->validate([
                'no_po' => 'required|string',
                'reason' => 'required|string',
            ]);
    
            // Cari dokumen berdasarkan no_po
            $opportunity = Opportunity::where('no_po', $validatedData['no_po'])->first();
    
            if (!$opportunity) {
                return response()->json(['message' => 'Opportunity not found.'], 404);
            }
    
            // Update dokumen
            $opportunity->update([
                'reason' => $validatedData['reason'],
                'status' => 'reject',
                'updated_at' => now(), // Gunakan fungsi now() Laravel untuk timestamp
            ]);
    
            return response()->json(['message' => 'Reason submitted and status updated successfully.'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'An error occurred.', 'error' => $e->getMessage()], 500);
        }
    }
    
    public function updateRevisionDate(Request $request)
    {
        // Validasi input
        $request->validate([
            'no_po' => 'required|string',
            'revision_date' => 'required|date',
        ]);

        // Cari dokumen berdasarkan no_po
        $opportunity = Opportunity::where('no_po', $request->no_po)->first();

        if (!$opportunity) {
            return response()->json(['message' => 'Opportunity not found.'], 404);
        }

        // Update revision date
        $opportunity->update([
            'revision_date' => $request->revision_date,
            'updated_at' => now(),
        ]);

        return response()->json(['message' => 'Revision date updated successfully.']);
    }

}
