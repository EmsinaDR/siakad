@php
    //content
    use Illuminate\Support\Carbon;
    \Carbon\Carbon::setLocale('id');
    $activecrud = collect([2, 4, 6, 8])->search(Auth::user()->id);
    $urlroot = app('request')->root();
    // $GuruNotulen = $Gurus->where('id', $datas->notulen_id)->first();
@endphp
{{-- @dd($data) --}}
{{-- @dd($datas) --}}
<x-layout-cetak>

    <style>
        /* ---------- Page break untuk print ---------- */
        /* Aturan utama: hanya berlaku saat mencetak */
        @media print {

            /* elemen yang memaksa pindah halaman setelahnya */
            .page-break {
                display: block;
                /* pastikan block-level */
                height: 0;
                /* tidak mengganggu layout layar */
                margin: 0;
                padding: 0;
                page-break-after: always;
                /* legacy (IE) */
                break-after: page;
                /* modern browsers */
            }

            /* mencegah pemotongan tabel atau elemen penting di tengah */
            table,
            tr,
            thead,
            tbody,
            tfoot,
            td,
            th {
                page-break-inside: avoid;
                break-inside: avoid;
            }

            /* jika ingin mencegah pemotongan untuk elemen tertentu */
            .avoid-break {
                page-break-inside: avoid;
                break-inside: avoid;
            }
        }

        /* ---------- Opsional: tampilkan indikator di layar (debugging) ---------- */
        .page-break {
            /* non-intrusive indicator hanya untuk tampilan layar dev */
            display: block;
            height: 1px;
            background: transparent;
        }
    </style>
    <link rel='stylesheet' href='{{ asset('css/layout-cetak.css') }}'>
    {{-- Undangan Rapat --}}
    <div class='container'>
        <x-kop-surat-cetak></x-kop-surat-cetak>
        <div class="mt-4"></div>

        <!-- No Surat dan Tanggal Sejajar dengan div -->
        <div style="display: flex; justify-content: space-between; margin-bottom: 20px;">
            <!-- Kolom No Surat -->
            <div style="width: 75%;">
                <table class="no-border" style="width: 100%; margin-bottom: 10px;">
                    <tr style="line-height: 0.5;">
                        <!-- Menambahkan style line-height untuk mengurangi jarak antar baris -->
                        <td width='15%' class='text-left'>
                            <strong>No. Surat</strong>
                        </td>
                        <td class='text-left'>: {{ $datas->nomor_surat ?? '-' }}</td>
                    </tr>
                    <tr style="line-height: 0.5;">
                        <!-- Menambahkan style line-height untuk mengurangi jarak antar baris -->
                        <td width='15%' class='text-left'>
                            <strong>Lampiran</strong>
                        </td>
                        <td class='text-left'>: {{ $datas->lampiran ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td width='15%' class='text-left' valign="top">
                            <strong>Hal</strong>
                        </td>
                        <td class='text-left' valign="top">: <b><u><i>Undangan {{ $data['judul'] ?? '-' }}</i></u></b>
                        </td>
                    </tr>

                </table>

            </div>
            <!-- Kolom Tanggal -->
            {{-- <div style="width: 45%; text-align: right;">
                {{ $Identitas->kecamatan }},
                {{ $data['tanggal_pelaksanaan'] ? \Carbon\Carbon::parse($data['tanggal_pelaksanaan'])->translatedFormat('d F Y') : '-' }}
            </div> --}}
        </div>

        <!-- Judul Undangan -->
        <br>

        <!-- Isi Undangan -->
        <div style="margin-bottom: 1.5em;">
            <p>Kepada </p>
            <p style="margin: 0;">
                Yth. Bapak/Ibu Dewan Guru dan Staf Karyawan
            </p>
            <p style="margin: 0;">
                Di Tempat
            </p>
        </div>

        <br><br>

        <p>Dengan hormat,</p>
        <p>
            Sehubungan dengan akan dilaksanakannya <b>{{ $data['judul'] }}</b>,
            kami mengundang Bapak/Ibu untuk hadir dalam rapat yang akan dilaksanakan pada:
        </p>

        <br>
        <style>
            table.no-border {
                border-collapse: collapse;
            }

            table.no-border td {
                vertical-align: top;
                padding: 4px 8px;
                /* kasih jarak antar cell biar gak mepet */
            }

            table.no-border td:first-child {
                width: 150px;
                font-weight: 600;
            }

            /* Reset margin atas <ul> supaya bullet list rapi */
            table.no-border td ul {
                margin-top: 0 !important;
                padding-left: 20px;
                /* agar bullet-nya ada indent */
            }
        </style>
        <table class="no-border" style="margin-left: 1em;">
            <tr>
                <td style="width: 150px;">Hari / Tanggal</td>
                <td style="width: 10px;">:</td>
                <td style="padding-left: 1.5em;">
                    {{ \Carbon\Carbon::parse($data['tanggal_pelaksanaan'])->translatedFormat('l, d F Y') }} - Selesai
                </td>
            </tr>
            <tr>
                <td>Waktu</td>
                <td>:</td>
                <td style="padding-left: 1.5em;">
                    {{ $data['waktu'] ? \Carbon\Carbon::parse($data['waktu'])->format('H:i') : '-' }} WIB – Selesai
                    {{-- {{ $datas->jam_selesai ? \Carbon\Carbon::parse($datas->jam_selesai)->format('H:i') : '-' }} WIB --}}
                </td>
            </tr>
            <tr>
                <td>Tempat</td>
                <td>:</td>
                <td style="padding-left: 1.5em;">{{ $Identitas->namasek }}</td>
            </tr>
            <tr>
                <td style="vertical-align: top;">Agenda</td>
                <td style="vertical-align: top;">:</td>
                <td style="vertical-align: top; padding-left: 0; margin-left: 0;">
                    {{-- {!! $datas->perihal !!} --}}
                    {!! $data['pembahasan'] !!}
                </td>
            </tr>
        </table>


        <br>

        <p>
            Demikian undangan ini kami sampaikan. Atas perhatian dan kehadiran Bapak/Ibu, kami ucapkan terima kasih.
        </p>

        <br><br>

        @php
            $ttds = [
                [
                    'jabatan' => 'Kepala ' . $Identitas->namasek,
                    'nama' => $Identitas->namakepala,
                    'nip' => $Identitas->nipkepala,
                ],
            ];
            $tempat = $Identitas->kecamatan;
            $tanggal = \Carbon\Carbon::now()->isoFormat('D MMMM YYYY');
        @endphp

        <x-tanda-tangan :ttds="$ttds" :tempat="$tempat" :tanggal="$tanggal" />


        @if (!empty($datas->tembusan))
            <br><br>
            <p><strong>Tembusan:</strong></p>
            <div class="tembusan-content">
                {{-- {!! $datas->tembusan !!} --}}
            </div>
        @endif

        @if (!empty($datas->lampiran))
            <br><br>
            <p><strong>Lampiran:</strong> {{ $datas->lampiran }}</p>
        @endif

    </div>


    <div class="page-break"></div> <!-- Ini akan memaksa pindah halaman saat print -->
    {{-- Undangan Rapat --}}

    {{-- Notulen --}}
    <div class='container'>
        <x-kop-surat-cetak></x-kop-surat-cetak>
        <div class="row">
            <div class="row ml-3">
                <div class="col-xl-3">
                    <p style="display: inline-block; width: 150px;">
                        Nama Acara
                    </p>
                    <p style="display: inline-block; width: 150px;">
                        Pukul
                    </p>
                    <p style="display: inline-block; width: 150px;">
                        Tempat
                    </p>
                </div>
                <div class="col-xl-9">
                    <p style="display: inline-block; width: 10px;">:</p>
                    <p style="display: inline-block;">
                        {{ $data['judul'] }} <br>
                    </p> <br>
                    <p style="display: inline-block; width: 10px;">:</p>
                    <p style="display: inline-block;">
                        {{ $data['waktu'] ? \Carbon\Carbon::parse($data['waktu'])->format('H:i') : '-' }} WIB – Selesai
                        {{-- {{ $datas->jam_selesai ? \Carbon\Carbon::parse($datas->jam_selesai)->format('H:i') : '-' }} WIB --}}
                    </p><br>
                    <p style="display: inline-block; width: 10px;">:</p>
                    <p style="display: inline-block;">
                        {{ $Identitas->namasek }}
                    </p><br>
                </div>
            </div>
        </div>
        <h3 class='text-center'>NOTULEN RAPAT</h3>
        <br>


    </div>
    <div class="page-break"></div> <!-- Ini akan memaksa pindah halaman saat print -->

    {{-- Notulen --}}

    {{-- Berita Acara --}}
    <div class='container'>
        <x-kop-surat-cetak></x-kop-surat-cetak>
        <h3 class='text-center'>BERITA ACARA</h3>
        <br>
        <p>Pada hari <b>{{ Carbon::create($data['tanggal_pelaksanaan'])->translatedformat('l') ?? '' }}</b> tanggal
            <b>{{ Carbon::create($data['tanggal_pelaksanaan'])->translatedformat('d') ?? '' }}</b> di bulan
            <b>{{ Carbon::create($data['tanggal_pelaksanaan'])->translatedformat('F') ?? '' }}</b> Tahun
            <b>{{ Carbon::create($data['tanggal_pelaksanaan'])->translatedformat('Y') ?? '' }}</b>,
            pukul {{ $data['waktu'] ? \Carbon\Carbon::parse($data['waktu'])->format('H:i') : '-' }}
            sampai
            dengan Selesai
            telah
            dilaksanakan
            <b>{{ $data['judul'] }}</b> tahun pelajaran {{ date('Y') }} dipimpin oleh
            <b>............................................................</b> yang bertempat di
            <b>{{ $Identitas->namasek }}</b> dan menghasilkan :
        </p>
        <br>

        {{-- {!! $datas->berita_acara !!} --}}

        <br>
        <br>
        {{-- <p>Demikian berita acara ini dibuat dengan sebenarnya dan sesuai dengan fakta yang dapatdipertanggungjawabkan kebenarannya.</p> --}}
        {{-- @php
                $ttds = [
                    ['jabatan' => 'Notulen', 'nama' => $GuruNotulen->nama_guru, 'nip' => $GuruNotulen->nip],
                    ['jabatan' => 'Kepala Sekolah', 'nama' => $Identitas->namakepala, 'nip' => $Identitas->nipkepala],
                ];
                $tempat = $Identitas->kecamatan;
                $tanggal = Carbon::now()->isoFormat('D MMMM YYYY');

            @endphp --}}
        {{-- <x-tanda-tangan :ttds="$ttds" :tempat="$tempat" :tanggal="$tanggal" /> --}}


    </div>
    <div class="page-break"></div> <!-- Ini akan memaksa pindah halaman saat print -->
    {{-- Berita Acara --}}
    {{-- Daftar Hadir --}}
    {{-- @if (is_null($datas->vote_id))
        @else --}}
    <div class='container'>
        <x-kop-surat-cetak></x-kop-surat-cetak>
        <h3 class='text-center'><b>DAFTAR HADIR</b></h3>
        <br>
        <div class="row">
            <div class="row ml-3">
                <div class="col-xl-3">
                    <p style="display: inline-block; width: 150px;">
                        Nama Acara
                    </p>
                    <p style="display: inline-block; width: 150px;">
                        Pukul
                    </p>
                    <p style="display: inline-block; width: 150px;">
                        Tempat
                    </p>
                </div>
                <div class="col-xl-9">
                    <p style="display: inline-block; width: 10px;">:</p>
                    <p style="display: inline-block;">
                        {{ $data['judul'] }} <br>
                    </p> <br>
                    <p style="display: inline-block; width: 10px;">:</p>
                    <p style="display: inline-block;">
                        {{ $data['waktu'] ? \Carbon\Carbon::parse($data['waktu'])->format('H:i') : '-' }} WIB – Selesai
                        {{-- {{ $datas->jam_selesai ? \Carbon\Carbon::parse($datas->jam_selesai)->format('H:i') : '-' }} WIB --}}
                    </p><br>
                    <p style="display: inline-block; width: 10px;">:</p>
                    <p style="display: inline-block;">
                        {{ $Identitas->namasek }}
                    </p><br>
                </div>
            </div>
        </div>
        <table id='example1x' class='table table-bordered table-hover'>
            <thead>
                <tr class='table-primary text-center align-middle'>
                    <th>ID</th>
                    <th>Nama Guru</th>
                    <th class="tanda-tangan">Tanda Tangan</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $DataGuru = \App\Models\User\Guru\Detailguru::WhereNotIn('id', [1,2,3])->get();
                @endphp
                @foreach ($Gurus as $data)
                    {{-- blade-formatter-disable --}}

                            {{-- blade-formatter-enable --}}
                    <tr class="text-center">
                        <td>{{ $loop->iteration }}</td>
                        <td class='text-left'>{{ $data->nama_guru }}{{ $data->gelar }}</td>
                        <td class="{{ $loop->iteration % 2 == 0 ? 'text-right' : 'text-left' }} tanda-tangan">
                            {{ $loop->iteration }}. .....................
                        </td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr class='table-primary text-center align-middle'>
                    <th>ID</th>
                    <th>Nama</th>
                    <th>Tanda Tangan</th>
                </tr>
            </tfoot>
        </table>
        @php
            $ttds = [
                [
                    'jabatan' => 'Kepala ' . $Identitas->namasek,
                    'nama' => $Identitas->namakepala,
                    'nip' => $Identitas->nipkepala,
                ],
            ];
            $tempat = $Identitas->kecamatan;
            $tanggal = \Carbon\Carbon::now()->isoFormat('D MMMM YYYY');
        @endphp

        <x-tanda-tangan :ttds="$ttds" :tempat="$tempat" :tanggal="$tanggal" />
        {{-- <div class="page-break"></div> <!-- Ini akan memaksa pindah halaman saat print --> --}}
    </div>
    {{-- @endif --}}

    {{-- Daftar Hadir --}}
    {{-- @dump($datas, $ProcessedTemplate, $Identitas, $DataGuru) --}}
</x-layout-cetak>
