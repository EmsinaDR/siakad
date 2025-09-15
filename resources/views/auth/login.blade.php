<!DOCTYPE html>
<html lang="en">
<style>
    body {
        background-image: url('https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQlkf5w_kMhasj8ERvaGvasnxqX76OUDGOLuA&s');
        background-size: cover;
        background-repeat: no-repeat;
    }

    .text-white {
        color: white;
    }
</style>
<link rel="icon" type="image/x-icon" href="{{ asset('img/logo.ico') }}">
{{-- <x-plugins-multiple-select-header></x-plugins-multiple-select-header> --}}
<x-alert-header></x-alert-header>
{{-- <x-plugins-tabel-header></x-plugins-tabel-header> --}}
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    {{-- <title>{{ $title }}</title> --}}
    {{-- <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css" rel="stylesheet"> --}}
    <!-- Bootstrap 5.3.3 CSS -->
    {{-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"> --}}
    <!-- Bootstrap 5.3.3 JS (includes Popper) --><!-- Ganti ini -->
    <!-- <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css" rel="stylesheet"> -->
    <!-- Dengan ini (Bootstrap 5.3 CDN) -->
    {{-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"> --}}
</head>

<body>
    <div class="container mb-4"><br>
        {{-- <div class="col-md-4 col-md-offset-4 "> --}}
        <div class="col-md-4 mx-auto">
            {{-- blade-formatter-disable --}}
            <div class="text-center">
                <img class='img-circle img-fluid mx-auto mb-2' style='width:100px;height:100px;margin-top:100px' src="{{ asset('img/logo.png')}}" alt="">
            </div>
            {{-- blade-formatter-enable --}}
            <h3 class="text-center text-success fs-3 fs-lg-5 fs-xl-4"><b>APLIKASI SIAKAD</b></h3>
            <h4 class="text-center text-white fs-3 fs-lg-3 fs-xl-2">
                <b>{{ strtoupper($Identitas->namasek) ?? ' SMP Cipta IT' }}</b>
            </h4>
            <p class="text-center text-white fs-6 fs-lg-5 fs-xl-4">{{ $Identitas->alamat ?? '' }}</p>
            <hr>
            @if (session('error'))
                <div class="alert alert-danger">
                    <b>Opps!</b> {{ session('error') }}
                </div>
            @endif
            {{-- blade-formatter-disable --}}
            <form action="{{ route('login') }}" method="post">
                @csrf
                {{-- {{ csrf_token() }} --}}
                {{-- @method('POST') --}}
                <div class="form-group mb-2">
                    <label class='text-white mb-1'> <i class="fa fa-envelope"></i> Email</label>
                    <input id="email" type="email" name="email" class="form-control" placeholder="Email" required="">
                </div>
                <div class="form-group mb-2">
                    <label class='text-white mb-1'><i class='fa fa-key'></i> Password</label>
                    <input id="password" type="password" name="password" class="form-control" placeholder="Password" required="">
                </div>
                <div class="row my-2">
                    <div class="col-12 d-flex flex-row justify-content-end gap-4 p-1">
                        <button type="submit" class="btn btn-primary w-auto">Log In</button>
                        <button type="button" class="btn btn-success w-auto" onclick="absenNow()">Absen Siswa</button>
                        <button type="button" class="btn btn-success w-auto" onclick="absenGuru()">Absen Guru</button>
                    </div>
                </div>
                <hr>
                <p class="text-center text-white">Belum punya akun? <a href="{{ route('register') }}">Register</a> sekarang! </p>
            </form>
            </br>
            </br>
        </div>
    </div>
            {{-- blade-formatter-enable --}}
            {{-- blade-formatter-disable --}}
            {{-- <a id='admindev' class='btn btn-app bg-primary'><span class='badge bg-primary'></span><i class='fa-user'></i> Admindev</a>
            <a id='admin' class='btn btn-app bg-primary'><span class='badge bg-primary'></span><i class='fa-user'></i> Admin</a>
            <a id='kepalasekolah' class='btn btn-app bg-primary'><span class='badge bg-primary'></span><i class='fa-user'></i>  kepalasekolah</a>
            <a id='wakakurikulum' class='btn btn-app bg-primary'><span class='badge bg-primary'></span><i class='fa-user'></i> wakakurikulum</a>
            <a href="javascript:void(0)" onclick="absenNow()" class="btn bg-secondary btn-block btn-xl d-flex justify-content-left align-items-center mb-2"> <i class="fa fa-qrcode mr-2"></i> Mulai Absensi </a> --}}
            {{-- blade-formatter-enable --}}
            {{-- <button type="button" onclick="absenNow()"
                class="btn bg-secondary btn-block btn-xl d-flex justify-content-left align-items-center mb-2">
                <i class="fa fa-qrcode mr-2"></i> Mulai Absensi
            </button> --}}
            <script>
                var email = document.getElementById('email');
                var password = document.getElementById('password');
                var admin = document.getElementById('admindev');
                var users = document.getElementById('admin');
                var kepalasekolah = document.getElementById('kepalasekolah');
                var wakakurikulum = document.getElementById('wakakurikulum');
                // admin.AddEventListener('click', function() {
                admin.addEventListener('click', function() {
                    // addEventListener
                    email.value = 'admindev@gmail.com';
                    password.value = 'admindev';
                })
                users.addEventListener('click', function() {
                    // addEventListener
                    email.value = 'admin@gmail.com';

                    password.value = 'Password';
                })
                kepalasekolah.addEventListener('click', function() {
                    // addEventListener
                    email.value = 'kepalasekolah@gmail.com';

                    password.value = 'Password';
                })
                wakakurikulum.addEventListener('click', function() {
                    // addEventListener
                    email.value = 'wakakurikulum@gmail.com';

                    password.value = 'Password';
                })
            </script>
            <script>
                function absenNow() {
                    setTimeout(function() {
                        window.location.href = "{{ secure_url(route('absensi.siswa.index.ajax', [], false)) }}";
                    }, 3000);
                }

                function absenGuru() {
                    setTimeout(function() {
                        window.location.href = "{{ secure_url(route('absensi.guru.index.ajax', [], false)) }}";
                    }, 3000);
                }
            </script>
</body>

</html>
