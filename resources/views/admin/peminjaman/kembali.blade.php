@extends('layouts.master')

@section('content')

<div class="app-content-header">
    <div class="container-fluid">
        <h3 class="mb-0">Pengembalian Buku</h3>
    </div>
</div>

<div class="app-content">
    <div class="container-fluid">

        <div class="card">

            <form action="{{ route('peminjaman.update', $peminjaman->id) }}"
                  method="POST">
                @csrf
                @method('PUT')

                <div class="card-body">

                    {{-- NO PINJAMAN --}}
                    <div class="mb-3">
                        <label class="form-label">No Pinjaman</label>
                        <input type="text"
                               class="form-control"
                               value="{{ $peminjaman->no_tiket }}"
                               readonly>
                    </div>

                    {{-- NISN --}}
                    <div class="mb-3">
                        <label class="form-label">NISN</label>
                        <input type="text"
                               class="form-control"
                               value="{{ $peminjaman->siswa->nisn }}"
                               readonly>
                    </div>

                    {{-- NAMA --}}
                    <div class="mb-3">
                        <label class="form-label">Nama Siswa</label>
                        <input type="text"
                               class="form-control"
                               value="{{ $peminjaman->siswa->nama_siswa }}"
                               readonly>
                    </div>

                    {{-- KELAS --}}
                    <div class="mb-3">
                        <label class="form-label">Kelas</label>
                        <input type="text"
                               class="form-control"
                               value="{{ $peminjaman->siswa->kelas_group->kelas->nama ?? '' }} - {{ $peminjaman->siswa->kelas_group->nama_kelas ?? '' }}"
                               readonly>
                    </div>

                    {{-- JUDUL BUKU --}}
                    <div class="mb-3">
                        <label class="form-label">Judul Buku</label>
                        <input type="text"
                               class="form-control"
                               value="{{ $peminjaman->buku->judul }}"
                               readonly>
                    </div>

                    {{-- TGL PINJAM --}}
                    <div class="mb-3">
                        <label class="form-label">Tanggal Pinjam</label>
                        <input type="date"
                               class="form-control"
                               value="{{ $peminjaman->tgl_pinjam }}"
                               readonly>
                    </div>

                    {{-- RENCANA KEMBALI --}}
                    <div class="mb-3">
                        <label class="form-label">Rencana Kembali</label>
                        <input type="date"
                               class="form-control"
                               value="{{ $peminjaman->tgl_rencana_kembali }}"
                               readonly>
                    </div>

                    {{-- TGL KEMBALI (ONLY EDITABLE) --}}
                    <div class="mb-3">
                        <label class="form-label">Tanggal Kembali</label>
                        <input type="date"
                               name="tgl_kembali"
                               class="form-control @error('tgl_kembali') is-invalid @enderror"
                               value="{{ old('tgl_kembali', $peminjaman->tgl_kembali) }}"
                               required>

                        @error('tgl_kembali')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                </div>

                <div class="card-footer">
                    <button type="submit" class="btn btn-success">
                        Simpan Pengembalian
                    </button>

                    <a href="{{ route('peminjaman') }}" class="btn btn-secondary">
                        Kembali
                    </a>
                </div>

            </form>

        </div>

    </div>
</div>

@endsection