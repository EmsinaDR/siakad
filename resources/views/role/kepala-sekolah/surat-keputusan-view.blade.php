@php
    //content
    use Illuminate\Support\Carbon;
    \Carbon\Carbon::setLocale('id');
    $activecrud = collect([2, 4, 6, 8])->search(Auth::user()->id);
    $urlroot = app('request')->root();
@endphp
<x-layout-cetak>
    @php
     $TemplatesView = $Templates->content;
        $DataGuru = $Gurus->where('id', $datas->detailguru_id)->first();
        $data = [
            'nomor_sk' => $datas['nomor_sk'],
            'nama_sekolah' => $Identitas->jenjang . ' '. $Identitas->nomor . ' '. $Identitas->namasek ?? 'Data Pada Identitas Sekolah Kosong',
            'nama_guru' => $DataGuru->nama_guru,
            'nip_guru' => $DataGuru->nip,
            'data_tempat' => $Identitas->namasek ?? 'Data Pada Identitas Sekolah Kosong',
            'data_tanggal' => Carbon::create($datas['tanggal_sk'])->translatedFormat('d F Y'),
            'data_nama_kepsek' => $Identitas->namakepala,
            'data_nip_kepsek' => '19800101 200012 1 002',
            'data_tahun_pelajaran' => $Tapels->tapel .' / ' . $Tapels->tapel + 1,
        ];

        $ProcessedTemplate = preg_replace_callback('/{{(.*?)}}/', function ($matches) use ($data) {
            $key = trim($matches[1]);
            return $data[$key] ?? $matches[0];
        }, $TemplatesView);
    @endphp
        <link rel="stylesheet" href="{{ asset('css/layout-cetak.css') }}">
        <div class="container">
            <x-kop-surat-cetak></x-kop-surat-cetak>
                        <style>
                            #myTable,
                            #myTable td,
                            #myTable th {
                                border: none !important;
                                border-collapse: collapse;
                            }
                        </style>
            {!! $ProcessedTemplate !!}


        </div>
{{-- @dump($datas, $ProcessedTemplate, $Identitas, $DataGuru) --}}
</x-layout-cetak>

{{--
Edaran Atau Pemberitahuan :
data_nomor
data_lampiran
data_nama_kegiatan
data_hari_tanggal
data_waktu_kegiatan
data_tempat_kegiatan
data_peserta_kegiatan


MOU :
data_nama_sekolah
data_alamat_sekolah
data_telp_sekolah
data_alamat_mitra
data_telp_mitra
data_hari
data_tanggal
data_tempat
data_nama_pihak1
data_jabatan_pihak1
data_nama_sekolah
data_nama_pihak2
data_jabatan_pihak2
data_nama_mitra
data_mulai_perjanjian
data_berakhir_perjanjian

Panggilan :


Pengantar :
$data_kelas
$data_no_surat
$data_lampiran
$data_tanggal
$data_waktu
$data_tempat
$data_nama_instansi




 --}}