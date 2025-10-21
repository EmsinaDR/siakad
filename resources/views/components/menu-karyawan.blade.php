{{-- Dokumen Karyawan --}}
{{-- <li class="nav-item menu-open ">
    <a href="#" class="nav-link active">
        <i class="nav-icon fa fa-tools"></i>
        <p>Dokumen</p>
    </a>
</li> --}}
{{-- E Surat Karyawan --}}
@if ($namaProgram === 'Adm. Kesiswaan')
    <li class="nav-item">
        <a href="#" class="nav-link">
            <i class="nav-icon fas fa-table"></i>
            <p>
                Adm Kesiswaan
                <i class="fas fa-angle-left right"></i>
            </p>
        </a>

        <ul class="nav nav-treeview pl-2">
            {{-- blade-formatter-disable --}}
                <li class="nav-item">
                    <a href="{{ route('katalog-buku.index') }}" class="nav-link"><i class="fa fa-qrcode nav-icon ml-2 text-info"></i><p>Buku Induk Siswa</p></a>
                </li>
                <li class="nav-item"><a href="{{ route('katalog-buku.index') }}" class="nav-link"><i class="fa fa-qrcode nav-icon ml-2 text-info"></i><p>Buku Klaper</p></a></li>
                <li class="nav-item"><a href="{{ route('katalog-buku.index') }}" class="nav-link"><i class="fa fa-qrcode nav-icon ml-2 text-info"></i><p>Data Mutasi Siswa</p></a></li>
                <li class="nav-item"><a href="{{ route('katalog-buku.index') }}" class="nav-link"><i class="fa fa-qrcode nav-icon ml-2 text-info"></i><p>Rekapitulasi Jml Siswa</p></a></li>
                <li class="nav-item"><a href="{{ route('katalog-buku.index') }}" class="nav-link"><i class="fa fa-qrcode nav-icon ml-2 text-info"></i><p>Kartu Pelajar</p></a></li>
                <li class="nav-item"><a href="{{ route('katalog-buku.index') }}" class="nav-link"><i class="fa fa-qrcode nav-icon ml-2 text-info"></i><p>Surat Kesiswaan</p></a></li>
                <li class="nav-item"><a href="{{ route('katalog-buku.index') }}" class="nav-link"><i class="fa fa-qrcode nav-icon ml-2 text-info"></i><p>Jadwal Kegiatan</p></a></li>
                <li class="nav-item"><a href="{{ route('katalog-buku.index') }}" class="nav-link"><i class="fa fa-qrcode nav-icon ml-2 text-info"></i><p>Arsip Disiplin Siswa</p></a></li>
                <li class="nav-item"><a href="{{ route('katalog-buku.index') }}" class="nav-link"><i class="fa fa-qrcode nav-icon ml-2 text-info"></i><p>Data Prestasi</p></a></li>
                <li class="nav-item"><a href="{{ route('katalog-buku.index') }}" class="nav-link"><i class="fa fa-qrcode nav-icon ml-2 text-info"></i><p>Berkas Pendaftaran</p></a></li>
                <li class="nav-item"><a href="{{ route('katalog-buku.index') }}" class="nav-link"><i class="fa fa-qrcode nav-icon ml-2 text-info"></i><p>Berkas Kelulusan</p></a></li>
                <li class="nav-item"><a href="{{ route('katalog-buku.index') }}" class="nav-link"><i class="fa fa-qrcode nav-icon ml-2 text-info"></i><p>Data Alumni</p></a></li>
                <li class="nav-item"><a href="{{ route('katalog-buku.index') }}" class="nav-link"><i class="fa fa-qrcode nav-icon ml-2 text-info"></i><p>Proker</p></a></li>
                {{-- blade-formatter-enable --}}
        </ul>
    </li>
