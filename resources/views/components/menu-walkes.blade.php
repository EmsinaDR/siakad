<li class='nav-item menu-open'>
    <a href='#' class='nav-link active'>
        <i class='nav-icon fas fa-file-alt'></i>
        <p>Wali Kelas</p>
    </a>
</li>

<li class="nav-item">
    <a href="{{ app('request')->root() }}/wali-kelas/2/data-siswa" class="nav-link">
        <i class="nav-icon fas fa-user-cog"></i>
        <p>
            Data Siswa
        </p>
    </a>
<li>
<li class="nav-item">
    <a href="{{ app('request')->root() }}/wali-kelas/2/data-jurnal-kelas" class="nav-link">
        <i class="nav-icon fa fa-tasks"></i>
        <p>
            Jurnal Kelas
        </p>
    </a>
<li>
<li class="nav-item">
    <a href="{{ app('request')->root() }}/wali-kelas/2/data-struktur-kelas" class="nav-link">
        <i class="nav-icon fa fa-network-wired"></i>
        <p>
            Struktur Kelas
        </p>
    </a>
<li>
<li class="nav-item">
    <a href="{{ app('request')->root() }}/wali-kelas/2/data-petugas-upacara" class="nav-link">
        <i class="nav-icon fa fa-network-wired"></i>
        <p>
            Petugas Upacara
        </p>
    </a>
<li>

    {{-- E Nilai Walkes --}}
<li class="nav-item">
    <a href="{{ app('request')->root() }}/wali-kelas/2/data-nilai-tugas-siswa" class="nav-link">
        <i class="nav-icon fa fa-file-alt"></i>
        <p>
            E Nilai
            <i class="fas fa-angle-left right"></i>
        </p>
    </a>
    <ul class="nav nav-treeview">
        <li class="nav-item">
            <a href="{{ app('request')->root() }}/wali-kelas/2/data-nilai-tugas-siswa" class="nav-link">
                <i class="fa fa-file nav-icon ml-4"></i>
                <p>Data Nilai Tugas</p>
            </a>

        </li>
        <li class="nav-item">
            <a href="{{ app('request')->root() }}/wali-kelas/2/data-nilai-ulangan-siswa" class="nav-link">
                <i class="fa fa-file nav-icon ml-4"></i>
                <p>Data Nilai Ulangan</p>
            </a>

        </li>
        <li class="nav-item">
            <a href="{{ app('request')->root() }}/wali-kelas/2/data-nilai-pts-pas-siswa" class="nav-link">
                <i class="fa fa-list nav-icon ml-4"></i>
                <p>Data Nilai PTS / PAS</p>
            </a>

        </li>
    </ul>
</li>
{{-- E Nilai Walkes Akhir --}}
{{-- Inventaris Kelas Walkes --}}
<li class="nav-item">
    <a href="{{ app('request')->root() }}/wali-kelas/2/data-siswa" class="nav-link">
        <i class="nav-icon fa fa fa-building"></i>
        <p>
            Inventaris
            <i class="fas fa-angle-left right"></i>
        </p>
    </a>
    <ul class="nav nav-treeview">
        <li class="nav-item">
            <a href="{{ app('request')->root() }}/wali-kelas/2/data-inventaris" class="nav-link">
                <i class="fa fa-clipboard-list nav-icon ml-4"></i>
                <p>Inventaris Kelas</p>
            </a>
            <a href="{{ app('request')->root() }}/wali-kelas/2/data-siswa" class="nav-link">
                <i class="fa fa-clipboard nav-icon ml-4"></i>
                <p>Pengajuan Inventaris</p>

            </a>
        </li>
    </ul>
<li>
    {{-- Inventaris Kelas Walkes Akhir --}}

    {{-- Absensi Siswa Walkes --}}
<li class="nav-item">
    <a href="#" class="nav-link">
        <i class="nav-icon fa fa-tags"></i>

        <p>
            Absensi
            <i class="fas fa-angle-left right"></i>
        </p>
    </a>
    {{-- Absensi Siswa Walkes --}}
    <ul class="nav nav-treeview">
        <li class="nav-item">
            <a href="{{ app('request')->root() }}/wali-kelas/2/data-absensi" class="nav-link">
                <i class="fa fa-tags nav-icon ml-4"></i>
                <p>Absensi Harian</p>
            </a>
            <a href="{{ app('request')->root() }}/wali-kelas/2/data-rakap-absensi" class="nav-link">
                <i class="fa fa-book nav-icon ml-4"></i>
                <p>Rekapitulasi Absensi</p>
            </a>

        </li>
    </ul>

    {{-- Absensi Siswa Walkes Akhir --}}
