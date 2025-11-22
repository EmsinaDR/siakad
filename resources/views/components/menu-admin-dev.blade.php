<li class="nav-item menu-open">
    <a href="#" class="nav-link active">
        <i class="nav-icon fa fa-edit"></i>
        <p>Data AdminDev</p>
    </a>
</li>
<li class="nav-item">
    <a href="{{ route('identitas.index') }}" class="nav-link">
        <i class="nav-icon fa fa-school"></i>
        <p>
            Profile Sekolah
        </p>
    </a>
</li>
{{-- Data Pengaturan --}}
<li class="nav-item">
    <a href="#" class="nav-link">
        {{-- <i class="nav-icon fa fa-users"></i> --}}
        <p>
            📝 Data Registrasi
            <i class="fas fa-angle-left right"></i>
        </p>
    </a>
    <ul class="nav nav-treeview pl-2">
        <li class="nav-item">
            <a href="{{ route('tokenapp.index') }}" class="nav-link">
                <p>🏅 Update Token</p>
            </a>
        </li>
    </ul>
</li>
<li class="nav-item">
    <a href="#" class="nav-link">
        {{-- <i class="nav-icon fa fa-users"></i> --}}
        <p>
            📝 Dokumen
            <i class="fas fa-angle-left right"></i>
        </p>
    </a>
    <ul class="nav nav-treeview pl-2">
        <li class="nav-item">
            <a href="{{ route('data.kartu') }}" class="nav-link">
                <p>🏅 Data Kartu</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('tokenapp.index') }}" class="nav-link">
                <p>🏅 Sosialisasi Vendor</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('tokenapp.index') }}" class="nav-link">
                <p>🏅 Buku Pegangan</p>
            </a>
        </li>
    </ul>
</li>
<li class="nav-item">
    <a href="#" class="nav-link">
        {{-- <i class="nav-icon fa fa-users"></i> --}}
        <p>
            📝 Control
            <i class="fas fa-angle-left right"></i>
        </p>
    </a>
    <ul class="nav nav-treeview pl-2">
        <li class="nav-item">
            <a href="{{ route('control-program.index') }}" class="nav-link">
                <p>🏅 Program</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('modul-app.index') }}" class="nav-link">
                <p>🏅 Modul</p>
            </a>
        </li>
        {{-- <li class="nav-item">
            <a href="{{ route('tokenapp.index') }}" class="nav-link">
                <p>🏅 Buku Pegangan</p>
            </a>
        </li> --}}
    </ul>
</li>
