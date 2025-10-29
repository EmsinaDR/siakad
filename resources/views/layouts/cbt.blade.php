<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>CBT</title>
<meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #f8f9fa; }
        .btn.nomor-soal-btn { padding: 8px 0; font-weight: bold; }
    </style>
</head>
<body>
    @yield('content')
</body>
</html>
