<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model; 
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class PpicSpk extends Model
{
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        // Secara eksplisit tetapkan koleksi
        $this->setTable('ppicspk');
    }

    protected $connection = 'mongodb'; // Menggunakan koneksi MongoDB
    protected $collection = 'PpicSpk'; // Nama collection di MongoDB (opsional)

    protected $fillable = [
        'material_number',
        'order_type',
        'production_plant',
    ];
}
