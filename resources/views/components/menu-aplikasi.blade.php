<li class="nav-item menu-open">
    <a href="#" class="nav-link active">
        <i class="nav-icon fa fa-coins"></i>
        <p>Seputar Aplikasi</p>
    </a>
</li>
<li class="nav-item">
    <a href="#" class="nav-link">
        <i class="nav-icon fa fa-users"></i>
        <p>
            Aplikasi
            <i class="fas fa-angle-left right"></i>
        </p>
    </a>
    <ul class="nav nav-treeview pl-2">
        <li class="nav-item">
            <a href="{{ route('tentang-aplikasi.index') }}" class="nav-link">
                <i class="fa fa-user-graduate nav-icon"></i>
                <p>Tentang Palikasi</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('karyawan.index') }}" class="nav-link">

                <i class="fa fa-user-circle nav-icon"></i>
                <p>Fitur Aplikasi</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('siswa.index') }}" class="nav-link">

                <i class="fa fa-user-tie nav-icon"></i>
                <p>Siswa</p>
            </a>
        </li>
    </ul>
</li>

{{-- /*
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear
php artisan optimize:clear

php artisan make:view aplikasi.fitur.fitur-aplikasi
php artisan make:view aplikasi.fitur.fitur-aplikasi-single
php artisan make:model Aplikasi/Fitur/FiturAplikasi
php artisan make:controller Aplikasi/Fitur/FiturAplikasiController --resource



php artisan make:seeder Aplikasi/Fitur/FiturAplikasiSeeder
php artisan make:migration Migration_FiturAplikasi




*/ --}}
