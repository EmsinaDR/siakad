@php
    //Dasboard Waka Sarprass
    use Illuminate\Support\Carbon;
    \Carbon\Carbon::setLocale('id');
    $activecrud = collect([2, 4, 6, 8])->search(Auth::user()->id);
    $urlroot = app('request')->root();
@endphp
<x-layout>
    <style>
        textarea {
            resize: none,
        }
    </style>
    <x-slot:title>{{ $title }}</x-slot:title>
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
            <div class='container-fluid'>
                <div class='row'>
                    <div class='col'>
                        <!-- Papan Informasi  -->
                        <div class='row mx-2'>
                            <div class='col-lg-4 col-6'>
                                <!-- small box / Data BOX-->
                                <div class='small-box bg-warning'><!-- Background -->
                                    <h3 class='m-2'>Data Sarpras</h3><!-- Judul -->
                                    <div class='inner'><!-- Isi Kontent -->
                                        <div class='d-flex justify-content-between'>
                                            <span>Total KIB A</span><span>{{ $KategoriTanah->count() }} Item</span>
                                        </div>
                                        <div class='d-flex justify-content-between'>
                                            <span>Total KIB B</span><span>{{ $TotalRuangan->count() }} Item</span>
                                        </div>
                                        <div class='d-flex justify-content-between'>
                                            <span>Total Vendor</span><span>{{ $TotalVendor->count() }} Vendor</span>
                                        </div>
                                    </div>
                                    <div class='icon'>
                                        <i class='fa fa-wallet'></i><!-- Icon -->
                                    </div>
                                    <a href='#' class='small-box-footer'>More info <i
                                            class='fas fa-arrow-circle-right'></i></a>
                                </div>
                                <!-- small box -->
                            </div>
                            <!-- ./col -->
                            <div class='col-lg-4 col-6'>
                                <!-- small box / Data BOX-->
                                <div class='small-box bg-info'><!-- Background -->
                                    <h3 class='m-2'>Data Kelas</h3><!-- Judul -->
                                    <div class='inner'><!-- Isi Kontent -->
                                        <div class='d-flex justify-content-between'>
                                            <span>Kelas
                                                VII</span><span>{{ $TotalKelas->where('tingkat_id', 7)->count() }}
                                                Kelas</span>
                                        </div>
                                        <div class='d-flex justify-content-between'>
                                            <span>Kelas
                                                VIII</span><span>{{ $TotalKelas->where('tingkat_id', 8)->count() }}
                                                Kelas</span>
                                        </div>
                                        <div class='d-flex justify-content-between'>
                                            <span>Kelas
                                                IX</span><span>{{ $TotalKelas->where('tingkat_id', 7)->count() }}
                                                Kelas</span>
                                        </div>
                                    </div>
                                    <div class='icon'>
                                        <i class='fa fa-school'></i><!-- Icon -->
                                    </div>
                                    <a href='#' class='small-box-footer'>More info <i
                                            class='fas fa-arrow-circle-right'></i></a>
                                </div>
                                <!-- small box -->
                            </div>
                            <!-- ./col -->
                            <div class='col-lg-4 col-6'>
                                <!-- small box / Data BOX-->
                                <div class='small-box bg-success'><!-- Background -->
                                    <h3 class='m-2'>Data User</h3><!-- Judul -->
                                    <div class='inner'><!-- Isi Kontent -->
                                        <div class='d-flex justify-content-between'>
                                            <span>Jumlah
                                                Guru</span><span>{{ $TotalUser->where('posisi', 'Guru')->count() }}</span>
                                        </div>
                                        <div class='d-flex justify-content-between'>
                                            <span>Jumlah
                                                Kaywawan</span><span>{{ $TotalUser->where('posisi', 'Karyawan')->count() }}</span>
                                        </div>
                                        <div class='d-flex justify-content-between'>
                                            <span>Jumlah
                                                Siswa</span><span>{{ $TotalUser->where('posisi', 'Siswa')->count() }}</span>
                                        </div>
                                    </div>
                                    <div class='icon'>
                                        <i class='fa fa-user'></i><!-- Icon -->
                                    </div>
                                    <a href='#' class='small-box-footer'>More info <i
                                            class='fas fa-arrow-circle-right'></i></a>
                                </div>
                                <!-- small box -->
                            </div>
                            <!-- ./col -->
                        </div>
                        <!-- Papan Informasi  -->
                        {{-- <x-footer></x-footer> --}}


                    </div>
                </div>
            </div>
            {{-- Papan Informasi --}}

            <!--Car Header-->
            <div class='card-header bg-primary mx-2'>
                <h3 class='card-title'>{{ $title }}</H3>
            </div>
            <!--Car Header-->


            <div class='ml-2 my-4'>
                Dasboard Waka Sarprass
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-xl-12">
                                <h2 class="mb-4">Dokumen Wakil Kepala Sekolah Sarpras</h2>
                                <h3>1. Dokumen Perencanaan dan Pengadaan</h3>
                                <ul>
                                    <li>Rencana Kebutuhan Sarana dan Prasarana Sekolah</li>
                                    <li>Proposal Pengadaan Sarana dan Prasarana</li>
                                    <li>Daftar Prioritas Pengadaan Barang/Jasa</li>
                                    <li>Dokumen Anggaran Sarpras (RAPBS/RKAS)</li>
                                    <li>Kontrak atau MoU dengan Pihak Ketiga (jika ada)</li>
                                </ul>

                                <h3>2. Dokumen Inventarisasi</h3>
                                <ul>
                                    <li>Buku Inventaris Barang</li>
                                    <li>Kartu Inventaris Barang (KIB)</li>
                                    <li>Daftar Aset Tetap Sekolah</li>
                                    <li>Labelisasi Barang dan Aset</li>
                                    <li>Berita Acara Penerimaan Barang</li>
                                </ul>

                                <h3>3. Dokumen Pemeliharaan dan Perbaikan</h3>
                                <ul>
                                    <li>Jadwal Pemeliharaan Sarana dan Prasarana</li>
                                    <li>Laporan Perawatan Rutin</li>
                                    <li>Formulir Permohonan Perbaikan</li>
                                    <li>Laporan Kerusakan Barang dan Sarana</li>
                                    <li>Berita Acara Perbaikan atau Penghapusan Barang</li>
                                </ul>

                                <h3>4. Dokumen Penghapusan dan Mutasi Barang</h3>
                                <ul>
                                    <li>Daftar Barang Rusak atau Tidak Layak Pakai</li>
                                    <li>Surat Permohonan Penghapusan Aset</li>
                                    <li>Berita Acara Penghapusan Barang</li>
                                    <li>Dokumen Mutasi Aset (jika ada pemindahan antar unit/sekolah)</li>
                                </ul>

                                <h3>5. Dokumen Penggunaan dan Monitoring</h3>
                                <ul>
                                    <li>Jadwal Penggunaan Sarana dan Prasarana</li>
                                    <li>Laporan Pemanfaatan Fasilitas Sekolah</li>
                                    <li>Formulir Peminjaman Barang/Fasilitas</li>
                                    <li>Laporan Inspeksi Sarpras</li>
                                </ul>

                                <h3>6. Dokumen Terkait Keamanan dan Keselamatan</h3>
                                <ul>
                                    <li>Laporan Keamanan Sarana dan Prasarana</li>
                                    <li>Dokumen Standar Operasional Prosedur (SOP) Keamanan</li>
                                    <li>Data Sistem Keamanan Sekolah (CCTV, Alat Pemadam, dll.)</li>
                                    <li>Evaluasi Keselamatan Bangunan dan Fasilitas</li>
                                </ul>


                                <p>Dokumen ini penting untuk memastikan pengelolaan sarana dan prasarana sekolah
                                    berjalan dengan
                                    baik,
                                    tertib, dan sesuai regulasi.</p>
                            </div>
                        </div>

                    </div>
                </div>

            </div>


        </div>

    </section>
</x-layout>
