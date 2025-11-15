

<li class="nav-item">
    <a href="{{ route('reset-password.index') }}" class="nav-link">
        <i class="fas fa-user-cog nav-icon"></i>
        <p>Reset Password</p>
    </a>
</li>
<li class="nav-item">
    <a href="#" class="nav-link">
        <i class="nav-icon fas fa-users-cog text-warning"></i>
        <p>
            Paket Kerjasama
            <i class="fas fa-angle-left right"></i>
        </p>
    </a>
    <ul class="nav nav-treeview">
        {{-- <li class="nav-item">
            <a href="{{ route('buku.wali.kelas') }}" class="nav-link">
                <i class="fas fa-book nav-icon ml-2 text-primary"></i>
                <p> Buku Wali Kelas</p>
            </a>
        </li> --}}
        {{-- <li class="nav-item">
            <a href="{{ route('buku.kepala') }}" class="nav-link">
                <i class="fas fa-book nav-icon ml-2 text-primary"></i>
                <p> Buku Kepala</p>
            </a>
        </li> --}}
        {{-- <li class="nav-item">
            <a href="{{ route('buku.guru') }}" class="nav-link">
                <i class="fas fa-book nav-icon ml-2 text-primary"></i>
                <p> Buku Guru</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('buku.uks') }}" class="nav-link">
                <i class="fas fa-book nav-icon ml-2 text-primary"></i>
                <p> Buku UKS</p>
            </a>
        </li> --}}
        {{-- <a href="#" class="nav-link" data-toggle="modal" data-target="#DokumenLomba">
            <i class="ml-2 fas fa-plus nav-icon text-primary"></i>
            <p>Data Lomba</p>
        </a> --}}
        {{-- Modal Siswa --}}
        {{--
        Surat Aktif
        Surat Ijin
        Pengantar Lomba
         --}}
        {{-- <a href="#" class="nav-link" data-toggle="modal" data-target="#DokumenLomba">
            <i class="ml-2 fas fa-plus nav-icon text-primary"></i>
            <p>Surat Siswa</p>
        </a> --}}
        {{-- Modal Siswa --}}
        <li class="nav-item">
            <a href="{{ route('adm-buku.index') }}" class="nav-link">
                <i class="fas fa-book nav-icon ml-2 text-primary"></i>
                <p> Dokumen</p>
            </a>
        </li>
    </ul>
</li>
<style>
    .modal {
        z-index: 9999;
    }

    /* .modal-backdrop {
        z-index: 1050;
    } */
</style>
