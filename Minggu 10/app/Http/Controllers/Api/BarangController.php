<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BarangModel;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class BarangController extends Controller
{
    public function index()
    {
        return response()->json(BarangModel::all());
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'barang_kode' => 'required|unique:m_barang,barang_kode',
            'barang_nama' => 'required',
            'kategori_id' => 'required|exists:m_kategori,kategori_id',
            'harga_beli' => 'required|numeric',
            'harga_jual' => 'required|numeric|gt:harga_beli',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $imageName = null;

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = $image->hashName();
            Storage::disk('public')->put('barang', $image);
            $imageName = 'barang/' . $imageName;
        }

        $barang = BarangModel::create([
            'barang_kode' => $request->barang_kode,
            'barang_nama' => $request->barang_nama,
            'kategori_id' => $request->kategori_id,
            'harga_beli' => $request->harga_beli,
            'harga_jual' => $request->harga_jual,
            'image' => $imageName,
        ]);

        return response()->json($barang, 201);
    }

    public function show(BarangModel $barang)
    {
        return response()->json($barang);
    }

    public function update(Request $request, BarangModel $barang)
    {
        $validator = Validator::make($request->all(), [
            'barang_kode' => 'sometimes|required|unique:m_barang,barang_kode,' . $barang->barang_id,
            'barang_nama' => 'sometimes|required',
            'kategori_id' => 'sometimes|required|exists:m_kategori,kategori_id',
            'harga_beli' => 'sometimes|required|numeric',
            'harga_jual' => 'sometimes|required|numeric|gt:harga_beli',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $data = $request->except('image');
        $imageName = $barang->image;

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = $image->hashName();
            Storage::disk('public')->put('barang', $image);
            $imageName = 'barang/' . $imageName;

            if ($barang->image && Storage::disk('public')->exists($barang->image)) {
                Storage::disk('public')->delete($barang->image);
            }
        }
        $data['image'] = $imageName;

        $barang->update($data);
        return response()->json($barang);
    }

    public function destroy(BarangModel $barang)
    {
        if ($barang->image && Storage::disk('public')->exists($barang->image)) {
            Storage::disk('public')->delete($barang->image);
        }

        $barang->delete();
        return response()->json([
            'success' => true,
            'message' => 'Barang deleted successfully',
        ]);
    }
}