@php
    $Identitas = \App\Models\Admin\Identitas::first();
    use Illuminate\Support\Carbon;
@endphp<h2>{{ $Identitas->namasek }}</h2>
<h2>Privnsi {{ $Identitas->provinsi }}</h2>
<h2>Kecamatan {{ $Identitas->kecamatan }}</h2>
<p>{{ $Identitas->alamat }}</p>
<p>{{ $Identitas->email }}</p>
<p>{{ Carbon::now()->translatedFormat('l, d F Y') }}</p>
