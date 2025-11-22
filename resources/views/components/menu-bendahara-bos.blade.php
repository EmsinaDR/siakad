{{--
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
            Bendahara BOS
            <i class="fas fa-angle-left right"></i>
        </p>
    </a>
    <ul class="nav nav-treeview">
        <li class="nav-item">
            <a href="#" class="nav-link">
                <i class="fa fa-users nav-icon text-info"></i>
                <p class=''> Dasboard </p>
            </a>
        </li>
        {{-- <li class="nav-item">
            <a href="#" class="nav-link">
                <i class="fa fa-tags nav-icon ml-2 text-info"></i>
                <p class=''> List Dana Bos </p>
            </a>
        </li> --}}
        <li class="nav-item">
            <a href="#" class="nav-link">
                <i class="fa fa-chart-line nav-icon ml-2 text-info"></i>
                <p class=''> List Dana</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{route('pemasukkan-bos.index')}}" class="nav-link">
                <i class="fa fa-credit-card nav-icon ml-2 text-info"></i>
                <p class=''> Pemasukkan </p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{route('pengeluaran-bos.index')}}" class="nav-link">
                <i class="fa fa-hand-holding-usd nav-icon ml-2 text-info"></i>
                <p class=''> Pengeluaran </p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{route('buku-kas-bos.index')}}" class="nav-link">
                <i class="fa fa-hand-holding-usd nav-icon ml-2 text-info"></i>
                <p class=''> Buku Kas BOS </p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('buku-kas-umum.index') }}" class="nav-link">
                <i class="fa fa-qrcode nav-icon ml-2 text-info"></i>
                <p class=''> Buku Kas Umum</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="#" class="nav-link">
                <i class="fa fa-qrcode nav-icon ml-2 text-info"></i>
                <p class=''> Laporan Pembayaran </p>
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
