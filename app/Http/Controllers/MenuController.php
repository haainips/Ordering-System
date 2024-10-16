<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use App\Models\Menu;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    public function show(Request $request, $selectedCategoryId = null)
    {
        $kategori = Kategori::all();
        $menu = $selectedCategoryId ? Menu::where('kategori_id', $selectedCategoryId)->get() : Menu::all();
        return view('daftarmenu.index', compact('kategori', 'menu', 'selectedCategoryId'));
    }

    public function filterKategori($id)
    {
        $menu = Menu::where('id_kategori', $id)->get();
        return response()->json($menu);
    }
}
