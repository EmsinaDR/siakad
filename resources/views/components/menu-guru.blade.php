@php
    use App\Models\Learning\Emengajar;
    use App\Models\Admin\Etapel;
    use App\Models\Admin\Emapel;
    use Illuminate\Support\Str;
    use App\Models\Admin\Ekelas;
    use App\Models\Auth\User;

    // $mengajar = Emengajar::select('name')->where('detailguru_id', 2)->get();
    $etapel = etapel::where('aktiv', 'Y')->first();

    // dd($etapel->semester);

    $mengajars = Emengajar::where('semester', $etapel->semester)
        ->where('detailguru_id', Auth::User()->id)
        // ->orderBy('kelas_id', 'asc')
        ->get()
        ->toArray();
    // dd($etapel->semester);

    // dd($mengajars);

    if ($mengajars === []) {
        $newdatamateri = [];
    } else {
        $mengajars = Emengajar::with(['emengajartomapel', 'emengajartokelas'])
            ->where('semester', $etapel->semester)
            ->where('detailguru_id', Auth::User()->id)
            // ->orderBy('kelas_id', 'asc')
            ->get();
        $kelompok = $mengajars->groupby('tingkat_id')->groupby('mapel_id');
        // dd($kelompok);
        $kelasmengajar = Ekelas::where('detailguru_id', Auth::User()->id)
            ->where('tapel_id', $etapel->id)
            ->get();
        // dd($kelasmengajar);
        foreach ($mengajars as $datamengajar) {
            $datamengajars[] = $datamengajar;
        }
        $uniq = $mengajars->select('tingkat_id', 'mapel_id')->toArray();
        $Materis = array_map('unserialize', array_unique(array_map('serialize', $uniq)));
        foreach ($Materis as $materi) {
            $newdatamateri[] = $materi;
        }
    }
    // dd(empty($mengajars));
@endphp
{{-- Data Siswa --}}

<li class='nav-item menu-open'>
    <a href='#' class='nav-link active'>
        <i class='nav-icon fas fa-file-alt'></i>
        <p>Data Pendukung</p>
    </a>
</li>
<li class='nav-item'>
    <a href='{{ route('ekaldik.index') }}' class='nav-link'>

        <i class='fa fa-calendar-check nav-icon'></i>
        <p>E Kaldik</p>
    </a>
</li>

<li class='nav-item'>
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
</li>
{{-- Data Siswa Akhir --}}
{{-- E Learning --}}
<li class="nav-item menu-open">
    <a href="#" class="nav-link active">
        <i class="nav-icon fas fa-file-alt"></i>
        <p>E Learning</p>
    </a>
</li>

<li class="nav-item">
    <a href="#" class="nav-link">
        <i class="nav-icon fa fa-folder"></i>
        <p>
            E Materi
            <i class="fas fa-angle-left right"></i>
        </p>
    </a>
    <ul class="nav nav-treeview">
        {{-- {{ dd($newdatamateri) }} --}}
        @if ($newdatamateri === [])
        @else
            @foreach ($newdatamateri as $newdatamater)
                <li class="nav-item">
                    @php
                        $mapelkelas = Emapel::findOrFail($newdatamater['mapel_id']);
                    @endphp
                    {{-- {{app('request')->root()}}/emateri/{{ str::random(350) }}/{{ $newdatamater['mapel_id'] }}/{{ $datamengajar->semester }}/{{$newdatamater['tingkat_id']}}/{{ str::random(10) }} --}}
                    <a href="{{ app('request')->root() }}/elearning/{{ $newdatamater['mapel_id'] }}/{{ $datamengajar->semester }}/{{ $newdatamater['tingkat_id'] }}/{{ $datamengajar['kelas_id'] }}/data-materi"
                        class="nav-link">
                        <i class="fa fa-file nav-icon ml-2 text-info"></i>
                        <p class=''> {{ $mapelkelas->singkatan }} - {{ $newdatamater['tingkat_id'] }}</p>
                    </a>
                </li>
            @endforeach
        @endif
    </ul>
