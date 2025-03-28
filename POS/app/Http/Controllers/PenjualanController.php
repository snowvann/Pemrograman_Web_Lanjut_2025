<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PenjualanController extends Controller
{
    public function index()
    {
        $penjualans = DB::table('t_penjualan')->get();
        return view('penjualan.index', compact('penjualans'));
    }

    public function create()
    {
        return view('penjualan.create');
    }

    public function store(Request $request)
    {
        DB::table('t_penjualan')->insert([
            'user_id' => $request->user_id,
            'pembeli' => $request->pembeli,
            'penjualan_kode' => $request->penjualan_kode,
            'penjualan_tanggal' => Carbon::now(),
        ]);
        return redirect('/penjualan');
    }

    public function edit($id)
    {
        $penjualan = DB::table('t_penjualan')->where('id', $id)->first();
        return view('penjualan.edit', compact('penjualan'));
    }

    public function update(Request $request, $id)
    {
        DB::table('t_penjualan')->where('id', $id)->update([
            'user_id' => $request->user_id,
            'pembeli' => $request->pembeli,
            'penjualan_kode' => $request->penjualan_kode,
            'penjualan_tanggal' => Carbon::now(),
        ]);
        return redirect('/penjualan');
    }

    public function destroy($id)
    {
        DB::table('t_penjualan')->where('id', $id)->delete();
        return redirect('/penjualan');
    }
}
