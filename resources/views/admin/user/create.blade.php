@extends('layouts.master')

@section('content')
<div class="app-content-header">
    <div class="container-fluid">
        <h3 class="mb-0">Tambah User</h3>
    </div>
</div>

<div class="app-content">
    <div class="container-fluid">
        <div class="card">
            <form action="{{ route('user.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label">Nama</label>
                        <input type="text" name="nama" class="form-control @if($errors->has('nama')) is-invalid @endif" value="{{ old('nama') }}" placeholder="Nama">
                        <div class="@if($errors->has('nama')) was-validated  @else invalid-feedback @endif text-danger" role="alert">{{ $errors->first('nama') }}</div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Level</label>
                        <select id="level" name="level" onchange="get_data(this)" class="form-control @error('level') is-invalid @enderror">
                            <option value="">-- Pilih Level --</option>
                            <option value="admin">Admin</option>
                            <option value="pegawai">Pegawai</option>
                            <option value="siswa">Siswa</option>
                        </select>

                        @error('level')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Data User</label>
                        <select name="data_id" id="data_id" class="form-control @error('data_id') is-invalid @enderror">
                            <option value="">-- Pilih Data User --</option>
                        </select>
                        <div class="@if($errors->has('data_id')) was-validated  @else invalid-feedback @endif text-danger" role="alert">{{ $errors->first('data_id') }}</div>
                    </div>
                    <hr />
                    <div class="mb-3">
                        <label class="form-label">Username</label>
                        <input type="text" name="username" class="form-control @if($errors->has('username')) is-invalid @endif" value="{{ old('username') }}" placeholder="Username">
                        <div class="@if($errors->has('username')) was-validated  @else invalid-feedback @endif text-danger" role="alert">{{ $errors->first('username') }}</div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Password</label>
                        <input type="password" name="password" class="form-control @if($errors->has('password')) is-invalid @endif" value="{{ old('password') }}" placeholder="Password">
                        <div class="@if($errors->has('password')) was-validated  @else invalid-feedback @endif text-danger" role="alert">{{ $errors->first('password') }}</div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Komfirmasi Password</label>
                        <input type="password" name="password_confirmation" class="form-control @if($errors->has('password_confirmation')) is-invalid @endif" value="{{ old('password_confirmation') }}" placeholder="Password">
                        <div class="@if($errors->has('password_confirmation')) was-validated  @else invalid-feedback @endif text-danger" role="alert">{{ $errors->first('password_confirmation') }}</div>
                    </div>
                    
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-success">Simpan Data</button>
                    <a href="{{ route('user') }}" class="btn btn-secondary">Kembali</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
@section('script')
<script>
    function get_data(dt){
        let level = dt.value;
        $.ajax({
            url: "{{ route('user.list_data') }}",
            method: "GET",
            data: "level="+level,
            success: function(respon){
                if(respon.status == "succses"){
                    var opts = respon.data;
                    var html = "<option  value=''>..:: Pilih Data ::..</option>";
                    opts.forEach(function(item) {
                        html += "<option value='"+item.id+"'>"+item.nama+"</option>";
                    });
                    $("#data_id").html(html);
                }
                console.log(respon);
            },
            error : function(error){
                console.log(error);
            }


        })
    }
</script>
@endsection