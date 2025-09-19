
<li class="nav-item">
    <a href="#" class="nav-link bg-success text-white">
        <i class="nav-icon fa fa-file-archive"></i>
        <p>
            Supervisi
            <i class="fas fa-angle-left right"></i>
        </p>
    </a>
    <ul class="nav nav-treeview">
        <li class="nav-item">
            <a href="#" class="nav-link text-white bg-primary">
                <i class="fas fa-chalkboard-teacher nav-icon pl-2"></i>
                <p>Instrumen</p>
                <i class="fas fa-angle-left right"></i>
            </a>
            <ul class="nav nav-treeview p-2">
                <li class="nav-item">
                    <a href="{{ route('jadwal-pelajaran.index') }}" class="nav-link text-dark bg-light">
                        <i class="fas fa-calendar-alt nav-icon pl-2 text-info"></i>
                        <p>S. Perangkat</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('data-kkm.index') }}" class="nav-link text-dark bg-light">
                        <i class="fas fa-balance-scale nav-icon pl-2 text-warning"></i>
                        <p>S. KBM</p>
                    </a>
                </li>
            </ul>
        </li>
    </ul>
    <ul class="nav nav-treeview">

        <li class="nav-item">
            <a href="#" class="nav-link text-white bg-primary">
                <i class="fas fa-chalkboard-teacher nav-icon pl-2"></i>
                <p>Supervisi Perangkat</p>
                <i class="fas fa-angle-left right"></i>
            </a>
            <ul class="nav nav-treeview p-2">
                <li class="nav-item">
                    <a href="{{ route('jadwal-pelajaran.index') }}" class="nav-link text-dark bg-light">
                        <i class="fas fa-calendar-alt nav-icon pl-2 text-info"></i>
                        <p>Jadwal Supervisi</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('data-kkm.index') }}" class="nav-link text-dark bg-light">
                        <i class="fas fa-balance-scale nav-icon pl-2 text-warning"></i>
                        <p>Nilai Supervisi</p>
                    </a>
                </li>
            </ul>
        </li>
    </ul>
    <ul class="nav nav-treeview">

        <li class="nav-item">
            <a href="#" class="nav-link text-white bg-primary">
                <i class="fas fa-chalkboard-teacher nav-icon pl-2"></i>
                <p>Supervisi KBM</p>
                <i class="fas fa-angle-left right"></i>
            </a>
            <ul class="nav nav-treeview p-2">

                <li class="nav-item">
                    <a href="{{ route('jadwal-pelajaran.index') }}" class="nav-link text-dark bg-light">
                        <i class="fas fa-calendar-alt nav-icon pl-2 text-info"></i>
                        <p>Jadwal Supervisi</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('data-kkm.index') }}" class="nav-link text-dark bg-light">
                        <i class="fas fa-balance-scale nav-icon pl-2 text-warning"></i>
                        <p>Nilai Supervisi</p>
                    </a>
                </li>
            </ul>
        </li>
    </ul>
</li>
