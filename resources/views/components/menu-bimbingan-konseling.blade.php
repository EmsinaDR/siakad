{{-- Bimbingan Konseling --}}
<li class="nav-item menu-open">
    <a href="#" class="nav-link active">
        <i class="nav-icon fas fa-user-cog"></i>
        Bimbingan Konseling
    </a>
</li>

<li class="nav-item">
    <a href="{{ route('bk-data-siswa.index') }}" class="nav-link">
        <i class="fas fa-users nav-icon text-primary"></i>
        <p class="text-primary">Daftar Siswa</p>
    </a>
</li>

<li class="nav-item">
    <a href="#" class="nav-link">
        <i class="nav-icon fas fa-database text-dark"></i>
        <p class="text-dark">
            Data BK
            <i class="fas fa-angle-left right"></i>
        </p>
    </a>
    <ul class="nav nav-treeview">

        <li class="nav-item">
            <a href="{{ route('bimbingan.index') }}" class="nav-link">
                <i class="fas fa-comments nav-icon ml-4 text-success"></i>
                <p class="text-success">Bimbingan</p>
            </a>
        </li>

        <li class="nav-item">
            <a href="{{ route('kredit-point.index') }}" class="nav-link">
                <i class="fas fa-star-half-alt nav-icon ml-4 text-warning"></i>
                <p class="text-warning">Kredit Point</p>
            </a>
        </li>

        <li class="nav-item">
            <a href="{{ route('pelanggaran.index') }}" class="nav-link">
                <i class="fas fa-exclamation-triangle nav-icon ml-4 text-danger"></i>
                <p class="text-danger">Pelanggaran</p>
            </a>
        </li>

        <li class="nav-item">
            <a href="#" class="nav-link">
                <i class="fas fa-bullhorn nav-icon ml-4 text-secondary"></i>
                <p class="text-secondary">Pengaduan</p>
            </a>
        </li>
    </ul>
</li>

<li class="nav-item">
    <a href="#" class="nav-link {{ !$IsPaketAktif ? 'disabled' : '' }}">
        <i class="nav-icon fas fa-poll text-purple"></i>
        <p class="text-purple">
            Kuisioner
        </p>
         {!! !$IsPaketAktif ? '<span class="right badge badge-warning">PR</span>' : '' !!}
    </a>
    <ul class="nav nav-treeview">
        <li class="nav-item">
            <a href="{{ route('dasboard-quesioner.index') }}" class="nav-link">
                <i class="fas fa-question-circle nav-icon ml-4 text-purple"></i>
                <p class="text-purple">Data Pertanyaan</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('dasboard-quesioner.index') }}" class="nav-link">
                <i class="fas fa-list-alt nav-icon ml-4 text-purple"></i>
                <p class="text-purple">Quisioner</p>
            </a>
        </li>
    </ul>
</li>

<li class="nav-item">
    <a href="{{ route('surat_bk') }}" class="nav-link">
        <i class="fas fa-envelope-open-text nav-icon text-muted"></i>
        <p class="text-muted">Surat Ijin</p>
    </a>
</li>

{{-- Bimbingan Konseling Akhir --}}
{{-- <li class="nav-item">
    <a href="#" class="nav-link">
        <i class="nav-icon fa fa-mail-bulk"></i>
        <p>
            Surat
            <i class="fas fa-angle-left right"></i>
        </p>
    </a>
    <ul class="nav nav-treeview">
        <li class="nav-item">
            <a href="{{ route('surat_bk') }}" class="nav-link">
                <i class="fa fa-file-alt nav-icon ml-4"></i>
                <p>Surat Ijin</p>
            </a>
        </li>

    </ul>
</li> --}}
