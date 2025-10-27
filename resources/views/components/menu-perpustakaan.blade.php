<li class="nav-item">
    <a href="#" class="nav-link">
        <i class="nav-icon fa fa-book"></i>
        <p>
            Perpustakaan
            <i class="fas fa-angle-left right"></i>
        </p>
    </a>
    <ul class="nav nav-treeview">
        <li class="nav-item">
            <a href="{{ route('katalog-buku.index') }}" class="nav-link">
                <i class="fa fa-qrcode nav-icon ml-2 text-info"></i>
                <p>Katalog Buku</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{route('katalog-ebook.index')}}" class="nav-link">
                <i class="fa fa-tablet-alt nav-icon ml-2 text-info"></i>
                <p>Katalog E-Book</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('kartu-buku.index') }}" class="nav-link">
                <i class="fa fa-address-book nav-icon ml-2 text-info"></i>
                <p>Kartu Buku</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('KartuPeminjaman') }}" class="nav-link">
                <i class="fa fa-book-reader nav-icon ml-2 text-info"></i>
                <p>Kartu Peminjaman</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('peminjaman-buku.index') }}" class="nav-link">
                <i class="fa fa-exchange-alt nav-icon ml-2 text-info"></i>
                <p>Data Peminjaman</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="#" class="nav-link">
                <i class="fa fa-archive nav-icon ml-2 text-info"></i>
                <p>Inventaris Perpustakaan</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('peraturan.index') }}" class="nav-link">
                <i class="fa fa-gavel nav-icon ml-2 text-info"></i>
                <p>Peraturan Pengunjung</p>
            </a>
        </li>
        {{-- <li class="nav-item">
            <a href="#" class="nav-link">
                <i class="fa fa-id-card nav-icon ml-2 text-info"></i>
                <p>Kartu Anggota</p>
            </a>
        </li> --}}
        <li class="nav-item">
            <a href="#" class="nav-link">
                <i class="fa fa-cogs nav-icon ml-2 text-info"></i>
                <p>Pengaturan</p>
            </a>
        </li>
    </ul>
</li>
