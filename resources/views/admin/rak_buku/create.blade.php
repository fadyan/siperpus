@extends('layouts.master')

@section('content')
<div class="app-content-header">
    <div class="container-fluid">
        <h3 class="mb-0">Tambah Data Rak Buku</h3>
    </div>
</div>

<div class="app-content">
    <div class="container-fluid">
        <div class="card">
            <form action="{{ route('rak_buku.store') }}" method="POST">
                @csrf
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label">Nama Rak Buku</label>
                        <input type="text" name="nama_rak" class="form-control @if($errors->has('nama_rak')) is-invalid @endif" value="{{ old('nama_rak') }}" placeholder="Masukkan Nama Rak">
                        <div class="@if($errors->has('nama_rak')) was-validated  @else invalid-feedback @endif text-danger" role="alert">{{ $errors->first('nama_rak') }}</div>
                    </div>
                    
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-success">Simpan Data</button>
                    <a href="{{ route('rak_buku') }}" class="btn btn-secondary">Kembali</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection