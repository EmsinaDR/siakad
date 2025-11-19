{{-- Pengaturan Role --}}
<li class="nav-item">
    <a href="#" class="nav-link">
        <i class="nav-icon fas fa-user-cog text-primary"></i>
        <p>
            Pengaturan Role
            <i class="fas fa-angle-left right"></i>
        </p>
    </a>
    <ul class="nav nav-treeview pl-2">
        <li class="nav-item">
            <a href="{{ route('role-guru.index') }}" class="nav-link">
                <i class="fas fa-chalkboard-teacher nav-icon"></i>
                <p>Guru</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('role-siswa.index') }}" class="nav-link">
                <i class="fas fa-user-graduate nav-icon"></i>
                <p>Siswa</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('seting-pengguna-program.index') }}" class="nav-link">
                <i class="fas fa-layer-group nav-icon"></i>
                <p>Program</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('reset-password.index') }}" class="nav-link">
                <i class="fas fa-layer-group nav-icon"></i>
                <p>Reset Password</p>
            </a>
        </li>
    </ul>
</li>
