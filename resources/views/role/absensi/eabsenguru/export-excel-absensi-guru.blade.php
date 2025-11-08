<x-layout-cetak>

    {{-- <link rel='stylesheet' href='{{ asset('css/layout-cetak.css') }}'> --}}

    <style>
        @page {
            size: A4;
            margin: 0.5cm;
        }

        html,
        body {
            height: 100%;
            overflow: hidden;
            font-family: 'Times New Roman', serif;
            font-size: 12pt;
            line-height: 1;
            box-sizing: border-box;
        }

        .text-center {
            text-align: center;
        }

        .text-justify {
            text-align: justify;
        }

        .kop {
            display: flex;
            align-items: center;
            border-bottom: 3px double black;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }

        .kop img {
            height: 80px;
            margin-right: 15px;
        }

        .ttd {
            float: right;
            text-align: center;
            margin-top: 50px;
        }
    </style>
    <x-kop-surat-cetak></x-kop-surat-cetak>
    <h3 class="text-center"><u><b>REKAP ABSENSI GURU</b></u></h3>
    @php
        // Ambil guru dari record pertama yang ada
        $guru = optional($DataAbsen->first()->first())->guru;
    @endphp
    @if ($guru)
        <table class="table-hover table-sm align-middle mb-0">
            <tbody>
                <tr>
                    <td width="20%" class="text-left">Nama Guru</td>
                    <td width="50%" class="text-left">: {{ $guru?->nama_guru }}</td>
                </tr>
                <tr>
                    <td class="text-left">Kode Guru</td>
                    <td class="text-left">: {{ $guru?->kode_guru }}</td>
                </tr>
            </tbody>
        </table>
    @endif

    <table width='100%' class="table-bordered text-center">
        <thead>
            <tr class="table-primary align-middle">
                <th class='text-center align-middle' rowspan='2' colspan="1">Tanggal</th>
                <th class='text-center align-middle' rowspan='2' colspan="1">JM</th>
                <th class='text-center align-middle' rowspan='2' colspan="1">JP</th>
                <th class='text-center align-middle' rowspan='2' colspan="1">Status <br>(H:I:A)</th>
                <th class='text-center align-middle' rowspan='1' colspan="2">Masuk</th>
                <th class='text-center align-middle' rowspan='1' colspan="3">Pulang (P)</th>
                <th class='text-center align-middle' rowspan='2' colspan="1">Durasi</th>
            </tr>
            <tr class="table-primary align-middle">
                <th>Jam</th>
                <th>Telat</th>
                <th>Jam</th>
                <th>PC</th>
                <th>PT</th>
            </tr>
        </thead>
        <tbody>

            @foreach ($DataAbsen as $tanggal => $absensis)
                @php
                    $masuk = $absensis->firstWhere('jenis_absen', 'masuk');
                    $pulang = $absensis->firstWhere('jenis_absen', 'pulang');
                    // dd($absensis);
                @endphp
                <tr>
                    <td class='text-center'>{{ $tanggal }}</td>
                    <td class="text-center">{{ $masuk->jam_masuk ?? '-' }}</td>
                    <td class="text-center">{{ $masuk->jam_pulang ?? '-' }}</td>
                    <td class='text-center'>{{ $masuk->absen ?? ($pulang->absen ?? '-') }}</td>
                    <td class='text-center'>{{ $masuk?->created_at?->format('H:i') ?? '-' }}</td>
                    <td class='text-center'>{{ $masuk->telat ?? '-' }}</td>
                    <td class='text-center'>{{ $pulang?->created_at?->format('H:i') ?? '-' }}</td>
                    <td class='text-center'>{{ $pulang->pulang_cepat ?? '-' }}</td>
                    <td class='text-center'>{{ $pulang->pulang_telat ?? '-' }}</td>
                    <td>{{ $masuk->durasi ?? '-' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="ttd">
        <p>{{ $kabupaten }}, {{ date('d F Y') }}</p>
        Kepala {{ $kedinasan }}<br><br><br><br>
        <p><strong>{{ $nama_kepala ?? '' }}</strong><br></p>
        <b style='margin-left:-145px'>NIP. {{ $nip_kepala ?? '__________' }}</b>
    </div>

    {{-- data_judul --}}

    {{-- @dump($datas, $ProcessedTemplate, $Identitas, $DataGuru) --}}
</x-layout-cetak>
