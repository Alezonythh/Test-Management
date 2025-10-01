<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel - Register</title>

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
            Memuat halaman Register…
        </p>
        <p class="text-gray-500 dark:text-gray-400 text-sm mt-1">
            Mohon tunggu sebentar, semua data sedang dipersiapkan.
        </p>
    </div>
    <main x-show="!loading" x-transition.opacity class="min-h-screen flex">
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
                        Buat Akun Baru
                    </h2>
                    <p class="text-base text-gray-600">
                        Akses peminjaman <span class="font-semibold text-[#F1A004]">Studio Pesat</span>
                    </p>
                </div>

                <!-- Form Register -->
                <form class="mt-6 space-y-6" method="POST" action="{{ route('register') }}">
                    @csrf

                    <!-- Nama -->
                    <div class="relative z-0 w-full group">
                        <input type="text" name="name" id="name" value="{{ old('name') }}"
                            class="block py-3 px-0 w-full text-sm text-gray-900 bg-transparent border-0
                                      border-b-2 border-gray-300 appearance-none focus:outline-none
                                      focus:ring-0 focus:border-[#F1A004] peer"
                            placeholder=" " required autofocus />
                        <label for="name"
                            class="peer-focus:font-medium absolute text-sm text-gray-500 duration-300 transform
                                      -translate-y-6 scale-75 top-3 -z-10 origin-[0]
                                      peer-focus:text-[#F1A004] peer-placeholder-shown:scale-100
                                      peer-placeholder-shown:translate-y-0 peer-focus:scale-75
                                      peer-focus:-translate-y-6">
                            Nama Lengkap
                        </label>
                        @error('name')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

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
                                      focus:ring-0 focus:border-[#F1A004] peer"
                            placeholder=" " required />
                        <label for="password"
                            class="peer-focus:font-medium absolute text-sm text-gray-500 duration-300 transform
                                      -translate-y-6 scale-75 top-3 -z-10 origin-[0]
                                      peer-focus:text-[#F1A004] peer-placeholder-shown:scale-100
                                      peer-placeholder-shown:translate-y-0 peer-focus:scale-75
                                      peer-focus:-translate-y-6">
                            Kata Sandi
                        </label>
                        @error('password')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Konfirmasi Password -->
                    <div class="relative z-0 w-full group">
                        <input type="password" name="password_confirmation" id="password_confirmation"
                            class="block py-3 px-0 w-full text-sm text-gray-900 bg-transparent border-0
                                      border-b-2 border-gray-300 appearance-none focus:outline-none
                                      focus:ring-0 focus:border-[#F1A004] peer"
                            placeholder=" " required />
                        <label for="password_confirmation"
                            class="peer-focus:font-medium absolute text-sm text-gray-500 duration-300 transform
                                      -translate-y-6 scale-75 top-3 -z-10 origin-[0]
                                      peer-focus:text-[#F1A004] peer-placeholder-shown:scale-100
                                      peer-placeholder-shown:translate-y-0 peer-focus:scale-75
                                      peer-focus:-translate-y-6">
                            Konfirmasi Kata Sandi
                        </label>
                        @error('password_confirmation')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Tombol Register -->
                    <button type="submit"
                        class="w-full py-3 rounded-lg text-base font-semibold
                                   text-white bg-gradient-to-r from-[#F1A004] to-[#facc15]
                                   hover:from-[#e69600] hover:to-[#d4a500]
                                   focus:outline-none focus:ring-4 focus:ring-[#F1A004]/50
                                   transition-all transform hover:scale-[1.02] shadow-lg">
                        Daftar Sekarang
                    </button>

                    <!-- Link ke Login -->
                    <p class="text-center text-sm text-gray-600">
                        Sudah punya akun?
                        <a href="{{ route('login') }}"
                            class="font-semibold text-[#F1A004] hover:text-[#b37700] transition">
                            Masuk Disini
                        </a>
                    </p>
                </form>
            </div>
        </div>
    </main>
</body>

</html>
