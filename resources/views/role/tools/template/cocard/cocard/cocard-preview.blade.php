<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Cocard Siap Cetak</title>
    <style>
        @page {
    size: A4 portrait;
    margin: 0;
}

body {
    margin: 0;
    padding: 0;
    font-family: Arial, sans-serif;
}

.page {
    width: 21cm;
    height: 29.7cm;
    padding: 1cm;
    box-sizing: border-box;
    display: flex;
    flex-wrap: wrap;
    justify-content: space-between;
    page-break-after: always;
}

.cocard {
    width: 5.5cm;
    height: 8.5cm;
    margin-bottom: 1cm;
    text-align: center;
    page-break-inside: avoid;
}

.cocard img {
    width: 100%;
    height: auto;
}

@media print {
    .no-print {
        display: none;
    }
}

    </style>
</head>

<body>

    <div class="no-print" style="padding: 1rem; background: #f0f0f0;">
        <button onclick="window.print()">🖨️ Cetak Sekarang</button>
    </div>

    @foreach (collect($svgUrls)->chunk(9) as $chunk)
        <div class="page">
            @foreach ($chunk as $item)
                <div class="cocard">
                    <img src="{{ $item['url'] }}" alt="Cocard {{ $item['nama'] }}">
                </div>
            @endforeach
        </div>
        <div class='page-break'></div>
    @endforeach


</body>

</html>



{{-- render_svg_base64('cocard002', [
                                            'line2' => 'Kelas',
                                            'posisi' => 'PESERTA',
                                            'nama' => 'Dany Rosepta',
                                            'nip' => '-',
                                            'namasekolah' => strtoupper($Identitas->namasek),
                                            'namakegiatan' => 'UJIAN MADRASAH',
                                            'foto' => 'img/template/cocard/property/blank.png',
                                            'logosekolah' => 'img/logo.png',
                                            'logodinas' => 'img/logo/kemenag.png',
                                            'tapel' => date('Y') . '/' . date('Y') + 1,
                                        ]) --}}
