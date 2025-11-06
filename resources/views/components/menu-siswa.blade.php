{{-- Role Admin --}}
<li class="nav-item menu-open">
    <a href="#" class="nav-link active">
        <i class="nav-icon fas fa-user-shield"></i>
        <p>Dasboard Siswa</p>
    </a>
</li>
<li class="nav-item">

    <a href="#" class="nav-link">
        <i class="nav-icon fas fa-users-cog text-warning"></i>
        <p>
            Data
            <i class="fas fa-angle-left right"></i>
        </p>
    </a>
    <ul class="nav nav-treeview">
        <li class="nav-item">
            <a href="{{ route('buku.wali.kelas') }}" class="nav-link">
                <i class="fas fa-book nav-icon ml-2 text-primary"></i>
                <p> Data Identitas</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('buku.kepala') }}" class="nav-link">
                <i class="fas fa-book nav-icon ml-2 text-primary"></i>
                <p> Dokumen Pribadi</p>
            </a>
        </li>
    </ul>
</li>
<li class="nav-item">

    <a href="#" class="nav-link">
        <i class="nav-icon fas fa-users-cog text-warning"></i>
        <p>
            Akademik
            <i class="fas fa-angle-left right"></i>
        </p>
    </a>
    <ul class="nav nav-treeview">
        <li class="nav-item">
            <a href="{{ route('buku.wali.kelas') }}" class="nav-link">
                <i class="fas fa-book nav-icon ml-2 text-primary"></i>
                <p> Data Nilai</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('buku.kepala') }}" class="nav-link">
                <i class="fas fa-book nav-icon ml-2 text-primary"></i>
                <p> Data Ekstra</p>
            </a>
        </li>
    </ul>
</li>
