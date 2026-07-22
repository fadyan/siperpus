<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Pegawai;

class PegawaiController extends Controller
{
    public function index()
    {
        $pegawai = Pegawai::all();
        return view('admin.pegawai.index', compact('pegawai'));
    }

    public function create()
{
    return view('admin.pegawai.create',);
}

    public function store(Request $request)
    {
        try {
            $validasi = [
                'nip'             => 'required',
                'nama_pegawai'    => 'required|max:100',
                'jk'              => 'required|in:L,P',
                'alamat'          => 'required',
                'jabatan'         => 'required',
            ];

            $messages = [
                'nip.required'           => 'NIP wajib diisi',
                // 'nip.unique'             => 'NIP sudah digunakan',

                'nama_pegawai.required'   => 'Nama pegawai wajib diisi',
                'nama_pegawai.max'        => 'Nama pegawai maksimal 100 karakter',

                'jk.required'             => 'Jenis kelamin wajib dipilih',
                'jk.in'                   => 'Jenis kelamin tidak valid',
                'alamat.required'   => 'Tempat lahir wajib diisi',
                'jabatan.required'  => 'Tanggal lahir wajib diisi',
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

            Pegawai::create([
                'nip'           => $request->nip,
                'nama_pegawai'   => $request->nama_pegawai,
                'jk'             => $request->jk,
                'alamat'         => $request->alamat,
                'jabatan'        => $request->jabatan,
            ]);

            return redirect()
                ->route('pegawai')
                ->with('success', 'Data pegawai berhasil disimpan');

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
        $pegawai = Pegawai::findOrFail($id);

        return view('admin.pegawai.edit', compact('pegawai')
        );
    }

    public function update(Request $request, $id)
    {
        $pegawai = pegawai::findOrFail($id);

        $validasi = [
            'nip' => 'required',
            'nama_pegawai' => 'required|max:100',
            'jk'           => 'required|in:L,P',
            'alamat'       => 'required',
            'jabatan'      => 'required',
        ];

        $validation = Validator::make($request->all(), $validasi);

        if ($validation->fails()) {
            return back()
                ->withErrors($validation)
                ->withInput();
        }

        $pegawai->update([
            'nip'          => $request->nip,
            'nama_pegawai' => $request->nama_pegawai,
            'jk'           => $request->jk,
            'alamat'       => $request->alamat,
            'jabatan'      => $request->jabatan,
        ]);

        return redirect()
            ->route('pegawai')
            ->with('success', 'Data pegawai berhasil diupdate');
    }

    public function destroy($id)
    {
        $pegawai = Pegawai::findOrFail($id);

        $pegawai->delete();

        return redirect()
            ->route('pegawai')
            ->with('success', 'Data pegawai berhasil dihapus');
    }
}