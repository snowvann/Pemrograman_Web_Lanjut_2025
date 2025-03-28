<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BarangController extends Controller
{
    public function index()
    {
        $barangs = DB::table('m_barang')->get();
        return view('barang.index', compact('barangs'));
    }

    public function create()
    {
        return view('barang.create');
    }

    public function store(Request $request)
    {
        DB::table('m_barang')->insert([
            'kategori_id' => $request->kategori_id,
            'barang_kode' => $request->barang_kode,
            'barang_nama' => $request->barang_nama,
            'harga_beli' => $request->harga_beli,
            'harga_jual' => $request->harga_jual,
        ]);
        return redirect('/barang');
    }

    public function edit($id)
    {
        $barang = DB::table('m_barang')->where('id', $id)->first();
        return view('barang.edit', compact('barang'));
    }

    public function update(Request $request, $id)
    {
        DB::table('m_barang')->where('id', $id)->update([
            'kategori_id' => $request->kategori_id,
            'barang_kode' => $request->barang_kode,
            'barang_nama' => $request->barang_nama,
            'harga_beli' => $request->harga_beli,
            'harga_jual' => $request->harga_jual,
        ]);
        return redirect('/barang');
    }

    public function destroy($id)
    {
        DB::table('m_barang')->where('id', $id)->delete();
        return redirect('/barang');
    }
}
