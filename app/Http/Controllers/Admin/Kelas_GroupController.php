<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Kelas_Group;
use App\Models\Kelas;

class Kelas_GroupController extends Controller
{
     public function index()
    {
        $kelas_group = kelas_group::all();
        return view('admin.kelas_group.index', compact('kelas_group'));
    }

    public function create()
    {
        $kelas = Kelas::all();
        return view('admin.kelas_group.create', compact('kelas'));
    }

    public function store(Request $request)
    {
        try {
            $validasi = [
                'kelas_id' => "required",
                'nama_kelas' => "required|max:20",

            ];
            $mesages = [
                "kelas_id.required" => "kelas wajib diisi",
                "nama_kelas.required" => "Nama Kelas wajib diisi",
                
            ];
            $validation = Validator::make($request->all(),$validasi,$mesages);
            if($validation->fails()){
                return back()->withErrors($validation)
                    ->withInput();
            }

            $data = [
                "kelas_id" => $request->kelas_id,
                "nama_kelas" => $request->nama_kelas,
            ];
            kelas_group::create($data);
            return redirect()->route('kelas_group')
            ->with('success', 'Data berhasil disimpan');
        }catch (\Exception $e) {

            return back()->withErrors([
                'error' => 'Terjadi kesalahan: ' . $e->getMessage()
            ])->withInput();
        }
    }
    public function edit($id)
    {
        $kelas_group = kelas_group::findOrFail($id);
        $kelas = Kelas::all();
        return view('admin.kelas_group.edit', compact('kelas_group', 'kelas'));
    }

    public function update(Request $request, $id)
    {       
        // dd($request->all());exit;
            $kelas_group = kelas_group::findOrFail($id);

            $kelas_group->update([             
            'kelas_id' => $request->kelas_id,
            'nama_kelas' => $request->nama_kelas,   
        ]);

        return redirect()->route('kelas_group')->with('success', 'Data berhasil diupdate');
    }
    public function destroy($id)
    {
        $kelas_group = kelas_group::findOrFail($id);

        $kelas_group->delete();

        return redirect()->route('kelas_group')
                        ->with('success', 'Data Kelas Group berhasil dihapus');
    }
}
