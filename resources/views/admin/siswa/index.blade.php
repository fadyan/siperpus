@extends('layouts.master')

@section('content')
<div class="app-content-header">
    <div class="container-fluid">
        <h3 class="mb-0">Data Siswa</h3>
    </div>
</div>

<div class="app-content">
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Daftar Data Siswa</h3>
                <div class="card-tools">
                    <a href="{{ route('siswa.create') }}" class="btn btn-primary btn-sm">
                        <i class="bi bi-plus-lg"></i> Tambah
                    </a>
                </div>
            </div>
            <div class="card-body">
                @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button"
                        class="btn-close"
                        data-bs-dismiss="alert"
                        aria-label="Close"></button>
                </div>
                @endif
                <table id="data" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th width='5px'>No</th>
                            <th>Nama Lengkap</th>
                            <th>NISN</th>
                            <th>Jenis Kelamin</th>
                            <th>Tempat Lahir</th>
                            <th>Tanggal Lahir</th>
                            <th>Kelas</th>
                            @if(auth()->user()->level === "admin")
                            <th width='10%'>Aksi</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @php $no=1; @endphp
                        @foreach($siswa as $dt)
                            <tr>
                                <td>{{ $no }}</td>
                                <td>{{ $dt->nama_siswa }}</td>
                                <td>{{ $dt->nisn }}</td>
                                <td>{{ $dt->jk }}</td>
                                <td>{{ $dt->tempat_lahir }}</td>
                                <td>{{ $dt->tanggal_lahir }}</td>
                                <td>{{ $dt->kelas_group->kelas->nama}} - {{ $dt->kelas_group->nama_kelas}}</td>
                                @if(auth()->user()->level === "admin")
                                <td>
                                     <a href="{{ route('siswa.edit', $dt->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                    <form action="{{ route('siswa.delete', $dt->id) }}"
                                        method="POST"
                                        style="display:inline;" class="delete-form d-inline">
                                        @csrf
                                        @method('DELETE')

                                        <button type="submit"
                                                class="btn btn-danger btn-sm">
                                            Hapus
                                        </button>
                                    </form>
                                </td>
                                @endif
                            </tr>
                            @php $no++ @endphp
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