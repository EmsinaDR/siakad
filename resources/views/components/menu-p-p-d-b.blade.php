{{-- <li class="nav-item menu-open">
    <a href="#" class="nav-link active">
        <i class="nav-icon fa fa-university"></i>
        <p>Data Keuangan</p>
    </a>
</li>

<li class="nav-item">
    <a href="#" class="nav-link">
        <i class="fa fa-users nav-icon text-info"></i>
        <p class=''> Data Siswa </p>
    </a>
</li> --}}
<li class="nav-item menu-open">
    <a href="#" class="nav-link active">
        <i class="nav-icon fas fa-user-cog"></i>
        Data PPDB
    </a>
</li>

<li class="nav-item">
    <a href="#" class="nav-link">
        <i class="nav-icon fas fa-users-cog text-warning"></i>
        <p>
            PPDB
            <i class="fas fa-angle-left right"></i>
        </p>
    </a>
    <ul class="nav nav-treeview">
        <li class="nav-item">
            <a href="{{route('peserta-ppdb.index')}}" class="nav-link">
                <i class="fas fa-user-check nav-icon ml-2 text-primary"></i>
                <p> Data Pendaftar </p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{route('piket-ppdb.index')}}" class="nav-link">
                <i class="fas fa-user-check nav-icon ml-2 text-primary"></i>
                <p> Jadwal Piket PPDB </p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{route('riwayat-ppdb.index')}}" class="nav-link">
                <i class="fas fa-history nav-icon ml-2 text-success"></i>
                <p> Riwayat Pendaftar </p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{route('pengumuman-ppdb.index')}}" class="nav-link">
                <i class="fas fa-bullhorn nav-icon ml-2 text-danger"></i>
                <p> Pengumuman </p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{route('pembayaran-ppdb.index')}}" class="nav-link">
                <i class="fas fa-credit-card nav-icon ml-2 text-info"></i>
                <p> Pembayaran </p>
            </a>
        </li>
        {{-- <li class="nav-item">
            <a href="#" class="nav-link">
                <i class="fas fa-file-alt nav-icon ml-2 text-secondary"></i>
                <p> Laporan </p>
            </a>
        </li> --}}
        <li class="nav-item">
            <a href="{{route('pengaturan-ppdb.index')}}" class="nav-link">
                <i class="fas fa-cogs nav-icon ml-2 text-warning"></i>
                <p> Pengaturan </p>
            </a>
        </li>
    </ul>
</li>

{{--


php artisan make:controller WakaKesiswaan/PPDB/DataPendaftarPPDBController -m WakaKesiswaan/PPDB/DataPendaftarPPDB
php artisan make:controller WakaKesiswaan/PPDB/RiwayatPendaftaranPPDBController -m WakaKesiswaan/PPDB/RiwayatPendaftaranPPDB
php artisan make:controller WakaKesiswaan/PPDB/PengumumanPPDBController -m WakaKesiswaan/PPDB/PengumumanPPDB
php artisan make:controller WakaKesiswaan/PPDB/PembayaranPPDBController -m WakaKesiswaan/PPDB/PembayaranPPDB
php artisan make:controller WakaKesiswaan/PPDB/StatistikPPDBController -m WakaKesiswaan/PPDB/StatistikPPDB
php artisan make:controller WakaKesiswaan/PPDB/PanduanPPDBController -m WakaKesiswaan/PPDB/PanduanPPDB
php artisan make:controller WakaKesiswaan/PPDB/JadwalPPDBController -m WakaKesiswaan/PPDB/JadwalPPDB
php artisan make:controller WakaKesiswaan/PPDB/KepanitianPPDBController -m WakaKesiswaan/PPDB/KepanitianPPDB
php artisan make:controller WakaKesiswaan/PPDB/FormulirPPDBController -m WakaKesiswaan/PPDB/FormulirPPDB


php artisan make:view role.ppdb.formulir-ppdb
php artisan make:view role.ppdb.riwayat-ppdb
php artisan make:view role.ppdb.pengumuman-ppdb
php artisan make:view role.ppdb.pembayaran-ppdb
php artisan make:view role.ppdb.statistik-ppdb
php artisan make:view role.ppdb.panduan-ppdb
php artisan make:view role.ppdb.jadwal-ppdb
php artisan make:view role.ppdb.kepanitian-ppdb
php artisan make:view role.ppdb.formulir-ppdb


--}}