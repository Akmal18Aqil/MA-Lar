<div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="index.html">Stisla</a>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <a href="index.html">St</a>
        </div>

        <ul class="sidebar-menu">
            <li class="menu-header">Dashboard</li>
            <li class="{{ Request::is('dashboard') ? 'active' : '' }}">
                <a href="{{ route('admin.dashboard') }}" class="nav-link"><i class="fas fa-fire"></i><span>Dashboard</span></a>
            </li>

            <li class="menu-header">Mahasantri</li>
            <li class="{{ Request::is('mahasantri') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('mahasantri.index') }}"><i class="fas fa-user-graduate"></i><span>Mahasantri</span></a>
            </li>
            

            <li class="menu-header">User Management</li>
            <li class="{{ Request::is('admin/users') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('admin.users.index') }}"><i class="fas fa-users"></i><span>Users</span></a>
            </li>
            
        </ul>
    </aside>
</div>
