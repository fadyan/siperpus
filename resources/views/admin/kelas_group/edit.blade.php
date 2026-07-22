@extends('layouts.master')

@section('content')

<div class="app-content-header">
    <div class="container-fluid">
        <h3 class="mb-0">Edit Kelas</h3>
    </div>
</div>

<div class="app-content">
    <div class="container-fluid">
        <div class="card">
            <form action="{{ route('kelas_group.update', $kelas_group->id) }}" method="POST">
                @csrf
                @method('PUT')
            <div class="card-body">
                <div class="mb-3">
                        <label class="form-label">Kelas</label>

                        <select name="kelas_id" class="form-control @error('kelas_id') is-invalid @enderror">
                            <option value="">-- Pilih Kelas --</option>

                            @foreach($kelas as $item)
                                <option value="{{ $item->id }}"
                                    {{ $kelas_group->kelas_id == $item->id ? 'selected' : '' }}>
                                    {{ $item->nama}}
                                </option>
                            @endforeach
                        </select>

                        @error('kelas_id')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                </div>   

            
                <div class="mb-3">
                    <label class="form-label">Nama Kelas</label>

                    <input type="text"
                           name="nama_kelas"
                           class="form-control @error('nama_kelas') is-invalid @enderror"
                           value="{{ old('nama_kelas', $kelas_group->nama_kelas) }}"
                           placeholder="Nama Kelas">

                    @error('nama_kelas')
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

                <a href="{{ route('kelas_group') }}" class="btn btn-secondary">
                    Kembali
                </a>
            </div>
        </form>
    </div>
</div>

</div>
@endsection
