<li class="nav-item">
    <a href="#" class="nav-link">
        <i class="nav-icon fa fa-folder"></i>
        <p>
            Guru Piket
            <i class="fas fa-angle-left right"></i>
        </p>
    </a>

    <ul class="nav nav-treeview">
        {{-- Contoh menu nonaktif --}}
        {{--
        <li class="nav-item">
            <a href="{{ route('buku.piket') }}" class="nav-link">
                <i class="fas fa-book nav-icon ml-2 text-primary"></i>
                <p>Blanko Dokumen</p>
            </a>
        </li>
        --}}

        {{-- Kartu Absen --}}
        <li class="nav-item ml-2">
            <a href="#" class="nav-link">
                <i class="nav-icon fas fa-id-card"></i>
                <p>
                    Kartu Absen
                    <i class="fas fa-angle-left right"></i>
                </p>
            </a>
            <ul class="nav nav-treeview pl-2">
                <li class="nav-item">
                    <a href="{{ app('request')->root() }}/admin/seting/kartu-qr-cetak-guru" class="nav-link ">
                        {{-- {{ $disabled }} --}}
                        <i class="fas fa-chalkboard-teacher nav-icon"></i>
                        <p>Guru</p>
                        {{-- @if ($disabled === 'disabled') --}}
                        {{-- <span class="right badge badge-warning">PR</span> --}}
                        {{-- @endif --}}
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('cetak.kartu.absensi.siswa') }}" class="nav-link">
                        <i class="fas fa-user-graduate nav-icon"></i>
                        <p>Siswa</p>
                    </a>
                </li>
                {{-- <li class="nav-item">
            <a href="{{ route('seting-pengguna-program.index') }}" class="nav-link">
                <i class="fas fa-layer-group nav-icon"></i>
                <p>Program</p>
            </a>
        </li> --}}
            </ul>
        </li>
        <li class="nav-item ml-2">
            <a href="#" class="nav-link">
                <i class="nav-icon fa fa-folder"></i>
                <p>
                    Absensi
                    <i class="fas fa-angle-left right"></i>
                </p>
            </a>
            <ul class="nav nav-treeview">
                <li class="nav-item">
                    <a href="{{ route('absensi.siswa.index.ajax') }}" class="nav-link ">
                        <i class="fa fa-qrcode nav-icon ml-2 text-info"></i>
                        <p>Absensi Siswa</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#"
                        class="nav-link {{ !$IsPaketAktif ? 'disabled' : '' }}">
                        <i class="fa fa-qrcode nav-icon ml-2 text-info"></i>
                        <p>Data Absensi Guru</p>
                        {!! !$IsPaketAktif ? '<span class="right badge badge-warning">CS</span>' : '' !!}
                    </a>
                </li>
                {{-- <li class="nav-item">
                    <a href="{{ route('absensi.guru.index.ajax') }}" class="nav-link">
                        <i class="fa fa-qrcode nav-icon ml-2 text-info"></i>
                        <p>Absensi Guru</p>
                    </a>
                </li> --}}
                <li class="nav-item">
                    <a href="{{ route('absensi.data-absensi-siswa.index') }}" class="nav-link">
                        <i class="fa fa-qrcode nav-icon ml-2 text-info"></i>
                        <p>Data Absensi Siswa</p>
                    </a>
                </li>
            </ul>
        </li>
        {{-- Submenu Ijin Digital --}}
        <li class="nav-item ml-2">
            <a href="#" class="nav-link">
                <i class="nav-icon fa fa-folder"></i>
                <p>
                    Ijin Digital
                    <i class="fas fa-angle-left right"></i>
                </p>
            </a>
            <ul class="nav nav-treeview">
                {{-- blade-formatter-disable --}}
                 <li class="nav-item">
                    <a href="{{ route('absensi.ijin-digital-siswa.index') }}" class="nav-link ">
                        <i class="fa fa-qrcode nav-icon ml-2 text-info"></i>
                        <p>Siswa</p>
                        {{-- <span class="right badge badge-warning">CS</span> --}}
                    </a>
                </li>
                {{-- <li class="nav-item">
                    <a href="{{ route('absensi.ijin-digital-siswa.index') }}"
                        class="nav-link {{ !$IsPaketAktif ? 'disabled' : '' }}">
                        <i class="fa fa-qrcode nav-icon ml-2 text-info"></i>
                        <p>Siswa</p>
                        {!! !$IsPaketAktif ? '<span class="right badge badge-warning">CS</span>' : '' !!}
                    </a>
                </li> --}}

                <li class="nav-item">
                    <a href="{{ route('absensi.ijin-digital-siswa.index') }}"
                        class="nav-link {{ !$IsPaketAktif ? 'disabled' : '' }}">
                        <i class="fa fa-qrcode nav-icon ml-2 text-info"></i>
                        <p>Guru</p>
                        {!! !$IsPaketAktif ? '<span class="right badge badge-warning">CS</span>' : '' !!}
                    </a>
                </li>

                 {{-- blade-formatter-enable --}}
            </ul>
        </li>
    </ul>
</li>
