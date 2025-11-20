{{-- <li class="nav-item menu-open">
    <a href="#" class="nav-link active">
        <i class="nav-icon fa fa-university"></i>
        <p>Data Keuangan</p>
    </a>
</li>
<li class="nav-item">
    <a href="{{ route('komite.index') }}" class="nav-link">
        <i class="fa fa-tachometer-alt nav-icon text-primary"></i>
        <p class=''> Dasboard </p>
    </a>
</li>
<li class="nav-item">
    <a href="#" class="nav-link">
        <i class="fa fa-users nav-icon text-info"></i>
        <p class=''> Data Siswa </p>
    </a>
</li> --}}
<li class="nav-item">
    <a href="#" class="nav-link">
        <i class="nav-icon fa fa-money-bill-wave"></i>
        <p>
            Bendahara Komite
            <i class="fas fa-angle-left right"></i>
        </p>
    </a>
    <ul class="nav nav-treeview">
        <li class="nav-item">
            <a href="{{ route('dasboard-komite.index') }}" class="nav-link">
                <i class="fa fa-edit nav-icon ml-2 text-info"></i>
                <p class=''> Dashboard </p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('InputKomite') }}" class="nav-link">
                <i class="fa fa-edit nav-icon ml-2 text-info"></i>
                <p class=''> Pemasukan </p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('pengeluaran-komite.index') }}" class="nav-link">
                <i class="fas fa-coins nav-icon ml-2 text-info"></i>
                <p class=''> Pengeluaran </p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('TunggakanSiswa') }}" class="nav-link">
                <i class="fa fa-edit nav-icon ml-2 text-info"></i>
                <p class=''> Tunggakan</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="#" class="nav-link">
                <i class="fa fa-chart-line nav-icon ml-2 text-info"></i>
                <p class=''> Grafik</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('dokumen-komite.index') }}" class="nav-link">
                <i class="fa fa-file nav-icon ml-2 text-info"></i>
                <p class=''> Dokumen </p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('buku-kas-komite.index') }}" class="nav-link">
                <i class="fa fa-qrcode nav-icon ml-2 text-info"></i>
                <p class=''> Buku Kas</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('buku-kas-umum.index') }}" class="nav-link">
                <i class="fa fa-qrcode nav-icon ml-2 text-info"></i>
                <p class=''> Buku Umum</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('PengaturanKomite') }}" class="nav-link">
                <i class="fa fa-cogs nav-icon ml-2 text-info"></i>
                <p class=''> Pengaturan</p>
            </a>
        </li>
    </ul>
</li>
