@extends('layouts.master')

@section('content')
<div class="app-content-header">
    <div class="container-fluid">
        <h3 class="mb-0">Tambah Siswa Baru</h3>
    </div>
</div>

<div class="app-content">
    <div class="container-fluid">
        <div class="card">
            <form action="{{ route('siswa.store') }}" method="POST">
                @csrf

                <div class="card-body">

                    <div class="mb-3">
                        <label class="form-label">NISN</label>
                        <input type="text" name="nisn"
                            class="form-control @error('nisn') is-invalid @enderror"
                            value="{{ old('nisn') }}"
                            placeholder="Masukkan NISN">

                        @error('nisn')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Nama Siswa</label>
                        <input type="text" name="nama_siswa"
                            class="form-control @error('nama_siswa') is-invalid @enderror"
                            value="{{ old('nama_siswa') }}"
                            placeholder="Masukkan Nama Siswa">

                        @error('nama_siswa')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Jenis Kelamin</label>

                        <select name="jk"
                            class="form-control @error('jk') is-invalid @enderror">
                            <option value="">-- Pilih Jenis Kelamin --</option>
                            <option value="L" {{ old('jk') == 'L' ? 'selected' : '' }}>
                                Laki-laki
                            </option>
                            <option value="P" {{ old('jk') == 'P' ? 'selected' : '' }}>
                                Perempuan
                            </option>
                        </select>

                        @error('jk')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Tempat Lahir</label>
                        <input type="text" name="tempat_lahir"
                            class="form-control @error('tempat_lahir') is-invalid @enderror"
                            value="{{ old('tempat_lahir') }}"
                            placeholder="Masukkan Tempat Lahir">

                        @error('tempat_lahir')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Tanggal Lahir</label>
                        <input type="date" name="tanggal_lahir"
                            class="form-control @error('tanggal_lahir') is-invalid @enderror"
                            value="{{ old('tanggal_lahir') }}">

                        @error('tanggal_lahir')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Kelas</label>

                        <select name="kelas_group_id"
                            class="form-control @error('kelas_group_id') is-invalid @enderror">

                            <option value="">-- Pilih Kelas --</option>

                            @foreach($kelas_group as $dt)
                                <option value="{{ $dt->id }}"
                                    {{ old('kelas_group_id') == $dt->id ? 'selected' : '' }}>
                                    {{ $dt->kelas->nama }} - {{ $dt->nama_kelas }}
                                </option>
                            @endforeach

                        </select>

                        @error('kelas_group_id')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                </div>

                <div class="card-footer">
                    <button type="submit" class="btn btn-success">
                        Simpan Data
                    </button>

                    <a href="{{ route('siswa') }}"
                        class="btn btn-secondary">
                        Kembali
                    </a>
                </div>

            </form>
        </div>
    </div>
</div>
@endsection