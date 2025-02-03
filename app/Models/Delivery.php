<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model; 
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;



class Delivery extends Model
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
        'so_sap', 
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
        'reason',
        'products',
        'delivery_date',
        'arriving_date',  
        'revision_date',
        'reason_revision',
        'file_path', 
        'file_name', 
        'file_name_delivery', 
        'reason_reject',
        'file_arriving',
        'file_pendukung_delivery',
    ];
            /**
     * Override table name resolution to use $collection.
     */
    public function getTable()
    {
        return $this->collection;
    }

    

}
