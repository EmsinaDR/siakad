<li class="nav-item">
    <a href="#" class="nav-link">
        <i class="nav-icon fa fa-folder text-primary"></i>
        <p>
            Supervisi
            <i class="fas fa-angle-left right"></i>
        </p>
    </a>
    <ul class="nav nav-treeview ml-2">

        <li class="nav-item">
            <a href="{{ route('instrument-supervisi.index') }}" class="nav-link">
                <i class="fas fa-file-alt nav-icon ml-2 text-info"></i>
                <p> Instrumen </p>
            </a>
        </li>
        <!-- Jadwal Supervisi -->
        <li class="nav-item">
            <a href="#" class="nav-link">
                <i class="fas fa-user-tie nav-icon ml-2 text-primary"></i>
                <p> Jadwal Supervisi </p>
                <i class="fas fa-angle-left right"></i>
            </a>
            <ul class="nav nav-treeview ml-2">
                <li class="nav-item">
                    <a href="{{ route('jadwal-supervisi-waka.index') }}" class="nav-link">
                        <i class="fas fa-user-graduate nav-icon ml-2 text-primary"></i>
                        <p> Kategori Waka</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('jadwal-supervisi-guru.index') }}" class="nav-link">
                        <i class="fas fa-users nav-icon ml-2 text-success"></i>
                        <p> Kategori Guru </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('jadwal-supervisi-laboratorium.index') }}" class="nav-link">
                        <i class="fas fa-tools nav-icon ml-2 text-warning"></i>
                        <p> Kategori Laboratorium </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('jadwal-supervisi-perpustakaan.index') }}" class="nav-link">
                        <i class="fas fa-tools nav-icon ml-2 text-warning"></i>
                        <p> Perpustakaan </p>
                    </a>
                </li>
            </ul>
        </li>

        <!-- Supervisi Waka -->
        <li class="nav-item">
            <a href="#" class="nav-link">
                <i class="fas fa-user-tie nav-icon ml-2 text-primary"></i>
                <p> Supervisi Waka </p>
                <i class="fas fa-angle-left right"></i>
            </a>
            <ul class="nav nav-treeview ml-2">
                <li class="nav-item">
                    <a href="{{ route('supervisi-waka-kurikulum.index') }}" class="nav-link">
                        <i class="fas fa-user-graduate nav-icon ml-2 text-primary"></i>
                        <p> Waka Kurikulum </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('supervisi-waka-kesiswaan.index') }}" class="nav-link">
                        <i class="fas fa-users nav-icon ml-2 text-success"></i>
                        <p> Waka Kesiswaan </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('supervisi-waka-sarpras.index') }}" class="nav-link">
                        <i class="fas fa-tools nav-icon ml-2 text-warning"></i>
                        <p> Waka Sarpras </p>
                    </a>
                </li>
            </ul>
        </li>

        <!-- Supervisi Guru -->
        <li class="nav-item">
            <a href="#" class="nav-link">
                <i class="fas fa-chalkboard-teacher nav-icon ml-2 text-success"></i>
                <p> Supervisi Guru </p>
                <i class="fas fa-angle-left right"></i>
            </a>
            <ul class="nav nav-treeview ml-2">
                <li class="nav-item">
                    <a href="{{ route('supervisi-pembelajaran.index') }}" class="nav-link">
                        <i class="fas fa-book-open nav-icon ml-2 text-success"></i>
                        <p> Pembelajaran </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('supervisi-perangkat-guru.index') }}" class="nav-link">
                        <i class="fas fa-folder-open nav-icon ml-2 text-secondary"></i>
                        <p> Perangkat </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('supervisi-atp-guru.index') }}" class="nav-link">
                        <i class="fas fa-tasks nav-icon ml-2 text-warning"></i>
                        <p> ATP </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('supervisi-modul-ajar-guru.index') }}" class="nav-link">
                        <i class="fas fa-file-alt nav-icon ml-2 text-danger"></i>
                        <p> Modul Ajar </p>
                    </a>
                </li>
            </ul>
        </li>

        <!-- Supervisi Labs -->
        <li class="nav-item">
            <a href="#" class="nav-link">
                <i class="fas fa-flask nav-icon ml-2 text-warning"></i>
                <p> Supervisi Labs </p>
                <i class="fas fa-angle-left right"></i>
            </a>
            <ul class="nav nav-treeview ml-2">
                <li class="nav-item">
                    <a href="{{ route('supervisi-laboran.index') }}" class="nav-link">
                        <i class="fas fa-user-cog nav-icon ml-2 text-info"></i>
                        <p> Laboran </p>
                    </a>
                </li>
                @php
                    $etapels = \App\Models\Admin\Etapel::where('aktiv', 'Y')->first();
                    $DataLabs = \App\Models\Laboratorium\RiwayatLaboratorium::where('tapel_id', $etapels->id)->get();
                @endphp
                @foreach ($DataLabs as $DataLab)
                    <li class="nav-item">
                        <a href="{{ route('riwayat-hafalan.index') }}" class="nav-link">
                            <i class="fas fa-vials nav-icon ml-2 text-warning"></i>
                            <p> {{ $DataLab->LaboratoriumOne->nama_laboratorium }} </p>
                        </a>
                    </li>
                @endforeach
            </ul>
        </li>

        <!-- Supervisi Perpustakaan -->
        <li class="nav-item">
            <a href="{{ route('supervisi-perpustakaan.index') }}" class="nav-link">
                <i class="fas fa-book nav-icon ml-2 text-danger"></i>
                <p> Supervisi Perpus </p>
            </a>
        </li>

        <!-- Supervisi Wali Kelas -->
        <li class="nav-item">
            <a href="{{ route('supervisi-wali-kelas.index') }}" class="nav-link">
                <i class="fas fa-user-friends nav-icon ml-2 text-purple"></i>
                <p> Supervisi Wali Kelas </p>
            </a>
        </li>

    </ul>
</li>
