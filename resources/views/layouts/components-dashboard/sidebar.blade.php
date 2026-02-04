<aside id="layout-menu" class="layout-menu menu-vertical menu bg-white d-flex flex-column" 
    style="width: 260px; height: 100vh; position: fixed; left: 0; top: 0; z-index: 1100; border-right: 1px solid #eef2f6; box-shadow: none !important;">
    
    {{-- LOGO SECTION --}}
    <div class="app-brand demo d-flex align-items-center px-4" style="height: 100px; min-height: 100px;">
        <a href="{{ route('dashboard.index') }}" class="app-brand-link d-flex align-items-center text-decoration-none">
            <div class="logo-icon-wrapper d-flex align-items-center justify-content-center shadow-sm" 
                 style="width: 40px; height: 40px; background: #696cff; border-radius: 12px;">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M12 20V10"></path>
                    <path d="M18 20V4"></path>
                    <path d="M6 20V16"></path>
                </svg>
            </div>
            <div class="ms-3 d-flex flex-column">
                <span class="fw-bold text-dark" style="font-size: 1.2rem; line-height: 1.1; letter-spacing: -0.5px;">Finance</span>
                <small class="text-muted fw-medium" style="font-size: 0.65rem; letter-spacing: 1px; text-transform: uppercase;">Smart Tracker</small>
            </div>
        </a>
    </div>

    {{-- MENU SECTION --}}
    <div class="menu-inner-shadow"></div>
    <ul class="menu-inner py-3 px-3 flex-grow-1 overflow-auto" style="list-style: none; margin: 0;">
        <li class="menu-item {{ Request::is('dashboard') ? 'active' : '' }}">
            <a href="{{ route('dashboard.index') }}" class="menu-link rounded-3 py-2 px-3 d-flex align-items-center text-decoration-none mb-1">
                <i class="menu-icon bx bx-grid-alt fs-5 me-3"></i>
                <div class="fw-bold">Dashboard</div>
            </a>
        </li>

        <li class="menu-item {{ Request::is('dashboard/transaksi*') ? 'active' : '' }}">
            <a href="{{ route('dashboard.transaksi.index') }}" class="menu-link rounded-3 py-2 px-3 d-flex align-items-center text-decoration-none mb-1">
                <i class="menu-icon bx bx-transfer-alt fs-5 me-3"></i>
                <div class="fw-bold">Transaksi</div>
            </a>
        </li>

        <li class="menu-header small text-uppercase my-4 px-3">
            <span class="text-muted fw-bold opacity-50" style="font-size: 0.65rem; letter-spacing: 1.5px;">Management</span>
        </li>

        @if (Auth::user()->is_admin == 1)
        <li class="menu-item {{ Request::is('dashboard/kategori-keuangan*') ? 'active' : '' }}">
            <a href="{{ route('dashboard.kategori-keuangan.index') }}" class="menu-link rounded-3 py-2 px-3 d-flex align-items-center text-decoration-none mb-1">
                <i class="menu-icon bx bx-category fs-5 me-3"></i>
                <div class="fw-bold">Kategori</div>
            </a>
        </li>
        @endif
        
        <li class="menu-item {{ Request::is('dashboard/akun-keuangan*') ? 'active' : '' }}">
            <a href="{{ route('dashboard.akun-keuangan.index') }}" class="menu-link rounded-3 py-2 px-3 d-flex align-items-center text-decoration-none mb-1">
                <i class="menu-icon bx bx-credit-card fs-5 me-3"></i>
                <div class="fw-bold">Akun/Rekening</div>
            </a>
        </li>

        <li class="menu-item {{ Request::is('dashboard/users*') ? 'active' : '' }}">
            <a href="{{ route('dashboard.users.index') }}" class="menu-link rounded-3 py-2 px-3 d-flex align-items-center text-decoration-none mb-1">
                <i class="menu-icon bx bx-user-circle fs-5 me-3"></i>
                <div class="fw-bold">Manajemen User</div>
            </a>
        </li>
    </ul>

    {{-- PROFILE & LOGOUT (Tanpa Card Hitam) --}}
    <div class="mt-auto border-top p-4 bg-white">
        <div class="d-flex align-items-center mb-4">
            <div class="flex-shrink-0">
                <div class="avatar-initial rounded-circle d-flex align-items-center justify-content-center text-white fw-bold shadow-sm" 
                     style="width: 42px; height: 42px; background: #696cff; font-size: 0.85rem;">
                    {{ substr(Auth::user()->name, 0, 2) }}
                </div>
            </div>
            <div class="ms-3 overflow-hidden text-start">
                <h6 class="mb-0 fw-bold text-dark text-truncate" style="font-size: 0.9rem;">{{ Auth::user()->name }}</h6>
                <small class="text-muted fw-medium" style="font-size: 0.75rem;">Administrator</small>
            </div>
        </div>
        
        <form action="{{ route('dashboard.logout') }}" method="POST">
            @csrf
            <button type="submit" class="btn btn-label-danger w-100 rounded-3 py-2 fw-bold d-flex align-items-center justify-content-center" 
                style="font-size: 0.75rem; background-color: #fff5f5; color: #ff3e1d; border: none;">
                <i class="bx bx-log-out me-2"></i> LOGOUT
            </button>
        </form>
    </div>
</aside>

<style>
    /* CSS Warna Item Aktif */
    .menu-item.active .menu-link {
        background: #f0f0ff !important;
        color: #696cff !important;
    }
    .menu-item.active i { color: #696cff !important; }
    .menu-link { color: #64748b; transition: all 0.2s; }
    .menu-link:hover { background: #f8fafc; color: #696cff; }
</style>