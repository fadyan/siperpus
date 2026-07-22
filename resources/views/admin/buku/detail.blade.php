@extends('layouts.master')

@section('content')

<div class="app-content">
    <div class="container-fluid">

        <div class="card">
            <div class="card-header">
                <h3>Detail Buku</h3>
            </div>

            <div class="card-body">

                <div class="row">

                    <div class="col-md-4 text-center">

                        @if($buku->cover)
                            <img src="{{ asset('upload/'.$buku->cover) }}"
                                 class="img-fluid rounded shadow"
                                 style="max-height:450px">
                        @endif

                    </div>

                    <div class="col-md-8">

                        <table class="table table-bordered">

                            <tr>
                                <th width="200">Judul Buku</th>
                                <td>{{ $buku->judul }}</td>
                            </tr>

                            <tr>
                                <th>Buku Untuk</th>
                                <td>{{ $buku->kelas->nama }}</td>
                            </tr>
                            <tr>
                                <th>Posisi Rak Buku</th>
                                <td>{{ $buku->rak_buku->nama_rak }}</td>
                            </tr>
                            <tr>
                                <th>Pengarang</th>
                                <td>{{ $buku->pengarang }}</td>
                            </tr>

                            <tr>
                                <th>Penerbit</th>
                                <td>{{ $buku->penerbit->nama_penerbit }}</td>
                            </tr>

                            <tr>
                                <th>Tahun</th>
                                <td>{{ $buku->tahun }}</td>
                            </tr>

                            <tr>
                                <th>Jumlah</th>
                                <td>{{ $buku->jumlah }}</td>
                            </tr>

                            <tr>
                                <th colspan='2' align='center'>Deskripsi</th>
                            </tr>
                            <tr>
                                <td colspan='2' align='justify'>{{ $buku->deskripsi }}</td>
                            </tr>

                        </table>

                        <div class="mt-3">
                            <a href="{{ route('dashboard') }}"
                            class="btn btn-secondary">
                                Kembali
                            </a>
                            @if(auth()->user()->level === "admin" || auth()->user()->level === "pegawai ")
                            <button type="button"
                                    class="btn btn-primary"
                                    data-bs-toggle="modal"
                                    data-bs-target="#modalPeminjaman">
                                <i class="bi bi-book"></i>
                                Pinjam Buku
                            </button>
                            @endif
                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>
</div>

<!-- Modal Peminjaman -->
<div class="modal fade"
     id="modalPeminjaman"
     tabindex="-1">

    <div class="modal-dialog">

        <div class="modal-content">
            <form action="javascript:void(0)" id="formPeminjaman" method="POST">
                @csrf

                <div class="modal-header">
                    <h5 class="modal-title">
                        Form Peminjaman Buku
                    </h5>

                    <button type="button"
                            class="btn-close"
                            data-bs-dismiss="modal">
                    </button>
                </div>

                <div class="modal-body">
                    
                    <div class="mb-3" id="alertPinjaman"><div>
                    <div class="mb-3">
                        <label class="form-label">Siswa</label>
                        <select name="siswa_id" class="form-control" required>
                            <option value="">Pilih Siswa</option>

                            @foreach($siswa as $dt)
                                <option value="{{ $dt->id }}">
                                    {{ $dt->nama_siswa }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <input type="hidden"
                        name="buku_id"
                        value="{{ $buku->id }}">

                    <div class="mb-3">
                        <label>Tanggal Pinjam</label>
                        <input type="date"
                            name="tgl_pinjam"
                            class="form-control"
                            value="{{ date('Y-m-d') }}"
                            required>
                    </div>

                    <div class="mb-3">
                        <label>Rencana Kembali</label>
                        <input type="date"
                            name="tgl_rencana_kembali"
                            class="form-control"
                            required>
                    </div>

                </div>

                <div class="modal-footer">

                    <button type="button"
                            class="btn btn-secondary"
                            data-bs-dismiss="modal">
                        Batal
                    </button>

                    <button type="submit"
                            class="btn btn-success">
                        Simpan Peminjaman
                    </button>

                </div>

            </form>

        </div>

    </div>

</div>
@endsection
@section('script')
<script>
    $('#formPeminjaman').submit(function(e) {
        e.preventDefault();

        let form = $(this);

        $.ajax({
            url: "{{ route('peminjaman.store') }}",
            type: 'POST',
            data: form.serialize(),
            success: function(response) {
                console.log(response);
                $('#alertPinjaman').html(`
                    <div class="alert alert-success">
                        Data peminjaman berhasil disimpan
                    </div>
                `);

                form.trigger('reset');

                setTimeout(function() {
                    location.reload();
                }, 1000);
            },

            error: function(xhr) {
                console.log(xhr);
                let errors = xhr.responseJSON.errors;

                let pesan = '';

                $.each(errors, function(key, value) {
                    pesan += `<li>${value[0]}</li>`;
                });

                $('#alertPinjaman').html(`
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            ${pesan}
                        </ul>
                    </div>
                `);
            }
        });

    });
</script>
@endsection