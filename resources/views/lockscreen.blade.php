<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Akses Terkunci</title>
</head>

<body style="text-align:center; margin-top: 100px;">
    <h1 style="color:red;">🚫 Akses Terkunci</h1>
    <p>Aplikasi terkunci karena token tidak valid atau pelanggaran keamanan.</p>
    <p>Hubungi Admin untuk mendapatkan token baru.</p>
    <p>
        <a href="mailto:admin@domain.com" style="font-size: 16px; text-decoration: none; color: blue;">Hubungi Admin</a>
    </p>
    <p>
    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
    </form>
    <a href="#" class="btn btn-danger"
        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
        Logout
    </a>
    </p>
</body>

</html>