@elseif ($namaProgram === 'Adm. Sarpras')
    <li class="nav-item">
        <a href="#" class="nav-link">
            <i class="nav-icon fas fa-table"></i>
            <p>
                {{ $namaProgram }}
                <i class="fas fa-angle-left right"></i>
            </p>
        </a>
        <ul class="nav nav-treeview">
            {{-- blade-formatter-disable --}}
                <li class="nav-item"><a href="{{ route('katalog-buku.index') }}" class="nav-link"><i class="fa fa-book nav-icon ml-2 text-info"></i><p>Buku Peminjaman</p></a></li>
                <li class="nav-item"><a href="{{ route('katalog-buku.index') }}" class="nav-link"><i class="fa fa-qrcode nav-icon ml-2 text-info"></i><p>Data Ruangan</p></a></li>
                <li class="nav-item"><a href="{{ route('katalog-buku.index') }}" class="nav-link"><i class="fa fa-qrcode nav-icon ml-2 text-info"></i><p>Inventaris Barang</p></a></li>
                <li class="nav-item"><a href="{{ route('katalog-buku.index') }}" class="nav-link"><i class="fa fa-qrcode nav-icon ml-2 text-info"></i><p>KIB A - F</p></a></li>
                <li class="nav-item"><a href="{{ route('katalog-buku.index') }}" class="nav-link"><i class="fa fa-qrcode nav-icon ml-2 text-info"></i><p>Penerimaan Barang</p></a></li>
                <li class="nav-item"><a href="{{ route('katalog-buku.index') }}" class="nav-link"><i class="fa fa-qrcode nav-icon ml-2 text-info"></i><p>Pengeluaran Barang</p></a></li>
                <li class="nav-item"><a href="{{ route('katalog-buku.index') }}" class="nav-link"><i class="fa fa-qrcode nav-icon ml-2 text-info"></i><p>BA Barang</p></a></li>
                <li class="nav-item"><a href="{{ route('katalog-buku.index') }}" class="nav-link"><i class="fa fa-qrcode nav-icon ml-2 text-info"></i><p>Rencana Kebutuhan</p></a></li>
                <li class="nav-item"><a href="{{ route('katalog-buku.index') }}" class="nav-link"><i class="fa fa-qrcode nav-icon ml-2 text-info"></i><p>Stok Opname</p></a></li>
                {{-- blade-formatter-enable --}}
        </ul>
    </li>
@elseif ($namaProgram === 'Adm. Surat Menyurat')
    <li class="nav-item">
        <a href="#" class="nav-link">
            <i class="nav-icon fas fa-table"></i>
            <p>
                {{ $namaProgram }}
                <i class="fas fa-angle-left right"></i>
            </p>
        </a>
        <ul class="nav nav-treeview pl-2">
            {{-- <x-menu-surat></x-menu-surat>
            <x-menu-program-rapat></x-menu-program-rapat> --}}
            {{-- blade-formatter-disable --}}
                <li class="nav-item"><a href="{{ route('katalog-buku.index') }}" class="nav-link"><i class="fa fa-qrcode nav-icon ml-0 text-info"></i><p>Agenda Rapat</p></a></li>
                <li class="nav-item"><a href="{{ route('katalog-buku.index') }}" class="nav-link"><i class="fa fa-qrcode nav-icon ml-0 text-info"></i><p>Notulen</p></a></li>
                <li class="nav-item"><a href="{{ route('katalog-buku.index') }}" class="nav-link"><i class="fa fa-qrcode nav-icon ml-0 text-info"></i><p>Surat Masuk</p></a></li>
                <li class="nav-item"><a href="{{ route('katalog-buku.index') }}" class="nav-link"><i class="fa fa-qrcode nav-icon ml-0 text-info"></i><p>Surat Keluar</p></a></li>
                <li class="nav-item"><a href="{{ route('katalog-buku.index') }}" class="nav-link"><i class="fa fa-qrcode nav-icon ml-0 text-info"></i><p>Klasifikasi Surat</p></a></li>
                <li class="nav-item"><a href="{{ route('katalog-buku.index') }}" class="nav-link"><i class="fa fa-qrcode nav-icon ml-0 text-info"></i><p>Kode Penomoran</p></a></li>
                <li class="nav-item"><a href="{{ route('katalog-buku.index') }}" class="nav-link"><i class="fa fa-qrcode nav-icon ml-0 text-info"></i><p>Tata Naskah Dinas</p></a></li>
            {{-- blade-formatter-enable --}}
        </ul>
    </li>
