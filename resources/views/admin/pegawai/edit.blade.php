@extends('layouts.master')

@section('content')

<div class="app-content-header">
    <div class="container-fluid">
        <h3 class="mb-0">Edit Data Pegawai</h3>
    </div>
</div>

<div class="app-content">
    <div class="container-fluid">
        <div class="card">
            <form action="{{ route('pegawai.update', $pegawai->id) }}" method="POST">
                @csrf
                @method('PUT')

            <div class="card-body">

                <div class="mb-3">
                    <label class="form-label">NIP</label>
                    <input type="text"
                           name="nip"
                           class="form-control @error('nip') is-invalid @enderror"
                           value="{{ old('nip', $pegawai->nip) }}"
                           placeholder="Masukkan NIP">

                    @error('nip')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Nama pegawai</label>
                    <input type="text"
                           name="nama_pegawai"
                           class="form-control @error('nama_pegawai') is-invalid @enderror"
                           value="{{ old('nama_pegawai', $pegawai->nama_pegawai) }}"
                           placeholder="Masukkan Nama pPgawai">

                    @error('nama_pegawai')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Jenis Kelamin</label>

                    <select name="jk"
                            class="form-control @error('jk') is-invalid @enderror">

                        <option value="">-- Pilih Jenis Kelamin --</option>

                        <option value="L"
                            {{ old('jk', $pegawai->jk) == 'L' ? 'selected' : '' }}>
                            Laki-laki
                        </option>

                        <option value="P"
                            {{ old('jk', $pegawai->jk) == 'P' ? 'selected' : '' }}>
                            Perempuan
                        </option>

                    </select>

                    @error('jk')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Alamat</label>
                    <input type="text"
                           name="alamat"
                           class="form-control @error('alamat') is-invalid @enderror"
                           value="{{ old('alamat', $pegawai->alamat) }}"
                           placeholder="Masukkan Alamat">

                    @error('alamat')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Jabatan</label>
                    <input type="text"
                           name="jabatan"
                           class="form-control @error('jabatan') is-invalid @enderror"
                           value="{{ old('jabatan', $pegawai->jabatan) }}"
                           placeholder="Masukkan Jabatan">

                    @error('jabatan')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-warning">
                    Update Data
                </button>

                <a href="{{ route('pegawai') }}" class="btn btn-secondary">
                    Kembali
                </a>
            </div>

        </form>
    </div>
</div>

</div>
@endsection
