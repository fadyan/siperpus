<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Models\Siswa;
use App\Models\Pegawai;
class UserController extends Controller
{
    public function index(){
        $data = User::all();
        return view("admin.user.index",compact("data"));
    }

    public function create()
    {
        return view('admin.user.create');
    }

    public function list_data(Request $request)
    {
        $level = $request->level;
        if($level === "siswa"){
            $data = Siswa::select('id', 'nama_siswa as nama','nisn')
            ->get()
            ->map(function ($item) {
                return [
                    'id' => $item->id,
                    'nama' => $item->nisn . ' - ' . $item->nama
                ];
            });;
        }else{
            $data = Pegawai::select('id', 'nama_pegawai as nama')->get();
        }
        return response()->json([
            "status" => "succses",
            "data" => $data
        ]);
    }



    public function store(Request $request)
    {
        try {
            $validasi = [
                'data_id'          => 'required',
                'level'            => 'required|in:admin,siswa,pegawai',
                'nama'             => 'required|max:100',
                'username'         => 'required|unique:users,username',
                'password'         => 'required|confirmed',
            ];

            $messages = [
                'data_id.required'      => 'Data User wajib dipilih',
                'level.required'        => 'Level wajib dipilih',
                'level.in'              => 'Level  tidak valid',
                'nama.required'         => 'Nama wajib diisi',
                'nama.max'              => 'Nama maksimal 100 karakter',
                'username.required'     => 'Username wajib diisi',
                'username.unique'       => 'Username ini sudah digunakan',
                'password.required'     => 'Password wajib diisi',
                'password.confirmed'    => 'Konfirmasi password tidak cocok',   
            ];

            $validation = Validator::make(
                $request->all(),
                $validasi,
                $messages
            );

            if ($validation->fails()) {
                return back()
                    ->withErrors($validation)
                    ->withInput();
            }

            User::create([
                'data_id'           => $request->data_id,
                'level'   => $request->level,
                'nama'             => $request->nama,
                'username'         => $request->username,
                'password'        => $request->password,
            ]);

            return redirect()
                ->route('user')
                ->with('success', 'Data User berhasil disimpan');

        } catch (\Exception $e) {

            return back()
                ->withErrors([
                    'error' => 'Terjadi kesalahan: '.$e->getMessage()
                ])
                ->withInput();
        }
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);

        $user->delete();

        return redirect()
            ->route('user')
            ->with('success', 'Data user berhasil dihapus');
    }
}
