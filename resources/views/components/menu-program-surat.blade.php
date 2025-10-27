<li class="nav-item">
    <a href="#" class="nav-link text-primary">
        <i class="nav-icon fa fa-folder-open text-warning"></i>
        <p>
            Dokumen Surat
            <i class="pl-2 fas fa-angle-left right"></i>
        </p>
    </a>
    <ul class="nav nav-treeview">
        <li class="nav-item">
            <a href="{{ route('klasifikasi-surat.index') }}" class="nav-link text-success">
                <i class="pl-2 nav-icon fas fa-envelope-open-text"></i>
                <p>Klasifikasi Surat</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('surat-masuk.index') }}" class="nav-link text-info">
                <i class="pl-2 fas fa-inbox nav-icon"></i>
                <p>Surat Masuk</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('surat-keluar.index') }}" class="nav-link text-success">
                <i class="pl-2 fas fa-paper-plane nav-icon"></i>
                <p>Surat Keluar</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('surat-keputusan.index') }}" class="nav-link text-danger">
                <i class="pl-2 fas fa-bullhorn nav-icon"></i>
                <p>Surat Edaran</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('surat-keputusan.index') }}" class="nav-link text-secondary">
                <i class="pl-2 fas fa-handshake nav-icon"></i>
                <p>Surat MOU</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('surat-keputusan.index') }}" class="nav-link text-warning">
                <i class="pl-2 fas fa-file-alt nav-icon"></i>
                <p>Surat Keterangan</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('surat-program-kerja.index') }}" class="nav-link text-teal">
                <i class="pl-2 fas fa-tasks nav-icon"></i>
                <p>Program Kerja</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('adart.index') }}" class="nav-link text-muted">
                <i class="pl-2 fas fa-book nav-icon"></i>
                <p>ADART</p>
            </a>
        </li>
    </ul>
</li>
