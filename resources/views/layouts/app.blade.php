<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'TrackingKU') }}</title>

    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        body { 
            background-color: #f8fafc; 
            font-family: 'Plus Jakarta Sans', sans-serif;
            margin: 0;
        }
        .main-wrapper { display: flex; min-height: 100vh; }
        .content-area { flex-grow: 1; display: flex; flex-direction: column; min-width: 0; }
        .custom-scrollbar-hidden::-webkit-scrollbar { width: 0; background: transparent; }
        .sidebar-link { text-decoration: none !important; }
        
        /* Tambahan agar warna ungu konsisten */
        .text-indigo-600 { color: #5544FF !important; }
        .bg-indigo-600 { background-color: #5544FF !important; }
        .from-indigo-700 { --tw-gradient-from: #5544FF; --tw-gradient-to: rgb(79 70 229 / 0); --tw-gradient-stops: var(--tw-gradient-from), var(--tw-gradient-to); }
    </style>
</head>
<body>
    <div id="app" class="main-wrapper">
        
        <aside class="bg-white border-r border-slate-100 flex flex-col h-screen sticky top-0 z-[1000] shadow-[20px_0_60px_-30px_rgba(0,0,0,0.02)]" style="min-width: 280px; max-width: 280px;">
            
            {{-- BAGIAN LOGO YANG DIUBAH --}}
            <div class="py-10 px-8 flex-none">
                <a href="{{ url('/') }}" class="flex items-center gap-4 group sidebar-link">
                    <div class="w-12 h-12 rounded-[16px] bg-gradient-to-tr from-indigo-700 to-violet-500 flex items-center justify-center shadow-lg shadow-indigo-200">
                        {{-- Icon Grafik/Analytics --}}
                        <i class='bx bx-stats text-3xl text-white'></i>
                    </div>
                    <div class="flex flex-col text-decoration-none">
                        <span class="text-[18px] font-[900] tracking-tight text-slate-800 leading-none">FINA<span class="text-indigo-600">NCE</span></span>
                        <span class="text-[9px] font-black text-slate-400 uppercase tracking-[0.2em] mt-2">Smart Tracker</span>
                    </div>
                </a>
            </div>

            <ul class="flex flex-col gap-2 px-6 flex-grow overflow-y-auto custom-scrollbar-hidden list-none p-0 m-0">
                <li class="mb-3 mt-4 px-4">
                    <span class="text-[10px] font-black text-slate-300 tracking-[0.3em] uppercase">Core Menu</span>
                </li>

                <li>
                    <a href="{{ route('dashboard.index') }}" class="sidebar-link flex items-center gap-4 px-5 py-4 rounded-[1.25rem] transition-all duration-300 {{ request()->routeIs('dashboard.index') ? 'bg-indigo-600 text-white shadow-xl shadow-indigo-200' : 'text-slate-500 hover:bg-slate-50 hover:text-indigo-600' }}">
                        <i class="bx bx-grid-alt text-[24px]"></i>
                        <span class="text-[13px] font-bold">Overview</span>
                    </a>
                </li>

                <li>
                    <a href="{{ route('dashboard.transaksi.index') }}" class="sidebar-link flex items-center gap-4 px-5 py-4 rounded-[1.25rem] transition-all duration-300 {{ request()->routeIs('dashboard.transaksi.*') ? 'bg-indigo-600 text-white shadow-xl' : 'text-slate-500 hover:bg-slate-50 hover:text-indigo-600' }}">
                        <i class="bx bx-transfer-alt text-[24px]"></i>
                        <span class="text-[13px] font-bold">Transaksi</span>
                    </a>
                </li>

                <li class="mb-3 mt-8 px-4">
                    <span class="text-[10px] font-black text-slate-300 tracking-[0.3em] uppercase">Management</span>
                </li>

                <li>
                    <a href="{{ route('dashboard.kategori-keuangan.index') }}" class="sidebar-link flex items-center gap-4 px-5 py-4 rounded-[1.25rem] transition-all duration-300 {{ request()->routeIs('dashboard.kategori-keuangan.*') ? 'bg-indigo-600 text-white shadow-xl' : 'text-slate-500 hover:bg-slate-50 hover:text-indigo-600' }}">
                        <i class="bx bx-category text-[24px]"></i>
                        <span class="text-[13px] font-bold">Kategori</span>
                    </a>
                </li>

                <li>
                    <a href="{{ route('dashboard.akun-keuangan.index') }}" class="sidebar-link flex items-center gap-4 px-5 py-4 rounded-[1.25rem] transition-all duration-300 {{ request()->routeIs('dashboard.akun-keuangan.*') ? 'bg-indigo-600 text-white shadow-xl' : 'text-slate-500 hover:bg-slate-50 hover:text-indigo-600' }}">
                        <i class="bx bx-credit-card text-[24px]"></i>
                        <span class="text-[13px] font-bold">Akun/Rekening</span>
                    </a>
                </li>

                <li>
                    <a href="{{ route('dashboard.users.index') }}" class="sidebar-link flex items-center gap-4 px-5 py-4 rounded-[1.25rem] transition-all duration-300 {{ request()->routeIs('dashboard.users.*') ? 'bg-indigo-600 text-white shadow-xl' : 'text-slate-500 hover:bg-slate-50 hover:text-indigo-600' }}">
                        <i class="bx bx-user-circle text-[24px]"></i>
                        <span class="text-[13px] font-bold">Manajemen User</span>
                    </a>
                </li>

                <li class="mt-auto mb-10">
                    <div class="p-6 rounded-[2rem] bg-slate-900 shadow-2xl relative overflow-hidden group">
                        <div class="relative z-10">
                            <div class="flex items-center gap-3 mb-4">
                                <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=6366f1&color=fff" class="w-10 h-10 rounded-xl border border-white/10">
                                <div class="overflow-hidden">
                                    <p class="text-[12px] font-bold text-white truncate m-0">{{ Auth::user()->name }}</p>
                                    <p class="text-[9px] text-slate-400 uppercase m-0">Administrator</p>
                                </div>
                            </div>
                            <form action="{{ route('dashboard.logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="w-full py-2.5 rounded-xl bg-rose-500 hover:bg-rose-600 text-white text-[10px] font-black uppercase tracking-widest transition-all border-none cursor-pointer">
                                    Logout
                                </button>
                            </form>
                        </div>
                    </div>
                </li>
            </ul>
        </aside>

        <div class="content-area">
            <nav class="navbar navbar-expand-md navbar-light bg-white border-b border-slate-100 py-4">
                <div class="container px-8">
                    <span class="text-xs font-black text-slate-400 uppercase tracking-widest">Workspace / Dashboard</span>
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav ms-auto">
                            <li class="nav-item">
                                <span class="nav-link font-bold text-slate-700 italic">{{ date('l, d F Y') }}</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>

            <main class="p-10">
                @yield('content')
            </main>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>