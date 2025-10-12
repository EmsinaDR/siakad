{{-- <li class="nav-item menu-open">
    <a href="#" class="nav-link active">
        <i class="nav-icon fa fa-university"></i>
        <p>Data Keuangan</p>
    </a>
</li>

<li class="nav-item">
    <a href="#" class="nav-link">
        <i class="fa fa-users nav-icon text-info"></i>
        <p class=''> Data Siswa </p>
    </a>
</li> --}}
@php
    // ::where('id', query)next->get();
    // $my_ekstra = App\WakaKesiswaan\Ekstra\RiwayatEkstra::where('tapel_id', $etapels->id)->where('detailguru_id', Auth::user()->id)->pluck('id')->toArray();

    $etapels = App\Models\Admin\Etapel::where('aktiv', 'Y')->first();
    $my_ekstras = App\Models\WakaKesiswaan\Ekstra\RiwayatEkstra::where('tapel_id', $etapels->id)
        ->where('detailguru_id', Auth::user()->id)
        ->get();
    $menu_materi = 'aktiv';
    $menu_jurnal = 'aktiv'; // aktiv or disabled
    // dd($my_ekstras);
@endphp
<li class="nav-item">
    <a href="#" class="nav-link">
        <i class="nav-icon fa fa-user-tie"></i>
        <p>
            Pembina Ekstra
            <i class="fas fa-angle-left right"></i>
        </p>
    </a>
    <ul class="nav nav-treeview">
        <li class="nav-item">
            <a href="#" class="nav-link">
                <i class="nav-icon fa fa-users nav-icon ml-2 text-info"></i>
                <p>
                    Data Peserta
                    <i class="fas fa-angle-left right"></i>
                </p>
            </a>
            <ul class="nav nav-treeview p-2">
                @foreach ($my_ekstras as $ekstra)
                    <li class="nav-item">
                        <a href="{{ app('request')->root() }}/ekstrakurikuler/peserta-ekstra/{{ $ekstra->id }}"
                            class="nav-link">
                            <i class="fa fa-user nav-icon ml-2 text-info"></i>
                            <p>{{ $ekstra->ekstra->ekstra }}</p>
                        </a>
                    </li>
                @endforeach
            </ul>
        </li>
        <li class="nav-item">
            <a href="#" class="nav-link">
                <i class="fa fa-calendar-check nav-icon ml-2 text-info"></i>
                <p>Absensi Ekstra
                    <i class="fas fa-angle-left right"></i>
                </p>
            </a>
            <ul class="nav nav-treeview p-2">
                @foreach ($my_ekstras as $ekstra)
                    <li class="nav-item">
                        <a href="{{ app('request')->root() }}/ekstrakurikuler/absensi-ekstra/{{ $ekstra->id }}"
                            class="nav-link">
                            <i class="fa fa-user-check nav-icon ml-2 text-info"></i>
                            <p>{{ $ekstra->ekstra->ekstra }}</p>
                        </a>
                    </li>
                @endforeach
            </ul>
        </li>
        {{-- Jurnal Ekstra --}}
        <li class="nav-item">
            <a href="#" class="nav-link {{ $menu_jurnal }}">
                <i class="fa fa-book nav-icon ml-2 text-info"></i>
                <p>Jurnal Ekstra
                    @if ($menu_jurnal !== 'disabled')
                        <i class="fas fa-angle-left right"></i>
                    @else
                        <span class="badge badge-warning right">CS</span>
                    @endif
                </p>
            </a>
            <ul class="nav nav-treeview p-2">
                @foreach ($my_ekstras as $ekstra)
                    <li class="nav-item">
                        <a href="{{ app('request')->root() }}/ekstrakurikuler/jurnal-ekstra/{{ $ekstra->id }}"
                            class="nav-link">
                            <i class="fa fa-book-reader nav-icon ml-2 text-info"></i>
                            <p>{{ $ekstra->ekstra->ekstra }}</p>
                        </a>
                    </li>
                @endforeach
            </ul>
        </li>
        {{-- Jurnal Ekstra --}}
        {{-- Materi Ekstra --}}
        <li class="nav-item">
            <a href="#" class="nav-link {{ $menu_materi }}">
                <i class="fa fa-book nav-icon ml-2 text-info"></i>
                <p>Materi Ekstra
                    @if ($menu_materi !== 'disabled')
                        <i class="fas fa-angle-left right"></i>
                    @else
                        <span class="badge badge-warning right">CS</span>
                    @endif
                </p>
            </a>
            <ul class="nav nav-treeview p-2">
                @foreach ($my_ekstras as $ekstra)
                    <li class="nav-item">
                        <a href="{{ app('request')->root() }}/ekstrakurikuler/materi-ekstra/{{ $ekstra->id }}"
                            class="nav-link">
                            <i class="fa fa-book-reader nav-icon ml-2 text-info"></i>
                            <p>{{ $ekstra->ekstra->ekstra }}</p>
                        </a>
                    </li>
                @endforeach
            </ul>
        </li>
        {{-- Materi Ekstra --}}
        <li class="nav-item">
            <a href="{{ app('request')->root() }}/ekstrakurikuler/pengaturan-ekstra/{{ $ekstra->id }}" class="nav-link">
                <i class="fa fa-cogs nav-icon ml-2 text-info"></i>
                <p>Pengaturan</p>
            </a>
        </li>
    </ul>
