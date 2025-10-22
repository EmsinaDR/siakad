<li class="nav-item">
    <a href="#" class="nav-link">
        <i class="nav-icon fa fa-folder"></i>
        <p>
            Rapat
            <i class="fas fa-angle-left right"></i>
        </p>
    </a>
    <ul class="nav nav-treeview pl-2">
        <li class="nav-item">
            <a href="{{route('data-rapat.index')}}" class="nav-link">
                <i class="fa fa-qrcode nav-icon ml-2 text-info"></i>
                <p class=''> Data Agenda Rapat</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{route('daftar-hadir-rapat.index')}}" class="nav-link">
                <i class="fa fa-qrcode nav-icon ml-2 text-info"></i>
                <p class=''> Daftar Hadir Rapat </p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{route('berita-acara-rapat.index')}}" class="nav-link">
                <i class="fa fa-qrcode nav-icon ml-2 text-info"></i>
                <p class=''> Berita Acara Rapat </p>
            </a>
        </li>
    </ul>
</li>

{{-- php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear
php artisan optimize:clear

php artisan make:view role.program.rapat.berita-acara
php artisan make:view role.program.rapat.berita-acara-single
php artisan make:model Program/Rapat/BeritaAcaraRapat
php artisan make:controller Program/Rapat/BeritaAcaraRapatController --resource



php artisan make:seeder Program/Rapat/BeritaAcaraRapatSeeder
php artisan make:migration Migration_BeritaAcaraRapat


 --}}
