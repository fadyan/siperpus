<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Rak_Buku;


class Rak_BukuController extends Controller
{
    public function index()
    {
        $rak_buku = Rak_Buku::all();
        return view('admin.rak_buku.index', compact('rak_buku'));
    }

    public function create()
    {
        
        return view('admin.rak_buku.create');
    }

    public function store(Request $request)
    {
        try {
            $validasi = [
                'nama_rak' => "required|max:100"
            ];
            $mesages = [
                "nama_rak.required" => "Nama wajib diisi",
                "nama_rak.max" => "Nama hanya maksimal 100 karakter",
            ];
            $validation = Validator::make($request->all(),$validasi,$mesages);
            if($validation->fails()){
                return back()->withErrors($validation)
                    ->withInput();
            }

            $data = [
                "nama_rak" => $request->nama_rak
            ];
            Rak_Buku::create($data);
            return redirect()->route('rak_buku')
            ->with('success', 'Data berhasil disimpan');
        }catch (\Exception $e) {

            return back()->withErrors([
                'error' => 'Terjadi kesalahan: ' . $e->getMessage()
            ])->withInput();
        }
    }
    public function edit($id)
    {
        $rak_buku = Rak_Buku::findOrFail($id);

        return view('admin.rak_buku.edit', compact('rak_buku'));
    }
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_rak' => 'required'
        ]);

        $rak_buku = Rak_Buku::findOrFail($id);

        $rak_buku->update([
            'nama_rak' => $request->nama_rak
        ]);

        return redirect()->route('rak_buku')
                        ->with('success', 'Data Rak buku berhasil diupdate');
    }
    public function destroy($id)
    {
        $rak_buku = Rak_Buku::findOrFail($id);

        if ($rak_buku->buku()->count() > 0) {
            return back()->with(
                'error',
                'Rak Buku tidak dapat dihapus karena masih digunakan oleh data buku.'
            );
        }

        $rak_buku->delete();

        return redirect()->route('rak_buku')
                        ->with('success', 'Data berhasil dihapus');
    }
}
