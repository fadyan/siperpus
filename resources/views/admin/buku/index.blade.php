@extends('layouts.master')

@section('content')
<div class="app-content-header">
    <div class="container-fluid">
        <h3 class="mb-0">Data Buku</h3>
    </div>
</div>

<div class="app-content">
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Daftar Koleksi Buku</h3>
                <div class="card-tools">
                    <a href="{{ route('buku.create') }}" class="btn btn-primary btn-sm">
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
                            <th width="100">Gambar</th>
                            <th width='10%'>Judul</th>
                            <th width='10%'>Rak Buku</th>
                            <th width='5%'>Kelas</th>
                            <th>Pengarang</th>
                            <th>Penerbit</th>
                            <th>Jumlah</th>
                            <th>Tahun</th>
                            @if(auth()->user()->level === "admin")
                            <th width='10%'>Aksi</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @php $no=1; @endphp
                        @foreach($buku as $dt)
                            <tr>
                                <td>{{ $no }}</td>
                                <td class="text-center">
                                    @if($dt->cover)
                                        <img src="{{ asset('upload/'.$dt->cover) }}"
                                            alt="Cover Buku"
                                            class="img-thumbnail"
                                            style="width: 80px; height: 100px; object-fit: cover;">
                                    @else
                                        <img src="{{ asset('assets/img/default-book.jpg') }}"
                                        class="img-thumbnail"
                                        style="width: 90px; height: 100px; object-fit:contain; background:#f8f9fa;"
                                        alt="Default Cover">
                                    @endif
                                </td>
                                <td>{{ $dt->judul }}</td>
                                <td>RAK {{ $dt->rak_buku->nama_rak }}</td>
                                <td>{{ $dt->kelas->nama }}</td>
                                <td>{{ $dt->pengarang }}</td>
                                <td>{{ $dt->penerbit->nama_penerbit }}</td>
                                <td>{{ $dt->jumlah }}</td>
                                <td>{{ $dt->tahun }}</td>
                                @if(auth()->user()->level === "admin")
                                <td>
                                     <a href="{{ route('buku.edit', $dt->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                    <form action="{{ route('buku.delete', $dt->id) }}"
                                        method="POST"
                                        style="display:inline;"
                                        class="delete-form d-inline">
                                        
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