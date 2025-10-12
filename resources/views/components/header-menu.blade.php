@php
    // use App\Models\Identitas;

    // $Identitas = App\Models\Admin\Identitas::get()[0];
    // $UserDetailguru = App\Models\User\Guru\Detailguru::find(Auth::user()->detailguru_id)->first();
    // $Identitas = $Identitas[0];
@endphp
{{-- {{ dd($Identitas['namasek']) }} --}}

<!-- Navbar -->
<style>
    .menu-header {
        display: flex;
        flex-direction: column;
        width: 100%;
    }

    .header-menu-nav {
        display: flex;
        /* background-color: red; */
        flex-direction: row;
        justify-content: space-between;
        align-items: center;

    }

    .title-sekolah {
        display: flex;
        flex-direction: row;
        margin-bottom: 5px;
        border-bottom: 10px solid #F4F6F9;
    }

    .menu-header>.title-sekolah>span {
        margin-top: 3px;
        color: red;
    }

    .title-sekolah h2 {
        margin-bottom: 5px;
        font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif;
    }

    .title-logo {
        display: flex;
        flex-direction: column;

        margin-bottom: 5px;
        /* justify-content: start; */
        align-items: start;
    }

    .title-sekolah img {
        border-radius: 50%;
        border: 2px solid #F4F6F9;
        height: 75px;
        margin-right: 25px;
        margin-bottom: 5px;
        margin-left: 20px;
    }
</style>
<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <div class="menu-header">
        <div class="title-sekolah">
            @php
                $logoPath = public_path('img/logo.png');
            @endphp

            <img src="{{ asset(file_exists($logoPath) ? 'img/logo.png' : 'img/dev/logodev.png') }}" alt="Logo">

            {{-- <img src="{{ asset('/img/logo.png') }}" alt=""> --}}

            <div class="title-logo">
                <h3>{{ $Identitas->namasek }}</h3>
                <span class="fs-7 fs-lg-5">{{ $Identitas->alamat }} <i class="fa fa-phone"></i>
                    {{ $Identitas->phone }}</span>
            </div>
            <hr>

        </div>
        <div class="header-menu-nav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i
                            class="fas fa-bars"></i></a>
                </li>
                {{-- <li class="nav-item d-none d-sm-inline-block">
                    <a href="index3.html" class="nav-link">Home</a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="#" class="nav-link">Contact</a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="#" class="nav-link">Data Order</a>
                </li> --}}
            </ul>
            {{-- Pengecekan Versi Gratis, Basic, Trial, Premium --}}
            @if (isset($Identitas) && $Identitas->paket === 'Trial')
                @php
                    $trialEnd = \Carbon\Carbon::parse($Identitas->trial_ends_at);
                    $now = \Carbon\Carbon::now();
                    $daysLeft = $now->diffInDays($trialEnd, false);
                @endphp

                @if ($daysLeft > 0)
                    <span style="background: orange; color: white; padding: 5px 10px; border-radius: 5px;">
                        🚨 Trial {{ number_format($daysLeft, 0) }} Hari
                    </span>
                @endif
            @else
                <span style="background: rgb(0, 59, 15); color: white; padding: 5px 10px; border-radius: 5px;">
                    🏅 {{ $Identitas->paket }}
                </span>

            @endif
            <!-- Right navbar links -->
            <ul class="navbar-nav ml-auto">
                <!-- Messages Dropdown Menu -->
                {{-- <li class="nav-item dropdown">
                    <a class="nav-link" data-toggle="dropdown" href="#">
                        <i class="far fa-comments"></i>
                        <span class="badge badge-danger navbar-badge">3</span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                        <a href="#" class="dropdown-item">

                            <div class="media">
                                <img src="{{ app('request')->root() }}dist/img/user1-128x128.jpg" alt="User Avatar"
                                    class="img-size-50 mr-3 img-circle" />

                                <div class="media-body">
                                    <h3 class="dropdown-item-title">
                                        Brad Diesel
                                        <span class="float-right text-sm text-danger"><i class="fas fa-star"></i></span>
                                    </h3>
                                    <p class="text-sm">Call me whenever you can...</p>
                                    <p class="text-sm text-muted">
                                        <i class="far fa-clock mr-1"></i> 4 Hours Ago
                                    </p>
                                </div>
                            </div>

                        </a>
                        <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item">

                            <div class="media">
                                <img style="width:45px"
                                    src="{{ $UserDetailguru->foto ? app('request')->root() . '/img/guru/' . $UserDetailguru->foto : app('request')->root() . '/dist/img/user2-160x160.jpg' }}"
                                    class="img-circle elevation-2" alt="User Image" />
                                <div class="media-body">
                                    <h3 class="dropdown-item-title">
                                        John Pierce
                                        <span class="float-right text-sm text-muted"><i class="fas fa-star"></i></span>
                                    </h3>
                                    <p class="text-sm">I got your message bro</p>
                                    <p class="text-sm text-muted">
                                        <i class="far fa-clock mr-1"></i> 4 Hours Ago
                                    </p>
                                </div>
                            </div>
                        </a>
                        <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item">
                            <div class="media">
                                <img style="width:45px"
                                    src="{{ $UserDetailguru->foto ? app('request')->root() . '/img/guru/' . $UserDetailguru->foto : app('request')->root() . '/dist/img/user2-160x160.jpg' }}"
                                    class="img-circle elevation-2" alt="User Image" />
                                <div class="media-body">
                                    <h3 class="dropdown-item-title">
                                        Nora Silvester
                                        <span class="float-right text-sm text-warning"><i
                                                class="fas fa-star"></i></span>
                                    </h3>
                                    <p class="text-sm">The subject goes here</p>
                                    <p class="text-sm text-muted">
                                        <i class="far fa-clock mr-1"></i> 4 Hours Ago
                                    </p>
                                </div>
                            </div>
                        </a>
                        <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item dropdown-footer">See All Messages</a>
                    </div>
                </li> --}}
                {{-- <li class="nav-item dropdown">
                    <a class="nav-link" data-toggle="dropdown" href="#">
                        <i class="far fa-bell"></i>
                        <span class="badge badge-warning navbar-badge">15</span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                        <span class="dropdown-item dropdown-header">15 Notifications</span>
                        <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item">
                            <i class="fas fa-envelope mr-2"></i> 4 new messages
                            <span class="float-right text-muted text-sm">3 mins</span>
                        </a>
                        <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item">
                            <i class="fas fa-users mr-2"></i> 8 friend requests
                            <span class="float-right text-muted text-sm">12 hours</span>
                        </a>
                        <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item">
                            <i class="fas fa-file mr-2"></i> 3 new reports
                            <span class="float-right text-muted text-sm">2 days</span>
                        </a>
                        <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>
                    </div>
                </li> --}}
                <li class="nav-item">
                    <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                        <i class="fas fa-expand-arrows-alt"></i>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="btn btn-danger"
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class='fa fa-sign-out-alt'></i>
                    </a>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>

                </li>
            </ul>
        </div>
    </div>
</nav>
