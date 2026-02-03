<aside id="layout-menu" class="layout-menu menu-vertical menu bg-white border-end-0 shadow-sm" style="width: 280px;">
    {{-- LOGO SECTION --}}
    <div class="app-brand demo d-flex align-items-center px-4" style="height: 100px;">
        <a href="{{ route('dashboard.index') }}" class="app-brand-link gap-2">
            <span class="app-brand-logo demo">
                <div class="p-2 rounded-3 bg-primary shadow-primary">
                    {{-- Icon Grafik yang lebih modern untuk Finansial --}}
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="12" y1="20" x2="12" y2="10"></line>
                        <line x1="18" y1="20" x2="18" y2="4"></line>
                        <line x1="6" y1="20" x2="6" y2="16"></line>
                    </svg>
                </div>
            </span>
            <div class="d-flex flex-column">
                <span class="app-brand-text demo menu-text fw-black text-dark tracking-tight" style="font-size: 1.5rem; line-height: 1;">FINA<span class="text-primary">NCE</span></span>
                <span class="text-muted fw-bold" style="font-size: 0.65rem; letter-spacing: 2px;">SMART TRACKER</span>
            </div>
        </a>
    </div>

    <div class="menu-inner-shadow"></div>

    <ul class="menu-inner py-3 px-3">
        {{-- OVERVIEW (Ditambahkan agar lengkap seperti di foto) --}}
        <li class="menu-item {{ Request::is('dashboard') ? 'active' : '' }}">
            <a href="{{ route('dashboard.index') }}" class="menu-link rounded-4 py-3">
                <i class="menu-icon bx bx-grid-alt fs-4"></i>
                <div class="fw-bold">Overview</div>
            </a>
        </li>

        {{-- TRANSAKSI --}}
        <li class="menu-item {{ Request::is('dashboard/transaksi*') ? 'active' : '' }}">
            <a href="{{ route('dashboard.transaksi.index') }}" class="menu-link rounded-4 py-3">
                <i class="menu-icon bx bx-transfer-alt fs-4"></i>
                <div class="fw-bold">Transaksi</div>
            </a>
        </li>

        {{-- MANAGEMENT HEADER --}}
        <li class="menu-header small text-uppercase my-4">
            <span class="menu-header-text fw-black text-muted tracking-widest" style="font-size: 0.7rem;">Management</span>
        </li>

        {{-- KATEGORI --}}
        <li class="menu-item {{ Request::is('dashboard/kategori-keuangan*') ? 'active' : '' }}">
            <a href="{{ route('dashboard.kategori-keuangan.index') }}" class="menu-link rounded-4 py-3">
                <i class="menu-icon bx bx-category fs-4"></i>
                <div class="fw-bold">Kategori</div>
            </a>
        </li>

        {{-- AKUN/REKENING --}}
        <li class="menu-item {{ Request::is('dashboard/akun-keuangan*') ? 'active' : '' }}">
            <a href="{{ route('dashboard.akun-keuangan.index') }}" class="menu-link rounded-4 py-3">
                <i class="menu-icon bx bx-credit-card fs-4"></i>
                <div class="fw-bold">Akun/Rekening</div>
            </a>
        </li>

        {{-- USER MANAGEMENT --}}
        <li class="menu-item {{ Request::is('dashboard/users*') ? 'active' : '' }} mb-4">
            <a href="{{ route('dashboard.users.index') }}" class="menu-link rounded-4 py-3">
                <i class="menu-icon bx bx-user-circle fs-4"></i>
                <div class="fw-bold">Manajemen User</div>
            </a>
        </li>

        {{-- USER PROFILE CARD --}}
        <div class="mt-auto p-3 rounded-5 bg-dark mb-2 shadow-lg mx-1">
            <div class="d-flex align-items-center mb-3">
                <div class="avatar avatar-md me-3">
                    <span class="avatar-initial rounded-3 bg-primary fw-bold text-uppercase">{{ substr(Auth::user()->name, 0, 2) }}</span>
                </div>
                <div class="user-info">
                    <h6 class="text-white mb-0 fw-bold">{{ Auth::user()->name }}</h6>
                    <small class="text-muted fw-bold text-uppercase" style="font-size: 0.6rem; letter-spacing: 1px;">Administrator</small>
                </div>
            </div>
            
            <form action="{{ route('dashboard.logout') }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-danger w-100 rounded-4 fw-black py-2 text-uppercase tracking-widest" style="font-size: 0.75rem;">
                    Logout
                </button>
            </form>
        </div>
    </ul>
</aside>

<style>
    /* Custom Styling sesuai gambar */
    .menu-vertical .menu-item.active > .menu-link {
        background-color: #5544FF !important; /* Warna ungu brand */
        color: #fff !important;
        box-shadow: 0 10px 20px -5px rgba(85, 68, 255, 0.4);
    }
    .menu-vertical .menu-item.active i {
        color: #fff !important;
    }
    .menu-link {
        color: #64748b !important;
        transition: all 0.3s ease;
    }
    .menu-link:hover {
        background-color: #f8fafc !important;
        transform: translateX(5px); /* Animasi geser sedikit saat hover */
    }
    .fw-black { font-weight: 900 !important; }
    .tracking-widest { letter-spacing: 0.15em !important; }
    .tracking-tight { letter-spacing: -0.05em !important; }
    .shadow-primary { box-shadow: 0 8px 15px -3px rgba(105, 108, 255, 0.4); }
    .bg-dark { background-color: #0F172A !important; } 
    .avatar-initial { width: 45px; height: 45px; display: flex; align-items: center; justify-content: center; }
    .text-primary { color: #5544FF !important; } /* Menyelaraskan warna teks dengan brand */
</style>