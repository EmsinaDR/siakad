<li class="nav-item">
    <a href="#" class="nav-link">
        <i class="nav-icon fa fa-money-bill-wave"></i>
        <p>
            Bendahara Study Tour
            <i class="fas fa-angle-left right"></i>
        </p>
    </a>
    <ul class="nav nav-treeview">
        <li class="nav-item">
            <a href="{{ route('DataStudyTour') }}" class="nav-link">
                <i class="fa fa-users nav-icon text-info"></i>
                <p class=''> Data Study Tour </p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('InputStudyTour') }}" class="nav-link">
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
        <li class="nav-item">
            <a href="{{ route('SettingStudyTour') }}" class="nav-link">
                <i class="fa fa-cogs nav-icon ml-2 text-info"></i>
                <p class=''> Pengaturan</p>
            </a>
        </li>
        {{-- <li class="nav-item">
            <a href="#" class="nav-link">
                <i class="fa fa-file nav-icon ml-2 text-info"></i>
                <p class=''> Tugas Guru </p>
            </a>
        </li> --}}
    </ul>
</li>
