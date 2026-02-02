<!DOCTYPE html>
<html lang="en" class="light-style customizer-hide" dir="ltr" data-theme="theme-default">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <title>Daftar | Tracking Keuangan</title>

    <link rel="icon" type="image/x-icon" href="{{ asset('assets/img/favicon/favicon.ico') }}" />

    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Public+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet" />

    <link rel="stylesheet" href="{{ asset('assets/vendor/fonts/boxicons.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/core.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/theme-default.css') }}" />
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>

    <style>
        /* Mengetengahkan konten secara sempurna */
        body, html {
            height: 100%;
            margin: 0;
        }

        body {
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(-45deg, #696cff, #8e44ad, #23a6d5, #23d5ab);
            background-size: 400% 400%;
            animation: gradientBG 15s ease infinite;
        }

        @keyframes gradientBG {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        .authentication-wrapper {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 100%;
            padding: 20px;
        }

        .authentication-inner {
            width: 100%;
            max-width: 480px; /* Sedikit lebih lebar untuk form register */
        }

        .card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border: none;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.2);
        }

        .btn-primary {
            background: #696cff;
            border: none;
            padding: 0.7rem;
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(105, 108, 255, 0.4);
        }

        /* Styling tambahan agar seragam */
        .app-brand-text {
            font-size: 1.75rem;
            letter-spacing: -0.5px;
        }
    </style>
</head>

<body>
    <div class="authentication-wrapper">
        <div class="authentication-inner animate__animated animate__fadeInUp">
            <div class="card p-2">
                <div class="card-body">
                    <div class="app-brand justify-content-center mb-4">
                        <a href="/" class="app-brand-link gap-2 text-decoration-none">
                            <span class="app-brand-logo demo">
                                <svg width="30" viewBox="0 0 25 42" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M13.7918 0.358365L3.39788 7.44174C0.566865 9.69409 -0.379795 12.4789 0.557901 15.7961C0.689989 16.2305 1.09563 17.7872 3.12357 19.2293C3.81463 19.7208 5.32369 20.3834 7.65075 21.2173L16.4176 26.3747C18.0339 24.4998 18.6973 22.4545 18.408 20.2388C17.9638 17.5347 16.1776 15.58 13.0497 14.3748L10.9195 13.4716L18.6192 7.98424L13.7918 0.358365Z" fill="#696CFF" />
                                </svg>
                            </span>
                            <span class="app-brand-text demo text-body fw-bolder">SmartFinance</span>
                        </a>
                    </div>

                    <h4 class="mb-2 text-center fw-bold">Mulai Perjalanan Keuanganmu 🚀</h4>
                    <p class="mb-4 text-center text-muted">Kelola pengeluaran dan pemasukan jadi lebih mudah.</p>

                    <form id="formAuthentication" class="mb-3" action="{{ route('register') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="name" class="form-label">Nama Lengkap</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" placeholder="Masukkan nama lengkap" value="{{ old('name') }}" required autofocus />
                            @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" placeholder="Masukkan email anda" value="{{ old('email') }}" required />
                            @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3 form-password-toggle">
                            <label class="form-label" for="password">Password</label>
                            <div class="input-group input-group-merge">
                                <input type="password" id="password" class="form-control @error('password') is-invalid @enderror" name="password" placeholder="••••••••" required />
                                <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                            </div>
                            @error('password') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3 form-password-toggle">
                            <label class="form-label" for="password_confirmation">Konfirmasi Password</label>
                            <div class="input-group input-group-merge">
                                <input type="password" id="password_confirmation" class="form-control" name="password_confirmation" placeholder="••••••••" required />
                                <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                            </div>
                        </div>

                        <div class="mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="terms-conditions" name="terms" required />
                                <label class="form-check-label" for="terms-conditions">
                                    Saya setuju dengan <a href="javascript:void(0);">kebijakan privasi</a>
                                </label>
                            </div>
                        </div>
                        <button class="btn btn-primary d-grid w-100" type="submit">Daftar Akun</button>
                    </form>

                    <p class="text-center">
                        <span>Sudah memiliki akun?</span>
                        <a href="{{ route('login') }}">
                            <span class="fw-bold">Masuk Sekarang</span>
                        </a>
                    </p>
                </div>
            </div>
            </div>
    </div>

    <script src="{{ asset('assets/vendor/libs/jquery/jquery.js') }}"></script>
    <script src="{{ asset('assets/vendor/js/bootstrap.js') }}"></script>
    <script src="{{ asset('assets/js/main.js') }}"></script>
</body>
</html>