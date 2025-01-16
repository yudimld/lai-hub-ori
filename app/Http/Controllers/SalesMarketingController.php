<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use MongoDB\Client as MongoDBClient;
use Illuminate\Support\Facades\DB;
use MongoDB\BSON\ObjectId;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;


use App\Models\Opportunity;
use App\Models\Delivery;


class SalesMarketingController extends Controller
{
    // Set session dan tampilkan halaman Opportunity
    public function opportunity()
    {
        session(['active_menu' => 'salesmarketing']);
        return view('salesmarketing.csr.opportunity');
    }
    
    // Simpan data JSON ke database (request to ppic)
    public function storePpicRequest(Request $request)
    {
        session(['active_menu' => 'salesmarketing']);
        try {
    
            // Validasi data
            $validatedData = $request->validate([
                'no_po' => 'required|string',
                'incoterm' => 'required|string',
                'customer' => 'required|string',
                'material' => 'required|string',
                'nama_barang_asli' => 'required|string',
                'nama_barang_jual' => 'required|string',
                'qty' => 'required|numeric',
                'uom' => 'required|string',
                'alamat_kirim' => 'required|string',
                'kemasan' => 'required|string',
                'gudang_pengambilan' => 'required|string',
                'tanggal_tiba' => 'required|date',
                'products' => 'required|array|min:1', // Validasi array produk
            ]);
    
            // Hilangkan duplikasi pada array produk
            $validatedData['products'] = array_unique($validatedData['products']);
    
            // Tambahkan status default
            $validatedData['status'] = 'open';
    
    
            // Simpan ke MongoDB
            $opportunity = Opportunity::create($validatedData);
    
    
            return response()->json([
                'message' => 'Data berhasil disimpan!',
                'data' => $opportunity,
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Terjadi kesalahan saat menyimpan data.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    // save to draft
    public function saveToDraft(Request $request)
    {
        session(['active_menu' => 'salesmarketing']);
        try {
            // Validasi data
            $validatedData = $request->validate([
                'no_po' => 'required|string',
                'incoterm' => 'required|string',
                'customer' => 'required|string',
                'material' => 'required|string',
                'nama_barang_asli' => 'required|string',
                'nama_barang_jual' => 'required|string',
                'qty' => 'required|numeric',
                'uom' => 'required|string',
                'alamat_kirim' => 'required|string',
                'kemasan' => 'required|string',
                'gudang_pengambilan' => 'required|string',
                'tanggal_tiba' => 'required|date',
                'products' => 'required|array|min:1',
            ]);
    
            // Simpan data sebagai draft menggunakan model
            $draftOpportunity = Opportunity::saveAsDraft($validatedData);
    
            // Kembalikan respons sukses
            return response()->json([
                'message' => 'Data successfully saved as draft!',
                'data' => $draftOpportunity,
            ], 201);
        } catch (\Exception $e) {
            // Log error
            Log::error('Error saving draft:', ['error' => $e->getMessage()]);
    
            return response()->json([
                'error' => 'Failed to save data as draft.',
                'details' => $e->getMessage(),
            ], 500);
        }
    }
    
    // read data dengan status
    public function getStatusRequestData()
    {
        session(['active_menu' => 'salesmarketing']);
        // Ambil data dari tabel opportunity dengan status 
        $data = Opportunity::whereNotNull('status')
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function ($item) {
                return [
                    'id' => $item->id, // ID atau primary key (jika ada)
                    'no_po' => $item->no_po,
                    'incoterm' => $item->incoterm,
                    'customer' => $item->customer,
                    'material' => $item->material,
                    'nama_barang_asli' => $item->nama_barang_asli,
                    'nama_barang_jual' => $item->nama_barang_jual,
                    'qty' => $item->qty,
                    'uom' => $item->uom,
                    'alamat_kirim' => $item->alamat_kirim,
                    'kemasan' => $item->kemasan,
                    'gudang_pengambilan' => $item->gudang_pengambilan,
                    'tanggal_tiba' => $item->tanggal_tiba,
                    'status' => ucfirst($item->status), // Format status
                    'products' => $item->products ?? [],
                    'reason' => $item->reason ?? 'N/A',
                    'created_at' => $item->created_at->format('Y-m-d'), // Tanggal request
                    'update_at' => $item->updated_at ? $item->updated_at->format('Y-m-d') : 'N/A', // Tanggal response
                ];
            });
    
        return response()->json($data);
    }

    // show modal edit
    public function getOpportunityById($id)
    {
        try {
            $opportunity = Opportunity::findOrFail($id); // Cari data berdasarkan ID
            return response()->json($opportunity); // Kirim data dalam format JSON
        } catch (\Exception $e) {
            return response()->json(['error' => 'Data not found'], 404);
        }
    }

    // edit
    public function updateProducts(Request $request, $id)
    {
        try {
            // Validasi input
            $validated = $request->validate([
                'products' => 'nullable|array|min:1', // Validasi array produk jika ada
                'status' => 'nullable|string', // Validasi status jika ada
            ]);
    
            // Cari data berdasarkan ID
            $opportunity = Opportunity::findOrFail($id);
    
            // Update produk jika ada
            if (isset($validated['products'])) {
                $opportunity->products = array_unique($validated['products']); // Hapus duplikasi
            }
    
            // Update status dan created_at jika status adalah "open"
            if (isset($validated['status']) && $validated['status'] === 'open') {
                $opportunity->status = 'open';
                $opportunity->created_at = now(); // Perbarui waktu
            }
    
            // Simpan perubahan
            $opportunity->save();
    
            return response()->json([
                'message' => 'Opportunity updated successfully!',
                'data' => $opportunity,
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    
    // delete
    public function deleteOpportunity($id)
    {
        try {
            $opportunity = Opportunity::findOrFail($id);
            $opportunity->delete();

            return response()->json(['message' => 'Opportunity deleted successfully']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to delete opportunity'], 500);
        }
    }
    // END OPPORTUNITY

    // SO NUMBER 
    public function showSoNumberPage()
    {
        session(['active_menu' => 'salesmarketing']);
        // Data dummy untuk SO
        $data = [
            [
                'po_number' => 'PO12345',
                'so_number' => 'SO12345',
                'tanggal_tiba' => '2025-01-10',
                'incoterm' => 'CIF',
                'customer' => 'Customer A',
                'material' => 'Material X',
                'nama_barang_asli' => 'Barang Asli A',
                'nama_barang_jual' => 'Barang Jual A',
                'qty' => 100,
                'uom' => 'kg',
                'alamat_kirim' => 'Alamat A',
                'kemasan' => 'Box',
                'gudang_pengambilan' => 'Gudang A'
            ],
            [
                'po_number' => 'PO12346',
                'so_number' => 'SO12346',
                'tanggal_tiba' => '2025-01-12',
                'incoterm' => 'FOB',
                'customer' => 'Customer B',
                'material' => 'Material Y',
                'nama_barang_asli' => 'Barang Asli B',
                'nama_barang_jual' => 'Barang Jual B',
                'qty' => 200,
                'uom' => 'm3',
                'alamat_kirim' => 'Alamat B',
                'kemasan' => 'Pallet',
                'gudang_pengambilan' => 'Gudang B'
            ],
            [
                'po_number' => 'PO12347',
                'so_number' => 'SO12347',
                'tanggal_tiba' => '2025-01-15',
                'incoterm' => 'EXW',
                'customer' => 'Customer C',
                'material' => 'Material Z',
                'nama_barang_asli' => 'Barang Asli C',
                'nama_barang_jual' => 'Barang Jual C',
                'qty' => 150,
                'uom' => 'pcs',
                'alamat_kirim' => 'Alamat C',
                'kemasan' => 'Carton',
                'gudang_pengambilan' => 'Gudang C'
            ],
            [
                'po_number' => 'PO12348',
                'so_number' => 'SO12348',
                'tanggal_tiba' => '2025-01-18',
                'incoterm' => 'DDP',
                'customer' => 'Customer D',
                'material' => 'Material W',
                'nama_barang_asli' => 'Barang Asli D',
                'nama_barang_jual' => 'Barang Jual D',
                'qty' => 120,
                'uom' => 'kg',
                'alamat_kirim' => 'Alamat D',
                'kemasan' => 'Bag',
                'gudang_pengambilan' => 'Gudang D'
            ],
            [
                'po_number' => 'PO12349',
                'so_number' => 'SO12349',
                'tanggal_tiba' => '2025-01-20',
                'incoterm' => 'CIF',
                'customer' => 'Customer E',
                'material' => 'Material V',
                'nama_barang_asli' => 'Barang Asli E',
                'nama_barang_jual' => 'Barang Jual E',
                'qty' => 180,
                'uom' => 'box',
                'alamat_kirim' => 'Alamat E',
                'kemasan' => 'Drum',
                'gudang_pengambilan' => 'Gudang E'
            ],
        ];

        return view('salesmarketing.csr.so-number', compact('data'));
    }

    // menyimpan data ke db delivery
    public function requestToDelivery(Request $request)
    {
        try {
            // Validasi input data
            $validatedData = $request->validate([
                'po_number' => 'required|string',
                'so_number' => 'required|string',
                'tanggal_tiba' => 'required|date',
                'customer' => 'required|string',
                'material' => 'required|string',
                'nama_barang_asli' => 'required|string',
                'nama_barang_jual' => 'required|string',
                'qty' => 'required|numeric',
                'uom' => 'required|string',
                'alamat_kirim' => 'required|string',
                'kemasan' => 'required|string',
                'gudang_pengambilan' => 'required|string',
                'file' => 'nullable|file|max:3072|mimes:jpg,jpeg,bmp,png,xls,xlsx,doc,docx,pdf,txt,ppt,pptx',
            ]);

            // Konversi tanggal_tiba ke ISODate menggunakan Carbon
            $validatedData['tanggal_tiba'] = Carbon::parse($validatedData['tanggal_tiba'])->toDateTimeString();


            // Handle file upload jika ada file
            if ($request->hasFile('file')) {
                $file = $request->file('file');
                $filePath = $file->store('uploads', 'public'); // Simpan file di storage/public/uploads
                $validatedData['file_path'] = $filePath; // Tambahkan path file ke data
                $validatedData['file_name'] = $file->getClientOriginalName(); // Nama file asli
            }
    
            // Menambahkan status dengan nilai 'open'
            $validatedData['status'] = 'open';
    
            // Menyimpan data ke MongoDB menggunakan model Delivery
            $delivery = Delivery::create($validatedData);
    
            return response()->json(['message' => 'Request berhasil terkirim ke Delivery.'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to send request.'], 500);
        }
    }

    // read data dengan status 
    public function showDeliveryStatus()
    {
            $deliveries = Delivery::orderBy('updated_at', 'desc')
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function ($item) {
                return [
                    'id' => $item->id,
                    'po_number' => $item->po_number,
                    'so_number' => $item->so_number,
                    'tanggal_tiba' => $item->tanggal_tiba,
                    'customer' => $item->customer,
                    'nama_barang_jual' => $item->nama_barang_jual,
                    'status' => ucfirst($item->status),
                    'material' => $item->material ?? 'N/A',
                    'nama_barang_asli' => $item->nama_barang_asli ?? 'N/A',
                    'qty' => $item->qty,
                    'uom' => $item->uom ?? 'N/A',
                    'alamat_kirim' => $item->alamat_kirim,
                    'kemasan' => $item->kemasan ?? 'N/A',
                    'gudang_pengambilan' => $item->gudang_pengambilan ?? 'N/A',
                    'file_name' => $item->file_name ?? null, // Nama file asli
                    'file_path' => $item->file_path ? asset('storage/' . $item->file_path) : null, // URL file
                    'updated_at' => $item->updated_at ? $item->updated_at->format('Y-m-d H:i:s') : 'N/A',
                    'created_at' => $item->created_at ? $item->created_at->format('Y-m-d H:i:s') : 'N/A',
                ];
            });
        
        return response()->json(['data' => $deliveries]);
        
    }

    // deleted tabel delivery
    public function deleteDelivery($id)
    {
        try {
            // Cari data berdasarkan ID
            $delivery = Delivery::findOrFail($id);
    
            // Hapus data
            $delivery->delete();
    
            // Berikan respons sukses
            return response()->json(['message' => 'Delivery deleted successfully']);
        } catch (\Exception $e) {
            // Tangani error
            return response()->json(['error' => 'Failed to delete delivery'], 500);
        }
    }

    public function uploadFile(Request $request, $id)
    {
        try {
            // Cari data berdasarkan ID
            $delivery = Delivery::findOrFail($id);
    
            // Periksa apakah ada file yang diunggah
            if ($request->hasFile('file')) {
                // Proses file yang diunggah
                $file = $request->file('file');
                $filePath = $file->store('uploads', 'public'); // Simpan file di folder 'uploads' di storage
                $delivery->file_path = $filePath;
                $delivery->file_name = $file->getClientOriginalName(); // Simpan nama asli file
                $delivery->save();
            }
    
            return response()->json(['message' => 'File uploaded successfully.'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to upload file.', 'error' => $e->getMessage()], 500);
        }
    }

    
    
    
    
        
    
    
    
    
    
    
    
    
     
    
    
}