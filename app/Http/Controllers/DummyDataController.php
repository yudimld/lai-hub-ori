<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DummyDataController extends Controller
{
    public function index()
    {
        // Menyediakan data dummy untuk API
        $data = [
            [
                'tanggal_tiba' => '2025-01-05',
                'incoterm' => 'FOB',
                'customer' => 'Customer 1',
                'material' => 'Material 1',
                'nama_barang_asli' => 'Barang Asli 1',
                'nama_barang_jual' => 'Barang Jual 1',
                'qty' => 10,
                'uom' => 'pcs',
                'alamat_kirim' => 'Alamat Kirim 1',
                'kemasan' => 'Kemasan 1',
                'gudang_pengambilan' => 'Gudang A',
                'no_po' => 'PO12345',
                'status' => 'approved',
                'product_1' => 'Produk 1',
                'product_2' => 'Produk 2',
                'product_3' => 'Produk 3',
                'product_4' => 'Produk 4',
                'product_5' => 'Produk 5',
            ],
            [
                'tanggal_tiba' => '2025-01-06',
                'incoterm' => 'CIF',
                'customer' => 'Customer 2',
                'material' => 'Material 2',
                'nama_barang_asli' => 'Barang Asli 2',
                'nama_barang_jual' => 'Barang Jual 2',
                'qty' => 20,
                'uom' => 'box',
                'alamat_kirim' => 'Alamat Kirim 2',
                'kemasan' => 'Kemasan 2',
                'gudang_pengambilan' => 'Gudang B',
                'no_po' => 'PO12346',
                'status' => 'approved',
                'product_1' => 'Produk 1',
                'product_2' => 'Produk 2',
                'product_3' => 'Produk 3',
                'product_4' => 'Produk 4',
                'product_5' => 'Produk 5',
            ],
            [
                'tanggal_tiba' => '2025-01-08',
                'incoterm' => 'CIF',
                'customer' => 'Customer 3',
                'material' => 'Material 3',
                'nama_barang_asli' => 'Barang Asli 3',
                'nama_barang_jual' => 'Barang Jual 3',
                'qty' => 40,
                'uom' => 'box',
                'alamat_kirim' => 'Alamat Kirim 3',
                'kemasan' => 'Kemasan 3',
                'gudang_pengambilan' => 'Gudang B',
                'no_po' => 'PO12347',
                'status' => 'approved',
                'product_1' => 'Produk 1',
                'product_2' => 'Produk 2',
                'product_3' => 'Produk 3',
                'product_4' => 'Produk 4',
                'product_5' => 'Produk 5',
            ],
        ];
        

        // Filter data yang tidak memiliki status 'open'
        $filteredData = array_filter($data, function ($item) {
            return $item['status'] !== 'open';
        });

        return response()->json(array_values($filteredData));
    }
}