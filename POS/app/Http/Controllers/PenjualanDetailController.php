<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PenjualanDetailController extends Controller
{
    public function index()
    {
        $penjualan_details = DB::table('t_penjualan_detail')->get();
        return view('penjualan_detail.index', compact('penjualan_details'));
    }

    public function create()
    {
        return view('penjualan_detail.create');
    }

    public function store(Request $request)
    {
        DB::table('t_penjualan_detail')->insert([
            'penjualan_id' => $request->penjualan_id,
            'barang_id' => $request->barang_id,
            'harga' => $request->harga,
            'jumlah' => $request->jumlah,
        ]);
        return redirect('/penjualan-detail');
    }

    public function edit($id)
    {
        $penjualan_detail = DB::table('t_penjualan_detail')->where('id', $id)->first();
        return view('penjualan_detail.edit', compact('penjualan_detail'));
    }

    public function update(Request $request, $id)
    {
        DB::table('t_penjualan_detail')->where('id', $id)->update([
            'penjualan_id' => $request->penjualan_id,
            'barang_id' => $request->barang_id,
            'harga' => $request->harga,
            'jumlah' => $request->jumlah,
        ]);
        return redirect('/penjualan-detail');
    }

    public function destroy($id)
    {
        DB::table('t_penjualan_detail')->where('id', $id)->delete();
        return redirect('/penjualan-detail');
    }
}