@elseif ($namaProgram === 'Adm. Waka Kurikulum')
    <li class="nav-item">
        <a href="#" class="nav-link">
            <i class="nav-icon fas fa-table"></i>
            <p>
                {{ $namaProgram }}
                <i class="fas fa-angle-left right"></i>
            </p>
        </a>
        <ul class="nav nav-treeview pl-2">

            {{-- blade-formatter-disable --}}
                <li class="nav-item"><a href="{{ route('katalog-buku.index') }}" class="nav-link"><i class="fa fa-qrcode nav-icon ml-2 text-info"></i><p>Buku mutasi siswa</p></a></li>
                <li class="nav-item"><a href="{{ route('katalog-buku.index') }}" class="nav-link"><i class="fa fa-qrcode nav-icon ml-2 text-info"></i><p>Proker</p></a></li>
                <li class="nav-item"><a href="{{ route('katalog-buku.index') }}" class="nav-link"><i class="fa fa-qrcode nav-icon ml-2 text-info"></i><p>Struktur Kurikulum</p></a></li>
                <li class="nav-item"><a href="{{ route('katalog-buku.index') }}" class="nav-link"><i class="fa fa-qrcode nav-icon ml-2 text-info"></i><p>Kalender Pendidikan</p></a></li>
                <li class="nav-item"><a href="{{ route('katalog-buku.index') }}" class="nav-link"><i class="fa fa-qrcode nav-icon ml-2 text-info"></i><p>Jadwal Pelajaran</p></a></li>
                <li class="nav-item"><a href="{{ route('katalog-buku.index') }}" class="nav-link"><i class="fa fa-qrcode nav-icon ml-2 text-info"></i><p>Pembagian Tugas</p></a></li>
                <li class="nav-item"><a href="{{ route('katalog-buku.index') }}" class="nav-link"><i class="fa fa-qrcode nav-icon ml-2 text-info"></i><p>Daftar Nilai</p></a></li>
                <li class="nav-item"><a href="{{ route('katalog-buku.index') }}" class="nav-link"><i class="fa fa-qrcode nav-icon ml-2 text-info"></i><p>Data Ujian</p></a></li>
                <li class="nav-item"><a href="{{ route('katalog-buku.index') }}" class="nav-link"><i class="fa fa-qrcode nav-icon ml-2 text-info"></i><p>Data Kelulusan</p></a></li>
                <li class="nav-item"><a href="{{ route('katalog-buku.index') }}" class="nav-link"><i class="fa fa-qrcode nav-icon ml-2 text-info"></i><p>Data Kenaikan</p></a></li>
                <li class="nav-item"><a href="{{ route('katalog-buku.index') }}" class="nav-link"><i class="fa fa-qrcode nav-icon ml-2 text-info"></i><p>Dokumen Rapor</p></a></li>
                <li class="nav-item"><a href="{{ route('katalog-buku.index') }}" class="nav-link"><i class="fa fa-qrcode nav-icon ml-2 text-info"></i><p>Evaluasi Kurikulum</p></a></li>
                {{-- blade-formatter-enable --}}
        </ul>
    </li>