</li>

{{--
php artisan make:controller WakaKesiswaan/Ekstra/PesertaEkstraController -m WakaKesiswaan/Ekstra/PesertaEkstra
php artisan make:controller WakaKesiswaan/Ekstra/DaftarHadirEkstraController -m WakaKesiswaan/Ekstra/DaftarHadirEkstra
php artisan make:controller WakaKesiswaan/Ekstra/JadwalEkstraController -m WakaKesiswaan/Ekstra/JadwalEkstra
php artisan make:controller WakaKesiswaan/Ekstra/PengaturanEkstraController -m WakaKesiswaan/Ekstra/PengaturanEkstra
php artisan make:controller WakaKesiswaan/Ekstra/MateriEkstraController -m WakaKesiswaan/Ekstra/MateriEkstra

php artisan make:view role.pembina.ekstra.peserta-ekstra
php artisan make:view role.pembina.ekstra.daftar-hadir-ekstra
php artisan make:view role.pembina.ekstra.pengaturan-ekstra
php artisan make:view role.pembina.ekstra.materi-ekstra

--}}
{{--
@if ($menu_materi !== 'oke')
            <li class="nav-item">
                <a href="#" data-toggle="tooltip"class="nav-link">
                    <i class="fa fa-credit-card nav-icon ml-2 text-info"></i>
                    <p class=''> Materi Ekstra
                        <i class="fas fa-angle-left ml-2 right"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview p-2">
                    @foreach ($my_ekstras as $ekstra)
                        <li class="nav-item">
                            <a
                                href="{{ app('request')->root() }}/ekstrakurikuler/peserta-ekstra/{{ $ekstra->ekstra_id }}">
                                <div class="d-flex align-items-center">
                                    <i class="fa fa-tags nav-icon ml-2 text-info"></i>
                                    <p class="mb-0 ml-2">{{ $ekstra->ekstra->ekstra }}</p>
                                </div>
                            </a>
                        </li>
                    @endforeach
                </ul>
            </li>
        @else
            <li class="nav-item">
                <a href="#" class="nav-link d-flex justify-content-between align-items-center disable">
                    <div class="d-flex align-items-center">
                        <i class="fa fa-tags nav-icon ml-2 text-info"></i>
                        <p class="mb-0 ml-2">{{ $ekstra->ekstra->ekstra }}</p>
                    </div>
                    <span class="badge badge-warning">CS</span>
                </a>
                <ul class="nav nav-treeview p-2">
                </ul>

            </li>
        @endif
         --}}
