<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Penerbit;


class PenerbitController extends Controller
{
    public function index()
    {
        $penerbit = Penerbit::all();
        return view('admin.penerbit.index', compact('penerbit'));
    }

    public function create()
    {
        
        return view('admin.penerbit.create');
    }

    public function store(Request $request)
    {
        try {
            $validasi = [
                'nama_penerbit' => "required|max:100"
            ];
            $mesages = [
                "nama_penerbit.required" => "Nama Penerbit wajib diisi",
                "nama_penerbit.max" => "Nama Penerbit hanya maksimal 100 karakter",
            ];
            $validation = Validator::make($request->all(),$validasi,$mesages);
            if($validation->fails()){
                return back()->withErrors($validation)
                    ->withInput();
            }

            $data = [
                "nama_penerbit" => $request->nama_penerbit
            ];
            Penerbit::create($data);
            return redirect()->route('penerbit')
            ->with('success', 'Data berhasil disimpan');
        }catch (\Exception $e) {

            return back()->withErrors([
                'error' => 'Terjadi kesalahan: ' . $e->getMessage()
            ])->withInput();
        }
    }
    public function edit($id)
    {
        $penerbit = Penerbit::findOrFail($id);

        return view('admin.penerbit.edit', compact('penerbit'));
    }
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_penerbit' => 'required'
        ]);

        $penerbit = Penerbit::findOrFail($id);

        $penerbit->update([
            'nama_penerbit' => $request->nama_penerbit
        ]);

        return redirect()->route('penerbit')
                        ->with('success', 'Data penerbit berhasil diupdate');
    }
    public function destroy($id)
    {
        $penerbit = Penerbit::findOrFail($id);

        if ($penerbit->buku()->count() > 0) {
            return back()->with(
                'error',
                'penerbit tidak dapat dihapus karena masih digunakan oleh data buku.'
            );
        }

        $penerbit->delete();

        return redirect()->route('penerbit')
                        ->with('success', 'Data berhasil dihapus');
    }
}
