<li class="nav-item">
    <a href="#" class="nav-link">
        <i class="nav-icon fa fa-folder"></i>
        <p>
            Program Tahfidz
            <i class="fas fa-angle-left right"></i>
        </p>
    </a>
    <ul class="nav nav-treeview ml-2">
        <li class="nav-item">
            <a href="{{ route('surat-keputusan.index') }}" class="nav-link">
                <i class="fa fa-qrcode nav-icon ml-2 text-info"></i>
                <p class=''> Data SK </p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('peserta-tahfidz.index') }}" class="nav-link">
                <i class="fa fa-qrcode nav-icon ml-2 text-info"></i>
                <p class=''> Peserta Tahfidz </p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('riwayat-hafalan.index') }}" class="nav-link">
                <i class="fa fa-qrcode nav-icon ml-2 text-info"></i>
                <p class=''> Riwayat Hafalan </p>
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
