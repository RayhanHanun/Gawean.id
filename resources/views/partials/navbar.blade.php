<!-- Hidden classes untuk Tailwind -->
<div class="hidden bg-white bg-purple-700 text-purple-700 text-gray-700 border-purple-700 shadow-purple-700/30 hover:bg-purple-800 hover:bg-purple-50 ring-1 ring-black/5"></div>

<nav id="navbar" class="fixed top-0 left-0 w-full z-50 bg-transparent shadow-none transition-all duration-300">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">

            <a href="{{ route('home') }}" class="flex items-center gap-2 group">
                <div class="w-10 h-10 bg-gradient-to-br from-purple-500 to-indigo-600 rounded-lg flex items-center justify-center group-hover:scale-105 transition-transform">
                    <span class="text-white font-bold text-xl">G</span>
                </div>
                <span id="logo-text" class="text-xl font-bold text-white transition-colors duration-300">
                    Gawean<span class="text-transparent bg-clip-text bg-gradient-to-r from-purple-600 to-indigo-600">.id</span>
                </span>
            </a>

            <div class="hidden md:flex items-center gap-8">
                <a href="{{ route('home') }}" class="nav-link text-white hover:text-gray-200 font-medium transition-colors relative group">
                    Beranda
                </a>
                <a href="{{ route('jobs.search') }}" class="nav-link text-white hover:text-gray-200 font-medium transition-colors relative group">
                    Cari Lowongan
                </a>
            </div>

            <div class="flex items-center gap-3">
                @guest
                    <a href="{{ route('login') }}" id="btn-login"
                       class="px-4 py-2 text-sm font-medium rounded-lg transition-all duration-300 border border-white text-white hover:bg-white/10">
                        Masuk
                    </a>
                    <a href="{{ route('register') }}" id="btn-register"
                       class="ml-2 px-5 py-2 text-sm font-medium rounded-lg transition-all duration-300 shadow-lg bg-white text-purple-700 hover:bg-gray-100">
                        Daftar
                    </a>
                @else
                    <a href="{{ auth()->user()->role === 'admin' ? route('admin.dashboard') : (auth()->user()->role === 'hrd' ? route('hrd.dashboard') : route('pelamar.dashboard')) }}"
                       class="px-5 py-2 bg-gradient-to-r from-purple-600 to-indigo-600 hover:from-purple-500 hover:to-indigo-500 text-white font-medium rounded-lg transition-all duration-300 shadow-lg shadow-purple-500/20 text-sm flex items-center gap-2">
                        <i class="fas fa-user"></i> Dashboard
                    </a>
                @endguest
            </div>

            <button class="md:hidden p-2" onclick="document.getElementById('mobile-menu').classList.toggle('hidden')">
                <i class="fas fa-bars text-gray-600 text-xl"></i>
            </button>
        </div>

        <div id="mobile-menu" class="hidden md:hidden pb-4 bg-white/90 backdrop-blur-md rounded-b-xl shadow-xl mt-2 p-4 absolute w-full left-0 md:static">
            <div class="flex flex-col gap-2">
                <a href="{{ route('home') }}" class="px-4 py-2 text-gray-700 hover:bg-purple-50 rounded-lg">Beranda</a>
                <a href="{{ route('jobs.search') }}" class="px-4 py-2 text-gray-700 hover:bg-purple-50 rounded-lg">Cari Lowongan</a>
            </div>
        </div>
    </div>
</nav>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const navbar = document.getElementById('navbar');
        const logoText = document.getElementById('logo-text');
        const links = document.querySelectorAll('.nav-link');
        const btnLogin = document.getElementById('btn-login');
        const btnRegister = document.getElementById('btn-register');

        // Function untuk update navbar style
        function updateNavbar() {
            if (window.scrollY > 10) {
                // ============================================
                // STATE: SCROLLED (NAVBAR PUTIH)
                // ============================================

                // 1. Navbar: Putih, Shadow Tebal dan Kontras
                navbar.className = "fixed top-0 left-0 w-full z-50 transition-all duration-300 bg-white shadow-lg ring-1 ring-black/5";

                // 2. Logo Text: Ungu
                if (logoText) {
                    logoText.className = "text-xl font-bold transition-colors duration-300 text-purple-700";
                }

                // 3. Links: Abu Gelap -> Hover Ungu
                links.forEach(link => {
                    link.className = "nav-link font-medium transition-colors relative group text-gray-700 hover:text-purple-700";
                });

                // 4. Tombol Login: Outline Ungu
                if (btnLogin) {
                    btnLogin.className = "px-4 py-2 text-sm font-medium rounded-lg transition-all duration-300 border border-purple-700 text-purple-700 hover:bg-purple-50";
                }

                // 5. Tombol Daftar: Background Ungu, Teks Putih
                if (btnRegister) {
                    btnRegister.className = "ml-2 px-5 py-2 text-sm font-medium rounded-lg transition-all duration-300 shadow-lg shadow-purple-700/30 bg-purple-700 text-white hover:bg-purple-800";
                    // Fallback inline style untuk memastikan warna terlihat
                    btnRegister.style.backgroundColor = "#7c3aed";
                    btnRegister.style.color = "#ffffff";
                }

            } else {
                // ============================================
                // STATE: TOP (NAVBAR TRANSPARAN)
                // ============================================

                // 1. Navbar: Transparan, No Shadow
                navbar.className = "fixed top-0 left-0 w-full z-50 transition-all duration-300 bg-transparent shadow-none";

                // 2. Logo Text: Putih
                if (logoText) {
                    logoText.className = "text-xl font-bold transition-colors duration-300 text-white";
                }

                // 3. Links: Putih
                links.forEach(link => {
                    link.className = "nav-link font-medium transition-colors relative group text-white hover:text-gray-200";
                });

                // 4. Tombol Login: Outline Putih
                if (btnLogin) {
                    btnLogin.className = "px-4 py-2 text-sm font-medium rounded-lg transition-all duration-300 border border-white text-white hover:bg-white/10";
                }

                // 5. Tombol Daftar: Background Putih, Teks Ungu
                if (btnRegister) {
                    btnRegister.className = "ml-2 px-5 py-2 text-sm font-medium rounded-lg transition-all duration-300 shadow-lg bg-white text-purple-700 hover:bg-gray-100";
                    // Reset inline style
                    btnRegister.style.backgroundColor = "";
                    btnRegister.style.color = "";
                }
            }
        }

        // Jalankan saat pertama load
        updateNavbar();

        // Scroll Event Listener
        window.addEventListener('scroll', updateNavbar);
    });
</script>

<style>
    /* Tambahan CSS untuk memastikan transition smooth */
    #btn-register {
        transition: all 0.3s ease-in-out;
    }

    /* Pastikan warna purple tersedia */
    .bg-purple-700 {
        background-color: #7c3aed !important;
    }

    .text-purple-700 {
        color: #7c3aed !important;
    }

    .hover\:bg-purple-800:hover {
        background-color: #6d28d9 !important;
    }

    /* Shadow yang lebih kontras untuk navbar scrolled */
    #navbar.bg-white {
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.15), 0 2px 4px -1px rgba(0, 0, 0, 0.1);
    }
</style>
