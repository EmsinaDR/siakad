@php
// use App\Models\User\Guru\Detailguru;

// $UserDetailguru = App\Models\User\Guru\Detailguru::find(Auth::user()->detailguru_id)->first();
// dd(Auth::user()->id);
// dd(Auth::check());
// $UserDetailguru = $Gurus->firstWhere('id', optional(Auth::user())->detailguru_id);

if (Auth::check()) {
    $UserDetailguru = $Gurus->firstWhere('id', Auth::user()->detailguru_id);
}
$urlroot = app('request')->root();
// $Programs = Cache::remember('seting_program', now()->addHours(5), function () {
//     return \App\Models\Program\SetingPengguna::all();
// });
// dd($urlroot.'/dist/img/user2-160x160.jpg');

// dd($UserDetailguru);
@endphp

<aside class="main-sidebar sidebar-light-primary elevation-4">
    <!-- Brand Logo -->
    <!-- <a href="index3.html" class="brand-link">
    <img
      src="dist/img/AdminLTELogo.png"
      alt="AdminLTE Logo"
      class="brand-image img-circle elevation-3"
      style="opacity: 0.8"
    />
  -->

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex justify-content-center align-items-center">
            <div class="image">
                <a href="{{ route('profile.edit') }}">
                    {{-- blade-formatter-disable --}}
                                <img style="width:45px" src="{{ optional($UserDetailguru)->foto ? $urlroot . '/img/guru/' . $UserDetailguru->foto : $urlroot . '/img/guru/user-guru.png' }}" class="img-circle elevation-2" alt="User Image" />

                    {{-- blade-formatter-enable --}}
                </a>
            </div>
            <div class="info">
                <a href="{{ route('profile.edit') }}" class="d-block">{{ Auth::user()->name  ?? ''}}</a>
                    <span class="badge bg-primary">{{ Auth::user()->posisi ?? '' }}</span>
                @if($Identitas->paket === 'Kersama')
                    <span class="badge bg-primary">{{$Identitas->paket}}</span>
                @elseif($Identitas->paket === 'Premium')
                    <span class="badge bg-success">{{$Identitas->paket}}</span>
                @else
                    <span class="badge bg-warning">{{$Identitas->paket}}</span>
                @endif


            </div>
        </div>
        <div class="user-panel mt-2 d-flex justify-content-center align-items-center">
            <div class="info">

            </div>

        </div>


        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                {{-- <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false"> --}}
                <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
                <li class="nav-item bg-success rounded my-1">
                    <a href="{{{route('Dashborad')}}}" class="nav-link">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>Dashboard</p>
                    </a>
                </li>
                @if(Auth::user()->posisi === "Admindev")
                <x-menu-admin-dev></x-menu-admin-dev>
                    {{-- <x-menu-paket-kerjasama/> --}}
                    @php
                    $AdminControl = $Programs->where('nama_program', 'Admin')->first() ?? '';
                    // dd($AdminControl);
                    @endphp
                        @if($AdminControl->aktivasi !== NULL)
                            <x-menu-admin></x-menu-admin>
                        @else
                        @endif
                @endif
                @if(Auth::user()->posisi == "Admin")
                <!-- Admin -->
                <x-menu-admin></x-menu-admin>
                @endif
                {{-- Role Guru --}}
                @if(Auth::user()->posisi == "Guru")
                <x-menu-guru></x-menu-guru>
                @endif
                {{-- Rool Walkes --}}
                @if(Auth::user()->posisi == "Walkes")
                <x-menu-walkes></x-menu-walkes>
                @endif
                {{-- Rool Karyawan --}}
                @if(Auth::user()->posisi == "Karyawan" )
                <x-menu-karyawan></x-menu-karyawan>
                @endif
                {{-- Rool Waka --}}
                @if(Auth::user()->posisi == "Waka Kurikulum" or Auth::user()->posisi == "Waka Kesiswaan" or Auth::user()->posisi == "Waka Sarprass" or Auth::user()->posisi == "Waka Humas" or Auth::user()->posisi == "Admindev")
                {{-- <x-menu-waka></x-menu-waka> --}}
                @endif
                {{-- Rool BK / Rool Bimbingan Konseling --}}
                @if(Auth::user()->posisi == "Bimbingan Konseling")
                <x-menu-bimbingan-konseling></x-menu-bimbingan-konseling>
                @endif
                @if(Auth::user()->posisi == "Guru")
                {{--
                Akun Bendahara
                 --}}
                 @php
                 $isbendahara_komite = true;
                 @endphp
                @endif
                {{-- Bendahara BOS --}}
                @if(Auth::user()->posisi == "Bendahara BOS" or Auth::user()->posisi == "Guru")
                <x-menu-bendahara-bos></x-menu-bendahara-bos>
                @endif
                {{-- Bendahara Komite --}}
                @if(Auth::user()->posisi == "Bendahara Komite" or Auth::user()->posisi == "Admindev")
                {{-- <x-menu-bendahara-komite></x-menu-bendahara-komite> --}}
                @endif
                {{-- Bendahara Tabungan --}}
                @if(Auth::user()->posisi == "Bendahara Tabungan" or Auth::user()->posisi == "Guru")
                <x-menu-bendahara-tabungan></x-menu-bendahara-tabungan>
                @endif
                {{-- Study Tour --}}
                @if(Auth::user()->posisi == "Bendahara Study Tour")

                @endif
                {{-- Perpustakaan --}}
                @if(Auth::user()->posisi == "Panitia PPDB" or Auth::user()->posisi == "Guru" or Auth::user()->posisi == "Admindev")
                {{-- <x-menu-p-p-d-b></x-menu-p-p-d-b> --}}
                @endif
                {{-- Pembina Ekstra --}}
                @if(Auth::user()->posisi == "Pembina Ekstra" or Auth::user()->posisi == "Guru")
                <x-menu-pembina-ekstra></x-menu-pembina-ekstra>
                @endif
                {{-- Pembina Laboratorium --}}
                @if(Auth::user()->posisi == "Pembina Ekstra" or Auth::user()->posisi == "Guru" or Auth::user()->posisi == "Admindev")
                {{-- <x-menu-pembina-laboratorium></x-menu-pembina-laboratorium> --}}
                @endif
                @if(Auth::user()->posisi == "Panitia PPDB" or Auth::user()->posisi == "Guru" or Auth::user()->posisi == "Admindev")
                {{-- <x-menu-program-karyawan></x-menu-program-karyawan> --}}
                {{-- <x-menu-legalisir-ijazah></x-menu-legalisir-ijazah> --}}
                    {{-- <x-menu-buku-tamu></x-menu-buku-tamu>
                    <x-menu-program-tahfidz></x-menu-program-tahfidz>
                    <x-menu-program-btq></x-menu-program-btq>
                    <x-menu-pembina-shalat-jamaah></x-menu-pembina-shalat-jamaah>
                    <x-menu-program-rapat></x-menu-program-rapat>
                    <x-menu-dokumentasi></x-menu-dokumentasi>
                    <x-menu-program-p-k-k-s></x-menu-program-p-k-k-s>
                    <x-menu-program-sop></x-menu-program-sop>
                    <x-menu-program-supervisi></x-menu-program-supervisi>
                    <x-menu-sk-kepala></x-menu-sk-kepala>
                    <x-menu-program-template-dokumen></x-menu-program-template-dokumen>
                    <x-menu-program-c-b-t></x-menu-program-c-b-t> --}}
                    {{--
                    menu-program-tahfidz
                    menu-program-btq
                    menu-program-evote
                    menu-program-pilketos



                    php artisan make:component Name
                    php artisan make:component menu-program-pilketos --force

                    --}}

                @endif
                @if($Identitas->paket === 'Kerjasama')
                @elseif($Identitas->paket === 'Premium')
                {{-- Data Menu Program --}}
                @php
                    $authId = Auth::user()->detailguru_id;
                @endphp

{{-- Loop semua program --}}
@foreach ($Programs as $p)
    {{-- Waka Menu --}}
    {{-- @dump($p->isGuruTerlibat($authId), $authId); --}}
    @if (in_array(trim($p->nama_program), ['Waka Kurikulum', 'Waka Sarpras', 'Waka Kesiswaan', 'Waka Humas']) && $p->isGuruTerlibat($authId))
    {{-- @if (in_array(trim($p->nama_program), ['Waka Kurikulum', 'Waka Sarpras', 'Waka Kesiswaan', 'Waka Humas']) && in_array($authId, json_decode($data->detailguru_id, true))) --}}

        @if (!isset($wakilKepalaMenu))

                @if($p->aktivasi === 1)
                    @php $wakilKepalaMenu = true; @endphp
                    <li class="nav-item menu-open">
                        <a href="#" class="nav-link active">
                            <i class="nav-icon fa fa-tools"></i>
                            <p>Wakil Kepala</p>
                        </a>
                    </li>
                @endif
        @endif

        @if($p->aktivasi === 1)
            <x-menu-waka :nama-program="$p->nama_program" />
            <x-menu-program-sop />
            <x-menu-program-template-dokumen />
        @endif

    @endif


    {{-- Buku Tamu --}}
    @if ($p->nama_program === 'Buku Tamu' && $p->isGuruTerlibat($authId))
        <x-menu-buku-tamu />
    @elseif ($p->nama_program === 'Kepala Sekolah' && $p->isGuruTerlibat($authId))

        @if($p->aktivasi === 1)
            <x-menu-kepala />
            <x-menu-program-surat />
            <x-menu-program-sop />
                <x-menu-program-template-dokumen />
            @endif
        {{-- <x-menu-program-supervisi /> --}}
    {{-- Program Lainnya --}}

    @elseif ($p->nama_program === 'Tahfidz' && $p->isGuruTerlibat($authId))
        @if($p->aktivasi === 1)
        <x-menu-program-tahfidz />
        @endif
    @elseif ($p->nama_program === 'BTQ' && $p->isGuruTerlibat($authId))
        @if($p->aktivasi === 1)
        <x-menu-program-btq />
        @endif
    @elseif (in_array($p->nama_program, ['Shalat', 'Shalat Berjamaan']) && $p->isGuruTerlibat($authId))
        @if($p->aktivasi === 1)
        <x-menu-pembina-shalat-jamaah />
        @endif
    @elseif ($p->nama_program === 'Rapat' && $p->isGuruTerlibat($authId))
        @if($p->aktivasi === 1)
        <x-menu-program-rapat />
        @endif
    @elseif ($p->nama_program === 'Surat Menyurat' && $p->isGuruTerlibat($authId))
        @if($p->aktivasi === 1)
        <x-menu-program-surat />
        @endif
    @elseif ($p->nama_program === 'Dokumentasi' && $p->isGuruTerlibat($authId))
        @if($p->aktivasi === 1)
        <x-menu-dokumentasi />
        @endif
    @elseif ($p->nama_program === 'Pembina Osis' && $p->isGuruTerlibat($authId))
        @if($p->aktivasi === 1)
        <x-menu-program-pembina-osis />
        @endif
    @elseif ($p->nama_program === 'PPKS' && $p->isGuruTerlibat($authId))
        @if($p->aktivasi === 1)
        <x-menu-program-p-k-k-s />
        @endif
    @elseif ($p->nama_program === 'SOP' && $p->isGuruTerlibat($authId))
        @if($p->aktivasi === 1)
        <x-menu-program-sop />
        @endif
    @elseif ($p->nama_program === 'Supervisi' && $p->isGuruTerlibat($authId))
        @if($p->aktivasi === 1)
        <x-menu-program-supervisi />
        @endif
    @elseif ($p->nama_program === 'SK KEPALA' && $p->isGuruTerlibat($authId))
        @if($p->aktivasi === 1)
        <x-menu-sk-kepala />
        @endif
    @elseif ($p->nama_program === 'Template Dokumen' && $p->isGuruTerlibat($authId))
        @if($p->aktivasi === 1)
        <x-menu-program-template-dokumen />
        @endif
    @elseif ($p->nama_program === 'CBT' && $p->isGuruTerlibat($authId))
        @if($p->aktivasi === 1)
        <x-menu-program-c-b-t />
        @endif
    @elseif ($p->nama_program === 'Sertifikat' && $p->isGuruTerlibat($authId))
        @if($p->aktivasi === 1)
        <x-menu-sertifikat />
        @endif
    @elseif ($p->nama_program === 'Legalisir Ijazah' && $p->isGuruTerlibat($authId))
        @if($p->aktivasi === 1)
        <x-menu-legalisir-ijazah />
        @endif
    @elseif ($p->nama_program === 'Guru Piket' && $p->isGuruTerlibat($authId))
        @if($p->aktivasi === 1)
        <x-menu-guru-piket />
        @endif
    @elseif ($p->nama_program === 'Tagline' && $p->isGuruTerlibat($authId))
        @if($p->aktivasi === 1)
        <x-menu-tagline />
        @endif
    @elseif ($p->nama_program === 'Bimbingan Konseling' && $p->isGuruTerlibat($authId))
        @if($p->aktivasi === 1)
        <x-menu-bimbingan-konseling />
        @endif
    @elseif ($p->nama_program === 'Petugas Perpustakaan' && $p->isGuruTerlibat($authId))
        @if($p->aktivasi === 1)
        <x-menu-perpustakaan />
        @endif
    @elseif ($p->nama_program === 'Laboratorium' && $p->isGuruTerlibat($authId))
        @if($p->aktivasi === 1)
        <x-menu-pembina-laboratorium />
        @endif
    @elseif ($p->nama_program === 'Panitia PPDB' && $p->isGuruTerlibat($authId))
        @if($p->aktivasi === 1)
        <x-menu-p-p-d-b />
        @endif
    {{-- @elseif ($p->nama_program === 'Bendahara Komite' && $p->isGuruTerlibat($authId))
        @if($p->aktivasi === 1)
        <x-menu-bendahara-komite />
        @endif --}}
    @elseif ($p->nama_program === 'Karyawan' && $p->isGuruTerlibat($authId))
        @if($p->aktivasi === 1)
        {{-- <x-menu-program-karyawan /> --}}
        @endif
    @endif
    @if (in_array(trim($p->nama_program), ['Adm. Kesiswaan', 'Adm. Sarpras', 'Adm. Kurikulum', 'Adm. Keuangan', 'Adm. Kepegawaian', 'Adm. Surat Menyurat', 'Adm. Umum', 'Adm. Penilaian & Ujian', 'Adm. PPDB', 'Adm. Ekstrakurikuler', 'Adm. OSIS', 'Adm. Pelayanan Public']
) && $p->isGuruTerlibat($authId))
        @if (!isset($AdmMenu))

                @if($p->aktivasi === 1)
                    @php $AdmMenu = true; @endphp
                    <li class="nav-item menu-open">
                        <a href="#" class="nav-link active">
                            <i class="nav-icon fa fa-tools"></i>
                            <p>Administrasi TU</p>
                        </a>
                    </li>
                @endif
        @endif

        @if($p->aktivasi === 1)
            <x-menu-karyawan :nama-program="$p->nama_program" />
        @endif


    @endif
    @if (in_array(trim($p->nama_program), ['Bendahara Komite', 'Bendahara Tabungan', 'Bendahara BOS', 'Bendahara CSR', 'Bendahara PIP']
) && $p->isGuruTerlibat($authId))
        @if (!isset($BendaharaMenu))

        @php
            $pendingCount = Cache::remember('transfer_pending_count', now()->addMinutes(10), function () use ($Tapels) {
                return \App\Models\Bendahara\Transfer\TransferPembayaran::where('tapel_id', $Tapels->id)
                    ->where('status', 'Pending')
                    ->count() ?? '';
            });
        @endphp
                @if($p->aktivasi === 1)
                    @php $BendaharaMenu = true; @endphp
                    <li class="nav-item menu-open">
                        <a href="#" class="nav-link active">
                            <i class="nav-icon fa fa-coins"></i>
                            <p>Bendahara</p>
                        </a>
                    </li>
<li class="nav-item">
    <a href="{{ route('transfer-pembayaran.index') }}" class="nav-link d-flex justify-content-between align-items-center">
        <div>
            <i class="fa fa-cogs nav-icon text-info"></i>
            <p class="d-inline mb-0">Transfer Uang</p>
        </div>
        <span class="badge bg-primary rounded-circle text-white d-flex align-items-center justify-content-center">
            {{$pendingCount}}
        </span>
    </a>
</li>

                @endif
                <x-bendahara-rencana-anggaran />
        @endif

        @if($p->aktivasi === 1)
            <x-menu-bendahara :nama-program="$p->nama_program" />

        @endif


    @endif



@endforeach
                @else
                @endif
<x-menu-aplikasi></x-menu-aplikasi>

            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
