<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // Tampilkan halaman home untuk semua pengguna
        return view('home');
    }
}

