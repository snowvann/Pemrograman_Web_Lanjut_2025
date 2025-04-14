<?php 

namespace App\Http\Controllers;
 
use App\Models\BarangModel;
use App\Models\KategoriModel;
use App\Models\LevelModel;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Illuminate\Support\Facades\Validator;

class BarangController extends Controller
{
    public function index(){
        $breadcrumb = (object) [
            'title' => 'Daftar Barang',
            'list' => ['Home', 'Barang']
        ];

        $page = (object) [
            'title' => 'Daftar barang yang terdaftar dalam sistem'
        ];

        $activeMenu = 'barang';
        $kategori = KategoriModel::select('kategori_id', 'kategori_nama')->get();
        return view('barang.index', [
            'activeMenu' => $activeMenu,
            'breadcrumb' => $breadcrumb,
            'kategori' => $kategori
        ]);
    }
    
    public function list(Request $request)
    {
        $barang = BarangModel::select('barang_id', 'barang_kode', 'barang_nama', 'harga_beli', 'harga_jual', 'kategori_id')
            ->with('kategori');

        $kategori_id = $request->input('filter_kategori');
        if (!empty($kategori_id)) {
            $barang->where('kategori_id', $kategori_id);
        }

        return DataTables::of($barang)
            // menambahkan kolom index / no urut (default nama kolom: DT_RowIndex)
            ->addIndexColumn()
            ->addColumn('aksi', function ($barang) { // menambahkan kolom aksi
                $btn = '<button onclick="modalAction(\''.url('/barang/' . $barang->barang_id . '/show_ajax').'\')" class="btn btn-info btn-sm">Detail</button> ';
                $btn .= '<button onclick="modalAction(\''.url('/barang/' . $barang->barang_id . '/edit_ajax').'\')" class="btn btn-warning btn-sm">Edit</button> ';
                $btn .= '<button onclick="modalAction(\''.url('/barang/' . $barang->barang_id . '/delete_ajax').'\')" class="btn btn-danger btn-sm">Hapus</button> ';
                return $btn;
            })
            ->rawColumns(['aksi']) // memberitahu bahwa kolom aksi adalah html
            ->make(true);
    }
    
    public function create_ajax()
    {
        $breadcrumb = (object) [
            'title' => 'Daftar Barang',
            'list' => ['Home', 'Barang']
        ];

        $page = (object) [
            'title' => 'Daftar barang yang terdaftar dalam sistem'
        ];

        $activeMenu = 'barang';
        return view('barang.create_ajax', [
            'activeMenu' => $activeMenu,
            'breadcrumb' => $breadcrumb
        ]);
    }

    public function store_ajax(Request $request)
    {
        if($request->ajax() || $request->wantsJson()){ 
            $rules = [ 
                'kategori_id' => ['required', 'integer', 'exists:m_kategori,kategori_id'], 
                'barang_kode' => ['required', 'min:3', 'max:20', 'unique:m_barang,barang_kode'], 
                'barang_nama' => ['required', 'string', 'max:100'], 
                'harga_beli' => ['required', 'numeric'], 
                'harga_jual' => ['required', 'numeric'], 
            ]; 
            $validator = Validator::make($request->all(), $rules); 
            if($validator->fails()){ 
                return response()->json([ 
                    'status' => false, 
                    'message' => 'Validasi Gagal', 
                    'msgField' => $validator->errors() 
                ]); 
            } BarangModel::create($request->all()); 
            return response()->json([ 
                'status' => true, 
                'message' => 'Data berhasil disimpan' 
            ]); 
        } 
        redirect('/');
    }

    public function edit_ajax(string $id)
    {
        $barang = BarangModel::find($id); 
        $level = LevelModel::select('level_id', 'level_nama')->get(); 
        return view('barang.edit_ajax', ['barang' => $barang, 'level' => $level]);
    }

