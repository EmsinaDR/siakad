{{-- /Wakil Kepala --}}
{{-- <li class="nav-item menu-open">
    <a href="#" class="nav-link active">
        <i class="nav-icon fa fa-tools"></i>
        <p>Wakil Kepala</p>
    </a>
</li> --}}

{{-- Data Kurikulum --}}
@if ($namaProgram === 'Waka Kurikulum')
    <li class="nav-item">
        <a href="#" class="nav-link bg-success text-white">
            <i class="nav-icon fa fa-file-archive"></i>
            <p>
                Kurikulum
                <i class="fas fa-angle-left right"></i>
            </p>
        </a>
        <ul class="nav nav-treeview">
            {{-- E Kaldik Kurikulum --}}
            <li class="nav-item">
                <a href="#" class="nav-link text-white bg-primary">
                    <i class="fas fa-chalkboard-teacher nav-icon pl-2"></i>
                    <p>Learning</p>
                    <i class="fas fa-angle-left right"></i>
                </a>
                <ul class="nav nav-treeview p-2">
                    {{-- Jadwal Pelajaran Kurikulum --}}
                    <li class="nav-item">
                        <a href="{{ route('jadwal-pelajaran.index') }}" class="nav-link text-dark bg-light">
                            <i class="fas fa-calendar-alt nav-icon pl-2 text-info"></i>
                            <p>Jadwal Pelajaran</p>
                        </a>
                    </li>
                    {{-- KKM Kurikulum --}}
                    <li class="nav-item">
                        <a href="{{ route('data-kkm.index') }}" class="nav-link text-dark bg-light">
                            <i class="fas fa-balance-scale nav-icon pl-2 text-warning"></i>
                            <p>KKM</p>
                        </a>
                    </li>

                    {{-- Daftar Materi --}}
                    <li class="nav-item">
                        <a href="{{ route('materi-ajar.index') }}" class="nav-link text-dark bg-light">
                            <i class="fas fa-book-open nav-icon pl-2 text-success"></i>
                            <p>Daftar Materi</p>
                        </a>
                    </li>

                    {{-- Jurnal --}}
                    <li class="nav-item">
                        <a href="#" class="nav-link text-dark bg-light">
                            <i class="fas fa-book nav-icon pl-2 text-danger"></i>
                            <p>Jurnal</p>
                        </a>
                    </li>
                    <li class="nav-item pr-2">
                        <a href="#" class="nav-link text-warning">
                            <i class="nav-icon fas fa-graduation-cap pl-2"></i>
                            <p>Data Nilai</p>
                            <i class="fas fa-angle-left right"></i>
                        </a>
                        {{-- Data Nilai UH --}}
                        <ul class="nav nav-treeview p-2">
                            <li class="nav-item">
                                <a href="{{ route('data-nilai-uh.index') }}" class="nav-link text-dark bg-light">
                                    <i class="fas fa-chart-line nav-icon pl-2 text-primary"></i>
                                    <p>Data Nilai UH</p>
                                </a>
                            </li>

                            {{-- Data Nilai Tugas --}}
                            <li class="nav-item">
                                <a href="{{ route('data-nilai-tugas.index') }}" class="nav-link text-dark bg-light">
                                    <i class="fas fa-tasks nav-icon pl-2 text-purple"></i>
                                    <p>Data Nilai Tugas</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('data-nilai-pts-pas.index') }}" class="nav-link text-dark bg-light">
                                    <i class="fas fa-tasks nav-icon pl-2 text-purple"></i>
                                    <p>Data Nilai PTS + PAS</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="#" class="nav-link text-dark bg-light">
                                    <i class="fas fa-tasks nav-icon pl-2 text-purple"></i>
                                    <p>Data Raport</p>
                                </a>
                            </li>
                        </ul>
                    </li>

                </ul>
            </li>
            <li class="nav-item pr-2">
                <a href="#" class="nav-link text-white bg-purple">
                    <i class="nav-icon fas fa-clipboard-list pl-2"></i>
                    <p>Perangkat Test</p>
                    <i class="fas fa-angle-left right"></i>
                </a>
                <ul class="nav nav-treeview p-2">
                    <li class="nav-item">
                        <a href="{{ route('jadwal-test.index') }}" class="nav-link text-dark bg-light">
                            <i class="fas fa-calendar-alt nav-icon pl-2 text-success"></i>
                            <p>Jadwal Test</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('peserta-test.index') }}" class="nav-link text-dark bg-light">
                            <i class="fas fa-user-friends nav-icon pl-2 text-info"></i>
                            <p>Peserta Test</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('ruang-test.index') }}" class="nav-link text-dark bg-light">
                            <i class="fas fa-door-open nav-icon pl-2 text-warning"></i>
                            <p>Ruang Test</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('kartu-test.index') }}" class="nav-link text-dark bg-light">
                            <i class="fas fa-id-card nav-icon pl-2 text-danger"></i>
                            <p>Kartu Test</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('berita-acara.index') }}" class="nav-link text-dark bg-light">
                            <i class="fas fa-file-alt nav-icon pl-2 text-primary"></i>
                            <p>Berita Acara Test</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('daftar-hadir.index') }}" class="nav-link text-dark bg-light">
                            <i class="fas fa-clipboard-list nav-icon pl-2 text-purple"></i>

                            <p>Daftar Hadir Peserta</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('tempat-duduk.index') }}" class="nav-link text-dark bg-light">
                            <i class="fas fa-chair nav-icon pl-2 text-teal"></i>
                            <p>Tempat Duduk</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('nomor-meja.index') }}" class="nav-link text-dark bg-light">
                            <i class="fas fa-th-large nav-icon pl-2 text-indigo"></i>
                            <p>Nomor Meja</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('peraturan-test.index') }}" class="nav-link text-dark bg-light">
                            <i class="fas fa-gavel nav-icon pl-2 text-dark"></i>
                            <p>Peraturan Test</p>
                        </a>
                    </li>
                </ul>
            </li>


            {{-- php artisan make:view role.waka.kurikulum.Perangkat.berita-acara
                php artisan make:view role.waka.kurikulum.Perangkat.tempat-duduk
                php artisan make:view role.waka.kurikulum.Perangkat.daftar-hadir
                php artisan make:view role.waka.kurikulum.Perangkat.jadwal-test
                php artisan make:view role.waka.kurikulum.Perangkat.nomor-meja
                php artisan make:view role.waka.kurikulum.Perangkat.tata-tertib-test --}}


            {{-- Guru Piket Kurikulum --}}
            <li class="nav-item">
                <a href="#" class="nav-link text-white bg-danger">
                    <i class="fas fa-user-check nav-icon pl-2"></i>
                    <p>Guru Piket</p>
                    <i class="fas fa-angle-left right"></i>
                </a>
                <ul class="nav nav-treeview p-2">
                    <li class="nav-item">
                        <a href="{{ route('absensi.data-absensi-siswa.index') }}" class="nav-link text-dark bg-light">
                            <i class="fas fa-user-clock nav-icon pl-2 text-primary"></i>
                            <p>Absensi</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('jadwal-piket-guru.index') }}" class="nav-link text-dark bg-light">
                            <i class="fas fa-calendar-check nav-icon pl-2 text-success"></i>
                            <p>Jadwal Piket</p>
                        </a>
                    </li>
                    {{-- <li class="nav-item">
                    <a href="#" class="nav-link text-dark bg-light">
                        <i class="fas fa-clipboard-list nav-icon pl-2 text-warning"></i>
                        <p>Laporan Piket</p>
                    </a>
                </li> --}}
                    <li class="nav-item">
                        <a href="{{ route('tugas-piket-guru.index') }}" class="nav-link text-dark bg-light">
                            <i class="fas fa-clipboard-list nav-icon pl-2 text-warning"></i>
                            <p>Data Tugas Siswa</p>
                        </a>
                    </li>
                </ul>
            </li>
            {{-- Guru Piket Akhir Kurikulum --}}

            {{-- E Kaldik Kurikulum Akhir --}}

            <li class="nav-item">
                <a href="{{ route('ekaldik.index') }}" class="nav-link">
                    <i class="fa fa-calendar-alt nav-icon pl-2"></i>
                    <p>E Kaldik</p>

                </a>
            </li>
            {{-- E Kaldik Kurikulum Akhir --}}

            {{-- E Prestasi Kuriklum --}}
            <li class="nav-item">
                <a href="{{ route('prestasi.index') }}" class="nav-link">
                    <i class="fa fa-trophy nav-icon pl-2"></i>
                    <p>Daftar Prestasi</p>
                </a>
            </li>

            {{-- E Prestasi Kuriklum Akhir --}}
            {{-- Dispensasi Kurikulum --}}
            <li class="nav-item">
                <a href="#" class="nav-link mr-2">
                    <i class="fa fa-file nav-icon pl-2"></i>
                    <p>SK Dipersasi</p>
                </a>
            </li>

            {{-- Dispensasi Kurikulum Akhir --}}

            {{-- Data Kelulusan Kurikulum --}}
            <li class="nav-item">
                <a href="#" class="nav-link text-white bg-success">
                    <i class="nav-icon fas fa-user-graduate pl-2"></i>
                    <p>
                        Data Kelulusan
                        <i class="fas fa-angle-left right"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview p-2">
                    <li class="nav-item pr-2">
                        <a href="#" class="nav-link text-warning">
                            <i class="nav-icon fas fa-graduation-cap pl-2"></i>
                            <p>Data Ujian</p>
                            <i class="fas fa-angle-left right"></i>
                        </a>
                        {{-- Data Nilai UH --}}
                        <ul class="nav nav-treeview p-2">
                            <li class="nav-item">
                                <a href="{{ route('data-peserta-ujian.index') }}"
                                    class="nav-link text-dark bg-light">
                                    <i class="fas fa-tasks nav-icon pl-2 text-purple"></i>
                                    <p>Jadwal Ujian</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('data-peserta-ujian.index') }}"
                                    class="nav-link text-dark bg-light">
                                    <i class="fas fa-tasks nav-icon pl-2 text-purple"></i>
                                    <p>Peserta Ujian</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('data-nilai-ujian.index') }}" class="nav-link text-dark bg-light">
                                    <i class="fas fa-tasks nav-icon pl-2 text-purple"></i>
                                    <p>Data Ujian</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                    {{-- Pengumuman Kelulusan --}}
                    <li class="nav-item">
                        <a href="#" class="nav-link text-dark bg-light">
                            <i class="fas fa-bullhorn nav-icon pl-2 text-danger"></i>
                            <p>Pengumuman</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('peserta-kelulusan.index') }}" class="nav-link text-dark bg-light">
                            <i class="fas fa-bullhorn nav-icon pl-2 text-danger"></i>
                            <p>Peserta Kelulusan</p>
                        </a>
                    </li>

                    {{-- Surat Keterangan Lulus dan Keterangan Nilai --}}
                    <li class="nav-item">
                        <a href="{{ route('nilai-raport-kelulusan.index') }}" class="nav-link text-dark bg-light">
                            <i class="fas fa-file-alt nav-icon pl-2 text-primary"></i>
                            <p>Nilai Raport</p>
                        </a>
                    </li>
                    <li class="nav-item pr-2">
                        <a href="#" class="nav-link text-success">
                            <i class="nav-icon fas fa-graduation-cap pl-2"></i>
                            <p>Data Surat</p>
                            <i class="fas fa-angle-left right"></i>
                        </a>
                        {{-- Data Nilai UH --}}
                        <ul class="nav nav-treeview p-2">
                            <li class="nav-item">
                                <a href="{{ route('data-peserta-ujian.index') }}"
                                    class="nav-link text-dark bg-light">
                                    <i class="fas fa-tasks nav-icon pl-2 text-purple"></i>
                                    <p>SKN</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('data-nilai-ujian.index') }}" class="nav-link text-dark bg-light">
                                    <i class="fas fa-tasks nav-icon pl-2 text-purple"></i>
                                    <p>SKL</p>
                                </a>
                            </li>

                            <li class="nav-item">
                                <a href="#" class="nav-link text-dark bg-light">
                                    <i class="fas fa-file-signature nav-icon pl-2 text-warning"></i>
                                    <p>SK Bebas</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                    {{-- Surat Bebas Perpustakaan, Administrasi, dan Nilai --}}
                </ul>

            </li>
            {{-- Data Kelulusan Kurikulum  Akhir --}}
            {{-- Data Ijazah --}}

            <li class="nav-item">
                <a href="{{ route('e-ijazah.index') }}" class="nav-link text-dark bg-light">
                    <i class="fas fa-bullhorn nav-icon pl-2 text-danger"></i>
                    <p>E Ijazah</p>
                </a>
            </li>
            {{-- Data Ijazah Akhir --}}
            {{-- Program Kerja --}}

            <li class="nav-item">
                <a href="{{ route('e-ijazah.index') }}" class="nav-link text-dark bg-light">
                    <i class="fas fa-bullhorn nav-icon pl-2 text-danger"></i>
                    <p>E Ijazah x</p>
                </a>
            </li>
            {{-- Data Program Kerja --}}

        </ul>
    </li>
@elseif($namaProgram === 'Waka Kesiswaan')
    {{-- Data Kurikulum Akhir --}}
    {{-- Data Kesiswaan --}}
    <li class="nav-item">
        <a href="#" class="nav-link bg-primary text-white">
            <i class="nav-icon fas fa-user-graduate"></i>
            <p>
                Kesiswaan
                <i class="fas fa-angle-left right"></i>
            </p>
        </a>
        <ul class="nav nav-treeview">
            <li class="nav-item">
                <a href="#" class="nav-link text-info">
                    <i class="fas fa-globe-asia nav-icon pl-2"></i>
                    <p>Jadwal Pengiriman</p>
                </a>
            </li>

            <li class="nav-item">
                <a href="#" class="nav-link text-success">
                    <i class="fas fa-calendar-alt nav-icon pl-2"></i>
                    <p>E Kesiswaan</p>
                </a>
            </li>

            <li class="nav-item">
                <a href="#" class="nav-link text-warning">
                    <i class="nav-icon fas fa-graduation-cap pl-2"></i>
                    <p>
                        Data Alumni
                        <i class="fas fa-angle-left right"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview pl-2">
                    <li class="nav-item">
                        <a href="#" class="nav-link text-danger">
                            <i class="fas fa-bullhorn nav-icon pl-2"></i>
                            <p>Pengumuman</p>
                        </a>
                    </li>
                </ul>
            </li>

            <li class="nav-item">
                <a href="#" class="nav-link text-primary">
                    <i class="nav-icon fas fa-folder-open pl-2"></i>
                    <p>
                        Data PPDB
                        <i class="fas fa-angle-left right pl-2"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview pl-2">
                    <li class="nav-item">
                        <a href="{{ route('data-peserta-ppdb.index') }}" class="nav-link text-success">
                            <i class="fas fa-file-alt nav-icon pl-2"></i>
                            <p>Formulir Pendaftaran</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link text-warning">
                            <i class="fas fa-users nav-icon pl-2"></i>
                            <p>Data Calon Siswa</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('riwayat-ppdb.index') }}" class="nav-link text-warning">
                            <i class="fas fa-users nav-icon pl-2"></i>
                            <p>Data Riwayat PPDB</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('pengumuman-ppdb.index') }}" class="nav-link text-danger">
                            <i class="fas fa-bullhorn nav-icon pl-2"></i>
                            <p>Pengumuman PPDB</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link text-info">
                            <i class="far fa-folder-open nav-icon pl-2"></i>
                            <p>Data PPDB</p>
                        </a>
                    </li>
                </ul>
                <x-menu-buku-tamu></x-menu-buku-tamu>
            </li>

            <li class="nav-item">
                <a href="#" class="nav-link bg-danger text-white">
                    <i class="nav-icon fas fa-trophy pl-2"></i>
                    <p>
                        Ekstrakurikuler
                        <i class="fas fa-angle-left right"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview">
                    <li class="nav-item pl-2">
                        <a href="{{ route('ekstrakurikuler.index') }}" class="nav-link text-info">
                            <i class="fas fa-calendar-alt nav-icon pl-2"></i>
                            <p>Data Ekstra</p>
                        </a>
                        <a href="{{ route('peserta-ekstrakurikuler.index') }}" class="nav-link text-warning">
                            <i class="fas fa-user-friends nav-icon pl-2"></i>
                            <p>Peserta Ekstra</p>
                        </a>
                        <a href="{{ route('nilai-ekstrakurikuler.index') }}" class="nav-link text-success">
                            <i class="fas fa-chart-line nav-icon pl-2"></i>
                            <p>Nilai Ekstra</p>
                        </a>
                        <a href="{{ route('daftar-hadir-ekstrakurikuler.index') }}" class="nav-link text-danger">
                            <i class="fas fa-list-alt nav-icon pl-2"></i>
                            <p>Daftar Hadir Ekstra</p>
                        </a>
                    </li>
                </ul>
            </li>
        </ul>
    </li>

    {{-- Data Kesiswaan Akhir --}}
