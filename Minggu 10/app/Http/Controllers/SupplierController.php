<?php

namespace App\Http\Controllers;

use App\Models\SupplierModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use Barryvdh\DomPDF\Facade\Pdf;

class SupplierController extends Controller
{

    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Daftar Supplier',
            'list' => ['Home', 'Supplier']
        ];

        $page = (object) [
            'title' => 'Daftar supplier yang terdaftar dalam sistem'
        ];

        $activeMenu = 'supplier'; // set menu yang sedang aktif

        return view('supplier.index', ['breadcrumb' => $breadcrumb, 'page' => $page, 'activeMenu' => $activeMenu]);
    }


    public function list(Request $request)
    {
        $suppliers = SupplierModel::select(
            'supplier_id',
            'supplier_kode',
            'supplier_nama',
            'supplier_alamat',
        );

        return DataTables::of($suppliers)
            ->addIndexColumn() // Menambahkan kolom index otomatis
            ->addColumn('aksi', function ($supplier) {
                $btn = '<a href="' . url('/supplier/' . $supplier->supplier_id) . '" class="btn btn-info btn-sm">Detail</a> ';

                $btn .= '<button onclick="modalAction(\''.url('/supplier/' . $supplier->supplier_id . '/edit_ajax').'\')" ';
                $btn .= 'class="btn btn-warning btn-sm">Edit</button> ';

                $btn .= '<button onclick="modalAction(\''.url('/supplier/' . $supplier->supplier_id . '/delete_ajax').'\')" ';
                $btn .= 'class="btn btn-danger btn-sm">Hapus</button> ';
                return $btn;
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }

    public function show(string $id)
    {
        $supplier = SupplierModel::find($id);

        $breadcrumb = (object) [
            'title' => 'Detail Supplier',
            'list' => ['Home', 'Supplier', 'Detail']
        ];

        $page = (object) [
            'title' => 'Detail supplier'
        ];

        $activeMenu = 'supplier'; // Set menu yang sedang aktif

        return view('supplier.show', [
            'breadcrumb' => $breadcrumb,
            'page' => $page,
            'supplier' => $supplier,
            'activeMenu' => $activeMenu
        ]);
    }

    public function create_ajax()
    {
        return view('supplier.create_ajax');
    }

    public function store_ajax(Request $request)
    {
        if($request->ajax() || $request->wantsJson()) {
            $rules = [
                'supplier_kode' => 'required|string|min:3|unique:m_supplier,supplier_id',
                'supplier_nama'     => 'required|string|max:100',
                'supplier_alamat'   => 'required|string',
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi Gagal',
                    'msgField' => $validator->errors(),
                ]);
            }

            SupplierModel::create($request->all());
            return response()->json([
                'status' => true,
                'message' => 'Data supplier berhasil disimpan'
            ]);
        }
        redirect('/');
    }

    public function edit_ajax(string $id)
    {
        $supplier = SupplierModel::find($id);

        return view('supplier.edit_ajax', ['supplier' => $supplier]);
    }

    public function update_ajax(Request $request, $id)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'supplier_kode' => 'required|string|min:3|unique:m_supplier,supplier_kode,' . $id . ',supplier_id',
                'supplier_nama'     => 'required|string|max:100',
                'supplier_alamat'   => 'required|string',
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'status'   => false,
                    'message'  => 'Validasi gagal.',
                    'msgField' => $validator->errors()
                ]);
            }

            $check = SupplierModel::find($id);
            if ($check) {
                $check->update($request->all());
                return response()->json([
                    'status'  => true,
                    'message' => 'Data berhasil diupdate'
                ]);
            } else {
                return response()->json([
                    'status'  => false,
                    'message' => 'Data tidak ditemukan'
                ]);
            }
        }
        return redirect('/');
    }

    public function confirm_ajax(string $id)
    {
        $supplier = SupplierModel::find($id);
        return view('supplier.confirm_ajax', ['supplier' => $supplier]);
    }

    public function delete_ajax(Request $request, $id)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $supplier = SupplierModel::find($id);
            if ($supplier) {
                $supplier->delete();
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

    //Menampilkan form import supplier
    public function import()
    {
      return view('supplier.import');
    }

    //Mengimport data supplier dari file excel
    public function import_ajax(Request $request)
    {
        if ($request->ajax() || $request->wantsJson()) {
          $rules = [
            //validasi file harus xls atau xlsx max 1mb
            'file_supplier' => ['required', 'mimes:xlsx', 'max:1024']
          ];
          $validator = Validator::make($request->all(), $rules);
          if ($validator->fails()) {
              return response()->json([
                  'status' => false,
                  'message' => 'Validasi Gagal',
                  'msgField' => $validator->errors()
              ]);
          }
            $file = $request->file('file_supplier'); //ambil file dari request
            $reader = IOFactory::createReader('Xlsx'); //load reader file excel
            $reader->setReadDataOnly(true); //hanya membaca data
            $spreadsheet = $reader->load($file->getRealPath()); //load file excel
            $sheet = $spreadsheet->getActiveSheet(); //ambil sheet yang aktif
            $data = $sheet->toArray(null, false, true, true); //ambil data excet
            $insert = [];
            if (count($data) > 1) {
                foreach ($data as $baris => $value) {
                    if ($baris > 1) { // baris ke 1 adalah header
                        $insert[] = [
                            'supplier_id' => $value['A'],
                            'supplier_kode' => $value['B'],
                            'supplier_nama' => $value['C'],
                            'supplier_alamat' => $value['D'],
                            'created_at' => now(),
                        ];
                    }
                }
                if (count($insert) > 0) {
                  //insert data ke database, jika sudah ada maka diabaikan
                    SupplierModel::insertOrIgnore($insert);
                  }
                  return response()->json([
                      'status' => true,
                      'message' => 'Data berhasil diimport'
                  ]);
                } else {
                    return response()->json([
                        'status' => false,
                        'message' => 'Tidak ada data yang diimport'
                ]);
            }
        }
        return redirect('/');
    }

    public function export_excel()
    {
        // Ambil data supplier yang akan diekspor
        $suppliers = SupplierModel::select('supplier_id', 'supplier_kode', 'supplier_nama', 'supplier_alamat')->get();

        // Load library PhpSpreadsheet
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet(); // Ambil sheet yang aktif

        // Set header kolom
        $sheet->setCellValue('A1', 'No');
        $sheet->setCellValue('B1', 'Supplier Id');
        $sheet->setCellValue('C1', 'Supplier Kode');
        $sheet->setCellValue('D1', 'Supplier Nama');
        $sheet->setCellValue('E1', 'Supplier Alamat');

        // Format header bold
        $sheet->getStyle('A1:E1')->getFont()->setBold(true);

        // Isi data supplier
        $no = 1;
        $baris = 2;
        foreach ($suppliers as $value) {
            $sheet->setCellValue('A' . $baris, $no);
            $sheet->setCellValue('B' . $baris, $value->supplier_id);
            $sheet->setCellValue('C' . $baris, $value->supplier_kode);
            $sheet->setCellValue('D' . $baris, $value->supplier_nama);
            $sheet->setCellValue('E' . $baris, $value->supplier_alamat);
            $baris++;
            $no++;
        }

        // Set auto size untuk kolom
        foreach (range('A', 'E') as $columnID) {
            $sheet->getColumnDimension($columnID)->setAutoSize(true);
        }

        // Set title sheet
        $sheet->setTitle('Data Supplier');

        // Generate filename
        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $filename = 'Data_Supplier_' . date('Y-m-d H:i:s') . '.xlsx';

        // Set header untuk download file
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');
        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
        header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');
        header('Cache-Control: cache, must-revalidate');
        header('Pragma: public');

        $writer->save('php://output');
        exit;
    }

    public function export_pdf()
    {
        $suppliers = SupplierModel::select('supplier_id', 'supplier_kode', 'supplier_nama', 'supplier_alamat')
            ->orderBy('supplier_id')
            ->get();

        $pdf = Pdf::loadView('supplier.export_pdf', ['supplier' => $suppliers]);
        $pdf->setPaper('a4', 'portrait'); // set ukuran kertas dan orientasi
        $pdf->setOption("isRemoteEnabled", true); // set true jika ada gambar dari url
        $pdf->render();

        return $pdf->stream('Data Supplier ' . date('Y-m-d H:i:s') . '.pdf');
    }
}
