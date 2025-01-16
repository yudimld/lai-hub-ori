<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model as Eloquent;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class Delivery extends Eloquent
{
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        // Secara eksplisit tetapkan koleksi
        $this->setTable('delivery');
    }

    protected $connection = 'mongodb'; // Menentukan koneksi MongoDB
    protected $collection = 'delivery'; // Nama koleksi di MongoDB
    protected $fillable = [
        'po_number',
        'so_number', 
        'tanggal_tiba', 
        'customer', 
        'material', 
        'nama_barang_asli', 
        'nama_barang_jual', 
        'qty', 
        'uom', 
        'alamat_kirim', 
        'kemasan', 
        'gudang_pengambilan',
        'status',
        'file_path', // Path file di storage
        'file_name', // Nama file asli
    ];

    public static function getAllDeliveries()
    {
        return DB::connection('mongodb')->table('delivery')->get()
            ->filter(function ($delivery) {
                // Filter hanya data yang memiliki status
                return isset($delivery->status) && !empty($delivery->status);
            })
            ->map(function ($delivery) {
                // Tentukan status berdasarkan kondisi saat ini
                $status = $delivery->status ?? 'Open'; // Default status 'Open'
    
                return [
                    'id'                 => isset($delivery->_id) && $delivery->_id instanceof \MongoDB\BSON\ObjectId ? (string) $delivery->_id : null,
                    'po_number'          => $delivery->po_number ?? '-',
                    'so_number'          => $delivery->so_number ?? '-',
                    'tanggal_tiba'       => isset($delivery->tanggal_tiba) && strtotime($delivery->tanggal_tiba) ? Carbon::parse($delivery->tanggal_tiba)->format('Y-m-d') : '-',
                    'customer'           => $delivery->customer ?? '-',
                    'material'           => $delivery->material ?? '-',
                    'nama_barang_asli'   => $delivery->nama_barang_asli ?? '-',
                    'nama_barang_jual'   => $delivery->nama_barang_jual ?? '-',
                    'qty'                => $delivery->qty ?? 0,
                    'uom'                => $delivery->uom ?? '-',
                    'alamat_kirim'       => $delivery->alamat_kirim ?? '-',
                    'kemasan'            => $delivery->kemasan ?? '-',
                    'gudang_pengambilan' => $delivery->gudang_pengambilan ?? '-',
                    'file_path'          => $delivery->file_path ?? null, // Menambahkan file_path
                    'file_name'          => $delivery->file_name ?? null, // Menambahkan file_name
                    'status'             => ucfirst($status), // Menampilkan status dengan kapital pertama
                ];
            })
            ->toArray();
    }
    

}
