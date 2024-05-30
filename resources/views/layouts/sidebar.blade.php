<aside id="sidebar-wrapper">
    <div class="sidebar-brand">
        <a href="{{ route('dashboard') }}">Inventory Bahan Baku</a>
    </div>
    <div class="sidebar-brand sidebar-brand-sm">
        <a href="{{ route('dashboard') }}">IBB</a>
    </div>
    <ul class="sidebar-menu">
        <li class="menu-header">Dashboard</li>
        <li class="{{ request()->is('dashboard') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('dashboard') }}"><i class="fas fa-fire"></i> <span>Dashboard</span></a>
        </li>
        <li class="menu-header">Master Data</li>
        @can('manage_kategori')
        <li class="{{ request()->is('dashboard/kategori') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('kategori.index') }}"><i class="fas fa-list"></i>
                <span>Kategori</span></a>
        </li>
        @endcan
        @can('manage_bahan')
        <li class="{{ request()->is('dashboard/bahanbaku*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('bahanbaku.index') }}"><i class="fas fa-box"></i> <span>Bahan Baku</span></a>
        </li>
        @endcan
        <li class="menu-header">Entry Data</li>
        @can('menage_pembelian')
        <li class="{{ request()->is('dashboard/pembelian*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('pembelian') }}"><i class="fas fa-plus"></i> <span>Pembelian</span></a>
        </li>
        <li class="{{ request()->is('dashboard/pengeluaran-kasir*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('kasir-keluar') }}"><i class="fab fa-slack-hash"></i> <span>Pengeluaran Kasir</span></a>
        </li>
        @endcan
        @can('menage_pengeluaran')
        <li class="{{ request()->is('dashboard/barang-keluar*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('pengeluaran') }}"><i class="fas fa-minus"></i> <span>Bahan
                    Keluar</span></a>
        </li>
        @endcan
        @can('menage_stok')
        <li class="{{ request()->is('dashboard/stok*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('stok.index') }}"><i class="fas fa-warehouse"></i> <span>Stok
                    Bahan</span></a>
        </li>
        @endcan
        @can('menage_laporan')
        <li class="menu-header">Laporan</li>
        <li class="{{ request()->is('dashboard/laporan-bulanan*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('laporan.bulanan') }}"><i class="fas fa-file"></i> <span>Laporan
                    Bulanan</span></a>
        </li>
        <li class="dropdown {{ request()->is('dashboard/laporan-per-kategori*') ? 'active' : '' }}">
            <a href="#" class="nav-link has-dropdown"><i class="fas fa-list"></i><span>Laporan per Kategori</span></a>
            <ul class="dropdown-menu">
                @foreach ($kategori as $k)
                    <li class="{{ request()->is('dashboard/laporan-per-kategori/'.$k->id) ? 'active' : '' }}"><a class="nav-link" href="{{ route('laporan.kategori', $k->id) }}">{{ $k->nama_kategori }}</a></li>
                @endforeach

                {{-- <li class=active><a class="nav-link" href="index.html">Ecommerce Dashboard</a></li> --}}
            </ul>
        </li>
        @endcan


        @if (Gate::check('menage_role') || Gate::check('menage_user'))
        <li class="menu-header">Pengaturan</li>
        @can('menage_role')
        <li class="{{ request()->is('dashboard/role*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('role.index') }}"><i class="fas fa-lock"></i> <span>Role</span></a>
        </li>
        @endcan
        @can('menage_user')
        <li class="{{ request()->is('dashboard/user*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('user.index') }}"><i class="fas fa-user"></i> <span>User</span></a>
        </li>
        @endcan
        @endif
        @can('menage_pengaturan')
        <li class="{{ request()->is('dashboard/settings*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('settings') }}"><i class="fas fa-cog"></i> <span>Settings</span></a>
        </li>
        @endcan

    </ul>
</aside>
