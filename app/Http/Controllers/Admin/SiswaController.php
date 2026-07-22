<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Siswa;
use App\Models\Kelas_Group;

class SiswaController extends Controller
{
    public function index()
    {
        $siswa = Siswa::all();
        return view('admin.siswa.index', compact('siswa'));
    }

    public function create()
{
    $kelas_group = Kelas_Group::all();
    return view('admin.siswa.create', compact('kelas_group')
    );
}

    public function store(Request $request)
    {
        try {
            $validasi = [
                'nisn'            => 'required|unique:siswa,nisn',
                'nama_siswa'      => 'required|max:100',
                'jk'              => 'required|in:L,P',
                'tempat_lahir'    => 'required|max:100',
                'tanggal_lahir'   => 'required|date',
                'kelas_group_id'  => 'required'
            ];

            $messages = [
                'nisn.required'           => 'NISN wajib diisi',
                'nisn.unique'             => 'NISN sudah digunakan',

                'nama_siswa.required'     => 'Nama siswa wajib diisi',
                'nama_siswa.max'          => 'Nama siswa maksimal 100 karakter',

                'jk.required'             => 'Jenis kelamin wajib dipilih',
                'jk.in'                   => 'Jenis kelamin tidak valid',

                'tempat_lahir.required'   => 'Tempat lahir wajib diisi',
                'tempat_lahir.max'        => 'Tempat lahir maksimal 100 karakter',

                'tanggal_lahir.required'  => 'Tanggal lahir wajib diisi',
                'tanggal_lahir.date'      => 'Format tanggal lahir tidak valid',

                'kelas_group_id.required' => 'Kelas wajib dipilih',
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

            Siswa::create([
                'nisn'           => $request->nisn,
                'nama_siswa'     => $request->nama_siswa,
                'jk'             => $request->jk,
                'tempat_lahir'   => $request->tempat_lahir,
                'tanggal_lahir'  => $request->tanggal_lahir,
                'kelas_group_id' => $request->kelas_group_id,
            ]);

            return redirect()
                ->route('siswa')
                ->with('success', 'Data siswa berhasil disimpan');

        } catch (\Exception $e) {

            return back()
                ->withErrors([
                    'error' => 'Terjadi kesalahan: '.$e->getMessage()
                ])
                ->withInput();
        }
    }

    public function edit($id)
    {
        $siswa = Siswa::findOrFail($id);
        $kelas_group = Kelas_Group::all();

        return view('admin.siswa.edit', compact('siswa', 'kelas_group')
        );
    }

    public function update(Request $request, $id)
    {
        $siswa = Siswa::findOrFail($id);

        $validasi = [
            'nisn' => 'required|unique:siswa,nisn,' . $id,
            'nama_siswa' => 'required|max:100',
            'jk' => 'required|in:L,P',
            'tempat_lahir' => 'required|max:100',
            'tanggal_lahir' => 'required|date',
            'kelas_group_id' => 'required'
        ];

        $validation = Validator::make($request->all(), $validasi);

        if ($validation->fails()) {
            return back()
                ->withErrors($validation)
                ->withInput();
        }

        $siswa->update([
            'nisn' => $request->nisn,
            'nama_siswa' => $request->nama_siswa,
            'jk' => $request->jk,
            'tempat_lahir' => $request->tempat_lahir,
            'tanggal_lahir' => $request->tanggal_lahir,
            'kelas_group_id' => $request->kelas_group_id,
        ]);

        return redirect()
            ->route('siswa')
            ->with('success', 'Data siswa berhasil diupdate');
    }

    public function destroy($id)
    {
        $siswa = Siswa::findOrFail($id);

        $siswa->delete();

        return redirect()
            ->route('siswa')
            ->with('success', 'Data siswa berhasil dihapus');
    }
}