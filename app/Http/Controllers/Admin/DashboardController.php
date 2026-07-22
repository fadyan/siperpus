<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Buku;
use App\Models\Kelas_Group;
use App\Models\Siswa;

class DashboardController extends Controller
{
    public function index()
    {
        $totalBuku = Buku::count();
        $totalStok = Buku::sum('jumlah');
        $totalKelas = Kelas_Group::count();
        $totalSiswa = Siswa::count();

        $limit = request('limit', 8);
        $bukuTerbaru = Buku::with(['kelas','rak_buku','penerbit'])
            ->latest()
            ->take($limit)
            ->get();

        return view('admin.dashboard', compact(
            'totalBuku',
            'totalStok',
            'totalKelas',
            'totalSiswa',
            'bukuTerbaru'
        ));
    }

    public function search(Request $request)
    {
        $keyword = $request->keyword;
        $limit = $request->limit ?? 8; // Default menampilkan 8 data

        $buku = Buku::with(['kelas', 'rak_buku', 'penerbit'])
            ->where(function ($query) use ($keyword) {

                // Tabel buku
                $query->where('judul', 'like', "%{$keyword}%")
                    ->orWhere('pengarang', 'like', "%{$keyword}%")
                    ->orWhere('tahun', 'like', "%{$keyword}%");

                // Relasi kelas
                $query->orWhereHas('kelas', function ($q) use ($keyword) {
                    $q->where('nama', 'like', "%{$keyword}%");
                });

                // Relasi rak buku
                $query->orWhereHas('rak_buku', function ($q) use ($keyword) {
                    $q->where('nama_rak', 'like', "%{$keyword}%");
                });

                // Relasi penerbit
                $query->orWhereHas('penerbit', function ($q) use ($keyword) {
                    $q->where('nama_penerbit', 'like', "%{$keyword}%");
                });

            })
            ->latest()
            ->limit($limit)
            ->get();

        return response()->json($buku);
    }
}