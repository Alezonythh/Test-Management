<!DOCTYPE html>
<html lang="id" x-data="{ loaded: false }" x-init="setTimeout(() => loaded = true, 100)">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>e-Perpustakaan SMK Pesat IT XPRO</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:300,400,500,600,700,800&family=poppins:300,400,500,600,700,800&display=swap" rel="stylesheet" />
    
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
                        'primary': {
                            50: '#eff6ff',
                            100: '#dbeafe',
                            200: '#bfdbfe',
                            300: '#93c5fd',
                            400: '#60a5fa',
                            500: '#3b82f6',
                            600: '#2563eb',
                            700: '#1d4ed8',
                            800: '#1e40af',
                            900: '#1e3a8a',
                        },
                        'accent': {
                            50: '#fdf4ff',
                            100: '#fae8ff',
                            200: '#f5d0fe',
                            300: '#f0abfc',
                            400: '#e879f9',
                            500: '#d946ef',
                            600: '#c026d3',
                            700: '#a21caf',
                            800: '#86198f',
                            900: '#701a75',
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
                            '0%, 100%': { transform: 'translateY(0px)' },
                            '50%': { transform: 'translateY(-20px)' },
                        },
                        slideUp: {
                            '0%': { transform: 'translateY(50px)', opacity: '0' },
                            '100%': { transform: 'translateY(0)', opacity: '1' },
                        },
                        fadeIn: {
                            '0%': { opacity: '0' },
                            '100%': { opacity: '1' },
                        },
                        scaleIn: {
                            '0%': { transform: 'scale(0.9)', opacity: '0' },
                            '100%': { transform: 'scale(1)', opacity: '1' },
                        }
                    }
                }
            }
        }
    </script>

    <style>
        .glass-effect {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        
        .dark .glass-effect {
            background: rgba(0, 0, 0, 0.3);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .gradient-text {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .gradient-bg {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }

        .hero-pattern {
            background-image: 
                radial-gradient(circle at 25px 25px, rgba(255,255,255,0.2) 2%, transparent 2%),
                radial-gradient(circle at 75px 75px, rgba(255,255,255,0.1) 2%, transparent 2%);
            background-size: 100px 100px;
        }

        .book-shadow {
            box-shadow: 
                0 1px 3px rgba(0,0,0,0.12),
                0 1px 2px rgba(0,0,0,0.24),
                0 0 0 1px rgba(255,255,255,0.05);
        }

        .floating-books {
            animation: float 6s ease-in-out infinite;
        }

        .floating-books:nth-child(2) {
            animation-delay: 2s;
        }

        .floating-books:nth-child(3) {
            animation-delay: 4s;
        }
    </style>
</head>

<body class="font-inter bg-gradient-to-br from-slate-900 via-purple-900 to-slate-900 text-white overflow-x-hidden">
    <!-- Background Pattern -->
    <div class="fixed inset-0 hero-pattern opacity-10 pointer-events-none"></div>
    
    <!-- Floating Elements -->
    <div class="fixed inset-0 pointer-events-none">
        <!-- Floating Books -->
        <div class="floating-books absolute top-20 left-10 w-8 h-10 bg-gradient-to-r from-blue-400 to-purple-500 rounded opacity-20 transform rotate-12"></div>
        <div class="floating-books absolute top-40 right-20 w-6 h-8 bg-gradient-to-r from-purple-400 to-pink-500 rounded opacity-20 transform -rotate-12"></div>
        <div class="floating-books absolute bottom-32 left-20 w-7 h-9 bg-gradient-to-r from-green-400 to-blue-500 rounded opacity-20 transform rotate-45"></div>
        <div class="floating-books absolute bottom-20 right-10 w-5 h-7 bg-gradient-to-r from-pink-400 to-red-500 rounded opacity-20 transform -rotate-45"></div>
        
        <!-- Gradient Orbs -->
        <div class="absolute top-10 right-10 w-72 h-72 bg-gradient-to-r from-purple-400 to-pink-400 rounded-full mix-blend-multiply filter blur-xl opacity-30 animate-pulse-slow"></div>
        <div class="absolute bottom-10 left-10 w-72 h-72 bg-gradient-to-r from-yellow-400 to-pink-400 rounded-full mix-blend-multiply filter blur-xl opacity-30 animate-pulse-slow" style="animation-delay: 2s;"></div>
    </div>

    <!-- Navigation -->
    <nav class="relative z-50 py-6" 
         x-show="loaded" 
         x-transition:enter="transition ease-out duration-500"
         x-transition:enter-start="opacity-0 transform -translate-y-4"
         x-transition:enter-end="opacity-100 transform translate-y-0">
        <div class="container mx-auto px-6">
            <div class="flex justify-between items-center">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-gradient-to-r from-blue-400 to-purple-500 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <span class="text-xl font-bold gradient-text">e-Perpustakaan</span>
                </div>
                <div class="flex items-center space-x-4 text-sm">
                    <div class="glass-effect px-4 py-2 rounded-lg">
                        <span id="current-time" class="font-medium"></span>
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
                <div class="text-center lg:text-left space-y-8"
                     x-show="loaded"
                     x-transition:enter="transition ease-out duration-700"
                     x-transition:enter-start="opacity-0 transform -translate-x-8"
                     x-transition:enter-end="opacity-100 transform translate-x-0">
                    
                    <!-- Badge -->
                    <div class="inline-flex items-center space-x-2 glass-effect px-4 py-2 rounded-full text-sm">
                        <div class="w-2 h-2 bg-green-400 rounded-full animate-pulse"></div>
                        <span>Online Library System</span>
                    </div>
                    
                    <!-- Main Heading -->
                    <div class="space-y-4">
                        <h1 class="text-4xl md:text-6xl font-bold leading-tight">
                            <span class="block gradient-text">Selamat Datang</span>
                            <span class="block text-white/90">di e-Perpustakaan</span>
                            <span class="block text-2xl md:text-3xl font-medium text-purple-300">SMK Pesat IT XPRO</span>
                        </h1>
                    </div>
                    
                    <!-- Description -->
                    <p class="text-lg text-white/70 leading-relaxed max-w-xl mx-auto lg:mx-0">
                        Temukan ribuan koleksi buku digital berkualitas tinggi. Akses mudah, cepat, dan terpercaya untuk mendukung pembelajaran Anda.
                    </p>
                    
                    <!-- Features -->
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 pt-4">
                        <div class="glass-effect p-4 rounded-lg text-center group hover:bg-white/20 transition-all duration-300">
                            <div class="w-8 h-8 bg-blue-500 rounded-lg mx-auto mb-2 flex items-center justify-center group-hover:scale-110 transition-transform">
                                <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                            <span class="text-sm font-medium">5000+ Buku</span>
                        </div>
                        <div class="glass-effect p-4 rounded-lg text-center group hover:bg-white/20 transition-all duration-300">
                            <div class="w-8 h-8 bg-purple-500 rounded-lg mx-auto mb-2 flex items-center justify-center group-hover:scale-110 transition-transform">
                                <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M12 6V4a2 2 0 00-2-2H8a2 2 0 00-2 2v2H4a2 2 0 00-2 2v6a2 2 0 002 2h8a2 2 0 002-2V8a2 2 0 00-2-2h-2z"/>
                                </svg>
                            </div>
                            <span class="text-sm font-medium">24/7 Akses</span>
                        </div>
                        <div class="glass-effect p-4 rounded-lg text-center group hover:bg-white/20 transition-all duration-300">
                            <div class="w-8 h-8 bg-green-500 rounded-lg mx-auto mb-2 flex items-center justify-center group-hover:scale-110 transition-transform">
                                <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zM3 10a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1v-6zM14 9a1 1 0 00-1 1v6a1 1 0 001 1h2a1 1 0 001-1v-6a1 1 0 00-1-1h-2z"/>
                                </svg>
                            </div>
                            <span class="text-sm font-medium">Gratis</span>
                        </div>
                    </div>
                    
                    <!-- CTA Button -->
                    <div class="pt-4"
                         x-data="{ hover: false }"
                         @mouseenter="hover = true"
                         @mouseleave="hover = false">
                        <a href="{{ route('dashboard') }}"
   class="group relative inline-flex items-center justify-center px-8 py-4 text-lg font-semibold text-white transition-all duration-300 bg-gradient-to-r from-purple-600 to-blue-600 rounded-xl hover:from-purple-700 hover:to-blue-700 focus:outline-none focus:ring-4 focus:ring-purple-500/50 transform hover:scale-105 hover:-translate-y-1 shadow-2xl hover:shadow-purple-500/25">
    <span class="relative z-10 flex items-center">
        <span>Mulai Jelajah</span>
        <svg class="ml-2 w-5 h-5 transition-transform group-hover:translate-x-1" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd"/>
        </svg>
    </span>
    <div class="absolute inset-0 rounded-xl bg-gradient-to-r from-purple-600 to-blue-600 opacity-0 group-hover:opacity-100 transition-opacity duration-300 filter blur-xl"></div>
</a>

                    </div>
                </div>
                
                <!-- Right Content - Hero Image -->
                <div class="relative"
                     x-show="loaded"
                     x-transition:enter="transition ease-out duration-700 delay-300"
                     x-transition:enter-start="opacity-0 transform translate-x-8"
                     x-transition:enter-end="opacity-100 transform translate-x-0">
                    
                    <!-- Main Image Container -->
                    <div class="relative z-10">
                        <div class="relative w-full max-w-lg mx-auto">
                            <!-- Glow Effect -->
                            <div class="absolute inset-0 bg-gradient-to-r from-purple-400 to-blue-400 rounded-2xl filter blur-3xl opacity-30 animate-pulse-slow"></div>
                            
                            <!-- Image Placeholder - Replace with your actual image -->
                            <div class="relative glass-effect rounded-2xl p-8 book-shadow">
                                <!-- Book Stack Illustration -->
                                <div class="space-y-4">
                                    <!-- Books Stack -->
                                    <div class="flex justify-center items-end space-x-2">
                                        <div class="w-16 h-20 bg-gradient-to-b from-red-400 to-red-600 rounded-lg transform rotate-6 shadow-lg"></div>
                                        <div class="w-16 h-24 bg-gradient-to-b from-blue-400 to-blue-600 rounded-lg transform -rotate-3 shadow-lg"></div>
                                        <div class="w-16 h-28 bg-gradient-to-b from-green-400 to-green-600 rounded-lg transform rotate-2 shadow-lg"></div>
                                        <div class="w-16 h-22 bg-gradient-to-b from-purple-400 to-purple-600 rounded-lg transform -rotate-6 shadow-lg"></div>
                                    </div>
                                    
                                    <!-- Digital Elements -->
                                    <div class="flex justify-center space-x-4 pt-4">
                                        <div class="w-3 h-3 bg-green-400 rounded-full animate-ping"></div>
                                        <div class="w-3 h-3 bg-blue-400 rounded-full animate-ping" style="animation-delay: 0.5s;"></div>
                                        <div class="w-3 h-3 bg-purple-400 rounded-full animate-ping" style="animation-delay: 1s;"></div>
                                    </div>
                                    
                                    <!-- Text -->
                                    <div class="text-center pt-4">
                                        <div class="text-2xl font-bold gradient-text">Digital Library</div>
                                        <div class="text-sm text-white/60 mt-1">Akses Unlimited</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Decorative Elements -->
                    <div class="absolute -top-4 -right-4 w-24 h-24 bg-gradient-to-r from-yellow-400 to-orange-400 rounded-full opacity-20 animate-bounce-slow"></div>
                    <div class="absolute -bottom-8 -left-8 w-16 h-16 bg-gradient-to-r from-pink-400 to-purple-400 rounded-full opacity-20 animate-bounce-slow" style="animation-delay: 1s;"></div>
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
                            © 2024 SMK Pesat IT XPRO - e-Perpustakaan Digital
                        </p>
                    </div>
                    <div class="flex items-center space-x-6 text-sm text-white/60">
                        <span class="flex items-center">
                            <div class="w-2 h-2 bg-green-400 rounded-full mr-2 animate-pulse"></div>
                            Server Online
                        </span>
                        <span>Versi 2.0</span>
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
        
        // Add some interactive particles
        document.addEventListener('mousemove', (e) => {
            const cursor = document.createElement('div');
            cursor.className = 'fixed w-1 h-1 bg-purple-400 rounded-full pointer-events-none z-50 opacity-50';
            cursor.style.left = e.clientX + 'px';
            cursor.style.top = e.clientY + 'px';
            document.body.appendChild(cursor);
            
            setTimeout(() => {
                cursor.remove();
            }, 1000);
        });
    </script>
</body>
</html>