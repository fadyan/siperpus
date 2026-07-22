@extends('layouts.master')

@section('content')
<div class="app-content-header">
    <div class="container-fluid">
        <h3 class="mb-0">Tambah Kelas Group</h3>
    </div>
</div>

<div class="app-content">
    <div class="container-fluid">
        <div class="card">
            <form action="{{ route('kelas_group.store') }}" method="POST">
                @csrf
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label">Kelas</label>

                        <select name="kelas_id" class="form-control @error('kelas_id') is-invalid @enderror">
                            <option value="">-- Pilih Kelas --</option>

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
                        <label class="form-label">Nama Kelas</label>
                        <input type="text" name="nama_kelas" class="form-control @if($errors->has('nama_kelas')) is-invalid @endif" value="{{ old('nama_kelas') }}" placeholder="nama_kelas">
                        <div class="@if($errors->has('nama_kelas')) was-validated  @else invalid-feedback @endif text-danger" role="alert">{{ $errors->first('nama_kelas') }}</div>
                    </div>
                    
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-success">Simpan Data</button>
                    <a href="{{ route('kelas_group') }}" class="btn btn-secondary">Kembali</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection