<li class="nav-item">
    <a href="#" class="nav-link">
        <i class="nav-icon fas fa-comments text-success"></i>
        <p>
            WhatsApp
            <i class="fas fa-angle-left right"></i>
        </p>
    </a>
    <ul class="nav nav-treeview">
        <li class="nav-item">
            <a href="{{ route('whatsappqrcode') }}" class="nav-link">
                <i class="fas fa-qrcode nav-icon text-primary ml-2"></i>
                <p>Dashboard</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('whatsappqrcode') }}" class="nav-link">
                <i class="fas fa-server nav-icon text-info ml-2"></i>
                <p>Server</p>
            </a>
        </li>
        {{-- <li class="nav-item">
            <a href="{{ route('kirimpesan.masal') }}" class="nav-link">
                <i class="fas fa-paper-plane nav-icon text-success ml-2"></i>
                <p>Kirim Pesan</p>
            </a>
        </li> --}}
        <li class="nav-item">

            <a href="#" class="nav-link ml-2">
                <i class="nav-icon fa fa-calendar-day text-success"></i>
                <p>
                    Penjadwalan
                    <i class="fas fa-angle-left right"></i>
                </p>
            </a>
            <ul class="nav nav-treeview">
                <li class="nav-item ml-2">
                    <a href="{{ route('penjadwalan.index') }}" class="nav-link">
                        <i class="fas fa-server nav-icon text-info ml-2"></i>
                        <p>Internal</p>
                    </a>
                </li>
                <li class="nav-item ml-2">
                    <a href="{{ route('penjadwalan-ppdb.index') }}" class="nav-link {{ !$IsPaketAktif ? 'disabled' : '' }}">
                        <i class="fas fa-server nav-icon text-info ml-2"></i>
                        <p>PPDB Sosialisasi</p>
                         {!! !$IsPaketAktif ? '<span class="right badge badge-warning">PR</span>' : '' !!}
                    </a>
                </li>
                <li class="nav-item ml-2">
                    <a href="{{ route('penjadwalan-ppdb.index') }}" class="nav-link {{ !$IsPaketAktif ? 'disabled' : '' }}">
                        <i class="fas fa-server nav-icon text-info ml-2"></i>
                        <p>PPDB MPLS</p>
                         {!! !$IsPaketAktif ? '<span class="right badge badge-warning">PR</span>' : '' !!}

                    </a>
                </li>
            </ul>
        </li>
        <li class="nav-item">
            <a href="{{ route('kirimpesan.masal') }}" class="nav-link {{ !$IsPaketAktif ? 'disabled' : '' }}">
                <i class="fas fa-robot nav-icon text-warning ml-2"></i>
                <p>Auto Responder</p>
                {!! !$IsPaketAktif ? '<span class="right badge badge-warning">PR</span>' : '' !!}
            </a>
        </li>
    </ul>
</li>
