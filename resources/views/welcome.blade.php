<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Smart Finance - Track Your Money</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />
    
    <script src="https://cdn.tailwindcss.com"></script>
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>

    <style>
        body {
            font-family: 'Instrument Sans', sans-serif;
            background: radial-gradient(circle at top right, #f0fdf4, #ffffff);
            overflow-x: hidden;
        }
        .glass-card {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(227, 227, 224, 0.5);
        }
        .gradient-text {
            background: linear-gradient(90deg, #10b981, #3b82f6);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        .floating {
            animation: floating 3s ease-in-out infinite;
        }
        @keyframes floating {
            0% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
            100% { transform: translateY(0px); }
        }
    </style>
</head>
<body class="min-h-screen flex flex-col items-center justify-center p-6">

    <header class="w-full max-w-6xl flex justify-between items-center py-6 animate__animated animate__fadeInDown">
        <div class="flex items-center gap-2">
            <div class="bg-emerald-500 p-2 rounded-lg shadow-lg shadow-emerald-200">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <span class="text-xl font-bold text-slate-800">FinanceFlow</span>
        </div>

        @if (Route::has('login'))
        <nav class="flex gap-4">
            @auth
                <a href="{{ url('/dashboard') }}" class="px-6 py-2 bg-slate-900 text-white rounded-full hover:bg-slate-800 transition-all shadow-md">Dashboard</a>
            @else
                <a href="{{ route('login') }}" class="px-6 py-2 text-slate-600 font-medium hover:text-emerald-600 transition-colors">Log in</a>
                @if (Route::has('register'))
                    <a href="{{ route('register') }}" class="px-6 py-2 bg-emerald-500 text-white rounded-full hover:bg-emerald-600 transition-all shadow-lg shadow-emerald-100">Get Started</a>
                @endif
            @endauth
        </nav>
        @endif
    </header>

    <main class="w-full max-w-6xl flex flex-col lg:flex-row items-center gap-12 mt-12">
        
        <div class="flex-1 animate__animated animate__fadeInLeft">
            <h1 class="text-5xl lg:text-7xl font-bold text-slate-900 leading-tight mb-6">
                Kuasai Uangmu, <br><span class="gradient-text">Bukan Sebaliknya.</span>
            </h1>
            <p class="text-lg text-slate-600 mb-8 leading-relaxed max-w-lg">
                Pantau pengeluaran, atur anggaran, dan capai kebebasan finansial dengan sistem pelacakan otomatis kami yang cerdas.
            </p>
            
            <div class="flex flex-wrap gap-4">
                <div class="flex items-center gap-2 px-4 py-2 bg-white rounded-lg shadow-sm border border-slate-100">
                    <span class="text-emerald-500">✔</span> <span class="text-sm font-medium text-slate-700">Laporan Real-time</span>
                </div>
                <div class="flex items-center gap-2 px-4 py-2 bg-white rounded-lg shadow-sm border border-slate-100">
                    <span class="text-emerald-500">✔</span> <span class="text-sm font-medium text-slate-700">Keamanan Terjamin</span>
                </div>
            </div>
        </div>

        <div class="flex-1 w-full animate__animated animate__zoomIn">
            <div class="glass-card p-4 rounded-3xl shadow-2xl relative overflow-hidden">
                <div class="bg-white rounded-2xl p-6 shadow-inner">
                    <div class="flex justify-between items-center mb-8">
                        <div>
                            <p class="text-xs text-slate-400 uppercase tracking-widest">Total Saldo</p>
                            <h2 class="text-3xl font-bold text-slate-800">Rp 12.500.000</h2>
                        </div>
                        <div class="h-12 w-12 bg-blue-100 rounded-full flex items-center justify-center text-blue-600 font-bold italic">
                            VISA
                        </div>
                    </div>
                    
                    <div class="space-y-4">
                        <div class="flex items-center justify-between p-3 bg-emerald-50 rounded-xl floating">
                            <div class="flex items-center gap-3">
                                <div class="bg-emerald-500 p-2 rounded-lg text-white">💰</div>
                                <div>
                                    <p class="font-semibold text-sm">Gaji Bulanan</p>
                                    <p class="text-xs text-slate-500">2 Feb 2026</p>
                                </div>
                            </div>
                            <span class="text-emerald-600 font-bold">+Rp 5jt</span>
                        </div>

                        <div class="flex items-center justify-between p-3 bg-rose-50 rounded-xl" style="animation-delay: 0.5s">
                            <div class="flex items-center gap-3">
                                <div class="bg-rose-500 p-2 rounded-lg text-white">☕</div>
                                <div>
                                    <p class="font-semibold text-sm">Kopi & Snack</p>
                                    <p class="text-xs text-slate-500">1 Feb 2026</p>
                                </div>
                            </div>
                            <span class="text-rose-600 font-bold">-Rp 45rb</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </main>

    <footer class="mt-20 text-slate-400 text-sm animate__animated animate__fadeIn animate__delay-1s">
        &copy; 2026 FinanceFlow Project. Made with ✨ and Laravel.
    </footer>

</body>
</html>