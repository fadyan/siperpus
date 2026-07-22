@extends('layouts.master')

@section('content')

<div class="app-content-header">
    <div class="container-fluid">
        <h3 class="mb-0">Edit Penerbit</h3>
    </div>
</div>

<div class="app-content">
    <div class="container-fluid">
        <div class="card">
            <form action="{{ route('penerbit.update', $penerbit->id) }}" method="POST">
                @csrf
                @method('PUT')

            <div class="card-body">
                <div class="mb-3">
                    <label class="form-label">Nama Penerbit</label>

                    <input type="text"
                           name="nama_penerbit"
                           class="form-control @error('nama_penerbit') is-invalid @enderror"
                           value="{{ old('nama_penerbit', $penerbit->nama_penerbit) }}"
                           placeholder="Nama Penerbit">

                    @error('nama_penerbit')
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

                <a href="{{ route('penerbit') }}" class="btn btn-secondary">
                    Kembali
                </a>
            </div>
        </form>
    </div>
</div>


</div>
@endsection
