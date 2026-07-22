@extends('layouts.master')

@section('content')

<style>
    .katalog-buku .card{
        border: 1px solid #dcdcdc !important;
        border-radius: 12px;
        overflow: hidden;
        transition: all .3s ease;
    }

    .katalog-buku .card:hover{
        transform: translateY(-5px);
        box-shadow: 0 8px 20px rgba(0,0,0,.15) !important;
    }
</style>

<div class="app-content-header">
    <div class="container-fluid">
        <h3 class="mb-0">Dashboard Perpustakaan</h3>
    </div>
</div>

<div class="app-content">
    <div class="container-fluid">

        @if(auth()->user()->level === "admin" || auth()->user()->level === "pegawai")
        <div class="row">

            <div class="col-lg-3 col-6">
                <div class="small-box text-bg-primary">
                    <div class="inner">
                        <h3>{{ $totalBuku }}</h3>
                        <p>Total Judul Buku</p>
                    </div>
                    <div class="icon">
                        <i class="bi bi-book"></i>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-6">
                <div class="small-box text-bg-success">
                    <div class="inner">
                        <h3>{{ $totalStok }}</h3>
                        <p>Total Stok Buku</p>
                    </div>
                    <div class="icon">
                        <i class="bi bi-bookshelf"></i>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-6">
                <div class="small-box text-bg-warning">
                    <div class="inner">
                        <h3>{{ $totalKelas }}</h3>
                        <p>Total Kelas</p>
                    </div>
                    <div class="icon">
                        <i class="bi bi-building"></i>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-6">
                <div class="small-box text-bg-danger">
                    <div class="inner">
                        <h3>{{ $totalSiswa }}</h3>
                        <p>Total Siswa</p>
                    </div>
                    <div class="icon">
                        <i class="bi bi-people-fill"></i>
                    </div>
                </div>
            </div>
        </div>
        @endif

        <!-- Katalog Buku -->
        <div class="card mt-3">
            <div class="card-header">
                <h5 class="mb-0">Katalog Buku Terbaru</h5>
            </div>

            <div class="card-body">
                <div class="row mb-3">

                    <div class="col-md-5">
                        <input
                            type="text"
                            id="searchBook"
                            class="form-control"
                            placeholder="Cari Judul, Pengarang, Penerbit...">
                    </div>

                    <div class="col-md-2">
                        <select class="form-select" id="limitBook">
                            <option value="8">8</option>
                            <option value="10">10</option>
                            <option value="20">20</option>
                            <option value="30">30</option>
                            <option value="50">50</option>
                            <option value="100">100</option>
                        </select>
                    </div>

                </div>

                <div class="row katalog-buku" id="hasilPencarian">

                    @forelse($bukuTerbaru as $buku)

                    <div class="col-md-3 mb-4 book-card" data-search="{{ strtolower($buku->judul.' '.$buku->pengarang.' '.$buku->penerbit->nama_penerbit.' '.$buku->kelas->nama.' '.$buku->rak_buku->nama_rak) }}">
                        <div class="card h-100 shadow-sm">

                            @if($buku->cover)
                               <div style="height:280px; overflow:hidden;">
                                    <img src="{{ asset('upload/'.$buku->cover) }}"
                                        class="w-100 h-100"
                                        style="object-fit:contain; background:#f8f9fa;">
                                </div>
                            @else
                                <div style="height:280px; overflow:hidden;">
                                    <img src="{{ asset('assets/img/default-book.jpg') }}"
                                        class="w-100 h-100"
                                        style="object-fit:contain; background:#f8f9fa;"
                                        alt="Default Cover">
                                </div>
                            @endif

                            <div class="card-body">

                                <h6 class="fw-bold" align="center">
                                    {{ $buku->judul }}
                                </h6>

                                <hr>

                                <p class="mb-1">
                                    <strong>Buku Untuk :</strong>
                                    {{ $buku->kelas -> nama }}
                                </p>
                                <p class="mb-1">
                                    <strong>Posisi Rak Buku:</strong>
                                    {{ $buku->rak_buku -> nama_rak }}
                                </p>
                                <p class="mb-1">
                                    <strong>Pengarang:</strong>
                                    {{ $buku->pengarang }}
                                </p>

                                <p class="mb-1">
                                    <strong>Penerbit:</strong>
                                    {{ $buku->penerbit->nama_penerbit }}
                                </p>

                                <p class="mb-2">
                                    <strong>Tahun:</strong>
                                    {{ $buku->tahun }}
                                </p>

                                <div class="d-flex justify-content-between align-items-center mt-3">
                                    <span class="badge bg-primary">
                                        Stok: {{ $buku->jumlah }}
                                    </span>

                                    <a href="{{ route('buku.detail', $buku->id) }}"
                                    class="btn btn-sm btn-info">
                                        <i class="bi bi-eye"></i> Detail
                                    </a>
                                </div>

                            </div>

                        </div>
                    </div>

                    @empty

                    <div class="col-12">
                        <div class="alert alert-info">
                            Belum ada data buku.
                        </div>
                    </div>

                    @endforelse

                </div>

            </div>
        </div>

    </div>
</div>

@endsection
@section('script')

<script>
window.dashboardConfig = {
    searchUrl: "{{ route('dashboard.search') }}",
    detailUrl: "{{ url('/buku/detail') }}",
    // cover
    uploadUrl: "{{ asset('upload') }}",
    defaultCover: "{{ asset('assets/img/default-book.jpg') }}"
};
</script>

<script src="{{ asset('assets/js/dashboard.js') }}"></script>

@endsection