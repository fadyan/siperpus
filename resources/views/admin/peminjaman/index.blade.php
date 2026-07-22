@extends('layouts.master')

@section('content')
<div class="app-content-header">
    <div class="container-fluid">
        <h3 class="mb-0">Data Peminjaman</h3>
    </div>
</div>

<div class="app-content">
    <div class="container-fluid">

        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Daftar Peminjaman Buku</h3>
            </div>

            <div class="card-body">

                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <table id="data" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>No Pinjaman</th>
                            <th>NISN</th>
                            <th>Nama Siswa</th>
                            <th>Kelas</th>
                            <th>Judul Buku</th>
                            <th>Tgl Pinjam</th>
                            <th>Rencana Kembali</th>
                            <th>Status</th>
                            @if(auth()->user()->level === "admin")
                            <th>Aksi</th>
                            @endif
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($peminjaman as $dt)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $dt->no_tiket ?? '-' }}</td>
                            <td>{{ $dt->siswa->nisn ?? '-' }}</td>
                            <td>{{ $dt->siswa->nama_siswa ?? '-' }}</td>
                            <td>
                                {{ $dt->siswa->kelas_group->kelas->nama ?? '-' }}
                                -
                                {{ $dt->siswa->kelas_group->nama_kelas ?? '-' }}
                            </td>
                            <td>{{ $dt->buku->judul ?? '-' }}</td>
                            <td>{{ $dt->tgl_pinjam }}</td>
                            <td>{{ $dt->tgl_rencana_kembali }}</td>
                            <td>
                                @if($dt->status == 'dipinjam')
                                    <span class="badge bg-warning">Dipinjam</span>
                                @else
                                    <span class="badge bg-success">Dikembalikan</span>
                                @endif
                            </td>
                            @if(auth()->user()->level === "admin")
                            <td>
                                @if($dt->status == 'dikembalikan')
                                    <button class="btn btn-secondary btn-sm" disabled>
                                        Sudah Dikembalikan
                                    </button>
                                @else
                                    <a href="{{ route('peminjaman.kembali', $dt->id) }}"
                                    class="btn btn-success btn-sm">
                                        Kembalikan
                                    </a>
                                @endif
                            </td>
                            @endif  
                        </tr>
                       
                        @endforeach
                    </tbody>
                </table>

            </div>
        </div>

    </div>
</div>
@endsection

@section('script')
<script>
$(document).ready(function () {
    $('#data').DataTable({
        responsive: true,
        autoWidth: false,
        language: {
            search: "Cari:",
            lengthMenu: "Tampilkan _MENU_ data",
            zeroRecords: "Data tidak ditemukan",
            info: "Menampilkan _START_ - _END_ dari _TOTAL_ data",
            infoEmpty: "Tidak ada data",
            infoFiltered: "(difilter dari _MAX_ total data)"
        }
    });
});
</script>
@endsection