@elseif ($namaProgram === 'Adm. Umum')
    <li class="nav-item">
        <a href="#" class="nav-link">
            <i class="nav-icon fas fa-table"></i>
            <p>
                {{ $namaProgram }}
                <i class="fas fa-angle-left right"></i>
            </p>
        </a>
        <ul class="nav nav-treeview pl-2">
            {{-- blade-formatter-disable --}}
                <li class="nav-item"><a href="{{ route('katalog-buku.index') }}" class="nav-link"><i class="fa fa-qrcode nav-icon ml-2 text-info"></i><p>Agenda Umum</p></a></li>
                <li class="nav-item"><a href="{{ route('katalog-buku.index') }}" class="nav-link"><i class="fa fa-qrcode nav-icon ml-2 text-info"></i><p>Buku Tamu</p></a></li>
                <li class="nav-item"><a href="{{ route('katalog-buku.index') }}" class="nav-link"><i class="fa fa-qrcode nav-icon ml-2 text-info"></i><p>Buku Notulen Rapat</p></a></li>
                <li class="nav-item"><a href="{{ route('katalog-buku.index') }}" class="nav-link"><i class="fa fa-qrcode nav-icon ml-2 text-info"></i><p>Buku Notulen Rapat</p></a></li>
                <li class="nav-item"><a href="{{ route('katalog-buku.index') }}" class="nav-link"><i class="fa fa-qrcode nav-icon ml-2 text-info"></i><p>Arsip Surat</p></a></li>
                <li class="nav-item"><a href="{{ route('katalog-buku.index') }}" class="nav-link"><i class="fa fa-qrcode nav-icon ml-2 text-info"></i><p>Data Kepegawaian</p></a></li>
                <li class="nav-item"><a href="{{ route('katalog-buku.index') }}" class="nav-link"><i class="fa fa-qrcode nav-icon ml-2 text-info"></i><p>Legalitas Sekolah</p></a></li>
                <li class="nav-item"><a href="{{ route('katalog-buku.index') }}" class="nav-link"><i class="fa fa-qrcode nav-icon ml-2 text-info"></i><p>SOP</p></a></li>
                {{-- blade-formatter-enable --}}
        </ul>
    </li>
@elseif ($namaProgram === 'Adm. Penilaian & Ujian')
    <li class="nav-item">
        <a href="#" class="nav-link">
            <i class="nav-icon fas fa-table"></i>
            <p>
                {{ $namaProgram }}
                <i class="fas fa-angle-left right"></i>
            </p>
        </a>
        <ul class="nav nav-treeview pl-2">
            {{-- blade-formatter-disable --}}
                <li class="nav-item"><a href="{{ route('katalog-buku.index') }}" class="nav-link"><i class="fa fa-qrcode nav-icon ml-2 text-info"></i><p>Kalender Penilaian</p></a></li>
                <li class="nav-item"><a href="{{ route('katalog-buku.index') }}" class="nav-link"><i class="fa fa-qrcode nav-icon ml-2 text-info"></i><p>Kisi-Kisi Soal</p></a></li>
                <li class="nav-item"><a href="{{ route('katalog-buku.index') }}" class="nav-link"><i class="fa fa-qrcode nav-icon ml-2 text-info"></i><p>Kisi-Kisi Soal </p></a></li>
                <li class="nav-item"><a href="{{ route('katalog-buku.index') }}" class="nav-link"><i class="fa fa-qrcode nav-icon ml-2 text-info"></i><p>Peserta Ujian</p></a></li>
                <li class="nav-item"><a href="{{ route('katalog-buku.index') }}" class="nav-link"><i class="fa fa-qrcode nav-icon ml-2 text-info"></i><p>BA Ujian</p></a></li>
                <li class="nav-item"><a href="{{ route('katalog-buku.index') }}" class="nav-link"><i class="fa fa-qrcode nav-icon ml-2 text-info"></i><p>BA Kejadian Khusus</p></a></li>
                <li class="nav-item"><a href="{{ route('katalog-buku.index') }}" class="nav-link"><i class="fa fa-qrcode nav-icon ml-2 text-info"></i><p>DH Ujian</p></a></li>
                <li class="nav-item"><a href="{{ route('katalog-buku.index') }}" class="nav-link"><i class="fa fa-qrcode nav-icon ml-2 text-info"></i><p>Rekap Nilai</p></a></li>
                <li class="nav-item"><a href="{{ route('katalog-buku.index') }}" class="nav-link"><i class="fa fa-qrcode nav-icon ml-2 text-info"></i><p>Arsip Hasil Ujian</p></a></li>
                <li class="nav-item"><a href="{{ route('katalog-buku.index') }}" class="nav-link"><i class="fa fa-qrcode nav-icon ml-2 text-info"></i><p>SOP Ujian</p></a></li>
                {{-- blade-formatter-enable --}}
        </ul>
    </li>
