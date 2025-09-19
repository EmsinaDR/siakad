{{-- <li class="nav-item">
    <a href="{{ route('bendahara.tabungan.index') }}" class="nav-link">
        <i class="fa fa-tachometer-alt nav-icon text-primary"></i>
        <p class=''> Dasboard </p>
    </a>
</li> --}}
<li class="nav-item">
    <a href="#" class="nav-link">
        <i class="nav-icon fa fa-money-bill-wave"></i>
        <p>
            Bendahara Tabungan
            <i class="fas fa-angle-left right"></i>
        </p>
    </a>
    <ul class="nav nav-treeview">
        <li class="nav-item">
            <a href="{{ route('DataTabungan') }}" class="nav-link">
                <i class="fa fa-users nav-icon ml-2 text-info"></i>
                <p class=''> Data Tabungan </p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('TabunganSiswa') }}" class="nav-link">
                <i class="fa fa-edit nav-icon ml-2 text-info"></i>
                <p class=''> Input Data </p>
            </a>
        </li>
        {{-- <li class="nav-item">
            <a href="#" class="nav-link">
                <i class="fa fa-chart-line nav-icon ml-2 text-info"></i>
                <p class=''> Grafik</p>
            </a>
        </li> --}}
        <li class="nav-item">
            <a href="{{ route('LaporanTabungan') }}" class="nav-link">
                <i class="fa fa-qrcode nav-icon ml-2 text-info"></i>
                <p class=''> Laporan</p>
            </a>
        </li>
        {{-- <li class="nav-item">
            <a href="{{ route('PengaturanKomite') }}" class="nav-link">
                <i class="fa fa-cogs nav-icon ml-2 text-info"></i>
                <p class=''> Pengaturan</p>
            </a>
        </li> --}}
        {{-- <li class="nav-item">
            <a href="#" class="nav-link">
                <i class="fa fa-file nav-icon ml-2 text-info"></i>
                <p class=''> Tugas Guru </p>
            </a>
        </li> --}}
    </ul>
</li>
