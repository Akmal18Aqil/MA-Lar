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
            <li class="dropdown {{ Request::is('dashboard') ? 'active' : '' }}">
                <a href="{{ route('dashboard') }}" class="nav-link"><i class="fas fa-fire"></i><span>Dashboard</span></a>
            </li>
            <li class="menu-header">Starter</li>
            <li class="dropdown {{ Request::is('mahasantri*') ? 'active' : '' }}">
                <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-columns"></i> <span>Mahasantri</span></a>
                <ul class="dropdown-menu">
                    <li class="{{ Request::is('mahasantri') ? 'active' : '' }}"><a class="nav-link" href="{{ route('mahasantri.index') }}">List Mahasantri</a></li>
                    <li class="{{ Request::is('mahasantri/create') ? 'active' : '' }}"><a class="nav-link" href="{{ route('mahasantri.create') }}">Add Mahasantri</a></li>
                </ul>
            </li>
        </ul>
    </aside>
</div>