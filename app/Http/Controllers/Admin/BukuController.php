<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Buku;
use App\Models\Kelas;
use App\Models\Siswa;
use App\Models\Rak_Buku;
use App\Models\Penerbit;
use Illuminate\Support\Facades\File;
class BukuController extends Controller
{
     public function index()
    {
        $buku = buku::all();
        return view('admin.buku.index', compact('buku'));
    }

    public function create()
    {
        $kelas = Kelas::all();
        $rak_buku = Rak_Buku::all();
        $penerbit = Penerbit::all();
        return view('admin.buku.create', compact('kelas','rak_buku','penerbit'));
    }

    public function store(Request $request)
    {
        try {
            $validasi = [
                'kelas_id' => "required",
                'judul' => "required|max:100",
                'rak_buku_id' => "required",
                'pengarang' => "required|max:100",
                'penerbit_id' => "required",
                'deskripsi' => "required|max:200",
                'jumlah' => 'required|integer|min:1',
                'tahun' => 'required|digits:4|integer|min:1900|max:' . date('Y'),
                'cover' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'

            ];
            $mesages = [
                "kelas_id.required" => "kelas wajib diisi",
                "judul.required" => "judul wajib diisi",
                "judul.max" => "judul hanya maksimal 100 karakter",
                "rak_buku_id" =>" Rak Buku Wajib Dipilih",
                "pengarang.required" => "pengarang wajib diisi",
                "pengarang.max" => "pengarang hanya maksimal 100 karakter",
                "penerbit_id.required" => "Penerbit wajib diisi",
                "deskripsi.required" => "Deskripsi wajib diisi",
                "deskripsi.max" => "Deskripsi hanya maksimal 1000 karakter",
                'jumlah.required' => 'Jumlah wajib diisi',
                'jumlah.integer'  => 'Jumlah harus berupa angka',
                'jumlah.min'      => 'Jumlah minimal 1',

                'tahun.required'   => 'Tahun wajib diisi',
                'tahun.digits'     => 'Tahun harus 4 digit',
                'tahun.integer'    => 'Tahun harus angka',
                'tahun.min'        => 'Tahun tidak valid',
                'tahun.max'        => 'Tahun tidak boleh lebih dari tahun sekarang',
                
            ];
            $validation = Validator::make($request->all(),$validasi,$mesages);
            if($validation->fails()){
                return back()->withErrors($validation)
                    ->withInput();
            }

            $cover = null;

            if ($request->hasFile('cover')) {

                $file = $request->file('cover');

                $namaFile = time() . '_' . $file->getClientOriginalName();

                $file->move(public_path('upload'), $namaFile);

                $cover = $namaFile;
            }

            $data = [
                "kelas_id" => $request->kelas_id,
                "judul" => $request->judul,
                "rak_buku_id" => $request->rak_buku_id,
                "pengarang" => $request->pengarang,
                "penerbit_id" => $request->penerbit_id,
                "deskripsi" => $request->deskripsi,
                "jumlah" => $request->jumlah,
                "tahun" => $request->tahun,
                "cover" => $cover
            ];
            buku::create($data);
            return redirect()->route('buku')
            ->with('success', 'Data berhasil disimpan');
        }catch (\Exception $e) {

            return back()->withErrors([
                'error' => 'Terjadi kesalahan: ' . $e->getMessage()
            ])->withInput();
        }
    }
    public function edit($id)
    {
        $buku = Buku::findOrFail($id);
        $kelas = Kelas::all();
        $rak_buku =Rak_Buku::all();
        $penerbit =Penerbit::all();
        return view('admin.buku.edit', compact('buku', 'kelas' , 'rak_buku','penerbit'));
    }

    public function update(Request $request, $id)
    {       
        // dd($request->all());exit;
            $buku = Buku::findOrFail($id);

            $cover = $buku->cover;

            if ($request->hasFile('cover')) 
                {

                    // hapus cover lama
                    if ($buku->cover && File::exists(public_path('upload/' . $buku->cover))) {
                        File::delete(public_path('upload/' . $buku->cover));
                    }

                    // upload cover baru
                    $file = $request->file('cover');

                    $namaFile = time() . '_' . $file->getClientOriginalName();

                    $file->move(public_path('upload'), $namaFile);

                    $cover = $namaFile;
                }

            $buku->update([
            'judul' => $request->judul,                
            'kelas_id' => $request->kelas_id,
            'rak_buku_id' => $request->rak_buku_id,
            'pengarang' => $request->pengarang,
            'penerbit_id' => $request->penerbit_id,
            'deskripsi' => $request->deskripsi,
            'jumlah' => $request->jumlah,
            'tahun' => $request->tahun,
            'cover'      => $cover,
        ]);

        return redirect()->route('buku')->with('success', 'Data berhasil diupdate');
    }
    public function destroy($id)
    {
        $buku = Buku::findOrFail($id);
        if ($buku->cover && File::exists(public_path('upload/' . $buku->cover))) 
            {
                File::delete(public_path('upload/' . $buku->cover));
            }

        $buku->delete();

        return redirect()->route('buku')
                        ->with('success', 'Data buku berhasil dihapus');
    }
    public function detail($id)
    {
        $buku = Buku::findOrFail($id);
        $siswa = Siswa::all();
        $rak_buku = Rak_Buku::all();
        $penerbit = Penerbit::all();
        $kelas = Kelas::all();

        return view('admin.buku.detail', compact('buku', 'siswa', 'rak_buku', 'penerbit', 'kelas'));
    }
}
