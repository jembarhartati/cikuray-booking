<?php

namespace App\Http\Controllers\Pendaki;

use App\Http\Controllers\Controller;

class InformasiController extends Controller
{
    public function index()
    {
        return view('pendaki.informasi');
    }
}
