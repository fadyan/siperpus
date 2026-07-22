@extends('layouts.master')

@section('content')
<div class="app-content-header">
    <div class="container-fluid">
        <h3 class="mb-0">Tambah Buku Baru</h3>
    </div>
</div>

<div class="app-content">
    <div class="container-fluid">
        <div class="card">
            <form action="{{ route('buku.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label">Judul Buku</label>
                        <input type="text" name="judul" class="form-control @if($errors->has('judul')) is-invalid @endif" value="{{ old('judul') }}" placeholder="Judul Buku">
                        <div class="@if($errors->has('judul')) was-validated  @else invalid-feedback @endif text-danger" role="alert">{{ $errors->first('judul') }}</div>
                    <div class="mb-3">
                        <label class="form-label">Rak Buku</label>

                        <select name="rak_buku_id" class="form-control select2 @error('rak_buku_id') is-invalid @enderror"
                        data-placeholder="-- Pilih Rak Buku --">
                        <option></option>
                            @foreach($rak_buku as $dt)
                                <option value="{{ $dt->id }}"
                                    {{ old('rak_buku_id') == $dt->id ? 'selected' : '' }}>
                                    {{ $dt->nama_rak }}
                                </option>
                            @endforeach
                        </select>

                        @error('rak_buku_id')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Kelas</label>

                        <select name="kelas_id" class="form-control select2 @error('kelas_id') is-invalid @enderror" 
                        data-placeholder="-- Pilih Kelas --">
                        <option></option>

                            @foreach($kelas as $dt)
                                <option value="{{ $dt->id }}"
                                    {{ old('kelas_id') == $dt->id ? 'selected' : '' }}>
                                    {{ $dt->nama }}
                                </option>
                            @endforeach
                        </select>

                        @error('kelas_id')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Pengarang</label>
                        <input type="text" name="pengarang" class="form-control @if($errors->has('pengarang')) is-invalid @endif" value="{{ old('pengarang') }}" placeholder="Pengarang">
                        <div class="@if($errors->has('pengarang')) was-validated  @else invalid-feedback @endif text-danger" role="alert">{{ $errors->first('pengarang') }}</div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Penerbit</label>

                        <select name="penerbit_id" class="form-control select2 @error('penerbit_id') is-invalid @enderror"
                        data-placeholder="-- Pilih Penerbit --">
                        <option></option>
                            @foreach($penerbit as $dt)
                                <option value="{{ $dt->id }}"
                                    {{ old('penerbit_id') == $dt->id ? 'selected' : '' }}>
                                    {{ $dt->nama_penerbit }}
                                </option>
                            @endforeach
                        </select>

                        @error('penerbit_id')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Deskripsi</label>
                        <textarea name="deskripsi" rows="5" class="form-control @if($errors->has('deskripsi')) is-invalid @endif" placeholder="Masukkan deskripsi buku">{{ old('deskripsi') }}</textarea>
                        <div class="@if($errors->has('deskripsi')) was-validated @else invalid-feedback @endif text-danger"role="alert">{{ $errors->first('deskripsi') }}</div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Jumlah</label>
                        <input type="text" name="jumlah" class="form-control @if($errors->has('jumlah')) is-invalid @endif" value="{{ old('jumlah') }}" placeholder="Jumlah">
                        <div class="@if($errors->has('jumlah')) was-validated  @else invalid-feedback @endif text-danger" role="alert">{{ $errors->first('jumlah') }}</div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Tahun</label>
                        <input type="text" name="tahun" class="form-control @if($errors->has('tahun')) is-invalid @endif" value="{{ old('tahun') }}" placeholder="Tahun">
                        <div class="@if($errors->has('tahun')) was-validated  @else invalid-feedback @endif text-danger" role="alert">{{ $errors->first('tahun') }}</div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Cover Buku</label>
                        <input type="file"
                            name="cover"
                            class="form-control @error('cover') is-invalid @enderror">

                        @error('cover')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-success">Simpan Data</button>
                    <a href="{{ route('buku') }}" class="btn btn-secondary">Kembali</a>
                </div>
            </form>
        </div>
    </div>
</div>
@section('script')
<script>
$(document).ready(function () {

    $('.select2').each(function () {

        $(this).select2({
            placeholder: $(this).data('placeholder'),
            allowClear: true,
            width: '100%'
        });

    });

});
</script>
@endsection
@endsection