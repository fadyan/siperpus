<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Peminjaman;
use App\Models\Buku;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class PeminjamanController extends Controller
{
    public function store(Request $request)
    {
        try {

            $validasi = [
                'siswa_id' => 'required',
                'buku_id' => 'required',
                'tgl_pinjam' => 'required|date',
                'tgl_rencana_kembali' => 'required|date|after_or_equal:tgl_pinjam',
            ];

            $messages = [
                'siswa_id.required' => 'Siswa wajib dipilih',
                'buku_id.required' => 'Buku wajib dipilih',

                'tgl_pinjam.required' => 'Tanggal pinjam wajib diisi',
                'tgl_pinjam.date' => 'Format tanggal pinjam tidak valid',

                'tgl_rencana_kembali.required' => 'Tanggal rencana kembali wajib diisi',
                'tgl_rencana_kembali.date' => 'Format tanggal rencana kembali tidak valid',
                'tgl_rencana_kembali.after_or_equal' => 'Tanggal rencana kembali tidak boleh sebelum tanggal pinjam',
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

            $buku = Buku::findOrFail($request->buku_id);

            if ($buku->jumlah <= 0) {
                return back()
                    ->withErrors([
                        'error' => 'Stok buku habis'
                    ])
                    ->withInput();
            }
            $kodeTanggal = Carbon::now()->format('Ymd');
            $last = Peminjaman::whereDate('created_at', Carbon::today())
                ->count();
            $no_tiket = 'PJM-' . $kodeTanggal . '-' . str_pad($last + 1, 4, '0', STR_PAD_LEFT);
            Peminjaman::create([
                'siswa_id' => $request->siswa_id,
                'buku_id' => $request->buku_id,
                'no_tiket' => $no_tiket,
                'tgl_pinjam' => $request->tgl_pinjam,
                'tgl_rencana_kembali' => $request->tgl_rencana_kembali,
                'status' => 'dipinjam'
            ]);

            $buku->decrement('jumlah');

            return response()->json([
                'status' => 'success',
                'pesan' => 'Peminjaman berhasil disimpan'
            ]);

        } catch (\Exception $e) {

            return response()->json([
                'status' => 'error',
                'pesan' => $e
            ]);
        }
    }
    public function index()
    {
        if(Auth::user()->level === "admin" || Auth::user()->level === "pegawai"){
            $peminjaman = Peminjaman::with(['siswa.kelas_group.kelas', 'buku'])->get();
        }else{
            $peminjaman = Peminjaman::with(['siswa.kelas_group.kelas', 'buku'])
            ->where("siswa_id",Auth::user()->data_id)
            ->get();
        }
        return view('admin.peminjaman.index',compact('peminjaman'));
    }
    public function kembali($id)
    {
        $peminjaman = Peminjaman::findOrFail($id);

        // ❌ kalau sudah dikembalikan
        if ($peminjaman->status == 'dikembalikan') {
            return redirect()
                ->back()
                ->with('error', 'Buku ini sudah dikembalikan');
        }

        return view('admin.peminjaman.kembali', compact('peminjaman'));
    }
    public function update(Request $request, $id)
        {
            $request->validate([
                'tgl_kembali' => 'required|date'
            ]);

            $peminjaman = Peminjaman::findOrFail($id);

            // 1. update peminjaman
            $peminjaman->update([
                'tgl_kembali' => $request->tgl_kembali,
                'status' => 'dikembalikan' // ✅ INI PENTING
            ]);

            // 2. update stok buku (balikin stok)
            $buku = Buku::findOrFail($peminjaman->buku_id);
            $buku->increment('jumlah');

            return redirect()
                ->route('peminjaman')
                ->with('success', 'Buku berhasil dikembalikan');
        }
}
