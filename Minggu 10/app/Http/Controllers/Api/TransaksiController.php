<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\PenjualanModel; // Ganti dengan model Penjualan Anda
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class TransaksiController extends Controller
{
    /**
     * Menampilkan semua Penjualan.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        try {
            $Penjualan = PenjualanModel::all(); // Eager load relasi jika ada
            return response()->json($Penjualan);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Gagal mengambil daftar Penjualan: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Menyimpan Penjualan baru.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            // Aturan validasi lainnya untuk Penjualan
            'total_harga' => 'required|numeric|min:0',
            'bukti_pembayaran' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Validasi untuk bukti pembayaran
            // ... tambahkan validasi lain sesuai kebutuhan
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $data = $request->except('bukti_pembayaran'); // Ambil semua data kecuali bukti_pembayaran
        $buktiPembayaranName = null; // Inisialisasi di luar blok if

        if ($request->hasFile('bukti_pembayaran')) {
            $buktiPembayaran = $request->file('bukti_pembayaran');
            $buktiPembayaranName = $buktiPembayaran->hashName();
            $buktiPembayaran->storeAs('public/bukti_pembayaran', $buktiPembayaranName); // Simpan buktinya
            $data['bukti_pembayaran'] = $buktiPembayaranName; // Tambahkan nama file ke data Penjualan
        }

        try {
            $Penjualan = PenjualanModel::create($data); // Buat Penjualan
        } catch (\Exception $e) {
            // Tangani kesalahan database atau lainnya
            return response()->json(['error' => 'Penjualan gagal dibuat: ' . $e->getMessage()], 500);
        }


        // Tambahkan logika lain setelah Penjualan dibuat, misalnya detail Penjualan, dll.

        return response()->json($Penjualan, 201);
    }

    /**
     * Menampilkan detail Penjualan.
     *
     * @param  \App\Models\PenjualanModel  $Penjualan
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(PenjualanModel $Penjualan)
    {
        try{
           return response()->json($Penjualan->load([])); // Load relasi jika ada
        } catch (\Exception $e) {
            return response()->json(['error' => 'Gagal menampilkan Penjualan: ' . $e->getMessage()], 500);
        }

    }

    /**
     * Memperbarui Penjualan yang sudah ada.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\PenjualanModel  $Penjualan
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, PenjualanModel $Penjualan)
    {
        $validator = Validator::make($request->all(), [
            // Aturan validasi untuk update
            'total_harga' => 'sometimes|required|numeric|min:0',
            'bukti_pembayaran' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            // ... tambahkan validasi lain sesuai kebutuhan
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $data = $request->except('bukti_pembayaran');
        $buktiPembayaranName = $Penjualan->bukti_pembayaran; // gunakan nama file yang lama

        if ($request->hasFile('bukti_pembayaran')) {
            $buktiPembayaran = $request->file('bukti_pembayaran');
            $buktiPembayaranName = $buktiPembayaran->hashName();
            $buktiPembayaran->storeAs('public/bukti_pembayaran', $buktiPembayaranName);
            $data['bukti_pembayaran'] = $buktiPembayaranName;

             // Hapus file lama jika ada
            if ($Penjualan->bukti_pembayaran && Storage::exists('public/bukti_pembayaran/' . $Penjualan->bukti_pembayaran)) {
                  Storage::delete('public/bukti_pembayaran/' . $Penjualan->bukti_pembayaran);
            }
        }

        try {
             $Penjualan->update($data);
        } catch (\Exception $e) {
             return response()->json(['error' => 'Gagal memperbarui Penjualan: ' . $e->getMessage()], 500);
        }
       

        return response()->json($Penjualan);
    }

    /**
     * Menghapus Penjualan.
     *
     * @param  \App\Models\PenjualanModel  $Penjualan
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(PenjualanModel $Penjualan)
    {
        try {
             // Hapus file terkait jika ada
            if ($Penjualan->bukti_pembayaran && Storage::exists('public/bukti_pembayaran/' . $Penjualan->bukti_pembayaran)) {
                Storage::delete('public/bukti_pembayaran/' . $Penjualan->bukti_pembayaran);
            }
            $Penjualan->delete();
            return response()->json(['message' => 'Penjualan berhasil dihapus']);
        } catch (\Exception $e) {
             return response()->json(['error' => 'Gagal menghapus Penjualan: ' . $e->getMessage()], 500);
        }
       
    }
}
