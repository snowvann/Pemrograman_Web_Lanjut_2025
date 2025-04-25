<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserModel;
use App\Models\LevelModel;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Daftar User',
            'list' => ['Home', 'User']
        ];

        $page = (object) [
            'title' => 'Daftar User yang terdaftar dalam sistem'
        ];

        $activeMenu = 'user'; // set menu yang aktif

        $level = LevelModel::all(); // ambil data level untuk filter level

        return view('user.index', [
            'breadcrumb' => $breadcrumb, 
            'page' => $page, 
            'level' => $level, 
            'activeMenu' => $activeMenu]);
    }

    public function list(Request $request)
    {
        $users = UserModel::select('user_id', 'username', 'nama', 'level_id')->with('level');

        // Filter data user berdasarkan level_id
        if ($request->level_id) {
            $users->where('level_id', $request->level_id);
        }

        return DataTables::of($users)
            ->addIndexColumn()
            ->addColumn('aksi', function ($user) {
                $btn = '<a href="' . url('/user/' . $user->user_id) . '" class="btn btn-info btn-sm">Detail</a> ';

                $btn .= '<button onclick="modalAction(\''.url('/user/' . $user->user_id . '/edit_ajax').'\')" ';
                $btn .= 'class="btn btn-warning btn-sm">Edit</button> ';

                $btn .= '<button onclick="modalAction(\''.url('/user/' . $user->user_id . '/delete_ajax').'\')" ';
                $btn .= 'class="btn btn-danger btn-sm">Hapus</button> ';
                return $btn;
            })
            ->rawColumns(['aksi'])
            ->make(true);

    }

    public function show($id)
    {
        $user = UserModel::with('level')->find($id);

        $breadcrumb = (object) [
            'title' => 'Detail User',
            'list' => ['Home', 'User', 'Detail']
        ];

        $page = (object) [
            'title' => 'Detail User'
        ];

        $activeMenu = 'user'; // set menu yang aktif

        return view('user.show', ['breadcrumb' => $breadcrumb, 'page' => $page, 'user' => $user, 'activeMenu' => $activeMenu]);
    }

    public function create_ajax()
    {
        $level = LevelModel::select('level_id', 'level_name')->get();

        return view('user.create_ajax')
                    ->with('level', $level);
    }

    public function store_ajax(Request $request)
    {
        if($request->ajax() || $request->wantsJson()) {
            $rules = [
                'level_id' => 'required|integer',
                'username' => 'required|string|min:3|unique:m_user,username',
                'nama'     => 'required|string|max:100',
                'password' => 'required|min:5',
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi Gagal',
                    'msgField' => $validator->errors(),
                ]);
            }

            UserModel::create($request->all());
            return response()->json([
                'status' => true,
                'message' => 'Data user berhasil disimpan'
            ]);
        }
        redirect('/');
    }

    public function edit_ajax(string $id)
    {
        $user = UserModel::find($id);
        $level = LevelModel::select('level_id', 'level_name')->get();

        return view('user.edit_ajax', ['user' => $user, 'level' => $level]);
    }

    public function update_ajax(Request $request, $id)
    {
        // cek apakah ada request ajax
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'level_id'  => 'required|integer',
                'username'  => 'required|max:20|unique:m_user,username,' . $id . ',user_id',
                'nama'      => 'required|max:100',
                'password'  => 'nullable|min:5|max:20'
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'status'   => false, // respon json, true jika validasi berhasil, false jika gagal
                    'message'  => 'Validasi gagal.',
                    'msgField' => $validator->errors() // ambil pesan error dari validator
                ]);
            }

            $check = UserModel::find($id);
            if ($check) {
                if (!$request->filled('password')) { // jika password tidak diisi, hapus dari request
                    $request->request->remove('password');
                }

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
        $user = UserModel::find($id);
        return view('user.confirm_ajax', ['user' => $user]);
    }

    public function delete_ajax(Request $request, $id)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $user = UserModel::find($id);
            if ($user) {
                $user->delete();
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

    //Menampilkan form import user
    public function import()
    {
      return view('user.import');
    }

    //Mengimport data user dari file excel
    public function import_ajax(Request $request)
    {
        if ($request->ajax() || $request->wantsJson()) {
          $rules = [
            //validasi file harus xls atau xlsx max 1mb
            'file_user' => ['required', 'mimes:xlsx', 'max:1024']
          ];
          $validator = Validator::make($request->all(), $rules);
          if ($validator->fails()) {
              return response()->json([
                  'status' => false,
                  'message' => 'Validasi Gagal',
                  'msgField' => $validator->errors()
              ]);
          }
            $file = $request->file('file_user'); //ambil file dari request
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
                            'user_id' => $value['A'],
                            'username' => $value['B'],
                            'nama' => $value['C'],
                            'level_id' => $value['D'],
                            'password' => bcrypt('password'), // default adalah password jika tidak ada di template
                            'created_at' => now(),
                        ];
                    }
                }
                if (count($insert) > 0) {
                  //insert data ke database, jika sudah ada maka diabaikan
                    UserModel::insertOrIgnore($insert);
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
        // Ambil data users yang akan diekspor
        $users = UserModel::select('user_id', 'username', 'nama', 'level_id')
            ->orderBy('user_id')
            ->with('level')
            ->get();

        // Load library PhpSpreadsheet
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Set header kolom
        $sheet->setCellValue('A1', 'No');
        $sheet->setCellValue('B1', 'User ID');
        $sheet->setCellValue('C1', 'Username');
        $sheet->setCellValue('D1', 'Nama');
        $sheet->setCellValue('E1', 'Level');

        // Format header bold
        $sheet->getStyle('A1:E1')->getFont()->setBold(true);

        // Isi data users
        $no = 1;
        $baris = 2;
        foreach ($users as $user) {
            $sheet->setCellValue('A' . $baris, $no);
            $sheet->setCellValue('B' . $baris, $user->user_id);
            $sheet->setCellValue('C' . $baris, $user->username);
            $sheet->setCellValue('D' . $baris, $user->nama);
            $sheet->setCellValue('E' . $baris, $user->level->level_name);
            $baris++;
            $no++;
        }

        // Set auto size untuk kolom
        foreach (range('A', 'E') as $columnID) {
            $sheet->getColumnDimension($columnID)->setAutoSize(true);
        }

        // Set title sheet
        $sheet->setTitle('Data User');

        // Generate filename
        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $filename = 'Data_User_' . date('Y-m-d H:i:s') . '.xlsx';

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
        $users = UserModel::select('user_id', 'username', 'nama', 'level_id')
            ->orderBy('user_id')
            ->with('level')
            ->get();

        $pdf = Pdf::loadView('user.export_pdf', ['user' => $users]);
        $pdf->setPaper('a4', 'portrait'); // set ukuran kertas dan orientasi
        $pdf->setOption("isRemoteEnabled", true); // set true jika ada gambar dari url
        $pdf->render();

        return $pdf->stream('Data user ' . date('Y-m-d H:i:s') . '.pdf');
    }

    //menampilkan halaman profil
    public function profilePage()
    {
        $user = auth()->user();
        if (!$user) {
           return redirect('/login')->with('error', 'Silahkan login terlebih dahulu');
       }

       $breadcrumb = (object) [
           'title' => 'Profile User',
           'list' => ['Home', 'Profile']
       ];

       $page = (object) [
           'title' => 'Profil Pengguna'
       ];

       $activeMenu = 'profile';

       return view('user.profile', compact('user', 'breadcrumb', 'page', 'activeMenu'));
    }

    //Menampilkan halaman form edit photo
    public function editPhoto(Request $request)
    {
        // Validasi file
        $request->validate([
            'foto_profil' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        try {

            $user = auth()->user();

            if (!$user) {
                return redirect('/login')->with('error', 'Silahkan login terlebih dahulu');
            }

            $userId = $user->user_id;

            $userModel = UserModel::find($userId);

            if (!$userModel) {
                return redirect('/login')->with('error', 'User tidak ditemukan');
            }

            if ($userModel->foto_profil && file_exists(storage_path('app/public/' . $userModel->foto_profil))) {
                Storage::disk('public')->delete($userModel->foto_profil);
            }

            $fileName = 'profile_' . $userId . '_' . time() . '.' . $request->foto_profil->extension();
            $path = $request->foto_profil->storeAs('profiles', $fileName, 'public');

            UserModel::where('user_id', $userId)->update([
                'foto_profil' => $path
            ]);

            return redirect()->back()->with('success', 'Foto profile berhasil diperbarui');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal mengupload foto: ' . $e->getMessage());
        }
    }
}
