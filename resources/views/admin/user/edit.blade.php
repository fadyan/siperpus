@extends('layouts.master')

@section('content')

<div class="app-content-header">
    <div class="container-fluid">
        <h3 class="mb-0">Edit Buku</h3>
    </div>
</div>

<div class="app-content">
    <div class="container-fluid">
        <div class="card">
            <form action="{{ route('buku.update', $buku->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

            <div class="card-body">

                <div class="mb-3">
                    <label class="form-label">Judul Buku</label>
                    <input type="text" name="judul"
                        class="form-control @error('judul') is-invalid @enderror"
                        value="{{ old('judul', $buku->judul) }}">
                    @error('judul')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Kelas</label>

                    <select name="kelas_id" class="form-control @error('kelas_id') is-invalid @enderror">
                        <option value="">-- Pilih Kelas --</option>

                        @foreach($kelas as $item)
                            <option value="{{ $item->id }}"
                                {{ $buku->kelas_id == $item->id ? 'selected' : '' }}>
                                {{ $item->nama}}
                            </option>
                        @endforeach
                    </select>

                    @error('kelas_id')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Pengarang</label>
                    <input type="text" name="pengarang"
                        class="form-control @error('pengarang') is-invalid @enderror"
                        value="{{ old('pengarang', $buku->pengarang) }}">
                    @error('pengarang')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Penerbit</label>
                    <input type="text" name="penerbit"
                        class="form-control @error('penerbit') is-invalid @enderror"
                        value="{{ old('penerbit', $buku->penerbit) }}">
                    @error('penerbit')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label class="form-label">Deskripsi</label>
                    <textarea name="deskripsi"
                        rows="5"
                        class="form-control @error('deskripsi') is-invalid @enderror">{{ old('deskripsi', $buku->deskripsi) }}</textarea>
                    @error('deskripsi')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Jumlah</label>
                    <input type="text" name="jumlah"
                        class="form-control @error('jumlah') is-invalid @enderror"
                        value="{{ old('jumlah', $buku->jumlah) }}">
                    @error('jumlah')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Tahun</label>
                    <input type="text" name="tahun"
                        class="form-control @error('tahun') is-invalid @enderror"
                        value="{{ old('tahun', $buku->tahun) }}">
                    @error('tahun')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label class="form-label">Cover Buku</label>

                    @if($buku->cover)
                        <div class="mb-2">
                            <img src="{{ asset('upload/'.$buku->cover) }}"
                                width="100"
                                class="img-thumbnail">
                        </div>
                    @endif

                    <input type="file"
                        name="cover"
                        class="form-control">
                        
                    <small class="text-muted">
                        Kosongkan jika tidak ingin mengganti cover.
                    </small>
                </div>

            </div>

            <div class="card-footer">
                <button type="submit" class="btn btn-warning">Update Data</button>
                <a href="{{ route('buku') }}" class="btn btn-secondary">Kembali</a>
            </div>

        </form>
    </div>
</div>
```

</div>
@endsection
