<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlanningWorkDate extends Model
{
    use HasFactory;

    protected $table = 'planning_work_dates';
    protected $fillable = ['year', 'month', 'target_production', 'target_workdays'];
    
    // Tentukan koneksi yang digunakan
    protected $connection = 'pgsql';  // Pastikan menggunakan koneksi pgsql
    
    public $timestamps = false;
}

