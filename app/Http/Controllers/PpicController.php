<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PpicController extends Controller
{
    
    public function index()
    {
        // Simpan session bahwa card Supply Chain diakses
        session(['active_menu' => 'supplychain']);
        return view('supplychain.ppic.eticket.data');
    }

    public function create()
    {
        return view('supplychain.ppic.eticket.create');
    }

    // Method untuk menampilkan data E-Ticket
    public function data()
    {
        return view('supplychain.ppic.eticket.data'); // View untuk data tambahan atau detail
    }
}