@elseif($namaProgram === 'Waka Sarpras')
    {{-- Data Sarpras --}}
    <li class="nav-item">
        <a href="#" class="nav-link bg-cornflowerblue text-white">
            <i class="nav-icon fas fa-warehouse"></i>
            <p>
                Sarpras
                <i class="fas fa-angle-left right"></i>
            </p>
        </a>
        <ul class="nav nav-treeview">
            {{-- Data Barang Sarpras --}}
            <li class="nav-item">
                <a href="{{ route('dashboard-sarpras.index') }}" class="nav-link">
                    <i class="fas fa-tachometer-alt nav-icon pl-2"></i> <!-- Ikon kotak untuk barang -->
                    <p>Dasboard</p>
                </a>
            </li>
            {{-- Data Inventaris Sarpras --}}
            {{-- E Sarpras Kurikulum --}}
            <li class="nav-item">
                <a href="#" class="nav-link">
                    <i class="fas fa-calendar-check nav-icon pl-2"></i> <!-- Ikon kalender lebih relevan -->
                    <p>Data Anggaran</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="#" class="nav-link">
                    <i class="fas fa-clipboard-list nav-icon text-primary pl-2"></i>
                    <!-- Ikon daftar untuk inventaris -->
                    <p>Data Inventaris</p>
                    <i class="fas fa-angle-left right"></i>
                </a>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="{{ route('inventaris-sarpras.index') }}" class="nav-link">
                            <i class="fas fa-box-open nav-icon text-warning pl-2"></i> <!-- Ikon inventaris barang -->
                            <p>Data Barang</p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="fas fa-clipboard-list nav-icon text-info pl-2"></i> <!-- Ikon daftar dokumen -->
                            <p>Inventaris KIB</p>
                            <i class="fas fa-angle-left right"></i>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('inventaris-kiba.index') }}" class="nav-link">
                                    <i class="fas fa-globe nav-icon text-success pl-4"></i> <!-- Ikon tanah -->
                                    <p class='pl-3'>KIB A</p>
                                </a>
                                <a href="{{ route('inventaris-kibb.index') }}" class="nav-link">
                                    <i class="fas fa-cogs nav-icon text-danger pl-4"></i>
                                    <!-- Ikon peralatan & mesin -->
                                    <p class='pl-3'>KIB B</p>
                                </a>
                                <a href="{{ route('inventaris-kibc.index') }}" class="nav-link">
                                    <i class="fas fa-building nav-icon text-primary pl-4"></i>
                                    <!-- Ikon bangunan & gedung -->
                                    <p class='pl-3'>KIB C</p>
                                </a>
                                <a href="{{ route('inventaris-kibd.index') }}" class="nav-link">
                                    <i class="fas fa-road nav-icon text-warning pl-4"></i>
                                    <!-- Ikon jalan, irigasi & jaringan -->
                                    <p class='pl-3'>KIB D</p>
                                </a>
                                <a href="{{ route('inventaris-kibe.index') }}" class="nav-link">
                                    <i class="fas fa-cube nav-icon text-info pl-4"></i>
                                    <!-- Ikon aset tetap lainnya -->
                                    <p class='pl-3'>KIB E</p>
                                </a>
                                <a href="{{ route('inventaris-kibf.index') }}" class="nav-link">
                                    <i class="fas fa-hard-hat nav-icon text-secondary pl-4"></i>
                                    <!-- Ikon konstruksi dalam pengerjaan -->
                                    <p class='pl-3'>KIB F</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('inventaris-vendor.index') }}" class="nav-link">
                            <i class="fas fa-file-alt nav-icon text-secondary pl-2"></i> <!-- Ikon dokumen -->
                            <p>Data Vendor</p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="fas fa-door-open nav-icon text-success pl-2"></i>
                            <!-- Ikon pintu terbuka untuk ruangan -->
                            <p>Pengaturan</p>
                            <i class="fas fa-angle-left right"></i>
                        </a>
                        <ul class="nav nav-treeview">

                            <li class="nav-item">
                                <a href="{{ route('inventaris-in-ruangan.index') }}" class="nav-link">
                                    <i class="fas fa-file-signature nav-icon text-warning pl-2"></i>
                                    <!-- Ikon tanda tangan untuk pengajuan -->
                                    <p>Inventaris In</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('pengajuan-inventaris-sarpras.index') }}" class="nav-link">
                                    <i class="fas fa-file-signature nav-icon text-warning pl-2"></i>
                                    <!-- Ikon tanda tangan untuk pengajuan -->
                                    <p>Pengajuan Inventaris</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </li>


        </ul>
    </li>

    {{-- Data Sarpras Akhir --}}
