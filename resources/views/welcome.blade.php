<!DOCTYPE html>
<html lang="id" x-data="{ loaded: false }" x-init="setTimeout(() => loaded = true, 100)">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Peminjaman Barang Studio - SMK Pesat IT XPRO</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link
        href="https://fonts.bunny.net/css?family=inter:300,400,500,600,700,800&family=poppins:300,400,500,600,700,800&display=swap"
        rel="stylesheet" />

    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        'inter': ['Inter', 'sans-serif'],
                        'poppins': ['Poppins', 'sans-serif'],
                    },
                    colors: {
                        'brand': {
                            primary: '#2C3262',
                            secondary: '#F1A004',
                            accent: '#FFFFFF'
                        }
                    },
                    animation: {
                        'float': 'float 6s ease-in-out infinite',
                        'slide-up': 'slideUp 0.6s ease-out',
                        'fade-in': 'fadeIn 0.8s ease-out',
                        'scale-in': 'scaleIn 0.5s ease-out',
                        'bounce-slow': 'bounce 3s infinite',
                        'pulse-slow': 'pulse 4s cubic-bezier(0.4, 0, 0.6, 1) infinite',
                    },
                    keyframes: {
                        float: {
                            '0%, 100%': {
                                transform: 'translateY(0px)'
                            },
                            '50%': {
                                transform: 'translateY(-20px)'
                            },
                        },
                        slideUp: {
                            '0%': {
                                transform: 'translateY(50px)',
                                opacity: '0'
                            },
                            '100%': {
                                transform: 'translateY(0)',
                                opacity: '1'
                            },
                        },
                        fadeIn: {
                            '0%': {
                                opacity: '0'
                            },
                            '100%': {
                                opacity: '1'
                            },
                        },
                        scaleIn: {
                            '0%': {
                                transform: 'scale(0.9)',
                                opacity: '0'
                            },
                            '100%': {
                                transform: 'scale(1)',
                                opacity: '1'
                            },
                        }
                    }
                }
            }
        }
    </script>

    <style>
        .glass-effect {
            background: rgba(44, 50, 98, 0.15);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border: 1px solid rgba(241, 160, 4, 0.2);
        }

        .gradient-text {
            background: linear-gradient(135deg, #F1A004 0%, #FFFFFF 50%, #2C3262 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .gradient-bg {
            background: linear-gradient(135deg, #2C3262 0%, #1a1d3a 100%);
        }

        .hero-pattern {
            background-image:
                radial-gradient(circle at 25px 25px, rgba(241, 160, 4, 0.1) 2%, transparent 2%),
                radial-gradient(circle at 75px 75px, rgba(255, 255, 255, 0.05) 2%, transparent 2%);
            background-size: 100px 100px;
        }

        .studio-shadow {
            box-shadow:
                0 1px 3px rgba(241, 160, 4, 0.12),
                0 1px 2px rgba(241, 160, 4, 0.24),
                0 0 0 1px rgba(241, 160, 4, 0.05);
        }

        .floating-equipment {
            animation: float 6s ease-in-out infinite;
        }

        .floating-equipment:nth-child(2) {
            animation-delay: 2s;
        }

        .floating-equipment:nth-child(3) {
            animation-delay: 4s;
        }
    </style>
</head>

<body class="font-inter gradient-bg text-white overflow-x-hidden" x-data="{ loading: true }" x-init="setTimeout(() => loading = false, 1500)">

    <!-- Loading Overlay -->
    <div x-show="loading"
        class="fixed inset-0 z-50 flex flex-col items-center justify-center bg-indigo-900/80 backdrop-blur-sm transition-opacity duration-500"
        x-transition.opacity>

        <!-- Spinner -->
        <div
            class="w-16 h-16 border-4 border-t-indigo-700 border-r-transparent border-b-indigo-700 border-l-transparent rounded-full animate-spin mb-4">
        </div>

        <!-- Loading Text -->
        <p class="text-white text-lg font-semibold animate-pulse">
            Memuat Halaman...
        </p>
        <p class="text-indigo-200 text-sm mt-1 text-center max-w-xs">
            Mohon tunggu sebentar, semua data sedang dipersiapkan.
        </p>
    </div>

    <div x-show="!loading" x-transition.opacity class="min-h-screen">
        <div class="fixed inset-0 hero-pattern opacity-10 pointer-events-none"></div>

        <!-- Floating Elements -->
        <div class="fixed inset-0 pointer-events-none">
            <!-- Floating Equipment Icons -->
            <div
                class="floating-equipment absolute top-20 left-10 w-8 h-10 bg-gradient-to-r from-yellow-500 to-orange-500 rounded opacity-20 transform rotate-12">
            </div>
            <div
                class="floating-equipment absolute top-40 right-20 w-6 h-8 bg-gradient-to-r from-blue-600 to-indigo-600 rounded opacity-20 transform -rotate-12">
            </div>
            <div
                class="floating-equipment absolute bottom-32 left-20 w-7 h-9 bg-gradient-to-r from-yellow-400 to-orange-400 rounded opacity-20 transform rotate-45">
            </div>
            <div
                class="floating-equipment absolute bottom-20 right-10 w-5 h-7 bg-gradient-to-r from-orange-400 to-yellow-400 rounded opacity-20 transform -rotate-45">
            </div>

            <!-- Gradient Orbs -->
            <div
                class="absolute top-10 right-10 w-72 h-72 bg-gradient-to-r from-yellow-400 to-orange-400 rounded-full mix-blend-multiply filter blur-xl opacity-30 animate-pulse-slow">
            </div>
            <div class="absolute bottom-10 left-10 w-72 h-72 bg-gradient-to-r from-orange-400 to-yellow-400 rounded-full mix-blend-multiply filter blur-xl opacity-30 animate-pulse-slow"
                style="animation-delay: 2s;"></div>
        </div>

        <!-- Navigation -->
        <nav class="relative z-50 py-6" x-show="loaded" x-transition:enter="transition ease-out duration-500"
            x-transition:enter-start="opacity-0 transform -translate-y-4"
            x-transition:enter-end="opacity-100 transform translate-y-0">
            <div class="container mx-auto px-6">
                <div class="flex justify-between items-center">
                    <div class="flex items-center space-x-3">
                        <div
                            class="w-10 h-10 bg-gradient-to-r from-yellow-500 to-orange-500 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M20 6h-2.18c.11-.31.18-.65.18-1a2.996 2.996 0 00-5.5-1.65l-.5.67-.5-.68C10.96 2.54 10.05 2 9 2 7.34 2 6 3.34 6 5c0 .35.07.69.18 1H4c-1.11 0-2 .89-2 2v11c0 1.11.89 2 2 2h16c1.11 0 2-.89 2-2V8c0-1.11-.89-2-2-2z" />
                            </svg>
                        </div>
                        <span class="text-xl font-bold gradient-text">Studio Equipment</span>
                    </div>
                    <div class="flex items-center space-x-4 text-sm">
                        <div class="glass-effect px-4 py-2 rounded-lg">
                            <span id="current-time" class="font-medium text-white"></span>
                        </div>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Main Content -->
        <main class="relative z-10 min-h-screen flex items-center justify-center px-6">
            <div class="container mx-auto">
                <div class="grid lg:grid-cols-2 gap-12 items-center max-w-6xl mx-auto">

                    <!-- Left Content -->
                    <div class="text-center lg:text-left space-y-8" x-show="loaded"
                        x-transition:enter="transition ease-out duration-700"
                        x-transition:enter-start="opacity-0 transform -translate-x-8"
                        x-transition:enter-end="opacity-100 transform translate-x-0">

                        <!-- Badge -->
                        <div class="inline-flex items-center space-x-2 glass-effect px-4 py-2 rounded-full text-sm">
                            <div class="w-2 h-2 bg-yellow-400 rounded-full animate-pulse"></div>
                            <span class="text-white">Studio Rental System</span>
                        </div>

                        <!-- Main Heading -->
                        <div class="space-y-4">
                            <h1 class="text-4xl md:text-6xl font-bold leading-tight">
                                <span class="block gradient-text">Selamat Datang</span>
                                <span class="block text-white/90">Di Peminjaman</span>
                                <span class="block text-2xl md:text-3xl font-medium" style="color: #F1A004;">Studio
                                    Equipment</span>
                            </h1>
                            <p class="text-lg text-white/80 font-medium">SMK Pesat IT XPRO</p>
                        </div>

                        <!-- Description -->
                        <p class="text-lg text-white/70 leading-relaxed max-w-xl mx-auto lg:mx-0">
                            Akses mudah dan cepat untuk meminjam peralatan studio profesional. Dukung proyek kreatif dan
                            pembelajaran Anda dengan sistem terpercaya.
                        </p>

                        <!-- Features -->
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 pt-4">
                            <div
                                class="glass-effect p-4 rounded-lg text-center group hover:bg-yellow-500/10 transition-all duration-300">
                                <div
                                    class="w-8 h-8 bg-gradient-to-r from-blue-600 to-indigo-600 rounded-lg mx-auto mb-2 flex items-center justify-center group-hover:scale-110 transition-transform">
                                    <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 24 24">
                                        <path
                                            d="M20 4H4c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2z" />
                                    </svg>
                                </div>
                                <span class="text-sm font-medium text-white">Camera Pro</span>
                            </div>
                            <div
                                class="glass-effect p-4 rounded-lg text-center group hover:bg-yellow-500/10 transition-all duration-300">
                                <div
                                    class="w-8 h-8 bg-gradient-to-r from-purple-600 to-pink-600 rounded-lg mx-auto mb-2 flex items-center justify-center group-hover:scale-110 transition-transform">
                                    <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 24 24">
                                        <path
                                            d="M12 14c1.66 0 2.99-1.34 2.99-3L15 5c0-1.66-1.34-3-3-3S9 3.34 9 5v6c0 1.66 1.34 3 3 3z" />
                                    </svg>
                                </div>
                                <span class="text-sm font-medium text-white">Audio Studio</span>
                            </div>
                            <div
                                class="glass-effect p-4 rounded-lg text-center group hover:bg-yellow-500/10 transition-all duration-300">
                                <div
                                    class="w-8 h-8 bg-gradient-to-r from-yellow-500 to-orange-500 rounded-lg mx-auto mb-2 flex items-center justify-center group-hover:scale-110 transition-transform">
                                    <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 24 24">
                                        <path
                                            d="M9 21c0 .55.45 1 1 1h4c.55 0 1-.45 1-1v-1H9v1zm3-19C8.14 2 5 5.14 5 9c0 2.38 1.19 4.47 3 5.74V17c0 .55.45 1 1 1h6c.55 0 1-.45 1-1v-2.26c1.81-1.27 3-3.36 3-5.74 0-3.86-3.14-7-7-7z" />
                                    </svg>
                                </div>
                                <span class="text-sm font-medium text-white">Lighting Set</span>
                            </div>
                        </div>

                        <!-- CTA Button -->
                        <div class="pt-4">
                            <a href="{{ route('dashboard') }}"
                                class="group relative inline-flex items-center justify-center px-8 py-4 text-lg font-semibold text-white transition-all duration-300 bg-gradient-to-r from-yellow-500 to-orange-500 rounded-xl hover:from-yellow-600 hover:to-orange-600 focus:outline-none focus:ring-4 focus:ring-yellow-500/50 transform hover:scale-105 hover:-translate-y-1 shadow-2xl hover:shadow-yellow-500/25">
                                <span class="relative z-10 flex items-center">
                                    <span>Mulai Peminjaman</span>
                                    <svg class="ml-2 w-5 h-5 transition-transform group-hover:translate-x-1"
                                        fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </span>
                                <div
                                    class="absolute inset-0 rounded-xl bg-gradient-to-r from-yellow-500 to-orange-500 opacity-0 group-hover:opacity-100 transition-opacity duration-300 filter blur-xl">
                                </div>
                            </a>
                        </div>
                    </div>

                    <!-- Right Content - Hero Illustration -->
                    <div class="relative" x-show="loaded"
                        x-transition:enter="transition ease-out duration-700 delay-300"
                        x-transition:enter-start="opacity-0 transform translate-x-8"
                        x-transition:enter-end="opacity-100 transform translate-x-0">

                        <!-- Main Illustration Container -->
                        <div class="relative z-10">
                            <div class="relative w-full max-w-lg mx-auto">
                                <!-- Glow Effect -->
                                <div
                                    class="absolute inset-0 bg-gradient-to-r from-yellow-400 to-orange-400 rounded-2xl filter blur-3xl opacity-30 animate-pulse-slow">
                                </div>

                                <!-- Studio Equipment Illustration -->
                                <div class="relative glass-effect rounded-2xl p-8 studio-shadow">
                                    <!-- Equipment Stack Illustration -->
                                    <div class="space-y-4">
                                        <!-- Equipment Stack -->
                                        <div class="flex justify-center items-end space-x-2">
                                            <div
                                                class="w-16 h-20 bg-gradient-to-b from-blue-600 to-indigo-600 rounded-lg transform rotate-6 shadow-lg">
                                            </div>
                                            <div
                                                class="w-16 h-24 bg-gradient-to-b from-yellow-500 to-orange-500 rounded-lg transform -rotate-3 shadow-lg">
                                            </div>
                                            <div
                                                class="w-16 h-28 bg-gradient-to-b from-purple-600 to-pink-600 rounded-lg transform rotate-2 shadow-lg">
                                            </div>
                                            <div
                                                class="w-16 h-22 bg-gradient-to-b from-green-600 to-teal-600 rounded-lg transform -rotate-6 shadow-lg">
                                            </div>
                                        </div>

                                        <!-- Status Indicators -->
                                        <div class="flex justify-center space-x-4 pt-4">
                                            <div class="w-3 h-3 bg-green-400 rounded-full animate-ping"></div>
                                            <div class="w-3 h-3 bg-yellow-400 rounded-full animate-ping"
                                                style="animation-delay: 0.5s;"></div>
                                            <div class="w-3 h-3 bg-orange-400 rounded-full animate-ping"
                                                style="animation-delay: 1s;"></div>
                                        </div>

                                        <!-- Text -->
                                        <div class="text-center pt-4">
                                            <div class="text-2xl font-bold gradient-text">Studio Equipment</div>
                                            <div class="text-sm text-white/60 mt-1">Siap Dipinjam</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Decorative Elements -->
                        <div
                            class="absolute -top-4 -right-4 w-24 h-24 bg-gradient-to-r from-yellow-400 to-orange-400 rounded-full opacity-20 animate-bounce-slow">
                        </div>
                        <div class="absolute -bottom-8 -left-8 w-16 h-16 bg-gradient-to-r from-orange-400 to-yellow-400 rounded-full opacity-20 animate-bounce-slow"
                            style="animation-delay: 1s;"></div>
                    </div>
                </div>
            </div>
        </main>

        <!-- Footer -->
        <footer class="relative z-10 mt-20 py-8">
            <div class="container mx-auto px-6">
                <div class="glass-effect rounded-2xl p-6">
                    <div class="flex flex-col md:flex-row justify-between items-center space-y-4 md:space-y-0">
                        <div class="text-center md:text-left">
                            <p class="text-white/80 text-sm">
                                © 2024 SMK Pesat IT XPRO - Sistem Peminjaman Studio
                            </p>
                        </div>
                        <div class="flex items-center space-x-6 text-sm text-white/60">
                            <span class="flex items-center">
                                <div class="w-2 h-2 bg-green-400 rounded-full mr-2 animate-pulse"></div>
                                Server Online
                            </span>
                            <span class="text-yellow-400 font-medium">v2.1</span>
                        </div>
                    </div>
                </div>
            </div>
        </footer>

        <script>
            // Real-time clock
            function updateTime() {
                const now = new Date();
                const options = {
                    weekday: 'long',
                    year: 'numeric',
                    month: 'long',
                    day: 'numeric',
                    hour: '2-digit',
                    minute: '2-digit'
                };

                const timeString = now.toLocaleDateString('id-ID', options);
                document.getElementById('current-time').textContent = timeString;
            }

            updateTime();
            setInterval(updateTime, 1000);

            // Simple interactive particles with brand colors
            // document.addEventListener('mousemove', (e) => {
            //     const cursor = document.createElement('div');
            //     const colors = ['bg-yellow-400', 'bg-orange-500'];
            //     const randomColor = colors[Math.floor(Math.random() * colors.length)];
            //     cursor.className = `fixed w-1 h-1 ${randomColor} rounded-full pointer-events-none z-50 opacity-60`;
            //     cursor.style.left = e.clientX + 'px';
            //     cursor.style.top = e.clientY + 'px';
            //     document.body.appendChild(cursor);

            //     setTimeout(() => {
            //         cursor.remove();
            //     }, 1000);
            // });
        </script>
    </div>
</body>

</html>
