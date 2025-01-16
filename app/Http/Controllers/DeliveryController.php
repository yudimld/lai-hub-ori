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
        session(['active_menu' => 'delivery']);
        $deliveries = Delivery::getAllDeliveries(); // Mengambil semua data dari collection delivery
        return response()->json(['data' => array_values($deliveries)]);
    }

    // Fungsi untuk memperbarui status menjadi 'delivery'
    public function updateStatusToDelivery(Request $request)
    {
        try {
            // Validasi data yang diterima
            $request->validate([
                'po_number' => 'required|string', // Validasi nomor PO
            ]);

            // Cari data berdasarkan po_number
            $delivery = Delivery::where('po_number', $request->po_number)->first();

            if ($delivery) {
                // Perbarui status menjadi 'delivery'
                if ($delivery->status !== 'open') {
                    return response()->json(['message' => 'Only open deliveries can be updated to delivery.'], 400);
                }

                $delivery->status = 'delivery';
                $delivery->updated_at = now(); // Perbarui timestamp
                $delivery->save();

                return response()->json(['message' => 'Status updated to Delivery successfully.'], 200);
            }

            return response()->json(['message' => 'Delivery data not found.'], 404);
        } catch (\Exception $e) {
            Log::error('Error updating status to Delivery: ' . $e->getMessage());
            return response()->json(['message' => 'An error occurred.', 'error' => $e->getMessage()], 500);
        }
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
}
