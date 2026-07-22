<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Kelas;


class KelasController extends Controller
{
    public function index()
    {
        $kelas = Kelas::all();
        return view('admin.kelas.index', compact('kelas'));
    }

    public function create()
    {
        
        return view('admin.kelas.create');
    }

    public function store(Request $request)
    {
        try {
            $validasi = [
                'nama' => "required|max:100"
            ];
            $mesages = [
                "nama.required" => "Nama wajib diisi",
                "nama.max" => "Nama hanya maksimal 100 karakter",
            ];
            $validation = Validator::make($request->all(),$validasi,$mesages);
            if($validation->fails()){
                return back()->withErrors($validation)
                    ->withInput();
            }

            $data = [
                "nama" => $request->nama
            ];
            Kelas::create($data);
            return redirect()->route('kelas')
            ->with('success', 'Data berhasil disimpan');
        }catch (\Exception $e) {

            return back()->withErrors([
                'error' => 'Terjadi kesalahan: ' . $e->getMessage()
            ])->withInput();
        }
    }
    public function edit($id)
    {
        $kelas = Kelas::findOrFail($id);

        return view('admin.kelas.edit', compact('kelas'));
    }
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required'
        ]);

        $kelas = Kelas::findOrFail($id);

        $kelas->update([
            'nama' => $request->nama
        ]);

        return redirect()->route('kelas')
                        ->with('success', 'Data kelas berhasil diupdate');
    }
    public function destroy($id)
    {
        $kelas = Kelas::findOrFail($id);

        if ($kelas->buku()->count() > 0) {
            return back()->with(
                'error',
                'Kelas tidak dapat dihapus karena masih digunakan oleh data buku.'
            );
        }

        $kelas->delete();

        return redirect()->route('kelas')
                        ->with('success', 'Data berhasil dihapus');
    }
}