@elseif ($namaProgram === 'Adm. PPDB')
    <li class="nav-item">
        <a href="#" class="nav-link">
            <i class="nav-icon fas fa-table"></i>
            <p>
                {{ $namaProgram }}
                <i class="fas fa-angle-left right"></i>
            </p>
        </a>
        <ul class="nav nav-treeview pl-2">
            {{-- blade-formatter-disable --}}
                <li class="nav-item"><a href="{{ route('katalog-buku.index') }}" class="nav-link"><i class="fa fa-qrcode nav-icon ml-2 text-info"></i><p>Proker</p></a></li>
                <li class="nav-item"><a href="{{ route('katalog-buku.index') }}" class="nav-link"><i class="fa fa-qrcode nav-icon ml-2 text-info"></i><p>Jadwal</p></a></li>
                <li class="nav-item"><a href="{{ route('katalog-buku.index') }}" class="nav-link"><i class="fa fa-qrcode nav-icon ml-2 text-info"></i><p>Formulir </p></a></li>
                <li class="nav-item"><a href="{{ route('katalog-buku.index') }}" class="nav-link"><i class="fa fa-qrcode nav-icon ml-2 text-info"></i><p>Daftar Peserta</p></a></li>
                <li class="nav-item"><a href="{{ route('katalog-buku.index') }}" class="nav-link"><i class="fa fa-qrcode nav-icon ml-2 text-info"></i><p>Berkas Pendaftaran</p></a></li>
                <li class="nav-item"><a href="{{ route('katalog-buku.index') }}" class="nav-link"><i class="fa fa-qrcode nav-icon ml-2 text-info"></i><p>Hasil Seleksi</p></a></li>
                <li class="nav-item"><a href="{{ route('katalog-buku.index') }}" class="nav-link"><i class="fa fa-qrcode nav-icon ml-2 text-info"></i><p>BA Seleksi</p></a></li>
                <li class="nav-item"><a href="{{ route('katalog-buku.index') }}" class="nav-link"><i class="fa fa-qrcode nav-icon ml-2 text-info"></i><p>Pengumuman </p></a></li>
                <li class="nav-item"><a href="{{ route('katalog-buku.index') }}" class="nav-link"><i class="fa fa-qrcode nav-icon ml-2 text-info"></i><p>Daftar Ulang</p></a></li>
                <li class="nav-item"><a href="{{ route('katalog-buku.index') }}" class="nav-link"><i class="fa fa-qrcode nav-icon ml-2 text-info"></i><p>BA Daftar Ulang</p></a></li>
                <li class="nav-item"><a href="{{ route('katalog-buku.index') }}" class="nav-link"><i class="fa fa-qrcode nav-icon ml-2 text-info"></i><p>SOP PPDB</p></a></li>
                <li class="nav-item"><a href="{{ route('katalog-buku.index') }}" class="nav-link"><i class="fa fa-qrcode nav-icon ml-2 text-info"></i><p>SOP</p></a></li>
                {{-- blade-formatter-enable --}}
        </ul>
    </li>
@elseif ($namaProgram === 'Adm. Ekstrakurikuler')
    <li class="nav-item">
        <a href="#" class="nav-link">
            <i class="nav-icon fas fa-table"></i>
            <p>
                {{ $namaProgram }}
                <i class="fas fa-angle-left right"></i>
            </p>
        </a>
        <ul class="nav nav-treeview pl-2">
            {{-- blade-formatter-disable --}}
                <li class="nav-item"><a href="{{ route('katalog-buku.index') }}" class="nav-link"><i class="fa fa-qrcode nav-icon ml-2 text-info"></i><p>Daftar Ekstra</p></a></li>
                <li class="nav-item"><a href="{{ route('katalog-buku.index') }}" class="nav-link"><i class="fa fa-qrcode nav-icon ml-2 text-info"></i><p>Jadwal</p></a></li>
                <li class="nav-item"><a href="{{ route('katalog-buku.index') }}" class="nav-link"><i class="fa fa-qrcode nav-icon ml-2 text-info"></i><p>Peserta Ekstrakurikuler</p></a></li>
                <li class="nav-item"><a href="{{ route('katalog-buku.index') }}" class="nav-link"><i class="fa fa-qrcode nav-icon ml-2 text-info"></i><p>Absensi Kegiatan</p></a></li>
                {{-- blade-formatter-enable --}}
        </ul>
    </li>
