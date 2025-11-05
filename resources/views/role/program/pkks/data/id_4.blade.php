@php
    use Illuminate\Support\Carbon;

    Carbon::setLocale('id');
    $activecrud = collect([2, 4, 6, 8])->contains(Auth::id());
    $urlroot = request()->root();
@endphp

<x-layout-view-pkks>
    <x-slot:judul>
        <h2>SURAT KEPUTUSAN PEMBAGIAN TUGAS</h2>
        <h2 class="header-title">{{ strtoupper($Identitas->namasek) }}</h2>
        <h2 class="header-title">{{ strtoupper($Tapels->tapel) }}</h2>
    </x-slot:judul>

    <link rel="stylesheet" href="{{ asset('css/viewpkks.css') }}">
    <section>

        @foreach ($TapelSelecteds as $TapelSelected)
            @php
                $TepelsIn = \App\Models\Admin\Etapel::where('id', $TapelSelected)->first();
            @endphp
            <div class="container">
                <x-kop-surat-cetak />
                <div class="my-4">
                    <h2 class='header-title text-center'>KEPUTUSAN</h2>
                    <h2 class="header-title">KEPUTUSAN KEPALA {{ strtoupper($Identitas->namasek) }}</h2>
                    {{-- blade-formatter-disable --}}
                    <div class="text-center">
                        <p><b class='text-center'>Nomor: MTs. 465 / PP.00.1/121/VII/ {{ $TepelsIn->tapel }}</b></p>
                        <p class=' mt-4'><b class='text-center'>TENTANG</b></p>
                        <p><b class='text-center'>PEMBAGIAN TUGAS MENGAJAR GURU DAN PEMENUHAN BEBAN KERJA DALAM KEGIATAN INTRAKURIKULER, KOKURIKULER, DAN EKSTRA KURIKULER</b></p>
                        <p><b class='text-center'>TAHUN PELAJARAN {{ $TepelsIn->tapel }} - {{ $TepelsIn->tapel + 1 }}</b></p>
                        <p><b class='text-center'>SEMESTER I (SATU)</b></p>
                    </div>
                    {{-- blade-formatter-enable --}}
                </div>

            </div>
            <div class="page-break"></div>
            {{-- EKstra --}}
            <div class="container">
                <x-kop-surat-cetak />
                <div class="my-4">
                    <div class="text-center">
                        <p><b class='text-center'>TUGAS TAMBAHAN GURU DAN TENAGA KEPENDIDIKAN</p>
                        <p><b class='text-center'>DALAM KEGIATAN EKSTRA KURIKULER</b></p>
                        <p><b class='text-center'>TAHUN PELAJARAN {{ $TepelsIn->tapel }} -
                                {{ $TepelsIn->tapel + 1 }}</b>
                        </p>
                    </div>
                    <table id='example1' width='100%' class='table table-bordered table-hover my-2'>
                        <thead>
                            <tr class='table-primary text-center align-middle'>
                                <th>ID</th>
                                <th>Nama Guru</th>
                                <th>Pembina Ekstra</th>
                                <th>Jadwal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($DataEkstras->where('tapel_id', $TapelSelected) as $DataEkstra)
                                <tr class='text-center'>
                                    <td>{{ $loop->iteration }}</td>
                                    <td class='text-left'>{{ $DataEkstra->Detailguru->nama_guru }}</td>
                                    <td class='text-center'>{{ $DataEkstra->EkstraOne->ekstra }}</td>
                                    <td class='text-center'>{{ $DataEkstra->jadwal }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr class='table-primary text-center align-middle'>
                                <th>ID</th>
                                <th>Nama Guru</th>
                                <th>Pembina Ekstra</th>
                                <th>Jadwal</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>

            </div>
            <div class="page-break"></div>
            {{-- ADM SEKOLAH --}}
            <div class="container">
                <x-kop-surat-cetak />
                <div class="my-4">
                    <div class="text-center">
                        <p><b class='text-center'>TUGAS TAMBAHAN GURU DAN TENAGA KEPENDIDIKAN</p>
                        <p><b class='text-center'>DALAM KEGIATAN ADMINISTRASI SEKOLAH</b></p>
                        <p><b class='text-center'>TAHUN PELAJARAN {{ $TepelsIn->tapel }} -
                                {{ $TepelsIn->tapel + 1 }}</b>
                        </p>

                    </div>
                </div>

            </div>
            <div class="page-break"></div>
            {{-- Wali Kelas --}}
            <div class="container">
                <x-kop-surat-cetak />
                {{-- blade-formatter-disable --}}
                <div class="my-4">
                    <div class="text-center">
                        <p><b class='text-center'>TUGAS TAMBAHAN GURU DAN TENAGA KEPENDIDIKAN</p>
                        <p><b class='text-center'>PEMBAGIAN WALI KELAS</b></p>
                        <p><b class='text-center'>TAHUN PELAJARAN {{ $TepelsIn->tapel }} - {{ $TepelsIn->tapel + 1 }}</b> </p>
                    </div>
                </div>
               {{-- blade-formatter-enable --}}
                <table id='example1' width='100%' class='table table-bordered table-hover'>
                    <thead>
                        <tr class='table-primary text-center align-middle'>
                            <th>ID</th>
                            <th>Nama Guru</th>
                            <th>Kelas</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($DataKelass->where('tapel_id', $TapelSelected) as $DataKelas)
                            <tr class='text-center'>
                                <td class='text-center'>{{ $loop->iteration }}</td>
                                <td class='text-left'>{{ $DataKelas->Guru->nama_guru }}</td>
                                <td class='text-center'>{{ $DataKelas->kelas }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr class='table-primary text-center align-middle'>
                            <th>ID</th>
                            <th>Nama Guru</th>
                            <th>Kelas</th>
                        </tr>
                    </tfoot>
                </table>

            </div>
            <div class="page-break"></div>
            {{-- PEMBAGIAN PIKET HARIAN --}}
            <div class="container">
                @php
                    // $DataTapelHeader = $DataEkstras->where('tapel_id', $TapelSelected);
                @endphp
                <x-kop-surat-cetak />
                <div class="my-4">
                    <div class="text-center">
                        <p><b class='text-center'>TUGAS TAMBAHAN GURU DAN TENAGA KEPENDIDIKAN</p>
                        <p><b class='text-center'>PEMBAGIAN PIKET HARIAN</b></p>
                        <p><b class='text-center'>TAHUN PELAJARAN </b></p>
                    </div>
                </div>
                <table id='example1' width='100%' class='table table-bordered table-hover'>
                    <thead>
                        <tr class='table-primary text-center align-middle'>
                            <th>ID</th>
                            <th>Hari</th>
                            <th>Nama Guru</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($DataPikets->where('tapel_id', $TapelSelected)->groupBy('tapel_id') as $tapel_id => $piketsByTapel)
                            @foreach ($piketsByTapel->groupBy('hari') as $hari => $DataPiket)
                                <tr class='text-center'>
                                    <td class='text-center'>{{ $loop->iteration }}</td>
                                    <td class='text-center'>{{ $hari }}</td>
                                    <td class='text-left'>
                                        @foreach ($DataPiket as $data)
                                            {{ $data->guru->nama_guru ?? 'Tidak Ada Guru' }}<br>
                                        @endforeach
                                    </td>
                                </tr>
                            @endforeach
                        @endforeach

                    </tbody>
                    <tfoot>
                        <tr class='table-primary text-center align-middle'>
                            <th>ID</th>
                            <th>Hari</th>
                            <th>Nama Guru</th>
                        </tr>
                    </tfoot>
                </table>


            </div>
            <div class="page-break"></div>
        @endforeach
    </section>
</x-layout-view-pkks>

{{-- <script>
    window.onload = function() {
        window.print();
    };
</script> --}}