</li>
<li class="nav-item">
    <a href="#" class="nav-link">
        <i class="nav-icon fa fa-folder"></i>
        <p>
            E Jurnal Mengajar
            <i class="fas fa-angle-left right"></i>
        </p>
    </a>
    <ul class="nav nav-treeview">
        <li class="nav-item">
            @foreach ($mengajars as $datamengajar)
                {{-- {{app('request')->root()}}/ejurnalmengajar/{{ str::random(350) }}/{{ $datamengajar->mapel_id }}/{{ $datamengajar->semester }}/{{ $datamengajar->tingkat_id }}/{{ $datamengajar['kelas_id'] }}/{{ str::random(10) }} --}}

                <a href="{{ app('request')->root() }}/elearning/{{ $datamengajar['mapel_id'] }}/{{ $datamengajar->semester }}/{{ $newdatamater['tingkat_id'] }}/{{ $datamengajar['kelas_id'] }}/jurnal/ejurnalmengajar"
                    class="nav-link">

                    <i class="fa fa-file nav-icon ml-2 text-info"></i>
                    <p class=''> {{ $datamengajar->emengajartokelas->kelas }} -
                        {{ $datamengajar->emengajartomapel->singkatan }}</p>
                </a>
            @endforeach

        </li>
    </ul>
</li>

<li class="nav-item">
    <a href="#" class="nav-link">
        <i class="nav-icon fa  fa-folder"></i>
        <p>
            E Nilai
            <i class="fas fa-angle-left right"></i>
        </p>
    </a>
    <ul class="nav nav-treeview">
        <li class="nav-item">
            <a href="#" class="nav-link">
                <i class="nav-icon fa fa-cog text-info"></i>
                <p>
                    Nilai Tugas
                    <i class="fas fa-angle-left right"></i>
                </p>
            </a>
            <ul class="nav nav-treeview">
                <li class="nav-item col">
                    @foreach ($mengajars as $datamengajar)
                        <a href="{{ app('request')->root() }}/elearning/{{ $datamengajar->mapel_id }}/{{ $datamengajar->semester }}/{{ $datamengajar->tingkat_id }}/{{ $datamengajar['kelas_id'] }}/nilai/nilai-tugas/"
                            class="nav-link">
                            <i class="fa fa-file nav-icon ml-2 text-info"></i>
                            <p class='btn'> {{ $datamengajar->emengajartokelas->kelas }} -
                                {{ $datamengajar->emengajartomapel->singkatan }}</p>

                        </a>
                    @endforeach

                </li>
            </ul>
        </li>
    </ul>
    <ul class="nav nav-treeview">
        <li class="nav-item">
            <a href="#" class="nav-link">
                <i class="nav-icon fa fa-cog text-info"></i>
                <p>
                    Nilai Ulangan
                    <i class="fas fa-angle-left right"></i>
                </p>
            </a>
            <ul class="nav nav-treeview">
                <li class="nav-item col">
                    @foreach ($mengajars as $datamengajar)
                        <a href="{{ app('request')->root() }}/elearning/{{ $datamengajar->mapel_id }}/{{ $datamengajar->semester }}/{{ $datamengajar->tingkat_id }}/{{ $datamengajar['kelas_id'] }}/nilai/nilai-ulangan/"
                            class="nav-link">
                            <i class="fa fa-file nav-icon ml-2 text-info"></i>
                            <p class='btn'> {{ $datamengajar->emengajartokelas->kelas }} -
                                {{ $datamengajar->emengajartomapel->singkatan }}</p>

                        </a>
                    @endforeach

                </li>
            </ul>
        </li>
    </ul>
    <ul class="nav nav-treeview">
        <li class="nav-item">
            <a href="#" class="nav-link">
                <i class="nav-icon fa fa-cog text-info"></i>
                <p>
                    Nilai PTS / PAS
                    <i class="fas fa-angle-left right"></i>
                </p>
            </a>
            <ul class="nav nav-treeview">
                <li class="nav-item col">
                    @foreach ($mengajars as $datamengajar)
                        <a href="{{ app('request')->root() }}/elearning/{{ $datamengajar->mapel_id }}/{{ $datamengajar->semester }}/{{ $datamengajar->tingkat_id }}/{{ $datamengajar['kelas_id'] }}/nilai/nilai-tugas/"
                            class="nav-link">
                            <i class="fa fa-file nav-icon ml-2 text-info"></i>
                            <p class='btn'> {{ $datamengajar->emengajartokelas->kelas }} -
                                {{ $datamengajar->emengajartomapel->singkatan }}</p>

                        </a>
                    @endforeach

                </li>
            </ul>
        </li>
    </ul>