@elseif ($namaProgram === 'Adm. OSIS')
    <li class="nav-item">
        <a href="#" class="nav-link">
            <i class="nav-icon fas fa-table"></i>
            <p>
                {{ $namaProgram }}
                <i class="fas fa-angle-left right"></i>
            </p>
        </a>
        <ul class="nav nav-treeview pl-2">
            {{-- blade-formatter-disable --}}
                <li class="nav-item"><a href="{{ route('katalog-buku.index') }}" class="nav-link"><i class="fa fa-qrcode nav-icon ml-2 text-info"></i><p>Proker</p></a></li>
                <li class="nav-item"><a href="{{ route('katalog-buku.index') }}" class="nav-link"><i class="fa fa-qrcode nav-icon ml-2 text-info"></i><p>Struktur</p></a></li>
                <li class="nav-item"><a href="{{ route('katalog-buku.index') }}" class="nav-link"><i class="fa fa-qrcode nav-icon ml-2 text-info"></i><p>Jadwal Kegiatan</p></a></li>
                <li class="nav-item"><a href="{{ route('katalog-buku.index') }}" class="nav-link"><i class="fa fa-qrcode nav-icon ml-2 text-info"></i><p>Notulen Rapat</p></a></li>
                <li class="nav-item"><a href="{{ route('katalog-buku.index') }}" class="nav-link"><i class="fa fa-qrcode nav-icon ml-2 text-info"></i><p>Surat Menyurat</p></a></li>
                <li class="nav-item"><a href="{{ route('katalog-buku.index') }}" class="nav-link"><i class="fa fa-qrcode nav-icon ml-2 text-info"></i><p>Proposal</p></a></li>
                <li class="nav-item"><a href="{{ route('katalog-buku.index') }}" class="nav-link"><i class="fa fa-qrcode nav-icon ml-2 text-info"></i><p>Data Anggota</p></a></li>
                <li class="nav-item"><a href="{{ route('katalog-buku.index') }}" class="nav-link"><i class="fa fa-qrcode nav-icon ml-2 text-info"></i><p>SOP Organisasi</p></a></li>
                <li class="nav-item"><a href="{{ route('katalog-buku.index') }}" class="nav-link"><i class="fa fa-qrcode nav-icon ml-2 text-info"></i><p>Data Pilketos</p></a></li>
                <li class="nav-item"><a href="{{ route('katalog-buku.index') }}" class="nav-link"><i class="fa fa-qrcode nav-icon ml-2 text-info"></i><p>SOP</p></a></li>
                <li class="nav-item"><a href="{{ route('katalog-buku.index') }}" class="nav-link"><i class="fa fa-qrcode nav-icon ml-2 text-info"></i><p>SOP</p></a></li>
                {{-- blade-formatter-enable --}}
        </ul>
    </li>
