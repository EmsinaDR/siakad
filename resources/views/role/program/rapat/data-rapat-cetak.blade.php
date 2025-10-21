@php
    //content
    use Illuminate\Support\Carbon;
    \Carbon\Carbon::setLocale('id');
    $activecrud = collect([2, 4, 6, 8])->search(Auth::user()->id);
    $urlroot = app('request')->root();
    $GuruNotulen = $Gurus->where('id', $datas->notulen_id)->first();
@endphp
{{-- @dd($datas) --}}
<x-layout-cetak>

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
                        <td class='text-left' valign="top">: <b><u><i>Undangan
                                        {{ $datas->nama_rapat ?? '-' }}</i></u></b></td>
                    </tr>

                </table>

            </div>
            <!-- Kolom Tanggal -->
            {{-- <div style="width: 45%; text-align: right;">
                {{ $Identitas->kecamatan }},
                {{ $datas->tanggal_pelaksanaan ? \Carbon\Carbon::parse($datas->tanggal_pelaksanaan)->translatedFormat('d F Y') : '-' }}
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
            Sehubungan dengan akan dilaksanakannya <b>{{ $datas->nama_rapat }}</b>,
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
                    {{ \Carbon\Carbon::parse($datas->tanggal_pelaksanaan)->translatedFormat('l, d F Y') }}</td>
            </tr>
            <tr>
                <td>Waktu</td>
                <td>:</td>
                <td style="padding-left: 1.5em;">
                    {{ $datas->jam_mulai ? \Carbon\Carbon::parse($datas->jam_mulai)->format('H:i') : '-' }} –
                    {{ $datas->jam_selesai ? \Carbon\Carbon::parse($datas->jam_selesai)->format('H:i') : '-' }} WIB
                </td>
            </tr>
            <tr>
                <td>Tempat</td>
                <td>:</td>
                <td style="padding-left: 1.5em;">{{ $datas->tempat }}</td>
            </tr>
            <tr>
                <td style="vertical-align: top;">Agenda</td>
                <td style="vertical-align: top;">:</td>
                <td style="vertical-align: top; padding-left: 0; margin-left: 0;">
                    {!! $datas->perihal !!}
                </td>
            </tr>
        </table>


        <br>

        <p>
            Demikian undangan ini kami sampaikan. Atas perhatian dan kehadiran Bapak/Ibu, kami ucapkan terima kasih.
        </p>

        <br><br>

        @php
            $ttds = [['jabatan' => 'Kepala Sekolah', 'nama' => $Identitas->namakepala, 'nip' => $Identitas->nipkepala]];
            $tempat = $Identitas->kecamatan;
            $tanggal = \Carbon\Carbon::now()->isoFormat('D MMMM YYYY');
        @endphp

        <x-tanda-tangan :ttds="$ttds" :tempat="$tempat" :tanggal="$tanggal" />

        @if (!empty($datas->tembusan))
            <br><br>
            <p><strong>Tembusan:</strong></p>
            <div class="tembusan-content">
                {!! $datas->tembusan !!}
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
    @if (!empty(trim($datas->notulen ?? '')))
        <div class='container'>
            <x-kop-surat-cetak></x-kop-surat-cetak>
            <h3 class='text-center'>NOTULEN RAPAT</h3>
            <br>
            {!! $datas->notulen !!}
        </div>
        <div class="page-break"></div> <!-- Ini akan memaksa pindah halaman saat print -->
    @endif

    {{-- Notulen --}}

    {{-- Berita Acara --}}
    @if (!empty(trim($datas->berita_acara ?? '')))
        <div class='container'>
            <x-kop-surat-cetak></x-kop-surat-cetak>
            <h3 class='text-center'>BERITA ACARA</h3>
            <br>
            <p>Pada hari <b>{{ Carbon::create($datas->tanggal_pelaksanaan)->translatedformat('l') ?? '' }}</b> tanggal
                <b>{{ Carbon::create($datas->tanggal_pelaksanaan)->translatedformat('d') ?? '' }}</b> di bulan
                <b>{{ Carbon::create($datas->tanggal_pelaksanaan)->translatedformat('F') ?? '' }}</b> Tahun
                <b>{{ Carbon::create($datas->tanggal_pelaksanaan)->translatedformat('Y') ?? '' }}</b>,
                pukul {{ $datas->jam_mulai ? \Carbon\Carbon::parse($datas->jam_mulai)->format('H:i') : '-' }}
                sampai
                dengan {{ $datas->jam_mulai ? \Carbon\Carbon::parse($datas->jam_mulai)->format('H:i') : '-' }}
                telah
                dilaksanakan
                <b>{{ $datas->nama_rapat }}</b> tahun pelajaran {{ date('Y') }} dipimpin oleh
                <b>{{ $datas->ketua }}</b> yang bertempat di <b>{{ $datas->tempat }}</b> dan menghasilkan :
            </p>
            <br>
            {!! $datas->berita_acara !!}
            isi Berita Acara
            <br>
            <br>
            <p>Demikian berita acara ini dibuat dengan sebenarnya dan sesuai dengan fakta yang dapat
                dipertanggungjawabkan kebenarannya.</p>
            @php
                $ttds = [
                    ['jabatan' => 'Notulen', 'nama' => $GuruNotulen->nama_guru, 'nip' => $GuruNotulen->nip],
                    ['jabatan' => 'Kepala Sekolah', 'nama' => $Identitas->namakepala, 'nip' => $Identitas->nipkepala],
                ];
                $tempat = $Identitas->kecamatan;
                $tanggal = Carbon::now()->isoFormat('D MMMM YYYY');

            @endphp
            <x-tanda-tangan :ttds="$ttds" :tempat="$tempat" :tanggal="$tanggal" />


        </div>
        <div class="page-break"></div> <!-- Ini akan memaksa pindah halaman saat print -->
    @endif
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
                        {{ $datas->nama_rapat }} <br>
                    </p> <br>
                    <p style="display: inline-block; width: 10px;">:</p>
                    <p style="display: inline-block;">
                        {{ $datas->jam_mulai ? \Carbon\Carbon::parse($datas->jam_mulai)->format('H:i') : '-' }} –
                        {{ $datas->jam_selesai ? \Carbon\Carbon::parse($datas->jam_selesai)->format('H:i') : '-' }} WIB
                    </p><br>
                    <p style="display: inline-block; width: 10px;">:</p>
                    <p style="display: inline-block;">
                        {{ $datas->tempat }}
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
                    $DataId = json_encode($datas->vote_id ?? \App\Models\User\Guru\Detailguru::pluck('id')->toArray());
                @endphp
                @foreach (json_decode($DataId) as $data)
                    {{-- blade-formatter-disable --}}
                            @php
                                $DataGuru = \App\Models\User\Guru\Detailguru::where('id', $data )->first();
                            @endphp
                            {{-- blade-formatter-enable --}}
                    <tr class="text-center">
                        <td>{{ $loop->iteration }}</td>
                        <td class='text-left'>{{ $DataGuru->nama_guru }}</td>
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
        {{-- <div class="page-break"></div> <!-- Ini akan memaksa pindah halaman saat print --> --}}
    </div>
    {{-- @endif --}}

    {{-- Daftar Hadir --}}
    {{-- @dump($datas, $ProcessedTemplate, $Identitas, $DataGuru) --}}
</x-layout-cetak>
