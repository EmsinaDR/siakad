<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Update Token</title>
</head>
<body style="margin: 20px;">
    <h1>Update Token SIAKAD</h1>

    @if (session('success'))
        <p style="color:green;">{{ session('success') }}</p>
    @endif

    <form method="POST" action="{{ route('admin.token.update') }}">
        @csrf
        <div>
            <label>Pilih Paket:</label>
            <select name="paket" required>
                <option value="Gratis">Gratis</option>
                <option value="Trial">Trial</option>
                <option value="Basic">Basic</option>
                <option value="Premium">Premium</option>
            </select>
        </div>
        <button type="submit" style="margin-top:10px;">Update Token</button>
    </form>
</body>
</html>
