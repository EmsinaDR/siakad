<li class="nav-item menu-open">
    <a href="#" class="nav-link active">
        <i class="nav-icon fas fa-user-shield"></i>
        <p>Tools</p>
    </a>
</li>
<li class="nav-item">

    <a href="#" class="nav-link">
        <i class="nav-icon fas fa-users-cog text-warning"></i>
        <p>
            Foto Digital
            <i class="fas fa-angle-left right"></i>
        </p>
    </a>
    <ul class="nav nav-treeview">
        <li class="nav-item">
            <a href="{{ route('foto.digital.guru') }}" class="nav-link {{ !$IsPaketAktif ? 'disabled' : '' }}">
                <i class="fas fa-book nav-icon ml-2 text-primary"></i>
                <p> Guru</p>
                {!! !$IsPaketAktif ? '<span class="right badge badge-warning">PR</span>' : '' !!}

            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('foto-digital-siswa.index') }}" class="nav-link">
                <i class="fas fa-book nav-icon ml-2 text-primary"></i>
                <p> Siswa</p>
            </a>
        </li>
    </ul>
</li>
<li class="nav-item">

    <a href="#" class="nav-link">
        <i class="nav-icon fas fa-print text-warning"></i>
        <p>
            Cetak Dokumen
            <i class="fas fa-angle-left right"></i>
        </p>
    </a>
    <ul class="nav nav-treeview">
        <li class="nav-item">
            <a href="{{ route('pengaturan-sertifikat.index') }}" class="nav-link">
                <i class="fas fa-book nav-icon ml-2 text-primary"></i>
                <p> Sertifikat</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('cocard.index') }}" class="nav-link">
                <i class="fas fa-book nav-icon ml-2 text-primary"></i>
                <p> Co Card</p>
            </a>
        </li>
    </ul>
</li>
<li class="nav-item">
    <a href="{{ route('image.index') }}" class="nav-link">
        <i class="fas fa-book nav-icon ml-2 text-primary"></i>
        <p> Image Compres</p>
    </a>
</li>

<li class="nav-item">
    <a href="{{ route('generator-qrcode.index') }}" class="nav-link">
        <i class="fas fa-book nav-icon ml-2 text-primary"></i>
        <p> QrCode</p>
        {{-- {!! !$IsPaketAktif ? '<span class="right badge badge-warning">PR</span>' : '' !!} --}}

    </a>
</li>
{{-- <li class="nav-item">
    <a href="{{ route('generator-qrcode.index') }}" class="nav-link {{ !$IsPaketAktif ? 'disabled' : '' }}">
        <i class="fas fa-book nav-icon ml-2 text-primary"></i>
        <p> QrCode</p>
       {!! !$IsPaketAktif ? '<span class="right badge badge-warning">PR</span>' : '' !!}

    </a>
</li> --}}
