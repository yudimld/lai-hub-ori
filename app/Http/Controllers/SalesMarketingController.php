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
    // Menut Opportunity
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

    // END
    

    // mENU STATUS OPPORTUNITY
    public function statusRequestPpic()
    {
        session(['active_menu' => 'salesmarketing']); // Set menu aktif sesuai halaman
        return view('salesmarketing.csr.status-request-ppic'); // Tampilkan view untuk halaman ini
    }

    // read data dengan status
    public function getStatusRequestData()
    {
        session(['active_menu' => 'salesmarketing']);
        // Ambil data dari tabel opportunity dengan status 
        $data = Opportunity::whereNotNull('status')
            ->orderBy('created_at', 'asc')
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
                    'agree_arriving_date' => $item->agree_arriving_date ?? 'N/A',
                    'agree_loading_date' => $item->agree_loading_date ?? 'N/A',
                    'sales_order_type' => $item->sales_order_type ?? 'N/A',
                    'revision_date' => $item->revision_date ?? 'N/A', // Tambahkan revision_date
                    'reason_revision' => $item->reason_revision ?? 'N/A',
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

    // update status revision to open 
    public function updateStatus(Request $request)
    {
        // Validasi input
        $request->validate([
            'id' => 'required|string', // ID dokumen
            'status' => 'required|string', // Status baru
        ]);
    
        // Cari dokumen berdasarkan ID
        $opportunity = Opportunity::where('id', $request->id)->first();
    
        if (!$opportunity) {
            return response()->json(['message' => 'Opportunity not found.'], 404);
        }
    
        // Perbarui status
        $opportunity->update([
            'status' => $request->status,
            'updated_at' => now(),
        ]);
    
        return response()->json(['message' => 'Status updated successfully.']);
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
    // END STATUS OPPORTUNITY

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
    // public function requestToDelivery(Request $request)
    // {
    //     try {
    //         // Validasi input data
    //         $validatedData = $request->validate([
    //             'po_number' => 'required|string',
    //             'so_number' => 'required|string',
    //             'tanggal_tiba' => 'required|date',
    //             'customer' => 'required|string',
    //             'material' => 'required|string',
    //             'nama_barang_asli' => 'required|string',
    //             'nama_barang_jual' => 'required|string',
    //             'qty' => 'required|numeric',
    //             'uom' => 'required|string',
    //             'alamat_kirim' => 'required|string',
    //             'kemasan' => 'required|string',
    //             'gudang_pengambilan' => 'required|string',
    //             'file' => 'nullable|file|max:3072|mimes:jpg,jpeg,bmp,png,xls,xlsx,doc,docx,pdf,txt,ppt,pptx',
    //         ], [
    //             'file.max' => 'Ukuran file tidak boleh lebih dari 3MB.',
    //             'file.mimes' => 'Format file tidak didukung.',
    //         ]);

    //         // Konversi tanggal_tiba ke ISODate menggunakan Carbon
    //         $validatedData['tanggal_tiba'] = Carbon::parse($validatedData['tanggal_tiba'])->toDateTimeString();

    //         // Handle file upload jika ada file
    //         if ($request->hasFile('file')) {
    //             $file = $request->file('file');
    //             $filePath = $file->store('uploads', 'public');
    //             $validatedData['file_path'] = $filePath;
    //             $validatedData['file_name'] = $file->getClientOriginalName();

    //             Log::info('File diterima:', [
    //                 'original_name' => $file->getClientOriginalName(),
    //                 'path' => $filePath
    //             ]);
    //         }

    //         // Menambahkan status dengan nilai 'open'
    //         $validatedData['status'] = 'open';

    //         // Menyimpan data ke MongoDB menggunakan model Delivery
    //         $delivery = Delivery::create($validatedData);

    //         return response()->json(['message' => 'Request berhasil terkirim ke Delivery.'], 200);
    //     } catch (\Exception $e) {
    //         Log::error('Error saat menyimpan data:', ['error' => $e->getMessage()]);
    //         return response()->json(['error' => 'Failed to send request.', 'details' => $e->getMessage()], 500);
    //     }
    // }
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
            ], [
                'file.max' => 'Ukuran file tidak boleh lebih dari 3MB.',
                'file.mimes' => 'Format file tidak didukung.',
            ]);

            // Konversi tanggal_tiba ke ISODate menggunakan Carbon
            $validatedData['tanggal_tiba'] = Carbon::parse($validatedData['tanggal_tiba'])->toDateTimeString();

            // Handle file upload jika ada file
            if ($request->hasFile('file')) {
                $file = $request->file('file');
                $filePath = $file->store('delivery', 'public'); // Simpan file di folder "delivery" di storage
                $validatedData['file_pendukung_delivery'] = $filePath; // Simpan path file ke kolom "file_pendukung_delivery"
                $validatedData['file_name_delivery'] = $file->getClientOriginalName(); // Nama asli file

                // Log untuk debugging
                Log::info('File diterima:', [
                    'original_name' => $file->getClientOriginalName(),
                    'path' => $filePath
                ]);
            }

            // Menambahkan status dengan nilai 'open'
            $validatedData['status'] = 'open';

            // Menyimpan data ke MongoDB menggunakan model Delivery
            $delivery = Delivery::create($validatedData);

            return response()->json(['message' => 'Request berhasil terkirim ke Delivery.'], 200);
        } catch (\Exception $e) {
            // Log error jika terjadi masalah
            Log::error('Error saat menyimpan data:', ['error' => $e->getMessage()]);
            return response()->json(['error' => 'Failed to send request.', 'details' => $e->getMessage()], 500);
        }
    }

    // END SO NUMBER

    // MENU STATUS ON DELIVERY
    public function showDeliveryStatus()
    {
        if (request()->ajax()) {
            try {
                $deliveries = Delivery::whereNotNull('status')
                    ->orderBy('updated_at', 'desc')
                    ->get()
                    ->map(function ($item) {
                        return [
                            'id' => $item->id,
                            'po_number' => $item->po_number,
                            'so_number' => $item->so_number,
                            'tanggal_tiba' => $item->tanggal_tiba,
                            'delivery_date' => $item->delivery_date 
                                ? Carbon::parse($item->delivery_date)->format('Y-m-d') 
                                : null, 
                            'arriving_date' => $item->arriving_date 
                                ? Carbon::parse($item->arriving_date)->format('Y-m-d') 
                                : null,
                            'revision_date' => $item->revision_date 
                                ? Carbon::parse($item->revision_date)->format('Y-m-d') 
                                : null,
                            'reason' => $item->reason ?? 'N/A',
                            'customer' => $item->customer,
                            'nama_barang_jual' => $item->nama_barang_jual,
                            'status' => ucfirst($item->status ?? 'unknown'),
                            'material' => $item->material ?? 'N/A',
                            'nama_barang_asli' => $item->nama_barang_asli ?? 'N/A',
                            'qty' => $item->qty,
                            'uom' => $item->uom ?? 'N/A',
                            'alamat_kirim' => $item->alamat_kirim,
                            'kemasan' => $item->kemasan ?? 'N/A',
                            'gudang_pengambilan' => $item->gudang_pengambilan ?? 'N/A',
                            'file_name' => $item->file_name ?? null,
                            'file_name_delivery' => $item->file_name_delivery ?? null,
                            'file_path' => $item->file_path ? asset('storage/' . $item->file_path) : null,
                            'file_arriving' => $item->file_arriving 
                                ? asset('storage/' . $item->file_arriving) 
                                : null,

                            'updated_at' => $item->updated_at ? $item->updated_at->format('Y-m-d H:i:s') : 'N/A',
                            'created_at' => $item->created_at ? $item->created_at->format('Y-m-d H:i:s') : 'N/A',
                            'reason_reject' => $item->reason_reject ?? 'N/A',
                            'reason_revision' => $item->reason_revision ?? 'N/A',
                            'file_pendukung_delivery' => $item->file_pendukung_delivery 
                                ? asset('storage/' . $item->file_pendukung_delivery) 
                                : 'No supporting file',
                        ];
                    });

                return response()->json(['data' => $deliveries]);

            } catch (\Exception $e) {
                // Log error dan respons
                \Log::error('AJAX Error: ' . $e->getMessage());
                return response()->json(['error' => 'Failed to fetch data'], 500);
            }
        }
    
        // Render halaman HTML jika bukan permintaan AJAX
        session(['active_menu' => 'salesmarketing']);
        return view('salesmarketing.csr.status-delivery');
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

    // edit delivery data
    public function getDeliveryDetail($id)
    {
        try {
            // Cari data delivery berdasarkan ID
            $delivery = Delivery::findOrFail($id);

            // Kirimkan data sebagai respons JSON
            return response()->json([
                'status' => 'success',
                'delivery' => $delivery,
            ], 200);
        } catch (\Exception $e) {
            // Jika terjadi kesalahan
            return response()->json([
                'status' => 'error',
                'message' => 'Data not found or an error occurred.',
                'error' => $e->getMessage(),
            ], 404);
        }
    }

    // END STATUS ON DELIVERY

    public function uploadFile(Request $request, $id)
    {
        try {
            // Cari data berdasarkan ID
            $delivery = Delivery::findOrFail($id);
    
            // Periksa apakah ada file yang diunggah
            if ($request->hasFile('file')) {
                $file = $request->file('file');
    
                // Simpan file ke folder 'delivery' di storage
                $filePath = $file->store('delivery', 'public');
    
                // Simpan file path dan nama file ke database
                $delivery->file_pendukung_delivery = $filePath; // Kolom file_pendukung_delivery
                $delivery->file_name_delivery = $file->getClientOriginalName(); // Nama asli file
                $delivery->save();
    
                // Buat URL untuk file yang diunggah
                $fileUrl = asset('storage/' . $filePath);
    
                // Logging untuk debugging
                Log::info('File uploaded:', [
                    'file_url' => $fileUrl,
                    'file_name' => $file->getClientOriginalName(),
                ]);
    
                return response()->json([
                    'message' => 'File uploaded successfully.',
                    'file_url' => $fileUrl,
                    'file_name' => $file->getClientOriginalName(),
                ], 200);
            }
    
            return response()->json(['message' => 'No file uploaded.'], 400);
        } catch (\Exception $e) {
            // Log error untuk debugging
            Log::error('Error saat upload file:', ['error' => $e->getMessage()]);
            return response()->json(['message' => 'Failed to upload file.', 'error' => $e->getMessage()], 500);
        }
    }
    
    
}