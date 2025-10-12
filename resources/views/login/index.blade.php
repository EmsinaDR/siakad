<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $title }}</title>
    {{-- <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css" rel="stylesheet"> --}}
</head>

<body>

    <div class="container"><br>
        <div class="col-md-4 col-md-offset-4">
            <h2 class="text-center"><b>Aplikasi SIAKAD</b><br>SMP Cipta IT</h2>
                <hr>
                @if (session('error'))
                <div class="alert alert-danger">
                    <b>Opps!</b> {{ session('error') }}
                </div>
                @endif
                <form action="{{ route('login') }}" method="post">
                    @csrf
                    <div class="form-group">
                        <label>Email</label>
                        <input id="email" type="email" name="email" class="form-control" placeholder="Email" required="">
                    </div>
                    <div class="form-group">
                        <label>Password</label>
                        <input id="password" type="password" name="password" class="form-control" placeholder="Password" required="">
                    </div>
                    <button type="submit" class="btn btn-primary btn-block">Log In</button>
                    <hr>
                    <p class="text-center">Belum punya akun? <a href="{{ route('register') }}">Register</a> sekarang!
                    </p>
                </form>
                <a id='admin' class='btn btn-app bg-primary'><span class='badge bg-primary'></span><i class='fa-user'></i>
                    Admin</a>
                <a id='users' class='btn btn-app bg-primary'><span class='badge bg-primary'></span><i class='fa-user'></i>
                    users</a>
                <script>
                    var email = document.getElementById('email');
                    var password = document.getElementById('password');
                    var admin = document.getElementById('admin');
                    var users = document.getElementById('users');
                    // admin.AddEventListener('click', function() {
                    admin.addEventListener('click', function() {
                        // addEventListener
                        email.value = 'septaata@gmail.com';
                        password.value = 'septaata';

                    })
                    users.addEventListener('click', function() {
                        // addEventListener
                        email.value = 'eufaazmi@gmail.com';

                        password.value = 'password';

                    })

                </script>
        </div>
    </div>


</body>

</html>
