<div class="main-sidebar sidebar-style-2" id="mainSidebar">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand d-flex justify-content-between align-items-center">
            @php
                $role = Auth::user()->role ?? null;
                $dashboardRoute = '#';
                if ($role === 'admin') {
                    $dashboardRoute = route('admin.dashboard');
                } elseif ($role === 'dosen') {
                    $dashboardRoute = route('dosen.dashboard');
                } elseif ($role === 'mahasantri') {
                    $dashboardRoute = route('mahasantri.dashboard');
                }
            @endphp
            <a href="{{ $dashboardRoute }}">SIAKAD</a>
            <button id="sidebarToggle" style="background:none;border:none;font-size:20px;cursor:pointer;" title="Minimize Sidebar">
                <i class="fa fa-angle-double-left"></i>
            </button>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <a href="{{ $dashboardRoute }}">SKD</a>
        </div>

        <ul class="sidebar-menu">
            @php $role = Auth::user()->role ?? null; @endphp
            @if($role === 'admin')
                <li class="menu-header">Dashboard</li>
                <li class="{{ Request::is('admin/dashboard') ? 'active' : '' }}">
                    <a href="{{ route('admin.dashboard') }}" class="nav-link"><i class="fa fa-fire"></i><span>Dashboard</span></a>
                </li>
                <li class="menu-header">Absensi</li>
                <li class="{{ Request::is('admin/absensi') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('admin.absensi.index') }}"><i class="fa fa-calendar-check-o"></i><span>Input Absensi</span></a>
                </li>
                <li class="menu-header">Mahasantri</li>
                <li class="{{ Request::is('admin/mahasantri') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('admin.mahasantri.index') }}"><i class="fa fa-user"></i><span>Manajemen Mahasantri</span></a>
                </li>
                <li class="menu-header">User Management</li>
                <li class="{{ Request::is('admin/users') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('admin.users.index') }}"><i class="fa fa-users"></i><span>Users</span></a>
                </li>
                <li class="menu-header">Manajemen UKT</li>
                <li class="{{ Request::is('admin/ukt*') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('admin.ukt.index') }}"><i class="fa fa-money"></i><span>Manajemen UKT</span></a>
                </li>
            @elseif($role === 'dosen')
                <li class="menu-header">Dashboard</li>
                <li class="{{ Request::is('dosen/dashboard') ? 'active' : '' }}">
                    <a href="{{ route('dosen.dashboard') }}" class="nav-link"><i class="fa fa-fire"></i><span>Dashboard</span></a>
                </li>
                <li class="menu-header">Kegiatan Mahasantri</li>
                <li class="{{ Request::is('dosen/kegiatan') ? 'active' : '' }}">
                    <a class="nav-link" href="#"><i class="fa fa-bar-chart"></i><span>Statistik Kegiatan</span></a>
                </li>
            @elseif($role === 'mahasantri')
                <li class="menu-header">Dashboard</li>
                <li class="{{ Request::is('mahasantri/dashboard') ? 'active' : '' }}">
                    <a href="{{ route('mahasantri.dashboard') }}" class="nav-link"><i class="fa fa-fire"></i><span>Dashboard</span></a>
                </li>
                <li class="menu-header">Data Diri</li>
                <li class="{{ Request::is('mahasantri/profile') ? 'active' : '' }}">
                    <a class="nav-link" href="#"><i class="fa fa-id-card-o"></i><span>Data Diri</span></a>
                </li>
                <li class="menu-header">Absen Kegiatan</li>
                <li class="{{ Request::is('mahasantri/absensi') ? 'active' : '' }}">
                    <a class="nav-link" href="#"><i class="fa fa-calendar-check-o"></i><span>Absen Kegiatan</span></a>
                </li>
                <li class="menu-header">UKT</li>
                <li class="{{ Request::is('mahasantri/ukt') ? 'active' : '' }}">
                    <a class="nav-link" href="#"><i class="fa fa-money"></i><span>Info UKT</span></a>
                </li>
                <li class="menu-header">Hukuman</li>
                <li class="{{ Request::is('mahasantri/hukuman') ? 'active' : '' }}">
                    <a class="nav-link" href="#"><i class="fa fa-gavel"></i><span>Status Hukuman</span></a>
                </li>
            @endif
        </ul>
    </aside>
</div>
<style>
    .sidebar-collapsed {
        width: 60px !important;
        transition: width 0.2s;
    }
    .sidebar-collapsed .sidebar-brand span,
    .sidebar-collapsed .sidebar-menu span {
        display: none;
    }
    .sidebar-collapsed .sidebar-brand a {
        font-size: 1.2rem;
    }
</style>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var sidebar = document.getElementById('mainSidebar');
        var toggleBtn = document.getElementById('sidebarToggle');
        toggleBtn.addEventListener('click', function() {
            sidebar.classList.toggle('sidebar-collapsed');
            // Change icon direction
            var icon = toggleBtn.querySelector('i');
            if (sidebar.classList.contains('sidebar-collapsed')) {
                icon.classList.remove('fa-angle-double-left');
                icon.classList.add('fa-angle-double-right');
            } else {
                icon.classList.remove('fa-angle-double-right');
                icon.classList.add('fa-angle-double-left');
            }
        });
    });
</script>
