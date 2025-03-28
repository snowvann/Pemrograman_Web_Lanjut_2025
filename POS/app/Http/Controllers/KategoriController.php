<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Kategori;

class KategoriController extends Controller
{
    public function index()
    {
        $kategoris = Kategori::all(); // Ambil semua data kategori
        return view('kategori.index', compact('kategoris')); // Kirim data ke view
    }

    public function create()
    {
        return view('kategori.create');
    }

    public function store(Request $request)
    {
        DB::table('m_kategori')->insert([
            'kategori_kode' => $request->kategori_kode,
            'kategori_nama' => $request->kategori_nama,
            'kategori_slug' => $request->kategori_slug,
        ]);
        return redirect('/kategori');
    }

    public function edit($id)
    {
        $kategori = Kategori::findOrFail($id);
        return view('kategori.edit', compact('kategori'));
    }
    
    

    public function update(Request $request, $id)
    {
        DB::table('m_kategori')->where('id', $id)->update([
            'kategori_kode' => $request->kategori_kode,
            'kategori_nama' => $request->kategori_nama,
            'kategori_slug' => $request->kategori_slug,
        ]);
        return redirect('/kategori');
    }

    public function destroy($id)
    {
        DB::table('m_kategori')->where('id', $id)->delete();
        return redirect('/kategori');
    }
}
