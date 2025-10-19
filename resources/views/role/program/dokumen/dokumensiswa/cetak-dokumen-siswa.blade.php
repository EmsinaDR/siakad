@extends('layouts.dokumen-siswa')

@section('title', 'Cetak Dokumen Siswa')

@section('content')
    {{-- <h2>Data Dokumen Siswa</h2> --}}

    @foreach ($siswas as $siswa)
        {{-- Cover Page --}}
        <div class="cover-page">
            <h1>Dokumen Siswa</h1>
            <h2>{{ $siswa->nama_siswa }}</h2>
            <table style="margin: 0 auto; border-collapse: collapse; width: auto;">
    <tr>
        <td style="padding: 8px; border: 0 solid #000;"><strong>NISN:</strong></td>
        <td style="padding: 8px; border: 0 solid #000;">{{ $siswa->nisn ?? '-' }}</td>
    </tr>
    <tr>
        <td style="padding: 8px; border: 0ch solid #000;"><strong>Kelas:</strong></td>
        <td style="padding: 8px; border: 0 solid #000;">{{ $siswa->KelasOne->nama_kelas ?? '-' }}</td>
    </tr>
    <tr>
        <td style="padding: 8px; border: 0 solid #000;"><strong>Dicetak pada:</strong></td>
        <td style="padding: 8px; border: 0 solid #000;">{{ now()->format('d-m-Y') }}</td>
    </tr>
</table>

        </div>

        {{-- Dokumen Pages --}}
        @foreach ($dokumenDipilih as $dokumen)
            <div class="dokumen-page">
                @if ($dokumen == 'kk')
                    <strong>Kartu Keluarga (KK)</strong>
                    <p>Data KK siswa...</p>
                @elseif($dokumen == 'ktp_ayah')
                    <strong>KTP Ayah</strong>
                    <p>Data KTP ayah siswa...</p>
                @elseif($dokumen == 'ktp_ibu')
                    <strong>KTP Ibu</strong>
                    <p>Data KTP ibu siswa...</p>
                @elseif($dokumen == 'karpel')
                    <strong>Kartu Pelajar (Karpel)</strong>
                    <p>Data Kartu Pelajar siswa...</p>
                @elseif ($dokumen == 'suket_aktif')
                    <div class="suket-aktif">
                        {{-- isi surat aktif --}}
                        <x-kop-surat-cetak></x-kop-surat-cetak>
                        <div style="text-align: center; margin-top: 20px;">
                            <h4><u>SURAT KETERANGAN AKTIF</u></h4>
                        </div>
                        <div style="margin-top: 30px; line-height: 1.8;">
                            <p>Yang bertanda tangan di bawah ini, Kepala {{ $Identitas->namasek }}, menerangkan bahwa:</p>
                            <table style="margin-left: 30px;">
                                <tr>
                                    <td>Nama</td>
                                    <td>: {{ $siswa->nama_siswa }}</td>
                                </tr>
                                <tr>
                                    <td>NISN</td>
                                    <td>: {{ $siswa->nisn ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <td>Kelas</td>
                                    <td>: {{ $siswa->KelasOne->kelas ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <td>Alamat</td>
                                    <td>: {{ $siswa->alamat_siswa ?? '-' }}</td>
                                </tr>
                            </table>
                            <p>Benar-benar merupakan siswa aktif...</p>
                        </div>
                        <div style="margin-top: 50px; text-align: right;">
                            <p>{{ $Identitas->kecamatan }}, {{ now()->translatedFormat('d F Y') }}</p>
                            <p>Kepala Sekolah,</p>
                            <br><br><br>
                            <p><u><strong>Drs. Andi Harapan, M.Pd</strong></u></p>
                            <p>NIP. 19650412 199003 1 001</p>
                        </div>

                    </div>
                @elseif($dokumen == 'kartu_kis')
                    <strong>Kartu Indonesia Sehat (KIS)</strong>
                    <p>Data KIS siswa...</p>
                @elseif($dokumen == 'kip')
                    <strong>Kartu Indonesia Pintar (KIP)</strong>
                    <p>Data KIP siswa...</p>
                @elseif($dokumen == 'akte')
                    <strong>Akte Kelahiran</strong>
                    <p>Data Akte Kelahiran siswa...</p>
                @endif
            </div>
        @endforeach
    @endforeach
@endsection
<script>
    window.onbeforeprint = function() {
        // Pastikan hanya footer di suket-aktif yang tampil
        document.querySelectorAll('.footer-siswa').forEach(el => {
            if (el.closest('.suket-aktif')) {
                el.style.display = 'block';
            } else {
                el.style.display = 'none';
            }
        });
    };

    window.onafterprint = function() {
        // Setelah print reset semua
        document.querySelectorAll('.footer-siswa').forEach(el => {
            el.style.display = '';
        });
    };
</script>
