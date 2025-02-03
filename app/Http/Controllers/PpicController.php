<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Session;
use MongoDB\Client as MongoDBClient;
use Illuminate\Support\Facades\DB;
use MongoDB\BSON\ObjectId;
use Carbon\Carbon;

use App\Models\Opportunity;
use App\Models\PpicSpk;

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
                'products',
                'reason_revision',
                'revision_date'
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
        $request->validate([
            'id' => 'required|string',
            'revision_date' => 'required|date',
            'reason_revision' => 'required|string',
        ]);
    
        // Cari dokumen berdasarkan id
        $opportunity = Opportunity::find($request->id);
    
        if (!$opportunity) {
            return response()->json(['message' => 'Opportunity not found.'], 404);
        }
    
        // Update revision date dan reason_revision
        $opportunity->update([
            'revision_date' => $request->revision_date,
            'reason_revision' => $request->reason_revision,
            'status' => 'revision', // Ubah status menjadi revision
            'updated_at' => now(),
        ]);
    
        return response()->json(['message' => 'Revision date updated successfully.']);
    }

    // fungsi CreateSPK
    public function createSpkIndex()
    {
        session(['active_menu' => 'ppic']);
        return view('supplychain.ppic.eticket.create');
    }

    // step1
    public function store(Request $request)
    {
        $request->validate([
            'material_number' => 'required|string|max:255',
            'order_type' => 'required|string|max:255',
            'production_plant' => 'required|string|max:255',
        ]);
    
        try {
            PpicSpk::create([
                'material_number' => $request->material_number,
                'order_type' => $request->order_type,
                'production_plant' => $request->production_plant,
            ]);
    
            return response()->json(['success' => true, 'message' => 'SPK created successfully.']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Failed to create SPK.'], 500);
        }
    }

    // card monitoring
    public function monitoringSpk()
    {
        return view('supplychain.ppic.monitoring.monitoring-spk');
    }

    // master data menu
    public function masterData() {
        return view('supplychain.ppic.eticket.master-data');
    }
    
    

    
    
    
    

}
