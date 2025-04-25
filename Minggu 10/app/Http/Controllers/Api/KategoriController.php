<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\KategoriModel; // Pastikan ini sesuai dengan nama model Anda
use Illuminate\Support\Facades\Validator;

class KategoriController extends Controller
{
    public function index()
    {
        return response()->json(KategoriModel::all());
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'kategori_nama' => 'required|unique:m_kategori,kategori_nama', // Sesuaikan dengan nama tabel dan kolom
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $kategori = KategoriModel::create($request->all());
        return response()->json($kategori, 201);
    }

    public function show(KategoriModel $kategori)
    {
        return response()->json($kategori);
    }

    public function update(Request $request, KategoriModel $kategori)
    {
        $validator = Validator::make($request->all(), [
            'kategori_nama' => 'sometimes|required|unique:m_kategori,kategori_nama,'.$kategori->kategori_id.',kategori_id', // Sesuaikan nama tabel dan kolom primary key
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        $kategori->update($request->all());
        return response()->json($kategori);
    }

    public function destroy(KategoriModel $kategori)
    {
        $kategori->delete();
        return response()->json([
            'success' => true,
            'message' => 'Data kategori berhasil dihapus',
        ]);
    }
}