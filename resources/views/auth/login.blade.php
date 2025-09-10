<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel - Dark Mode</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Tailwind CSS -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>

    <body class="font-poppins text-gray-300 bg-gray-900 dark:bg-gray-900 dark:text-gray-300">
        <main class="min-h-screen flex items-center justify-center px-4 sm:px-6 lg:px-8">
            <div class="max-w-6xl w-full flex bg-gray-800 rounded-xl shadow-lg overflow-hidden">
                <!-- Sisi kiri - Gambar -->
                <div class="hidden lg:block lg:w-1/2 bg-cover bg-center" 
                     style="background-image: url('{{ asset('storage/orang.png') }}');">
                </div>

                <!-- Sisi kanan - Formulir Masuk -->
                <div class="w-full lg:w-1/2 p-8 md:p-12 space-y-8">
                    <div class="text-center">
                        <img class="mx-auto h-12 mb-6 w-auto">
                        <h2 class="text-3xl font-extrabold text-gray-100">
                            Selamat Datang Kembali!
                        </h2>
                        <p class="mt-2 text-sm text-gray-400">
                            Masuk ke akun Perpustakaan Anda
                        </p>
                    </div>

                    <!-- Error Notification -->
              

                    <form class="mt-8 space-y-6" id="form-signin" method="POST" action="{{ route('login') }}">
                        @csrf
                        <div class="space-y-4">
                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-300">Alamat Email</label>
                                <div class="mt-1 relative rounded-md shadow-sm">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                            <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z" />
                                            <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z" />
                                        </svg>
                                    </div>
                                    <input id="email" name="email" type="email" autocomplete="email" required
                                           class="appearance-none block w-full px-3 py-3 pl-10 border border-gray-600 rounded-md bg-gray-700 placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 transition duration-150 ease-in-out sm:text-sm"
                                           placeholder="Masukkan email Anda" value="{{ old('email') }}">
                                </div>
                                <!-- Menampilkan pesan error untuk email -->
                                @error('email')
                                    <div class="mt-2 text-sm text-red-600">{{ $message }}</div>
                                @enderror
                            </div>

                            <div>
                                <label for="password" class="block text-sm font-medium text-gray-300">Kata Sandi</label>
                                <div class="mt-1 relative rounded-md shadow-sm">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                            <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                    <input id="password" name="password" type="password" autocomplete="current-password" required
                                           class="appearance-none block w-full px-3 py-3 pl-10 border border-gray-600 rounded-md bg-gray-700 placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 transition duration-150 ease-in-out sm:text-sm"
                                           placeholder="Masukkan kata sandi Anda">
                                </div>
                                <!-- Menampilkan pesan error untuk password -->
                                @error('password')
                                    <div class="mt-2 text-sm text-red-600">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <input id="remember-me" name="remember-me" type="checkbox" 
                                       class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-600 rounded transition duration-150 ease-in-out">
                                <label for="remember-me" class="ml-2 block text-sm text-gray-300">
                                    Ingat saya
                                </label>
                            </div>

                            <div class="text-sm">
                                <a href="{{ route('password.request') }}" 
                                   class="font-medium text-indigo-400 hover:text-indigo-300 transition duration-150 ease-in-out">
                                    Lupa kata sandi?
                                </a>
                            </div>
                        </div>

                        <div>
                            <button type="submit"
                                    class="group relative w-full flex justify-center py-3 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition duration-150 ease-in-out transform hover:scale-105">
                                Masuk
                            </button>
                        </div>
                    </form>

                    <div class="mt-6 text-center">
                        <p class="text-sm text-gray-400">
                            Belum punya akun?
                            <a href="{{ route('register') }}" 
                               class="font-medium text-indigo-400 hover:text-indigo-300 transition duration-150 ease-in-out">
                                Daftar sekarang
                            </a>
                        </p>
                    </div>
                </div>
            </div>
        </main>
    </body>
</html>
