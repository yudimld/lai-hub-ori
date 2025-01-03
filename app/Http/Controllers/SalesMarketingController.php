<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SalesMarketingController extends Controller
{
    // Set session dan tampilkan halaman Opportunity
    public function opportunity()
    {
        session(['active_menu' => 'salesmarketing']);
        return view('salesmarketing.csr.opportunity');
    }

    // Set session dan tampilkan halaman SO Number
    public function soNumber()
    {
        session(['active_menu' => 'salesmarketing']);
        return view('salesmarketing.csr.so-number');
    }
}
