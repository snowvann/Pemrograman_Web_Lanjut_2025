<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class StokController extends Controller
{
    public function index()
    {
        $stoks = DB::table('t_stok')->get();
        return view('stok.index', compact('stoks'));
    }

    public function create()
    {
        return view('stok.create');
    }

    public function store(Request $request)
    {
        DB::table('t_stok')->insert([
            'barang_id' => $request->barang_id,
            'user_id' => $request->user_id,
            'stok_tanggal' => Carbon::now(),
            'stok_jumlah' => $request->stok_jumlah,
        ]);
        return redirect('/stok');
    }

    public function edit($id)
    {
        $stok = DB::table('t_stok')->where('id', $id)->first();
        return view('stok.edit', compact('stok'));
    }

    public function update(Request $request, $id)
    {
        DB::table('t_stok')->where('id', $id)->update([
            'barang_id' => $request->barang_id,
            'user_id' => $request->user_id,
            'stok_tanggal' => Carbon::now(),
            'stok_jumlah' => $request->stok_jumlah,
        ]);
        return redirect('/stok');
    }

    public function destroy($id)
    {
        DB::table('t_stok')->where('id', $id)->delete();
        return redirect('/stok');
    }
}
