@php
    $transparentRoutes = ['home', 'jobs.search'];
    $isTransparentPage = in_array(Route::currentRouteName(), $transparentRoutes);

    $navClass = $isTransparentPage
        ? 'bg-transparent shadow-none'
        : 'bg-white shadow-md ring-1 ring-black/5';

    $textClass = $isTransparentPage
        ? 'text-white'
        : 'text-gray-700';

    $btnRegisterStyle = $isTransparentPage
        ? 'bg-white text-purple-700 hover:bg-gray-100'
        : 'bg-purple-700 text-white hover:bg-purple-800 shadow-purple-700/30';

    $btnLoginStyle = $isTransparentPage
        ? 'border-white text-white hover:bg-white/10'
        : 'border-purple-700 text-purple-700 hover:bg-purple-50';
@endphp

<div class="hidden bg-white text-gray-700 border-purple-700 shadow-lg ring-1 ring-black/5 bg-purple-700 text-white hover:bg-purple-800 border-white hover:bg-white/10"></div>

<nav id="navbar" class="fixed top-0 left-0 w-full z-50 transition-all duration-300 {{ $navClass }}">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <div class="flex justify-between items-center h-16 relative">

            <a href="{{ route('home') }}" class="flex items-center gap-2 group z-10">
                <span id="logo-text" class="text-xl font-bold transition-colors duration-300 {{ $isTransparentPage ? 'text-white' : 'text-purple-700' }}">
                    Gawean<span class="text-transparent bg-clip-text bg-gradient-to-r from-purple-600 to-indigo-600">.id</span>
                </span>
            </a>

            <div class="hidden md:flex items-center gap-8 absolute left-1/2 transform -translate-x-1/2">
                <a href="{{ route('home') }}" class="nav-link font-medium transition-colors relative group {{ $textClass }} hover:text-purple-700">
                    Beranda
                    <span class="absolute -bottom-1 left-0 w-0 h-0.5 bg-gradient-to-r from-purple-500 to-indigo-500 group-hover:w-full transition-all duration-300"></span>
                </a>
                <a href="{{ route('jobs.search') }}" class="nav-link font-medium transition-colors relative group {{ $textClass }} hover:text-purple-700">
                    Cari Lowongan
                    <span class="absolute -bottom-1 left-0 w-0 h-0.5 bg-gradient-to-r from-purple-500 to-indigo-500 group-hover:w-full transition-all duration-300"></span>
                </a>
            </div>

            <div class="flex items-center gap-3 z-10">
                @guest
                    <a href="{{ route('login') }}" id="btn-login"
                       class="px-4 py-2 text-sm font-medium rounded-lg transition-all duration-300 border {{ $btnLoginStyle }}">
                        Masuk
                    </a>
                    <a href="{{ route('register') }}" id="btn-register"
                       class="ml-2 px-5 py-2 text-sm font-medium rounded-lg transition-all duration-300 shadow-lg {{ $btnRegisterStyle }}">
                        Daftar
                    </a>
                @else
                    <a href="{{ auth()->user()->role === 'admin' ? route('admin.dashboard') : (auth()->user()->role === 'hrd' ? route('hrd.dashboard') : route('pelamar.dashboard')) }}"
                       class="px-5 py-2 bg-gradient-to-r from-purple-600 to-indigo-600 hover:from-purple-500 hover:to-indigo-500 text-white font-medium rounded-lg transition-all duration-300 shadow-lg shadow-purple-500/20 text-sm flex items-center gap-2">
                        <i class="fas fa-user"></i> Dashboard
                    </a>
                @endguest
            </div>

            <button class="md:hidden p-2 z-10" onclick="document.getElementById('mobile-menu').classList.toggle('hidden')">
                <i class="fas fa-bars text-gray-600 text-xl"></i>
            </button>
        </div>

        <div id="mobile-menu" class="hidden md:hidden pb-4 bg-white/90 backdrop-blur-md rounded-b-xl shadow-xl mt-2 p-4 absolute w-full left-0">
            <div class="flex flex-col gap-2">
                <a href="{{ route('home') }}" class="px-4 py-2 text-gray-700 hover:bg-purple-50 rounded-lg">Beranda</a>
                <a href="{{ route('jobs.search') }}" class="px-4 py-2 text-gray-700 hover:bg-purple-50 rounded-lg">Cari Lowongan</a>
            </div>
        </div>
    </div>
</nav>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const isTransparentPage = @json($isTransparentPage);

        const navbar = document.getElementById('navbar');
        const logoText = document.getElementById('logo-text');
        const links = document.querySelectorAll('.nav-link');
        const btnLogin = document.getElementById('btn-login');
        const btnRegister = document.getElementById('btn-register');

        function updateNavbar() {
            if (!isTransparentPage) return;

            if (window.scrollY > 10) {
                // SCROLLED
                navbar.className = "fixed top-0 left-0 w-full z-50 transition-all duration-300 bg-white shadow-lg ring-1 ring-black/5";
                if(logoText) logoText.className = "text-xl font-bold transition-colors duration-300 text-purple-700";

                links.forEach(link => {
                    link.className = "nav-link font-medium transition-colors relative group text-gray-700 hover:text-purple-700";
                });

                if (btnLogin) {
                    btnLogin.className = "px-4 py-2 text-sm font-medium rounded-lg transition-all duration-300 border border-purple-700 text-purple-700 hover:bg-purple-50";
                }
                if (btnRegister) {
                    btnRegister.className = "ml-2 px-5 py-2 text-sm font-medium rounded-lg transition-all duration-300 shadow-lg shadow-purple-700/30 bg-purple-700 text-white hover:bg-purple-800";
                }

            } else {
                // TOP
                navbar.className = "fixed top-0 left-0 w-full z-50 transition-all duration-300 bg-transparent shadow-none";
                if(logoText) logoText.className = "text-xl font-bold transition-colors duration-300 text-white";

                links.forEach(link => {
                    link.className = "nav-link font-medium transition-colors relative group text-white hover:text-gray-200";
                });

                if (btnLogin) {
                    btnLogin.className = "px-4 py-2 text-sm font-medium rounded-lg transition-all duration-300 border border-white text-white hover:bg-white/10";
                }
                if (btnRegister) {
                    btnRegister.className = "ml-2 px-5 py-2 text-sm font-medium rounded-lg transition-all duration-300 shadow-lg bg-white text-purple-700 hover:bg-gray-100";
                }
            }
        }

        if (isTransparentPage) {
            updateNavbar();
            window.addEventListener('scroll', updateNavbar);
        }
    });
</script>