@elseif($namaProgram === 'Waka Humas')
    <li class="nav-item">
        <a href="#" class="nav-link bg-chocolate text-white">
            <i class="nav-icon fas fa-user-cog"></i>
            <p>
                Humas
                <i class="fas fa-angle-left right"></i>
            </p>
        </a>
        <ul class="nav nav-treeview">
            <li class="nav-item">
                <a href="#" class="nav-link">
                    <i class="fa fa-clipboard-list nav-icon pl-2"></i>

                    <p>Jadwal Pengiriman</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="#" class="nav-link">
                    <i class="fa fa-bullhorn nav-icon pl-2"></i>

                    <p>Bulk Sender</p>
                </a>
            </li>

        </ul>
    </li>
    {{-- /Wakil Kepala --}}
    {{-- <li class="nav-item">
        <a href="#" class="nav-link  bg-cornflowerblue">
            <i class="nav-icon fa fa-tools"></i>
            <p>Tools</p>
                <i class="fas fa-angle-left right"></i>
        </a>
        <ul class="nav nav-treeview">
            <li class="nav-item">
                <a href="#" class="nav-link">
                    <i class="nav-icon fa fa-bullhorn"></i>
                    <p>
                        Whatsapp Sender
                        <i class="fas fa-angle-left right"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="fas fa-globe-asia nav-icon"></i>
                            <p>Jadwal Pengiriman</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="fas fa-globe-asia nav-icon"></i>
                            <p>Bulk Sender</p>
                        </a>
                    </li>

                </ul>
            </li>
        </ul>
    </li> --}}
