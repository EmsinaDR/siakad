<li class='nav-item menu-open'>
    <a href='#' class='nav-link active'>
        <i class='nav-icon fas fa-file-alt'></i>
        <p>Data Kepala</p>
    </a>
</li>
<li class='nav-item'>
    <a href='{{ route('ekaldik.index') }}' class='nav-link'>
        <i class='fa fa-calendar-check nav-icon'></i>
        <p>E Kaldik</p>
    </a>
</li>

{{-- <li class='nav-item'>
    <a href='#' class='nav-link'>
        <i class='nav-icon fa fa-store'></i>
        <p>
            Kelas
            <i class='fas fa-angle-left right'></i>
        </p>
    </a>
    <ul class='nav nav-treeview'>
        <li class='nav-item'>
            <a href='#' class='nav-link'>
                <i class='far icon nav-icon'></i>
                <p>namekelas</p>
            </a>
        </li>
    </ul>
</li> --}}
<li class="nav-item">
    <a href="#" class="nav-link">
        <i class="nav-icon fa fa-folder"></i>
        <p>
            Agenda Rapat
            <i class="fas fa-angle-left right"></i>
        </p>
    </a>
    <ul class="nav nav-treeview pl-2">
        <li class="nav-item">
            <a href="{{ route('data-rapat.index') }}" class="nav-link">
                <i class="fa fa-qrcode nav-icon ml-2 text-info"></i>
                <p class=''> Data Rapat</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('daftar-hadir-rapat.index') }}" class="nav-link">
                <i class="fa fa-qrcode nav-icon ml-2 text-info"></i>
                <p class=''> Daftar Hadir Rapat </p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('berita-acara-rapat.index') }}" class="nav-link">
                <i class="fa fa-qrcode nav-icon ml-2 text-info"></i>
                <p class=''> Berita Acara Rapat </p>
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
<li class='nav-item'>
    <a href='#' class='nav-link'>
        <i class='nav-icon fa fa-store'></i>
        <p>
            Data Keuangan
            <i class='fas fa-angle-left right'></i>
        </p>
    </a>
    <ul class='nav nav-treeview'>
        <li class='nav-item'>
            <a href='{{ route('buku-kas-komite.index') }}' class='nav-link'>
                <i class='far icon nav-icon'></i>
                <p>Kas Komite</p>
            </a>
        </li>
        <li class='nav-item'>
            <a href='{{ route('buku-kas-bos.index') }}' class='nav-link'>
                <i class='far icon nav-icon'></i>
                <p>Kas BOS</p>
            </a>
        </li>
        <li class='nav-item'>
            <a href='{{ route('buku-kas-csr.index') }}' class='nav-link'>
                <i class='far icon nav-icon'></i>
                <p>Kas CSR</p>
            </a>
        </li>
        {{-- <li class='nav-item'>
            <a href='#' class='nav-link'>
                <i class='far icon nav-icon'></i>
                <p>Kas Tabungan</p>
            </a>
        </li> --}}
        <li class='nav-item'>
            <a href='{{ route('buku-kas-umum.index') }}' class='nav-link'>
                <i class='far icon nav-icon'></i>
                <p>Kas Umum</p>
            </a>
        </li>
    </ul>
</li>
<li class='nav-item'>
    <a href='#' class='nav-link'>
        <i class='nav-icon fa fa-store'></i>
        <p>
            Data Pembinaan
            <i class='fas fa-angle-left right'></i>
        </p>
    </a>
    <ul class='nav nav-treeview'>
        <li class='nav-item'>
            <a href='{{ route('pembinaan.index') }}' class='nav-link'>
                <i class='far icon nav-icon'></i>
                <p>Data Pembinaan</p>
            </a>
        </li>
    </ul>
</li>
<li class='nav-item'>
    <a href='#' class='nav-link'>
        <i class='nav-icon fa fa-store'></i>
        <p>
            Pengaturan Pengguna
            <i class='fas fa-angle-left right'></i>
        </p>
    </a>
    <ul class='nav nav-treeview'>
        <li class='nav-item'>
            <a href='{{ route('seting-pengguna-program.index') }}' class='nav-link'>
                <i class='far icon nav-icon'></i>
                <p>Data Pengguna</p>
            </a>
        </li>
    </ul>
</li>
<li class='nav-item'>
    <a href='#' class='nav-link active'>
        <i class='nav-icon fas fa-file-alt'></i>
        <p>Data Pendukung Lainnya</p>
    </a>
    <a href='#' class='nav-link'>
        <i class='nav-icon fa fa-store'></i>
        <p>
            Dokumen
            <i class='fas fa-angle-left right'></i>
        </p>
    </a>
    <ul class='nav nav-treeview'>
        <li class='nav-item'>
            <a href='{{ route('surat-keputusan.index') }}' class='nav-link'>
                <i class='far icon nav-icon'></i>
                <p>Surat Keputusan</p>
            </a>
        </li>
        <li class='nav-item'>
            <a href='{{ route('surat-program-kerja.index') }}' class='nav-link'>
                <i class='far icon nav-icon'></i>
                <p>Program Kerja</p>
            </a>
        </li>
        <li class='nav-item'>
            <a href='{{ route('adart.index') }}' class='nav-link'>
                <i class='far icon nav-icon'></i>
                <p>ADART</p>
            </a>
        </li>
    </ul>
</li>
{{-- <li class="nav-item">
    <a href="#" class="nav-link">
        <i class="nav-icon fa fa-store"></i>
        <p>
            Waka
            <i class="fas fa-angle-left right"></i>
        </p>
    </a>
    <ul class="nav nav-treeview">
        <li class="nav-item">
            <a href="{{ route('surat-keputusan.index') }}" class="nav-link">
                <i class="far icon nav-icon"></i>
                <p>Kurikulum</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('surat-program-kerja.index') }}" class="nav-link">
                <i class="far icon nav-icon"></i>
                <p>Data Kelulusan</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('adart.index') }}" class="nav-link">
                <i class="far icon nav-icon"></i>
                <p>ADART</p>
            </a>
        </li>
    </ul>
</li> --}}
