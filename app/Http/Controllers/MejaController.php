<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use Illuminate\Http\Request;

class MejaController extends Controller
{
    public function show($nomer_meja)
    {
        $menus = Menu::when('nomor_meja', $nomer_meja)->get();
        return view('daftarmenu.index', compact('nomer_meja'));
    }
}