@else
@endif
{{-- <li class="nav-item menu-open">
    <a href="#" class="nav-link active">
        <i class="nav-icon fas fa-cogs"></i>
        <p>Setting</p>
    </a>
</li>

<li class="nav-item">
    <a href="#" class="nav-link">
        <i class="nav-icon fas fa-table"></i>
        <p>
            Data
            <i class="fas fa-angle-left right"></i>
        </p>
    </a>
    <ul class="nav nav-treeview">
        <li class="nav-item">
            <a href="#" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Data 1</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="#" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Data 2</p>
            </a>
        </li>
    </ul>
</li> --}}
{{-- php artisan make:controller WakaSarpras/nameController -m WakaSarpras/name --}}


{{-- php artisan make:controller WakaSarpras/Inventaris/inventarisKIBAController -m WakaSarpras/Inventaris/inventarisKIBA
php artisan make:controller WakaSarpras/Inventaris/inventarisKIBBController -m WakaSarpras/Inventaris/inventarisKIBB
php artisan make:controller WakaSarpras/Inventaris/inventarisKIBCController -m WakaSarpras/Inventaris/inventarisKIBC
php artisan make:controller WakaSarpras/Inventaris/inventarisKIBDController -m WakaSarpras/Inventaris/inventarisKIBD
php artisan make:controller WakaSarpras/Inventaris/inventarisKIBEController -m WakaSarpras/Inventaris/inventarisKIBE
php artisan make:controller WakaSarpras/Inventaris/inventarisKIBFController -m WakaSarpras/Inventaris/inventarisKIBF --}}
