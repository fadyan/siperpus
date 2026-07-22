@extends('layouts.master')

@section('content')
<div class="app-content-header">
    <div class="container-fluid">
        <h3 class="mb-0">Tambah Data Penerbit</h3>
    </div>
</div>

<div class="app-content">
    <div class="container-fluid">
        <div class="card">
            <form action="{{ route('penerbit.store') }}" method="POST">
                @csrf
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label">Nama Penerbit</label>
                        <input type="text" name="nama_penerbit" class="form-control @if($errors->has('nama_penerbit')) is-invalid @endif" value="{{ old('nama_penerbit') }}" placeholder="Nama Penerbit">
                        <div class="@if($errors->has('nama_penerbit')) was-validated  @else invalid-feedback @endif text-danger" role="alert">{{ $errors->first('nama_penerbit') }}</div>
                    </div>
                    
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-success">Simpan Data</button>
                    <a href="{{ route('penerbit') }}" class="btn btn-secondary">Kembali</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection