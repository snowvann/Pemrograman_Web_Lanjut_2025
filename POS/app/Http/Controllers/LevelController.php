<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LevelController extends Controller
{
    public function index()
    {
        $levels = DB::table('m_level')->get();
        return view('level.index', compact('levels'));
    }

    public function create()
    {
        return view('level.create');
    }

    public function store(Request $request)
    {
        DB::table('m_level')->insert([
            'level_kode' => $request->level_kode,
            'level_nama' => $request->level_nama,
        ]);
        return redirect('/level');
    }

    public function edit($id)
    {
        $level = DB::table('m_level')->where('id', $id)->first();
        return view('level.edit', compact('level'));
    }

    public function update(Request $request, $id)
    {
        DB::table('m_level')->where('id', $id)->update([
            'level_kode' => $request->level_kode,
            'level_nama' => $request->level_nama,
        ]);
        return redirect('/level');
    }

    public function destroy($id)
    {
        DB::table('m_level')->where('id', $id)->delete();
        return redirect('/level');
    }

}
