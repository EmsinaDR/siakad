@php
    use App\Models\Admin\Ekelas;
    $ekelass = Ekelas::where('aktiv', 'Y')->get();
    if ($Identitas->paket === 'Premium') {
        $disabled = '';
    } elseif ($Identitas->paket === 'Trial') {
        $disabled = '';
    } else {
        $disabled = 'disabled';
    }
    // dd($ekelass);
@endphp
{{-- Role Admin --}}
<li class="nav-item menu-open">
    <a href="#" class="nav-link active">
        <i class="nav-icon fas fa-user-shield"></i>
        <p>Master Data Admin</p>
    </a>
</li>

<li class="nav-item">
    <a href="{{ route('identitas.index') }}" class="nav-link">
        <i class="nav-icon fas fa-school"></i>
        <p>Profil Sekolah</p>
    </a>
</li>

{{-- Data Pengaturan --}}
<li class="nav-item">
    <a href="#" class="nav-link">
        <i class="nav-icon fas fa-users"></i>
        <p>
            Data User
            <i class="fas fa-angle-left right"></i>
        </p>
    </a>
    <ul class="nav nav-treeview pl-2">
        <li class="nav-item">
            <a href="{{ route('guru.index') }}" class="nav-link">
                <i class="fas fa-chalkboard-teacher nav-icon"></i>
                <p>Guru</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('karyawan.index') }}" class="nav-link">
                <i class="fas fa-user-tie nav-icon"></i>
                <p>Karyawan</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('siswa.index') }}" class="nav-link">
                <i class="fas fa-user-graduate nav-icon"></i>
                <p>Siswa</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('alumni.index') }}" class="nav-link">
                <i class="fas fa-user-graduate nav-icon"></i>
                <p>Alumni</p>
            </a>
        </li>
    </ul>
</li>

{{-- Pengaturan Pendidikan --}}
<li class="nav-item">
    <a href="#" class="nav-link">
        <i class="nav-icon fas fa-cogs"></i>
        <p>
            Pengaturan Pendidikan
            <i class="fas fa-angle-left right"></i>
        </p>
    </a>
    <ul class="nav nav-treeview pl-2">
        <li class="nav-item">
            <a href="{{ route('etapel.index') }}" class="nav-link">
                <i class="fas fa-calendar-alt nav-icon"></i>
                <p>Tahun Pelajaran</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('kelas.index') }}" class="nav-link">
                <i class="fas fa-chalkboard nav-icon"></i>
                <p>Kelas</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('emapel.index') }}" class="nav-link">
                <i class="fas fa-book-open nav-icon"></i>
                <p>Mata Pelajaran</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('emengajar.index') }}" class="nav-link">
                <i class="fas fa-chalkboard-teacher nav-icon"></i>
                <p>Mengajar</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('laboratorium.index') }}" class="nav-link">
                <i class="fas fa-flask nav-icon"></i>
                <p>Laboratorium</p>
            </a>
        </li>
    </ul>
</li>
@if ($Identitas->paket === 'Kerjasama')
    <x-menu-paket-kerjasama />
    {{-- @dd(optional($Modul->where('slug', 'absensi')->first())->is_active, $Modul->toArray()); --}}
    @if (optional($Modul->where('slug', 'absensi')->first())->is_active)
        <x-menu-guru-piket />
    @endif
    @if (optional($Modul->where('slug', 'tools')->first())->is_active)
        <x-menu-tools />
    @endif
@else
@endif

@if (in_array($Identitas->paket, ['Premium', 'Trial']))
    <x-menu-role />
@else
@endif
@if (optional($Modul->where('slug', 'whatsapp')->first())->is_active)
    <x-menu-whatsapp />
@endif

{{-- Data Pengaturan ROle Akhir --}}

{{-- Data Pengaturan Mutasi Awal --}}
{{-- <li class="nav-item">
    <a href="#" class="nav-link">
        <i class="nav-icon fa fa-cog"></i>
        <p>
            Data Mutasi
            <i class="fas fa-angle-left right"></i>
        </p>
    </a>
    <ul class="nav nav-treeview">
        <li class="nav-item">
            <a href="{{ route('role-guru.index') }}" class="nav-link">
                <i class="fa fa-calendar nav-icon"></i>
                <p>Guru</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('etapel.index') }}" class="nav-link">
                <i class="fa fa-calendar nav-icon"></i>
                <p>Siswa</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('etapel.index') }}" class="nav-link">
                <i class="fa fa-calendar nav-icon"></i>
                <p>Pindah Kelas</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="#" class="nav-link">
                <i class="nav-icon fa fa-cog"></i>
                <p>
                    Pengaturan PPDB
                    <i class="fas fa-angle-left right mr-4"></i>
                </p>
            </a>
            <ul class="nav nav-treeview">
                <li class="nav-item">
                    <a href="{{ route('role-guru.index') }}" class="nav-link">
                        <i class="fa fa-calendar nav-icon ml-2"></i>
                        <p>Guru</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('etapel.index') }}" class="nav-link">
                        <i class="fa fa-calendar nav-icon ml-2"></i>
                        <p>Siswa</p>
                    </a>
                </li>
            </ul>
        </li>
    </ul>
</li> --}}
{{-- Data Pengaturan Mutasi Akhir --}}