<li>
    {{-- Absensi Siswa Walkes Akhir --}}

    {{-- Keungan Siswa Walkes --}}
<li class="nav-item">
    <a href="{{ app('request')->root() }}/wali-kelas/2/data-siswa" class="nav-link">
        <i class="nav-icon fa fa-wallet"></i>

        <p>
            Keuangan
            <i class="fas fa-angle-left right"></i>
        </p>
    </a>
    <ul class="nav nav-treeview">
        <li class="nav-item">
            {{-- Keuangan Study Tour Walkes --}}
            <a href="{{ app('request')->root() }}/wali-kelas/2/data-siswa" class="nav-link">
                <i class="fa fa-file-invoice-dollar nav-icon ml-4"></i>
                <p>Study Tour</p>
            </a>

            {{-- Keuangan Study Tour Walkes Akhir --}}
            {{-- Keungan Komite Walkes --}}
            <a href="{{ app('request')->root() }}/wali-kelas/2/data-siswa" class="nav-link">
                <i class="fa fa-file-invoice-dollar nav-icon ml-4"></i>
                <p>Komite</p>
            </a>

            {{-- Keungan Komite Walkes Akhir --}}
            {{-- Keungan Tabungan Siswa --}}
            <a href="{{ app('request')->root() }}/wali-kelas/2/data-siswa" class="nav-link">
                <i class="fa fa-wallet nav-icon ml-4"></i>
                <p>Tabungan</p>
            </a>

            {{-- Keungan Tabungan Siswa Akhir --}}
        </li>
    </ul>
<li>
    {{-- Keungan Siswa Walkes Akhir --}}

    {{-- Jadwal Walkes --}}
<li class='nav-item'>
    <a href='#' class='nav-link'>
        <i class='nav-icon fa fa-calendar-alt'></i>

        <p>
            Jadwal
            <i class='fas fa-angle-left right'></i>
        </p>
    </a>
    <ul class='nav nav-treeview'>
        {{-- Jadwal Pelajaran Walkes --}}
        <li class='nav-item'>
            <a href='#' class='nav-link'>
                <i class='fa fa-clipboard-list nav-icon ml-4 nav-icon'></i>

                <p>Jadwal Pelajaran</p>
            </a>
        </li>

        {{-- Jadwal Pelajaran Walkes Akhir --}}
        {{-- Jadwal Piket Walkes --}}
        <li class='nav-item'>
            <a href='#' class='nav-link'>
                <i class='fa fa-clipboard-list nav-icon ml-4 nav-icon'></i>

                <p>Jadwal Piket</p>
            </a>
        </li>

        {{-- Jadwal Piket Walkes Akhir --}}
    </ul>
</li>
{{-- Jadwal Walkes Akhir --}}

{{-- Bimbingan Konseling Walkes --}}
<li class="nav-item">
    <a href="{{ app('request')->root() }}/wali-kelas/2/data-siswa" class="nav-link">
        <i class="nav-icon fas fa-table"></i>
        <p>
            Bimbingan Konseling
            <i class="fas fa-angle-left right"></i>
        </p>
    </a>
    <ul class="nav nav-treeview">
        <li class="nav-item">
            <a href="{{ app('request')->root() }}/wali-kelas/2/data-siswa" class="nav-link">
                <i class="fa fa-list-ul nav-icon ml-4"></i>

                <p>Kredit Point</p>
            </a>
            <a href="{{ app('request')->root() }}/wali-kelas/2/data-siswa" class="nav-link">
                <i class="fa fa-list-ul nav-icon ml-4"></i>

                <p>Pelanggaran Siswa</p>
            </a>
            <a href="{{ app('request')->root() }}/wali-kelas/2/data-siswa" class="nav-link">
                <i class="fa fa-trophy nav-icon ml-4"></i>
                <p>Prestasi</p>
            </a>

        </li>
    </ul>

<li>

    {{-- Bimbingan Konseling Walkes Akhir --}}
