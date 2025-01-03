<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class MesSpkController extends Controller
{
    // Method untuk menampilkan halaman List SPK
    public function index()
    {
        Session::put('active_menu', 'mes-spk'); // Set active menu
        return view('mes.spk.list'); // Menampilkan halaman List SPK
    }

    // Method untuk menampilkan halaman Create SPK
    public function create()
    {
        Session::put('active_menu', 'mes-spk'); // Set active menu
        return view('mes.spk.create'); // Menampilkan halaman Create SPK
    }
}
