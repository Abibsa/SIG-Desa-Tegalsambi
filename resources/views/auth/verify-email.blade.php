<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Verify Email - WebGIS Tegalsambi</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400;500;600;700;900&display=swap"
        rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        * {
            font-family: 'Orbitron', sans-serif;
        }

        body {
            background: #000000;
            overflow: hidden;
        }

        @keyframes float {

            0%,
            100% {
                transform: translateY(0px);
            }

            50% {
                transform: translateY(-15px);
            }
        }

        @keyframes floatSlow {

            0%,
            100% {
                transform: translateY(0px) rotate(0deg);
            }

            50% {
                transform: translateY(-10px) rotate(2deg);
            }
        }

        @keyframes neonPulse {

            0%,
            100% {
                box-shadow: 0 0 20px rgba(239, 68, 68, 0.3), 0 0 40px rgba(239, 68, 68, 0.2), 0 0 60px rgba(239, 68, 68, 0.1);
            }

            50% {
                box-shadow: 0 0 30px rgba(239, 68, 68, 0.5), 0 0 60px rgba(239, 68, 68, 0.3), 0 0 90px rgba(239, 68, 68, 0.2);
            }
        }

        @keyframes holoGlow {

            0%,
            100% {
                opacity: 0.3;
            }

            50% {
                opacity: 0.6;
            }
        }

        @keyframes scan {
            0% {
                transform: translateY(-100%);
            }

            100% {
                transform: translateY(100%);
            }
        }

        .floating-card {
            animation: float 6s ease-in-out infinite;
        }

        .floating-element {
            animation: floatSlow 8s ease-in-out infinite;
        }

        .neon-border {
            animation: neonPulse 3s ease-in-out infinite;
        }

        .holo-glow {
            animation: holoGlow 4s ease-in-out infinite;
        }

        .scan-line {
            animation: scan 8s linear infinite;
        }

        .glass {
            background: rgba(10, 10, 10, 0.7);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
        }

        .btn-cyber {
            position: relative;
            overflow: hidden;
        }

        .btn-cyber::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 0;
            height: 0;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.3);
            transform: translate(-50%, -50%);
            transition: width 0.6s, height 0.6s;
        }

        .btn-cyber:hover::before {
            width: 300px;
            height: 300px;
        }

        .btn-cyber:hover {
            box-shadow: 0 0 30px rgba(239, 68, 68, 0.6), 0 0 60px rgba(239, 68, 68, 0.4);
        }

        .cyber-grid {
            background-image: linear-gradient(rgba(239, 68, 68, 0.05) 1px, transparent 1px), linear-gradient(90deg, rgba(239, 68, 68, 0.05) 1px, transparent 1px);
            background-size: 50px 50px;
        }
    </style>
</head>

<body class="h-full flex items-center justify-center relative">

    <div class="cyber-grid fixed inset-0 opacity-30"></div>
    <div class="fixed top-10 right-20 w-32 h-32 border border-red-600/20 rounded-lg floating-element holo-glow"></div>
    <div class="fixed bottom-20 left-10 w-24 h-24 border border-red-500/20 rounded-full floating-element holo-glow"
        style="animation-delay: 2s;"></div>
    <div class="fixed top-1/3 left-1/4 w-16 h-16 border border-red-400/20 rotate-45 floating-element holo-glow"
        style="animation-delay: 4s;"></div>
    <div class="fixed top-0 right-0 w-96 h-96 bg-red-600/10 rounded-full blur-[150px] holo-glow"></div>
    <div class="fixed bottom-0 left-0 w-80 h-80 bg-red-500/10 rounded-full blur-[120px] holo-glow"
        style="animation-delay: 2s;"></div>

    <div class="relative z-10 w-full max-w-xs px-4 mx-auto">
        <div class="floating-card">
            <div class="glass neon-border rounded-2xl border border-red-600/30 overflow-hidden relative">
                <div
                    class="scan-line absolute w-full h-0.5 bg-gradient-to-r from-transparent via-red-500/50 to-transparent">
                </div>
                <div class="h-0.5 bg-gradient-to-r from-transparent via-red-600 to-transparent"></div>

                <div class="p-6">
                    <div class="text-center mb-8">
                        <h1 class="text-2xl font-bold text-white tracking-widest mb-2"
                            style="text-shadow: 0 0 20px rgba(239, 68, 68, 0.5);">
                            VERIFY
                        </h1>
                        <div class="flex items-center justify-center gap-2">
                            <div class="h-px w-8 bg-gradient-to-r from-transparent to-red-600"></div>
                            <p class="text-xs text-gray-500 uppercase tracking-[0.3em]">Email Address</p>
                            <div class="h-px w-8 bg-gradient-to-l from-transparent to-red-600"></div>
                        </div>
                    </div>

                    <div class="mb-6 text-xs text-gray-400 text-center leading-relaxed">
                        Terima kasih telah mendaftar! Sebelum memulai, verifikasi email Anda dengan mengklik link yang
                        telah kami kirimkan.
                    </div>

                    @if (session('status') == 'verification-link-sent')
                        <div
                            class="mb-6 text-xs text-green-500 text-center font-medium bg-green-500/10 border border-green-500/30 rounded-lg p-3">
                            Link verifikasi baru telah dikirim ke email Anda.
                        </div>
                    @endif

                    <div class="space-y-4">
                        <form method="POST" action="{{ route('verification.send') }}">
                            @csrf
                            <button type="submit"
                                class="btn-cyber w-full py-3.5 bg-gradient-to-r from-red-600 to-red-700 hover:from-red-500 hover:to-red-600 text-white font-bold text-sm uppercase tracking-widest rounded-lg transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 focus:ring-offset-black">
                                <span class="relative z-10">Resend Email</span>
                            </button>
                        </form>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit"
                                class="w-full text-xs text-gray-500 hover:text-red-500 transition-colors uppercase tracking-wide py-2">
                                Log Out
                            </button>
                        </form>
                    </div>
                </div>

                <div class="h-0.5 bg-gradient-to-r from-transparent via-red-600 to-transparent"></div>
            </div>

            <div class="text-center mt-6">
                <p class="text-xs text-gray-700 uppercase tracking-widest">&copy; {{ date('Y') }} WebGIS Tegalsambi</p>
            </div>
        </div>
    </div>
</body>

</html>