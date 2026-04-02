<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion toggled" id="accordionSidebar">
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="#">
        <div class="sidebar-brand-icon">
            <img src="{{ asset('img/logo-inspektorat2.png') }}" alt="Logo Inspektorat"
                style="width: 40px; height: auto;">
        </div>
        <div class="sidebar-brand-text mx-3">Inspektorat Jawa Timur</div>
    </a>
    <hr class="sidebar-divider my-0">

    <!-- Menu di sidebar jika user yang login memiliki role Monitor -->
  
    <li class="nav-item active">
        <a class="nav-link" href="{{ route('data.peminjaman.mobil') }}">
            <i class="fas fa-book-open"></i>
            <span>Tabel Peminjaman</span>
        </a>
    </li>

    <li class="nav-item active">
        <a class="nav-link" href="{{ route('mobil.index') }}">
            <i class="fas fa-car"></i>
            <span>Data Mobil</span>
        </a>
    </li>

    <li class="nav-item active">
        <a class="nav-link" href="{{ route('data.user') }}">
            <i class="fas fa-list-alt"></i>
            <span>Report Peminjaman</span>
        </a>
    </li>

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>
</ul>