<li class="nav-item">
    <a href="#" class="nav-link">
        <i class="nav-icon fa fa-money-bill-wave"></i>
        <p>
            Rencana Anggaran
            <i class="fas fa-angle-left right"></i>
        </p>
    </a>
    <ul class="nav nav-treeview">
        <li class="nav-item">
            <a href="{{ route('rencana-anggaran-list.index') }}" class="nav-link">
                <i class="fa fa-edit nav-icon ml-2 text-info"></i>
                <p class=''> Data List </p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('rencana-anggaran-sekolah.index') }}" class="nav-link">
                <i class="fa fa-edit nav-icon ml-2 text-info"></i>
                <p class=''> Data Rencana </p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('InputKomite') }}" class="nav-link">
                <i class="fa fa-edit nav-icon ml-2 text-info"></i>
                <p class=''> RKAS </p>
            </a>
        </li>
    </ul>
</li>
