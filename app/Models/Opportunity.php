<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use MongoDB\Laravel\Eloquent\Model; 
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class Opportunity extends Model
{
    use HasFactory;

    protected $connection = 'mongodb'; // Koneksi MongoDB
    protected $collection = 'opportunity'; // Nama koleksi di MongoDB
    protected $fillable = [
        'no_po',
        'incoterm',
        'customer',
        'material',
        'nama_barang_asli',
        'nama_barang_jual',
        'qty',
        'uom',
        'alamat_kirim',
        'kemasan',
        'gudang_pengambilan',
        'tanggal_tiba',
        'status',
        'reason',
        'revision_date',
        'products',
        'agree_loading_date', 
        'agree_arriving_date', 
        'sales_order_type', 
    ];

        /**
     * Override table name resolution to use $collection.
     */
    public function getTable()
    {
        return $this->collection;
    }

        /**
     * Simpan data menjadi draft.
     */
    public static function saveAsDraft(array $data)
    {
        $data['status'] = 'draft'; // Set status ke draft
        return self::create($data); // Gunakan create untuk menyimpan data
    }

}

