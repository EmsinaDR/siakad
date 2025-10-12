@php
    //content
    use Illuminate\Support\Carbon;
    \Carbon\Carbon::setLocale('id');
    $activecrud = collect([2, 4, 6, 8])->search(Auth::user()->id);
    $urlroot = app('request')->root();
    $dataSiswa = App\Models\User\Siswa\Detailsiswa::where('id', request()->segment(4))->first();
    $PesertaUjian = App\Models\WakaKurikulum\Elearning\Nilai\KurulumDataPesertaUjian::where(
        'detailsiswa_id',
        request()->segment(4),
    )->first();
@endphp
<style>
    #example1 {
        width: 100% !important;
        /* Pastikan tabel lebar penuh */
        max-width: 100%;
        table-layout: auto;
        /* Jangan paksa lebar tetap */
        overflow-x: hidden;
        /* Sembunyikan scroll horizontal */
    }
</style>
<x-layout>
    <style>
        textarea {
            resize: none,
        }
    </style>
    <x-slot:title>{{ $title }} - {{ $dataSiswa->nama_siswa }}</x-slot:title>
    <x-slot:breadcrumb>{{ $breadcrumb }}</x-slot:breadcrumb>
    <section class='content mx-2 my-4'>
        {{-- Validator --}}
        @if ($errors->any())
            <div class='alert alert-danger'>
                <ul class='mb-0'>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        {{-- Validator --}}
        <div class='card'>
            {{-- Papan Informasi --}}


            {{-- Papan Informasi --}}

            <!--Car Header-->
            <div class='card-header bg-primary mx-2'>
                <h3 class='card-title'>{{ $title }}</H3>
            </div>
            <!--Car Header-->


            {{-- blade-formatter-disable --}}
               <div class='row m-2'>
                   <div class='col-xl-2'>
                       <button type='button' class='btn btn-block btn-default bg-primary btn-md' onclick='TambahData()'> <i class='fa fa-plus'></i> Tambah Data</button>
                   </div>
                   <div class='col-xl-10'></div>
               </div>
               {{-- blade-formatter-enable --}}


            <div class='ml-2 my-4'>
                <div class='card'>
                    <div class='card-header bg-primary'>
                        <h3 class='card-title'>{{ $title }}</h3>
                    </div>
                    <div class='card-body'>
                        <div class="table-responsive">
                            {{-- blade-formatter-disable --}}
                           {{-- blade-formatter-enable --}}
                            <div class="row mb-3">
                                <div class="col-xl-4">
                                    Nama <br>
                                    Kelas <br>
                                    Nomor Ujian <br>
                                </div>
                                <div class="col-xl-8">
                                    : {{ $dataSiswa->nama_siswa }} <br>
                                    : {{ $dataSiswa->KelasOne->kelas }} <br>
                                    : {{ $PesertaUjian->nomor_ujian }} <br>
                                </div>

                            </div>
                            {{-- <h4>Nama: <strong>{{ $datas->first()->nama_siswa ?? 'N/A' }} /
                                    {{ $dataSiswa->nama_siswa }}</strong></h4>
                            <h4>Kelas: <strong>{{ $kelas->Kelas->kelas ?? 'N/A' }}</strong></h4> --}}
                            <table id='example1' class="table table-bordered table-striped table-hover">
                                <thead class="text-center">
                                    <tr class="table-primary">
                                        <th rowspan="2">Mata Pelajaran</th>
                                        @foreach ($datas->groupBy('tapel_id') as $tapel => $data)
                                            <th colspan="3">Semester {{ $tapel - 2 }}</th>
                                        @endforeach
                                        <th rowspan="2">Jumlah</th> {{-- Tambahkan kolom "Jumlah" --}}
                                    </tr>
                                    <tr class="table-secondary">
                                        @foreach ($datas->groupBy('tapel_id') as $tapel => $data)
                                            <th>P</th>
                                            <th>K</th>
                                            <th>RT</th>
                                        @endforeach
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        // Variabel untuk menyimpan total per kolom
                                        $totalPerTapel = [];
                                        $totalKeseluruhan = 0;
                                    @endphp

                                    @foreach ($datas->groupBy('mapel_id') as $mapel => $nilai)
                                        <tr>
                                            <td>{{ $nilai->first()->mapel }}</td>
                                            @php $totalRataRata = 0; @endphp {{-- Total rata-rata per mapel --}}
                                            @foreach ($nilai as $tapel)
                                                <td class="text-center">
                                                    {{ number_format($tapel->nilai_pengetahuan ?? 0, 2) }}</td>
                                                <td class="text-center">
                                                    {{ number_format($tapel->nilai_keterampilan ?? 0, 2) }}</td>
                                                <td class="text-center">{{ number_format($tapel->rata_rata ?? 0, 2) }}
                                                </td>

                                                @php
                                                    // Menyimpan total nilai per tahun ajaran (tapel)
                                                    $totalPerTapel[$tapel->tapel_id]['pengetahuan'] =
                                                        ($totalPerTapel[$tapel->tapel_id]['pengetahuan'] ?? 0) +
                                                        ($tapel->nilai_pengetahuan ?? 0);
                                                    $totalPerTapel[$tapel->tapel_id]['keterampilan'] =
                                                        ($totalPerTapel[$tapel->tapel_id]['keterampilan'] ?? 0) +
                                                        ($tapel->nilai_keterampilan ?? 0);
                                                    $totalPerTapel[$tapel->tapel_id]['rata_rata'] =
                                                        ($totalPerTapel[$tapel->tapel_id]['rata_rata'] ?? 0) +
                                                        ($tapel->rata_rata ?? 0);

                                                    $totalRataRata += $tapel->rata_rata ?? 0; // Tambahkan ke total per mapel
                                                @endphp
                                            @endforeach
                                            <td class="text-center fw-bold">{{ number_format($totalRataRata, 2) }}</td>
                                            {{-- Total per baris --}}
                                            @php $totalKeseluruhan += $totalRataRata; @endphp
                                        </tr>
                                    @endforeach
                                </tbody>

                                {{-- Baris Total Keseluruhan --}}
                                <tfoot>
                                    <tr class="table-success fw-bold">
                                        <td class="text-center">Jumlah</td>
                                        @foreach ($datas->groupBy('tapel_id') as $tapel => $data)
                                            <td class="text-center">
                                                {{ number_format($totalPerTapel[$tapel]['pengetahuan'] ?? 0, 2) }}</td>
                                            <td class="text-center">
                                                {{ number_format($totalPerTapel[$tapel]['keterampilan'] ?? 0, 2) }}
                                            </td>
                                            <td class="text-center">
                                                {{ number_format($totalPerTapel[$tapel]['rata_rata'] ?? 0, 2) }}</td>
                                        @endforeach
                                        <td class="text-center">{{ number_format($totalKeseluruhan, 2) }}</td>
                                        {{-- Total semua rata-rata --}}
                                    </tr>
                                </tfoot>
                            </table>


                        </div>

                    </div>
                </div>
            </div>


        </div>

    </section>
