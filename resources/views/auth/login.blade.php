@extends('layouts.auth')

@section('content')

<div class="login-wrapper">

    <div class="login-header text-center">

        <img src="{{ asset('assets/img/logo.png') }}"
             class="logo mb-3"
             alt="Logo DDI">

        <h1>Siperpus DDI Cambalagi</h1>


    </div>

    <div class="login-card">

        <div class="card-body">

            <h5 class="text-center text-white mb-4">
                Sign in to your account
            </h5>

            @if($errors->has('error_validasi'))
                <div class="alert alert-danger">
                    {{ $errors->first('error_validasi') }}
                </div>
            @endif

            <form action="{{ route('login-proses') }}" method="POST">

                @csrf

                <div class="mb-3">

                    <div class="input-group">

                        <span class="input-group-text">
                            <i class="bi bi-person-fill"></i>
                        </span>

                        <input
                            type="text"
                            name="username"
                            value="{{ old('username') }}"
                            class="form-control @error('username') is-invalid @enderror"
                            placeholder="Username">

                    </div>

                    @error('username')
                        <small class="text-warning">{{ $message }}</small>
                    @enderror

                </div>

                <div class="mb-4">

                    <div class="input-group">

                        <span class="input-group-text">
                            <i class="bi bi-lock-fill"></i>
                        </span>

                        <input
                            id="password"
                            type="password"
                            name="password"
                            class="form-control @error('password') is-invalid @enderror"
                            placeholder="Password">

                        <button
                            class="input-group-text"
                            type="button"
                            id="togglePassword">

                            <i class="bi bi-eye" id="toggleIcon"></i>

                        </button>

                    </div>

                    @error('password')
                        <small class="text-warning">{{ $message }}</small>
                    @enderror

                </div>

                <button class="btn btn-success w-100 py-2">

                    <i class="bi bi-box-arrow-in-right"></i>

                    Sign In

                </button>

            </form>

        </div>

    </div>

</div>

<script>
document.addEventListener('DOMContentLoaded', function () {

    const password = document.getElementById('password');
    const togglePassword = document.getElementById('togglePassword');
    const toggleIcon = document.getElementById('toggleIcon');

    togglePassword.addEventListener('click', function () {

        const type = password.getAttribute('type') === 'password'
            ? 'text'
            : 'password';

        password.setAttribute('type', type);

        toggleIcon.classList.toggle('bi-eye');
        toggleIcon.classList.toggle('bi-eye-slash');

    });

});
</script>
@endsection