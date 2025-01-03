<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class Post extends Eloquent
{
    protected $connection = 'mongodb';  // Menentukan koneksi MongoDB
    protected $fillable = ['title', 'body'];  // Field yang dapat diisi
}
