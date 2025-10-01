<!-- Ionicons -->
<script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>

<button data-drawer-target="default-sidebar" data-drawer-toggle="default-sidebar" aria-controls="default-sidebar"
    type="button"
    class="inline-flex items-center p-2 mt-2 ml-3 text-sm text-gray-500 rounded-lg sm:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600">
    <span class="sr-only">Open sidebar</span>
    <svg class="w-6 h-6" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
        <path clip-rule="evenodd" fill-rule="evenodd"
            d="M2 4.75A.75.75 0 012.75 4h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 4.75zm0 10.5a.75.75 0 01.75-.75h7.5a.75.75 0 010 1.5h-7.5a.75.75 0 01-.75-.75zM2 10a.75.75 0 01.75-.75h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 10z">
        </path>
    </svg>
</button>

<aside x-data="{
    open: JSON.parse(localStorage.getItem('sidebarOpen') || 'false'),
    setOpen(value) {
        this.open = value;
        localStorage.setItem('sidebarOpen', value);
        window.dispatchEvent(new Event('sidebar-toggled'));
    }
}" @mouseenter="setOpen(true)" @mouseleave="setOpen(false)" :class="open ? 'w-64' : 'w-16'"
    class="fixed top-0 left-0 h-screen bg-gray-800 text-white transition-all duration-300">
    <div
        class="relative flex flex-col h-full overflow-y-auto py-5 px-3 shadow-xl transition-all duration-500
           bg-gradient-to-b from-[#2C3262] to-[#1E224A] dark:from-[#1E224A] dark:to-[#14172E]
           border-r border-white/10 dark:border-white/5">

        <!-- shimmer tipis -->
        <div
            class="absolute inset-0 bg-gradient-to-tr from-white/5 via-transparent to-white/5 
                animate-[shimmer_6s_linear_infinite] blur-xl opacity-20 pointer-events-none">
        </div>

        <!-- siluet kecil -->
        <span
            class="absolute w-24 h-24 bg-white/10 dark:bg-white/5 rounded-full blur-3xl 
                 top-1/4 left-6 animate-pulse"></span>
        <span
            class="absolute w-32 h-16 bg-white/10 dark:bg-white/5 rounded-full blur-2xl 
                 bottom-1/3 right-4 animate-bounce"></span>
        <ul class="space-y-2 flex-grow">
            <div class="flex items-center justify-center rounded-md h-16">
                <h1 class="flex items-center font-bold text-white space-x-3">
                    <div
                        class="bg-white/90 backdrop-blur-md rounded-full p-1 flex items-center justify-center shadow-sm">
                        <img src="/images/login.png" alt="Logo" class="w-15 h-8">
                    </div>
                    <span x-show="open"
                        class="text-lg font-extrabold bg-gradient-to-r from-[#ffff] to-[#F1A004] bg-clip-text text-transparent tracking-wide">
                        SMK Pesat Studio
                    </span>
                </h1>
            </div>
            <button id="theme-toggle"
                class="p-2 rounded-lg bg-gray-200 dark:bg-gray-700 text-gray-900 dark:text-gray-200">
            </button>

            <li>
                <a href="{{ route('dashboard') }}"
                    class="relative flex items-center p-3 rounded-lg 
          text-gray-700 dark:text-gray-200 font-semibold
          transition-all duration-500 ease-in-out
          hover:bg-gradient-to-r hover:from-indigo-500 hover:to-purple-600 hover:text-white
          hover:shadow-lg hover:shadow-indigo-500/30
          hover:scale-[1.02] hover:translate-x-1
          group">

                    <!-- Indicator bar kiri -->
                    <span
                        class="absolute left-0 top-0 h-full w-1 rounded-r-lg bg-gradient-to-b from-indigo-500 to-purple-600 
                 opacity-0 group-hover:opacity-100 transition-opacity duration-500"></span>

                    <!-- Icon -->
                    <ion-icon name="grid-sharp"
                        class="flex-shrink-0 w-6 h-6 text-indigo-500 dark:text-yellow-400 
                     group-hover:text-white transition-colors duration-500"></ion-icon>

                    <!-- Label -->
                    <span x-show="open" class="ml-3 group-hover:text-white transition-colors duration-500">
                        Dashboard
                    </span>
                </a>

            </li>

            @if (Auth::check() && (Auth::user()->role == 'admin' || Auth::user()->role == 'supervisor'))
                <li>
                    <!-- Tombol utama -->
                    <button type="button"
                        class="relative flex items-center p-3 w-full rounded-lg font-semibold
               text-gray-700 dark:text-gray-200
               transition-all duration-500 ease-in-out
               hover:bg-gradient-to-r hover:from-indigo-500 hover:to-purple-600 hover:text-white
               hover:scale-[1.02] hover:translate-x-1 hover:shadow-lg hover:shadow-indigo-500/30
               group"
                        aria-controls="dropdown-pages" data-collapse-toggle="dropdown-pages" aria-expanded="false">

                        <!-- Indicator bar kiri -->
                        <span
                            class="absolute left-0 top-0 h-full w-1 rounded-r-lg 
                 bg-gradient-to-b from-indigo-500 to-purple-600 
                 opacity-0 group-hover:opacity-100 transition-opacity duration-500"></span>

                        <!-- Icon -->
                        <ion-icon name="cube-sharp"
                            class="flex-shrink-0 w-6 h-6 text-indigo-500 dark:text-yellow-400 
                     group-hover:text-white transition-colors duration-500"></ion-icon>

                        <!-- Label -->
                        <span x-show="open"
                            class="flex-1 ml-3 text-left whitespace-nowrap 
                 group-hover:text-white transition-colors duration-500">
                            Inventaris
                        </span>

                        <!-- Panah -->
                        <svg aria-hidden="true"
                            class="w-5 h-5 text-gray-500 dark:text-gray-300 
                transition-transform duration-500 group-aria-expanded:rotate-180"
                            fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                clip-rule="evenodd"></path>
                        </svg>
                    </button>

                    <!-- Dropdown Menu -->
                    <ul id="dropdown-pages" class="hidden py-2 space-y-2">
                        @if (Auth::check() && Auth::user()->role == 'admin')
                            <li>
                                <a href="{{ route('books.create') }}" x-show="open"
                                    class="relative flex items-center p-2 pl-12 rounded-md 
                  text-gray-700 dark:text-gray-200 
                  transition-all duration-500 ease-in-out
                  hover:bg-gradient-to-r hover:from-indigo-500 hover:to-purple-600 hover:text-white
                  hover:scale-[1.02] hover:translate-x-1 hover:shadow-lg hover:shadow-indigo-500/30
                  group">
                                    <span
                                        class="absolute left-6 w-1 h-6 rounded-full bg-indigo-400 
                         opacity-0 group-hover:opacity-100 transition-opacity"></span>
                                    Tambah Barang
                                </a>
                            </li>
                        @endif
                        <li>
                            <a href="{{ route('books.index') }}" x-show="open"
                                class="relative flex items-center p-2 pl-12 rounded-md 
                  text-gray-700 dark:text-gray-200 
                  transition-all duration-500 ease-in-out
                  hover:bg-gradient-to-r hover:from-indigo-500 hover:to-purple-600 hover:text-white
                  hover:scale-[1.02] hover:translate-x-1 hover:shadow-lg hover:shadow-indigo-500/30
                  group">
                                <span
                                    class="absolute left-6 w-1 h-6 rounded-full bg-indigo-400 
                         opacity-0 group-hover:opacity-100 transition-opacity"></span>
                                Daftar Barang
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.borrowedBooks') }}" x-show="open"
                                class="relative flex items-center p-2 pl-12 rounded-md 
                  text-gray-700 dark:text-gray-200 
                  transition-all duration-500 ease-in-out
                  hover:bg-gradient-to-r hover:from-indigo-500 hover:to-purple-600 hover:text-white
                  hover:scale-[1.02] hover:translate-x-1 hover:shadow-lg hover:shadow-indigo-500/30
                  group">
                                <span
                                    class="absolute left-6 w-1 h-6 rounded-full bg-indigo-400 
                         opacity-0 group-hover:opacity-100 transition-opacity"></span>
                                Daftar Peminjaman
                            </a>
                        </li>
                    </ul>





                <li>



                <li>
                    <a href="{{ route('users.index') }}"
                        class="relative flex items-center p-2 rounded-lg 
              text-gray-700 dark:text-gray-200 font-semibold
              transition-all duration-500 ease-in-out
              hover:bg-gradient-to-r hover:from-indigo-500 hover:to-purple-600 hover:text-white
              hover:scale-[1.02] hover:translate-x-1 hover:shadow-lg hover:shadow-indigo-500/30
              group">

                        <!-- Indicator bar kiri -->
                        <span
                            class="absolute left-0 top-0 h-full w-1 rounded-r-lg 
                     bg-gradient-to-b from-indigo-500 to-purple-600 
                     opacity-0 group-hover:opacity-100 transition-opacity duration-500"></span>

                        <!-- Icon -->
                        <ion-icon name="people-sharp"
                            class="flex-shrink-0 w-6 h-6 text-indigo-500 dark:text-yellow-400 
                         group-hover:text-white transition-colors duration-500"></ion-icon>

                        <!-- Label -->
                        <span x-show="open" class="ml-3 group-hover:text-white transition-colors duration-500">
                            Daftar User
                        </span>
                    </a>
                </li>


                <li>
                    <a href="{{ route('admin.confirmRequests') }}"
                        class="relative flex items-center p-2 rounded-lg 
              text-gray-700 dark:text-gray-200 font-semibold
              transition-all duration-500 ease-in-out
              hover:bg-gradient-to-r hover:from-indigo-500 hover:to-purple-600 hover:text-white
              hover:scale-[1.02] hover:translate-x-1 hover:shadow-lg hover:shadow-indigo-500/30
              group">

                        <!-- Indicator bar kiri -->
                        <span
                            class="absolute left-0 top-0 h-full w-1 rounded-r-lg 
                     bg-gradient-to-b from-indigo-500 to-purple-600 
                     opacity-0 group-hover:opacity-100 transition-opacity duration-500"></span>

                        <!-- Icon -->
                        <ion-icon name="checkmark-circle-sharp"
                            class="flex-shrink-0 w-6 h-6 text-indigo-500 dark:text-yellow-400 
                         group-hover:text-white transition-colors duration-500"></ion-icon>

                        <!-- Label -->
                        <span x-show="open" class="ml-3 group-hover:text-white transition-colors duration-500">
                            Konfirmasi
                        </span>
                    </a>
                </li>


                </li>

            @endif

            @if (Auth::check() && Auth::user()->role == 'anggota')
                <li>
                    <button type="button"
                        class="relative flex items-center p-3 w-full rounded-lg font-semibold
                   text-gray-700 dark:text-gray-200
                   transition-all duration-500 ease-in-out
                   hover:bg-gradient-to-r hover:from-indigo-500 hover:to-purple-600
                   hover:text-white hover:shadow-lg hover:shadow-indigo-500/30
                   hover:scale-[1.02] hover:translate-x-1
                   group"
                        aria-controls="dropdown-lemari" data-collapse-toggle="dropdown-lemari" aria-expanded="false">

                        <!-- Indicator bar kiri -->
                        <span
                            class="absolute left-0 top-0 h-full w-1 rounded-r-lg 
                     bg-gradient-to-b from-indigo-500 to-purple-600 
                     opacity-0 group-hover:opacity-100 transition-opacity duration-500"></span>

                        <!-- Icon -->
                        <ion-icon name="cube-sharp"
                            class="flex-shrink-0 w-6 h-6 text-indigo-500 dark:text-yellow-400 
                         group-hover:text-white transition-colors duration-500"></ion-icon>

                        <!-- Label -->
                        <span x-show="open"
                            class="flex-1 ml-3 text-left whitespace-nowrap group-hover:text-white transition-colors duration-500">
                            Inventaris
                        </span>

                        <!-- Arrow -->
                        <svg aria-hidden="true"
                            class="w-5 h-5 text-gray-500 dark:text-gray-300 transition-transform duration-500 group-aria-expanded:rotate-180"
                            fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                clip-rule="evenodd"></path>
                        </svg>
                    </button>

                    <!-- Dropdown Menu -->
                    <ul id="dropdown-lemari" class="hidden py-2 space-y-2">
                        <li>
                            <a href="{{ route('anggota.index') }}" x-show="open"
                                class="relative flex items-center p-2 pl-12 w-full rounded-lg
                  text-gray-700 dark:text-gray-200 font-normal
                  transition-all duration-500 hover:bg-gradient-to-r hover:from-indigo-500 hover:to-purple-600
                  hover:text-white hover:shadow-lg hover:shadow-indigo-500/30
                  hover:scale-[1.02] hover:translate-x-1 group">
                                <span
                                    class="absolute left-6 top-0 h-full w-1 rounded-r-lg bg-gradient-to-b from-indigo-500 to-purple-600 
                     opacity-0 group-hover:opacity-100 transition-opacity duration-500"></span>
                                Daftar Barang
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('anggota.borrowed') }}" x-show="open"
                                class="relative flex items-center p-2 pl-12 w-full rounded-lg
                      text-gray-700 dark:text-gray-200 font-normal
                      transition-all duration-500 hover:bg-gradient-to-r hover:from-indigo-500 hover:to-purple-600
                      hover:text-white hover:shadow-lg hover:shadow-indigo-500/30
                      hover:scale-[1.02] hover:translate-x-1 group">
                                <span
                                    class="absolute left-6 top-0 h-full w-1 rounded-r-lg bg-gradient-to-b from-indigo-500 to-purple-600 
                             opacity-0 group-hover:opacity-100 transition-opacity duration-500"></span>
                                Riwayat Peminjaman
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('anggota.pending_requests') }}" x-show="open"
                                class="relative flex items-center p-2 pl-12 w-full rounded-lg
                      text-gray-700 dark:text-gray-200 font-normal
                      transition-all duration-500 hover:bg-gradient-to-r hover:from-indigo-500 hover:to-purple-600
                      hover:text-white hover:shadow-lg hover:shadow-indigo-500/30
                      hover:scale-[1.02] hover:translate-x-1 group">
                                <span
                                    class="absolute left-6 top-0 h-full w-1 rounded-r-lg bg-gradient-to-b from-indigo-500 to-purple-600 
                             opacity-0 group-hover:opacity-100 transition-opacity duration-500"></span>
                                Informasi Peminjaman
                            </a>
                        </li>
                    </ul>
                </li>
            @endif



            @guest
                <li>
                    <a href="{{ route('anggota.index') }}"
                        class="relative flex items-center p-3 rounded-lg 
                  text-gray-700 dark:text-gray-200 font-semibold
                  transition-all duration-500 ease-in-out
                  hover:bg-gradient-to-r hover:from-indigo-500 hover:to-purple-600 hover:text-white
                  hover:shadow-lg hover:shadow-indigo-500/30
                  hover:scale-[1.02] hover:translate-x-1
                  group">

                        <!-- Indicator bar kiri -->
                        <span
                            class="absolute left-0 top-0 h-full w-1 rounded-r-lg bg-gradient-to-b from-indigo-500 to-purple-600 
                         opacity-0 group-hover:opacity-100 transition-opacity duration-500"></span>

                        <!-- Icon -->
                        <ion-icon name="cube-outline"
                            class="flex-shrink-0 w-6 h-6 text-indigo-500 dark:text-yellow-400 
                             group-hover:text-white transition-colors duration-500"></ion-icon>

                        <!-- Label -->
                        <span x-show="open" class="ml-3 group-hover:text-white transition-colors duration-500">
                            Daftar Barang
                        </span>
                    </a>
                </li>
            @endguest




        </ul>
        @guest
            <ul class="pt-5 mt-5 space-y-2 border-t border-gray-200 dark:border-gray-700">


                <li>
                    <a href="{{ route('login') }}"
                        class="relative flex items-center p-3 rounded-lg 
              text-gray-700 dark:text-gray-200 font-semibold
              transition-all duration-500 ease-in-out
              hover:bg-gradient-to-r hover:from-green-500 hover:to-lime-500 hover:text-white
              hover:shadow-lg hover:shadow-green-500/30
              hover:scale-[1.02] hover:translate-x-1
              group">

                        <!-- Indicator bar kiri -->
                        <span
                            class="absolute left-0 top-0 h-full w-1 rounded-r-lg bg-gradient-to-b from-green-500 to-lime-500 
                     opacity-0 group-hover:opacity-100 transition-opacity duration-500"></span>

                        <!-- Icon -->
                        <ion-icon name="log-in-outline"
                            class="flex-shrink-0 w-6 h-6 text-green-500 dark:text-green-400 
                         group-hover:text-white transition-colors duration-500"></ion-icon>

                        <!-- Label -->
                        <span x-show="open" class="ml-3 group-hover:text-white transition-colors duration-500">
                            Login
                        </span>
                    </a>
                </li>


                <li>
                    <a href="{{ route('register') }}"
                        class="relative flex items-center p-3 rounded-lg 
              text-gray-700 dark:text-gray-200 font-semibold
              transition-all duration-500 ease-in-out
              hover:bg-gradient-to-r hover:from-blue-500 hover:to-indigo-500 hover:text-white
              hover:shadow-lg hover:shadow-blue-500/30
              hover:scale-[1.02] hover:translate-x-1
              group">

                        <!-- Indicator bar kiri -->
                        <span
                            class="absolute left-0 top-0 h-full w-1 rounded-r-lg bg-gradient-to-b from-blue-500 to-indigo-500 
                   opacity-0 group-hover:opacity-100 transition-opacity duration-500"></span>

                        <!-- Icon -->
                        <ion-icon name="person-add-outline"
                            class="flex-shrink-0 w-6 h-6 text-blue-500 dark:text-blue-400 
                         group-hover:text-white transition-colors duration-500"></ion-icon>

                        <!-- Label -->
                        <span x-show="open" class="ml-3 group-hover:text-white transition-colors duration-500">
                            Register
                        </span>
                    </a>
                </li>

            </ul>


        @endguest
        @auth
            <ul class="pt-5 mt-5 space-y-2 border-t border-gray-200 dark:border-gray-700">
                <li>
                    <!-- Log Out -->
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit"
                            class="relative flex items-center w-full p-3 rounded-lg
                           text-gray-700 dark:text-gray-200 font-semibold
                           transition-all duration-500 ease-in-out
                           hover:bg-gradient-to-r hover:from-red-500 hover:to-pink-500 hover:text-white
                           hover:shadow-lg hover:shadow-red-500/30
                           hover:scale-[1.02] hover:translate-x-1
                           group">

                            <!-- Indicator bar kiri -->
                            <span
                                class="absolute left-0 top-0 h-full w-1 rounded-r-lg bg-gradient-to-b from-red-500 to-pink-500 
                             opacity-0 group-hover:opacity-100 transition-opacity duration-500"></span>

                            <!-- Icon Logout -->
                            <ion-icon name="log-out-outline"
                                class="flex-shrink-0 w-6 h-6 text-red-500 dark:text-red-400 
                                 group-hover:text-white transition-colors duration-500"></ion-icon>

                            <!-- Label -->
                            <span x-show="open" class="ml-3 group-hover:text-white transition-colors duration-500">
                                Log Out
                            </span>
                        </button>
                    </form>
                </li>
            </ul>

        @endauth
    </div>

</aside>

<script>
    const themeToggleBtn = document.getElementById("theme-toggle");

    // cek tema terakhir
    if (localStorage.getItem("theme") === "dark") {
        document.documentElement.classList.add("dark");
    }

    function updateIcon() {
        themeToggleBtn.innerHTML = document.documentElement.classList.contains("dark") ?
            "🌞" // kalau dark → ikon matahari
            :
            "🌙"; // kalau light → ikon bulan
    }

    // set icon awal
    updateIcon();

    themeToggleBtn.addEventListener("click", () => {
        document.documentElement.classList.toggle("dark");

        if (document.documentElement.classList.contains("dark")) {
            localStorage.setItem("theme", "dark");
        } else {
            localStorage.setItem("theme", "light");
        }

        updateIcon();
    });
</script>
