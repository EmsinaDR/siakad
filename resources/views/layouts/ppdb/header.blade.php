{{-- blade-formatter-disable --}}

{{-- blade-formatter-enable --}}

@php
    $logoIco = $Identitas->namasek === 'Sekolah Cipta IT' ? 'img/dev/logo.ico' : 'img/logo.ico';
    $logo = $Identitas->namasek === 'Sekolah Cipta IT' ? 'img/dev/logo.png' : 'img/logo.png';
@endphp
{{-- <pre>{{ var_dump($Identitas) }}</pre> --}}

<link rel="icon" type="image/x-icon" href="{{ secure_asset($logoIco) }}">

<head>
    <meta charset="UTF-8">
    <title>Formulir PPDB - {{ $Identitas->namasek }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
