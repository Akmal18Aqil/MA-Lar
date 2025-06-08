<div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="/">SIAKAD</a>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <a href="/">SKD</a>
        </div>

        <ul class="sidebar-menu">
            @php $role = Auth::user()->role ?? null; @endphp
            @if($role === 'admin')
                <li class="menu-header">Dashboard</li>
                <li class="{{ Request::is('admin/dashboard') ? 'active' : '' }}">
                    <a href="{{ route('admin.dashboard') }}" class="nav-link"><i class="fas fa-fire"></i><span>Dashboard</span></a>
                </li>
                <li class="menu-header">Absensi</li>
                <li class="{{ Request::is('admin/absensi') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('admin.absensi.index') }}"><i class="fas fa-calendar-check"></i><span>Input Absensi</span></a>
                </li>
                <li class="menu-header">Mahasantri</li>
                <li class="{{ Request::is('admin/mahasantri') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('admin.mahasantri.index') }}"><i class="fas fa-user-graduate"></i><span>Manajemen Mahasantri</span></a>
                </li>
                <li class="menu-header">User Management</li>
                <li class="{{ Request::is('admin/users') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('admin.users.index') }}"><i class="fas fa-users"></i><span>Users</span></a>
                </li>
            @elseif($role === 'dosen')
                <li class="menu-header">Dashboard</li>
                <li class="{{ Request::is('dosen/dashboard') ? 'active' : '' }}">
                    <a href="{{ route('dosen.dashboard') }}" class="nav-link"><i class="fas fa-fire"></i><span>Dashboard</span></a>
                </li>
                <li class="menu-header">Kegiatan Mahasantri</li>
                <li class="{{ Request::is('dosen/kegiatan') ? 'active' : '' }}">
                    <a class="nav-link" href="#"><i class="fas fa-chart-bar"></i><span>Statistik Kegiatan</span></a>
                </li>
            @elseif($role === 'mahasantri')
                <li class="menu-header">Dashboard</li>
                <li class="{{ Request::is('mahasantri/dashboard') ? 'active' : '' }}">
                    <a href="{{ route('mahasantri.dashboard') }}" class="nav-link"><i class="fas fa-fire"></i><span>Dashboard</span></a>
                </li>
                <li class="menu-header">Data Diri</li>
                <li class="{{ Request::is('mahasantri/profile') ? 'active' : '' }}">
                    <a class="nav-link" href="#"><i class="fas fa-id-card"></i><span>Data Diri</span></a>
                </li>
                <li class="menu-header">Absen Kegiatan</li>
                <li class="{{ Request::is('mahasantri/absensi') ? 'active' : '' }}">
                    <a class="nav-link" href="#"><i class="fas fa-calendar-check"></i><span>Absen Kegiatan</span></a>
                </li>
                <li class="menu-header">UKT</li>
                <li class="{{ Request::is('mahasantri/ukt') ? 'active' : '' }}">
                    <a class="nav-link" href="#"><i class="fas fa-money-bill"></i><span>Info UKT</span></a>
                </li>
                <li class="menu-header">Hukuman</li>
                <li class="{{ Request::is('mahasantri/hukuman') ? 'active' : '' }}">
                    <a class="nav-link" href="#"><i class="fas fa-gavel"></i><span>Status Hukuman</span></a>
                </li>
            @endif
        </ul>
    </aside>
</div>
