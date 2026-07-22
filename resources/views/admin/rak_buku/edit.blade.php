@extends('layouts.master')

@section('content')

<div class="app-content-header">
    <div class="container-fluid">
        <h3 class="mb-0">Edit Rak</h3>
    </div>
</div>

<div class="app-content">
    <div class="container-fluid">
        <div class="card">
            <form action="{{ route('rak_buku.update', $rak_buku->id) }}" method="POST">
                @csrf
                @method('PUT')

            <div class="card-body">
                <div class="mb-3">
                    <label class="form-label">Nama Rak</label>

                    <input type="text"
                           name="nama_rak"
                           class="form-control @error('nama_rak') is-invalid @enderror"
                           value="{{ old('nama_rak', $rak_buku->nama_rak) }}"
                           placeholder="Masukkan Nama Rak">

                    @error('nama_rak')
                        <div class="text-danger">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>

            <div class="card-footer">
                <button type="submit" class="btn btn-warning">
                    Update Data
                </button>

                <a href="{{ route('rak_buku') }}" class="btn btn-secondary">
                    Kembali
                </a>
            </div>
        </form>
    </div>
</div>


</div>
@endsection
