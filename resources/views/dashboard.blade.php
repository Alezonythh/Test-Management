<x-app-layout>

    <body class="bg-gray-100 font-roboto " style="margin-left: 250px">
        <div class="p-6">
            <!-- Header -->
            <div class="flex justify-end items-center mb-4">
                <div class="flex items-center space-x-4 text-white">
                    <p>{{now()->format('l,d M Y | H:i:s')}}</p>
                    <i class="fas fa-clock"></i>
                    <i class="fas fa-user-circle"></i>
                </div>
            </div>

            <!-- Dashboard Info Section -->
            <div class="bg-gradient-to-r from-red-500 to-blue-600 rounded-lg shadow-lg p-6 mb-6 text-white">
                <div class="flex flex-wrap items-center">
                    <img
                        src="{{ asset('storage/orang.png') }}"
                        alt="Welcome Image"
                        class="w-full sm:w-1/2 md:w-2/3 lg:w-1/4 mx-auto md:mx-0" />
                    <div class="mt-6 md:mt-0 md:ml-10 text-center md:text-left">
                        @auth
                        <h1 class="text-4xl font-bold mb-3">Hallo, {{Auth::user()->name}}!</h1>
                        @else
                        <h1 class="text-4xl font-bold mb-3">Selamat Datang!</h1>
                        @endauth
                        <p class="mb-4">Selamat Datang Di Website Perpustakaan Online. Temukan buku menarik untuk dibaca atau dipinjam <br>, yang di jamin menawarkan buku-buku bagus terbaik dan berkualitas</p>
                        <div class="flex space-x-4">
                        @auth
                        @if (Auth::user()->role == 'admin')
                            <a href="{{route('admin.borrowedBooks')}}">
                                <button class="relative inline-flex items-center justify-center p-0.5 mb-2 me-2 overflow-hidden text-sm font-medium text-gray-900 rounded-lg group bg-gradient-to-br from-red-600 to-blue-500 group-hover:from-purple-600 group-hover:to-blue-500 hover:text-white dark:text-white focus:ring-4 focus:outline-none focus:ring-blue-300 dark:focus:ring-blue-800">
                                    <span class="relative px-5 py-2.5 transition-all ease-in duration-75 bg-white dark:bg-gray-900 rounded-md group-hover:bg-opacity-0">
                                        Informasi Riwayat
                                    </span>
                                </button>
                            </a>
                            <a href="{{route('books.index')}}">
                                <button class="relative inline-flex items-center justify-center p-0.5 mb-2 me-2 overflow-hidden text-sm font-medium text-gray-900 rounded-lg group bg-gradient-to-br from-red-600 to-blue-500 group-hover:from-purple-600 group-hover:to-blue-500 hover:text-white dark:text-white focus:ring-4 focus:outline-none focus:ring-blue-300 dark:focus:ring-blue-800">
                                    <span class="relative px-5 py-2.5 transition-all ease-in duration-75 bg-white dark:bg-gray-900 rounded-md group-hover:bg-opacity-0">
                                        Pinjam Buku
                                    </span>
                                </button>
                            </a>
                            @endif
                            @if (Auth::user()->role == 'anggota')
                            <a href="{{route('anggota.index')}}">
                                <button class="relative inline-flex items-center justify-center p-0.5 mb-2 overflow-hidden text-sm font-medium text-gray-900 rounded-lg group bg-gradient-to-br from-red-600 to-blue-500 group-hover:from-purple-600 group-hover:to-blue-500 hover:text-white dark:text-white focus:ring-4 focus:outline-none focus:ring-blue-300 dark:focus:ring-blue-800">
                                    <span class="relative px-5 py-2.5 transition-all ease-in duration-75 bg-white dark:bg-gray-900 rounded-md group-hover:bg-opacity-0">
                                        PINJAM BUKU
                                    </span>
                                </button>
                            </a>
                            <a href="{{route('anggota.borrowed')}}">
                                <button class="relative inline-flex items-center justify-center p-0.5 mb-2 me-2 overflow-hidden text-sm font-medium text-gray-900 rounded-lg group bg-gradient-to-br from-red-600 to-blue-500 group-hover:from-purple-600 group-hover:to-blue-500 hover:text-white dark:text-white focus:ring-4 focus:outline-none focus:ring-blue-300 dark:focus:ring-blue-800">
                                    <span class="relative px-5 py-2.5 transition-all ease-in duration-75 bg-white dark:bg-gray-900 rounded-md group-hover:bg-opacity-0">
                                        RIWAYAT PEMINJAMAN
                                    </span>
                                </button>
                            </a>
                            @endif
                            @endauth
                        </div>
                    </div>
                </div>
             
            </div>

            <!-- Cards Section -->
            <div class="bg-gradient-to-r from-red-500 to-blue-600 rounded-lg shadow-lg p-6 mb-6">
                <div class="flex flex-row justify-between gap-4">
                    <!-- Total Buku -->
                    <div class="p-4 bg-[#8FD14F] rounded-xl text-white w-full transform transition-all duration-300 hover:scale-105 hover:shadow-lg">
                        <div class="flex flex-row justify-between items-center mb-8">
                            <i class="fa-solid fa-book text-6xl"></i>
                            <h1 class="font-extrabold text-3xl">{{ $totalBuku }}</h1>
                        </div>
                        <div class="flex flex-col items-center">
                            <p class="text-center">Total Buku</p>
                        </div>
                    </div>

                    <!-- Buku Tersedia -->
                    <div class="p-4 bg-[#347928] rounded-xl text-white w-full transform transition-all duration-300 hover:scale-105 hover:shadow-lg">
                        <div class="flex flex-row justify-between items-center mb-8">
                            <i class="fa-solid fa-book text-6xl"></i>
                            <h1 class="font-extrabold text-3xl">{{ $totalstat }}</h1>
                        </div>
                        <div class="flex flex-col items-center">
                            <p class="text-center">Buku Tersedia</p>
                        </div>
                    </div>

                    <!-- Buku Tidak Tersedia -->
                    <div class="p-4 bg-[#FF2929] rounded-xl text-white w-full transform transition-all duration-300 hover:scale-105 hover:shadow-lg">
                        <div class="flex flex-row justify-between items-center mb-8">
                            <i class="fa-solid fa-book text-6xl"></i>
                            <h1 class="font-extrabold text-3xl">{{ $totalava }}</h1>
                        </div>
                        <div class="flex flex-col items-center">
                            <p class="text-center">Buku Tidak Tersedia</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</x-app-layout>