</li>

{{-- E Nilai Akhir --}}


{{-- E Learning Akhir --}}



<li class="nav-item">
    <a href="#" class="nav-link">
        <i class="nav-icon fa  fa-folder"></i>
        <p>
            Uji Kompetensi
            <i class="fas fa-angle-left right"></i>
        </p>
    </a>
    <ul class="nav nav-treeview">
        <li class="nav-item">
            <a href="#" class="nav-link">
                <i class="nav-icon fa fa-cog text-info"></i>
                <p>
                    E Tugas
                    <i class="fas fa-angle-left right"></i>
                </p>
            </a>
            {{-- <ul class="nav nav-treeview">
                <li class="nav-item col">
                    @foreach ($mengajars as $datamengajar)
                        <a href="{{ app('request')->root() }}/elearning/{{ $datamengajar->mapel_id }}/{{ $datamengajar->semester }}/{{ $datamengajar->tingkat_id }}/{{ $datamengajar['kelas_id'] }}/data-tugas/"
                            class="nav-link">
                            <i class="fa fa-file nav-icon ml-2 text-info"></i>
                            <p class='btn'> {{ $datamengajar->emengajartokelas->kelas }} -
                                {{ $datamengajar->emengajartomapel->singkatan }}</p>

                        </a>
                    @endforeach

                </li>

            </ul> --}}
            <ul class="nav nav-treeview">
                @if ($newdatamateri === [])
                @else
                    @foreach ($newdatamateri as $newdatamater)
                        <li class="nav-item">
                            @php
                                $mapelkelas = Emapel::findOrFail($newdatamater['mapel_id']);
                            @endphp
                            {{-- {{app('request')->root()}}/emateri/{{ str::random(350) }}/{{ $newdatamater['mapel_id'] }}/{{ $datamengajar->semester }}/{{$newdatamater['tingkat_id']}}/{{ str::random(10) }} --}}
                            <a href="{{ app('request')->root() }}/elearning/{{ $newdatamater['mapel_id'] }}/{{ $datamengajar->semester }}/{{ $datamengajar->tingkat_id }}/{{ $datamengajar['kelas_id'] }}/data-tugas/"
                                class="nav-link">
                                <i class="fa fa-file nav-icon ml-2 text-info"></i>
                                <p class=''> {{ $mapelkelas->singkatan }} -
                                    {{ $newdatamater['tingkat_id'] }}</p>
                            </a>
                        </li>
                    @endforeach
                @endif
            </ul>
        </li>

    </ul>
</li>


{{-- Perangkat Guru --}}
<li class="nav-item menu-open">
    <a href="#" class="nav-link active">
        <i class="nav-icon fas fa-file-alt"></i>
        <p>Perangkat</p>
    </a>
</li>
<li class="nav-item">
    <a href="#" class="nav-link">
        <i class="nav-icon fa fa-calendar-check"></i>
        <p>
            Perangkat Test
            <i class="fas fa-angle-left right"></i>
        </p>
    </a>
    <ul class="nav nav-treeview">
        <li class="nav-item">
            <a href="#" class="nav-link">
                <i class="fa fa-calendar-check nav-icon m-2"></i>
                <p>Jadwal Test</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="#" class="nav-link">
                <i class="fa fa-journal-whills nav-icon m-2"></i>

                <p>Peraturan Test</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="#" class="nav-link">
                <i class="fa fa-address-card nav-icon m-2"></i>

                <p>Kartu Test</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="#" class="nav-link">
                <i class="fa fa-file-alt nav-icon m-2"></i>

                <p>Dokumen Test</p>
            </a>
        </li>
    </ul>
</li>

{{-- Perangkat Guru Akhir --}}
