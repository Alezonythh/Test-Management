<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel - Login</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Tailwind CSS -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-poppins bg-gray-100" x-data="{ loading: true }" x-init="setTimeout(() => loading = false, 1500)">

    <!-- Loading Overlay -->
    <div x-show="loading"
        class="fixed inset-0 z-50 flex flex-col items-center justify-center bg-white dark:bg-gray-900 transition-opacity duration-500"
        x-transition.opacity>

        <!-- Spinner -->
        <div
            class="w-16 h-16 border-4 border-t-indigo-500 border-r-transparent border-b-indigo-500 border-l-transparent rounded-full animate-spin mb-4">
        </div>

        <!-- Loading Text -->
        <p class="text-gray-700 dark:text-gray-300 text-lg font-semibold animate-pulse">
            Memuat halaman Login…
        </p>
        <p class="text-gray-500 dark:text-gray-400 text-sm mt-1">
            Mohon tunggu sebentar, semua data sedang dipersiapkan.
        </p>
    </div>
    <main x-show="!loading" x-transition.opacity class="min-h-screen flex">
        <!-- Bagian Kiri -->
        <!-- Bagian Kiri -->
        <div class="hidden lg:flex lg:w-1/2 bg-[#F1A004] bg-center bg-no-repeat bg-contain"
            style="background-image: url('{{ asset('images/login.png') }}');">
        </div>

        <!-- Bagian Kanan -->
        <div class="w-full lg:w-1/2 bg-white flex items-center justify-center p-8 md:p-12">
            <div class="max-w-md w-full space-y-10">

                <!-- Heading -->
                <div class="text-center space-y-2">
                    <h2 class="text-4xl font-bold text-[#F1A004]">
                        Selamat Datang
                    </h2>
                    <p class="text-base text-gray-600">
                        Akses peminjaman <span class="font-semibold text-[#F1A004]">Studio Pesat</span>
                    </p>
                </div>

                <!-- Form Login -->
                <form class="mt-6 space-y-6" method="POST" action="{{ route('login') }}">
                    @csrf

                    <!-- Email -->
                    <div class="relative z-0 w-full group">
                        <input type="email" name="email" id="email" value="{{ old('email') }}"
                            class="block py-3 px-0 w-full text-sm text-gray-900 bg-transparent border-0
                              border-b-2 border-gray-300 appearance-none focus:outline-none
                              focus:ring-0 focus:border-[#F1A004] peer"
                            placeholder=" " required />
                        <label for="email"
                            class="peer-focus:font-medium absolute text-sm text-gray-500 duration-300 transform
                              -translate-y-6 scale-75 top-3 -z-10 origin-[0]
                              peer-focus:text-[#F1A004] peer-placeholder-shown:scale-100
                              peer-placeholder-shown:translate-y-0 peer-focus:scale-75
                              peer-focus:-translate-y-6">
                            Alamat Email
                        </label>
                        @error('email')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div class="relative z-0 w-full group">
                        <input type="password" name="password" id="password"
                            class="block py-3 px-0 w-full text-sm text-gray-900 bg-transparent border-0
                  border-b-2 border-gray-300 appearance-none focus:outline-none
                  focus:ring-0 focus:border-[#F1A004] peer pr-10"
                            placeholder=" " required />

                        <label for="password"
                            class="peer-focus:font-medium absolute text-sm text-gray-500 duration-300 transform
                  -translate-y-6 scale-75 top-3 -z-10 origin-[0]
                  peer-focus:text-[#F1A004] peer-placeholder-shown:scale-100
                  peer-placeholder-shown:translate-y-0 peer-focus:scale-75
                  peer-focus:-translate-y-6">
                            Kata Sandi
                        </label>

                        <!-- Icon Mata -->
                        <button type="button" onclick="togglePassword()"
                            class="absolute right-0 top-3 text-[#F1A004] hover:text-[#b37700] focus:outline-none">
                            <svg id="eye-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51
                     7.36 4.5 12 4.5c4.638 0 8.573 3.007
                     9.963 7.178.07.207.07.431 0 .639C20.577
                     16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                        </button>

                        @error('password')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <!-- Ingat Saya & Lupa Password -->
                    <div class="flex items-center justify-between text-sm">

                        <a href="{{ route('password.request') }}"
                            class="font-medium text-[#F1A004] hover:text-[#b37700] transition">
                            Lupa kata sandi?
                        </a>
                    </div>

                    <!-- Tombol Login -->
                    <button type="submit"
                        class="w-full py-3 rounded-lg text-base font-semibold
                           text-white bg-gradient-to-r from-[#F1A004] to-[#facc15]
                           hover:from-[#e69600] hover:to-[#d4a500]
                           focus:outline-none focus:ring-4 focus:ring-[#F1A004]/50
                           transition-all transform hover:scale-[1.02] shadow-lg">
                        Masuk Sekarang
                    </button>

                    <!-- Link ke Register -->
                    <p class="text-center text-sm text-gray-600">
                        Belum punya akun?
                        <a href="{{ route('register') }}"
                            class="font-semibold text-[#F1A004] hover:text-[#b37700] transition">
                            Daftar Sekarang
                        </a>
                    </p>
                </form>
            </div>
        </div>


    </main>
</body>

</html>

<!-- Script Toggle -->
<script>
    function togglePassword() {
        const passwordInput = document.getElementById('password');
        const eyeIcon = document.getElementById('eye-icon');

        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            eyeIcon.outerHTML = `
            <svg id="eye-icon" xmlns="http://www.w3.org/2000/svg" 
                 fill="none" viewBox="0 0 24 24" stroke-width="1.5" 
                 stroke="currentColor" class="w-5 h-5">
                <path stroke-linecap="round" stroke-linejoin="round" 
                      d="M3.98 8.223A10.477 10.477 0 001.934 
                         12C3.226 16.338 7.244 19.5 12 19.5c.993 
                         0 1.953-.138 2.863-.395M6.228 6.228A10.451 
                         10.451 0 0112 4.5c4.756 0 8.773 3.162 
                         10.065 7.5a10.523 10.523 0 01-4.293 
                         5.774M6.228 6.228L3 3m3.228 3.228l12.544 
                         12.544M21 21l-3-3"/>
            </svg>`;
        } else {
            passwordInput.type = 'password';
            eyeIcon.outerHTML = `
            <svg id="eye-icon" xmlns="http://www.w3.org/2000/svg" 
                 fill="none" viewBox="0 0 24 24" stroke-width="1.5" 
                 stroke="currentColor" class="w-5 h-5">
                <path stroke-linecap="round" stroke-linejoin="round"
                      d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 
                         7.36 4.5 12 4.5c4.638 0 8.573 3.007 
                         9.963 7.178.07.207.07.431 0 .639C20.577 
                         16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z"/>
                <path stroke-linecap="round" stroke-linejoin="round"
                      d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
            </svg>`;
        }
    }
</script>