@elseif ($namaProgram === 'Adm. Pelayanan Public')
    <li class="nav-item">
        <a href="#" class="nav-link">
            <i class="nav-icon fas fa-table"></i>
            <p>
                {{ $namaProgram }}
                <i class="fas fa-angle-left right"></i>
            </p>
        </a>
        <ul class="nav nav-treeview pl-2">
            {{-- blade-formatter-disable --}}
                <li class="nav-item"><a href="{{ route('katalog-buku.index') }}" class="nav-link"><i class="fa fa-qrcode nav-icon ml-2 text-info"></i><p>Surat Keterangan</p></a></li>
                <li class="nav-item"><a href="{{ route('katalog-buku.index') }}" class="nav-link"><i class="fa fa-qrcode nav-icon ml-2 text-info"></i><p>Buku Pengaduan</p></a></li>
                <li class="nav-item"><a href="{{ route('katalog-buku.index') }}" class="nav-link"><i class="fa fa-qrcode nav-icon ml-2 text-info"></i><p>Log Pelayanan</p></a></li>
                <li class="nav-item"><a href="{{ route('katalog-buku.index') }}" class="nav-link"><i class="fa fa-qrcode nav-icon ml-2 text-info"></i><p>Dokumentasi </p></a></li>
                <li class="nav-item"><a href="{{ route('katalog-buku.index') }}" class="nav-link"><i class="fa fa-qrcode nav-icon ml-2 text-info"></i><p>Survei Kepuasan</p></a></li>
                <li class="nav-item"><a href="{{ route('katalog-buku.index') }}" class="nav-link"><i class="fa fa-qrcode nav-icon ml-2 text-info"></i><p>SOP</p></a></li>
                <li class="nav-item"><a href="{{ route('katalog-buku.index') }}" class="nav-link"><i class="fa fa-qrcode nav-icon ml-2 text-info"></i><p>SOP</p></a></li>
                <li class="nav-item"><a href="{{ route('katalog-buku.index') }}" class="nav-link"><i class="fa fa-qrcode nav-icon ml-2 text-info"></i><p>SOP</p></a></li>
                <li class="nav-item"><a href="{{ route('katalog-buku.index') }}" class="nav-link"><i class="fa fa-qrcode nav-icon ml-2 text-info"></i><p>SOP</p></a></li>
                {{-- blade-formatter-enable --}}
        </ul>
    </li>
@elseif ($namaProgram === 'Waka Kurikulum')
@else
@endif

{{-- <li class="nav-item">
    <a href="#" class="nav-link">
        <i class="nav-icon fa fa-mail-bulk"></i>
        <p>
            Arsip Surat
            <i class="fas fa-angle-left right"></i>
        </p>
    </a>
    <ul class="nav nav-treeview">
        <li class="nav-item">
            <a href="#" class="nav-link">
                <i class="fa fa-file-archive nav-icon"></i>
                <p>Surat Masuk</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="#" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Surat Keluar</p>
            </a>
        </li>
    </ul>
</li>
<li class="nav-item">
    <a href="#" class="nav-link">
        <i class="nav-icon fas fa-table"></i>
        <p>
            Rapat
            <i class="fas fa-angle-left right"></i>
        </p>
    </a>
    <ul class="nav nav-treeview">
        <li class="nav-item">
            <a href="#" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Data 1</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="#" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Data 2</p>
            </a>
        </li>
    </ul>
</li>
<li class="nav-item ">
    <a href="#" class="nav-link">
        <i class="nav-icon fas fa-table"></i>
        <p>
            Dokumen SOP
        </p>
    </a>
</li>
<li class="nav-item ">
    <a href="#" class="nav-link">
        <i class="nav-icon fas fa-table"></i>
        <p>
            Surat Keputusan
        </p>
    </a>
</li>
<li class="nav-item menu-open ">
    <a href="#" class="nav-link active">
        <i class="nav-icon fa fa-tools"></i>
        <p>Dokumen Pemberkasan</p>
    </a>
</li>
<li class="nav-item">
    <a href="#" class="nav-link">
        <i class="nav-icon fa fa-mail-bulk"></i>
        <p>
            Akreditasi
            <i class="fas fa-angle-left right"></i>
        </p>
    </a>
    <ul class="nav nav-treeview">
        <li class="nav-item">
            <a href="#" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>---------</p>
            </a>
        </li>
    </ul>
</li>
<li class="nav-item">
    <a href="#" class="nav-link">
        <i class="nav-icon fa fa-archive"></i>
        <p>
            PKKM / PKKS
            <i class="fas fa-angle-left right"></i>
        </p>
    </a>
    <ul class="nav nav-treeview">
        <li class="nav-item">
            <a href="#" class="nav-link">
                <i class="far fa-circle nav-icon"></i>

                <p>---------</p>
            </a>
        </li>
    </ul>
</li> --}}