</x-layout>
@php
$filePath = public_path('img/logo.png'); // Path file di folder public
// Membaca konten file sebagai string
$fileContents = File::get($filePath);
// Mengubah konten file menjadi Base64
$fileBase64 = base64_encode($fileContents);
// Menambahkan prefix untuk tipe file (misalnya untuk gambar JPEG)
$mimeType = mime_content_type($filePath); // Mengetahui tipe MIME file
$fileBase64WithPrefix = 'data:' . $mimeType . ';base64,' . $fileBase64;
@endphp
<script>
$(document).ready(function() {
    $('#example1').DataTable().destroy();
    $('#example1').DataTable({
        responsive: true,
        lengthChange: false,
        autoWidth: false,
        buttons: [
            {
                extend: 'pdfHtml5',
                text: 'PDF Export',
                orientation: 'landscape',
                pageSize: 'A4',
                customize: function (doc) {
                    // Hapus title default DataTables
                    doc.content.splice(0, 1);

                    // Tambahkan informasi tambahan di atas tabel
                    doc.content.unshift({
                        text: 'Laporan Nilai Siswa\nNama: John Doe\nKelas: XII IPA 1\nTanggal: ' + new Date().toLocaleDateString(),
                        fontSize: 12,
                        bold: true,
                        margin: [0, 0, 0, 10]
                    });
                }
            },
            'copy', 'csv', 'excel', 'print'
        ]
    }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
});


</script>

