@php
    $etapels = App\Models\Admin\Etapel::where('aktiv', 'Y')->first();
    $data_laboratoriums = App\Models\Laboratorium\RiwayatLaboratorium::with('elaboratorium')
        ->where('detailguru_id', Auth::user()->detailguru_id)
        ->where('tapel_id', $etapels->id)
        ->get();
        // dump($data_laboratoriums);
        // http://127.0.0.1:8000/laboratorium/inventaris-laboratorium/1
@endphp

<li class="nav-item">
    <a href="#" class="nav-link">
        <i class="nav-icon fas fa-flask text-warning"></i> <!-- Ikon laboratorium -->
        <p>
            Data Laboratorium
            <i class="fas fa-angle-left right"></i>
        </p>
    </a>
    <ul class="nav nav-treeview">
        <!-- Jadwal Penggunaan -->
        <li class="nav-item">
            <a href="#" class="nav-link ml-2">
                <i class="fas fa-calendar-alt nav-icon text-primary"></i> <!-- Ikon jadwal -->
                <p>Jadwal Penggunaan</p>
                <i class="fas fa-angle-left right pr-2"></i>
            </a>
            <ul class="nav nav-treeview ml-2">
                @foreach ($data_laboratoriums as $laboratorium)
                    <li class="nav-item">
                        <a href="{{ url('laboratorium/jadwal-laboratorium/' . $laboratorium->laboratorium_id) }}" class="nav-link">
                            <i class="fas fa-microscope nav-icon text-info ml-2"></i> <!-- Ikon laboratorium -->
                            <p>{{ $laboratorium->elaboratorium->nama_laboratorium }}</p>
                        </a>
                    </li>
                @endforeach
            </ul>
        </li>

        <!-- Peraturan Lab -->
        <li class="nav-item">
            <a href="#" class="nav-link ml-2">
                <i class="fas fa-clipboard-list nav-icon text-danger"></i> <!-- Ikon peraturan -->
                <p>Peraturan Lab</p>
                <i class="fas fa-angle-left right pr-2"></i>
            </a>
            <ul class="nav nav-treeview ml-2">
                @foreach ($data_laboratoriums as $laboratorium)
                    <li class="nav-item">
                        <a href="{{ url('laboratorium/peraturan-laboratorium/' . $laboratorium->laboratorium_id) }}" class="nav-link">
                            <i class="fas fa-exclamation-triangle nav-icon text-warning ml-2"></i> <!-- Ikon peringatan -->
                            <p>{{ $laboratorium->elaboratorium->nama_laboratorium }}</p>
                        </a>
                    </li>
                @endforeach
            </ul>
        </li>

        <!-- Inventaris -->
        <li class="nav-item">
            <a href="{{ route('pengaturan-laboratorium.index') }}" class="nav-link ml-2">
                <i class="fas fa-boxes nav-icon text-success"></i> <!-- Ikon inventaris -->
                <p>Inventaris</p>
                <i class="fas fa-angle-left right pr-2"></i>
            </a>
            <ul class="nav nav-treeview ml-2">
                @foreach ($data_laboratoriums as $laboratorium)
                    <li class="nav-item">
                        <a href="{{ url('laboratorium/inventaris-laboratorium/' . $laboratorium->ruang_id) }}" class="nav-link">
                            <i class="fas fa-warehouse nav-icon text-secondary ml-2"></i> <!-- Ikon penyimpanan -->
                            <p>{{ $laboratorium->elaboratorium->nama_laboratorium }}</p>
                        </a>
                    </li>
                @endforeach
            </ul>
        </li>
    </ul>
</li>