    public function update_ajax(Request $request, $id)
    {
        if ($request->ajax() || $request->wantsJson()) { 
            $rules = [ 
                'kategori_id' => ['required', 'integer', 'exists:m_kategori,kategori_id'], 
                'barang_kode' => ['required', 'min:3', 'max:20', 'unique:m_barang,barang_kode, '. $id .',barang_id'], 
                'barang_nama' => ['required', 'string', 'max:100'], 
                'harga_beli' => ['required', 'numeric'], 
                'harga_jual' => ['required', 'numeric'], 
            ]; 
            // use Illuminate\Support\Facades\Validator; 
            $validator = Validator::make($request->all(), $rules); 
            if ($validator->fails()) { 
                return response()->json([ 
                    'status' => false, // respon json, true: berhasil, false: gagal 
                    'message' => 'Validasi gagal.', 
                    'msgField' => $validator->errors() // menunjukkan field mana yang error 
                    ]); 
            } 
            $check = BarangModel::find($id); 
            if ($check) { $check->update($request->all()); 
                return response()->json([ 
                    'status' => true, 
                    'message' => 'Data berhasil diupdate' 
                ]); 
            } else {
                return response()->json([ 
                    'status' => false, 
                    'message' => 'Data tidak ditemukan' 
                ]); 
            } 
        } 
        return redirect('/');
    }

    public function confirm_ajax($id) { 
        $barang = BarangModel::find($id); 
        return view('barang.confirm_ajax', ['barang' => $barang]); 
    }

    public function delete_ajax(Request $request, $id) { 
        if($request->ajax() || $request->wantsJson()){ 
            $barang = BarangModel::find($id); 
            if($barang){ // jika sudah ditemuikan 
                $barang->delete(); // barang di hapus 
                return response()->json([ 
                    'status' => true, 
                    'message' => 'Data berhasil dihapus' 
                ]); 
            } else { 
                return response()->json([ 
                    'status' => false, 
                    'message' => 'Data tidak ditemukan' 
                ]); 
            } 
        } 
        return redirect('/'); 
    }

    public function import() { 
        $breadcrumb = (object) [
            'title' => 'Import Barang',
            'list' => ['Home', 'Barang']
        ];

        $page = (object) [
            'title' => 'Import Barang'
        ];

        $activeMenu = 'barang';
        return view('barang.import', [
            'activeMenu' => $activeMenu,
            'breadcrumb' => $breadcrumb
        ]);
    }

    public function import_ajax(Request $request)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'file_barang' => ['required', 'mimes:xlsx', 'max:1024']
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi Gagal',
                    'msgField' => $validator->errors()
                ]);
            }

            try {
                $file = $request->file('file_barang');

                // Load Excel
                $reader = IOFactory::createReader('Xlsx');
                $reader->setReadDataOnly(true);
                $spreadsheet = $reader->load($file->getRealPath());
                $sheet = $spreadsheet->getActiveSheet();
                $data = $sheet->toArray(null, false, true, true); // key by column A, B, C

                $insert = [];

                if (count($data) > 1) {
                    foreach ($data as $row => $value) {
                        if ($row == 1) continue; // skip header

                        // Cek data minimal harus lengkap
                        if (!isset($value['A'], $value['B'], $value['C'], $value['D'], $value['E'])) continue;

                        // Optional: cek apakah kategori_id valid (sudah ada di tabel kategori)
                        $insert[] = [
                            'kategori_id' => (int) $value['A'],
                            'barang_kode' => trim($value['B']),
                            'barang_nama' => trim($value['C']),
                            'harga_beli' => (int) $value['D'],
                            'harga_jual' => (int) $value['E'],
                            'created_at' => now(),
                            'updated_at' => now(),
                        ];
                    }

                    if (!empty($insert)) {
                        BarangModel::insertOrIgnore($insert);
                        return response()->json([
                            'status' => true,
                            'message' => 'Data berhasil diimport'
                        ]);
                    }
                }

                return response()->json([
                    'status' => false,
                    'message' => 'Tidak ada data yang bisa diimport'
                ]);
            } catch (\Exception $e) {
                return response()->json([
                    'status' => false,
                    'message' => 'Terjadi kesalahan saat import: ' . $e->getMessage()
                ]);
            }
        }

        return redirect('/');
    }
}