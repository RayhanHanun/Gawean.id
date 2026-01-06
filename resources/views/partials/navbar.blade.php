<nav id="navbar" class="fixed top-0 left-0 w-full z-50 bg-transparent shadow-none transition-all duration-300">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">
            <!-- Logo -->
            <a href="{{ route('home') }}" class="flex items-center gap-2 group">
                <div class="w-10 h-10 bg-gradient-to-br from-purple-500 to-indigo-600 rounded-lg flex items-center justify-center group-hover:scale-105 transition-transform">
                    <span class="text-white font-bold text-xl">G</span>
                </div>
                <span id="logo-text" class="text-xl font-bold text-white transition-colors duration-300">Gawean<span class="text-transparent bg-clip-text bg-gradient-to-r from-purple-600 to-indigo-600">.id</span></span>
            </a>

            <!-- Desktop Navigation -->
            <div class="hidden md:flex items-center gap-8">
                <a href="{{ route('home') }}" class="nav-link text-white hover:text-gray-200 font-medium transition-colors relative group">
                    Beranda
                    <span class="absolute -bottom-1 left-0 w-0 h-0.5 bg-gradient-to-r from-purple-500 to-indigo-500 group-hover:w-full transition-all duration-300"></span>
                </a>
                <a href="{{ route('jobs.search') }}" class="nav-link text-white hover:text-gray-200 font-medium transition-colors relative group">
                    Cari Lowongan
                    <span class="absolute -bottom-1 left-0 w-0 h-0.5 bg-gradient-to-r from-purple-500 to-indigo-500 group-hover:w-full transition-all duration-300"></span>
                </a>
            </div>

            <!-- Auth Buttons -->
            <div class="flex items-center gap-3">
                @guest
                    <a href="{{ route('login') }}" id="btn-login" class="border border-white text-white hover:bg-white/10 font-medium transition-all duration-300 rounded-lg px-4 py-2 text-sm">
                        Masuk
                    </a>
                    <a href="{{ route('register') }}" id="btn-register" class="px-5 py-2 bg-white text-purple-700 hover:bg-gray-100 font-medium rounded-lg transition-all duration-300 shadow-lg shadow-purple-500/20 text-sm">
                        Daftar
                    </a>
                @else
                    @if(auth()->user()->isAdmin())
                        <a href="{{ route('admin.dashboard') }}" class="px-5 py-2 bg-gradient-to-r from-purple-600 to-indigo-600 hover:from-purple-500 hover:to-indigo-500 text-white font-medium rounded-lg transition-all duration-300 shadow-lg shadow-purple-500/20 text-sm flex items-center gap-2">
                            <i class="fas fa-tachometer-alt"></i>Dashboard Admin
                        </a>
                    @elseif(auth()->user()->isHrd())
                        <a href="{{ route('hrd.dashboard') }}" class="px-5 py-2 bg-gradient-to-r from-purple-600 to-indigo-600 hover:from-purple-500 hover:to-indigo-500 text-white font-medium rounded-lg transition-all duration-300 shadow-lg shadow-purple-500/20 text-sm flex items-center gap-2">
                            <i class="fas fa-building"></i>Dashboard HRD
                        </a>
                    @else
                        <a href="{{ route('pelamar.dashboard') }}" class="px-5 py-2 bg-gradient-to-r from-purple-600 to-indigo-600 hover:from-purple-500 hover:to-indigo-500 text-white font-medium rounded-lg transition-all duration-300 shadow-lg shadow-purple-500/20 text-sm flex items-center gap-2">
                            <i class="fas fa-user"></i>Dashboard
                        </a>
                    @endif
                @endguest
            </div>

            <!-- Mobile Menu Button -->
            <button class="md:hidden p-2" onclick="document.getElementById('mobile-menu').classList.toggle('hidden')">
                <i class="fas fa-bars text-gray-600 text-xl"></i>
            </button>
        </div>

        <!-- Mobile Menu -->
        <div id="mobile-menu" class="hidden md:hidden pb-4">
            <div class="flex flex-col gap-2 border-t border-white/30 pt-4 mt-2 transition-colors duration-300" id="mobile-menu-container">
                <a href="{{ route('home') }}" class="mobile-link px-4 py-2 text-white hover:bg-white/10 hover:text-gray-200 rounded-lg transition-colors">Beranda</a>
                <a href="{{ route('jobs.search') }}" class="mobile-link px-4 py-2 text-white hover:bg-white/10 hover:text-gray-200 rounded-lg transition-colors">Cari Lowongan</a>
                @guest
                    <a href="{{ route('login') }}" class="mobile-link px-4 py-2 text-white hover:bg-white/10 hover:text-gray-200 rounded-lg transition-colors">Masuk</a>
                    <a href="{{ route('register') }}" class="mobile-register px-4 py-2 bg-white text-purple-700 text-center rounded-lg font-medium transition-colors">Daftar</a>
                @endguest
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
        const mobileLinks = document.querySelectorAll('.mobile-link');
        const mobileRegister = document.querySelector('.mobile-register');
        const mobileMenuContainer = document.getElementById('mobile-menu-container');

        const applyScrolledState = (isScrolled) => {
            if (isScrolled) {
                navbar.classList.remove('bg-transparent', 'shadow-none');
                navbar.classList.add('bg-white', 'shadow-[0_4px_20px_-5px_rgba(0,0,0,0.3)]', 'ring-1', 'ring-black/5');
                logoText.classList.remove('text-white');
                logoText.classList.add('text-purple-700');
                links.forEach(link => {
                    link.classList.remove('text-white', 'hover:text-gray-200');
                    link.classList.add('text-gray-700', 'hover:text-purple-700');
                });
                btnLogin.classList.remove('border-white', 'text-white', 'hover:bg-white/10');
                btnLogin.classList.add('border-purple-700', 'text-purple-700', 'hover:bg-purple-50');
                btnRegister.classList.remove('bg-white', 'text-purple-700', 'hover:bg-gray-100');
                btnRegister.classList.add('bg-purple-700', 'text-white', 'hover:bg-purple-800');
                mobileMenuContainer.classList.remove('border-white/30');
                mobileMenuContainer.classList.add('border-purple-200/60');
                mobileLinks.forEach(link => {
                    link.classList.remove('text-white', 'hover:bg-white/10', 'hover:text-gray-200');
                    link.classList.add('text-gray-700', 'hover:bg-purple-50', 'hover:text-purple-700');
                });
                if (mobileRegister) {
                    mobileRegister.classList.remove('bg-white', 'text-purple-700');
                    mobileRegister.classList.add('bg-purple-700', 'text-white', 'hover:bg-purple-800');
                }
            } else {
                navbar.classList.remove('bg-white', 'shadow-[0_4px_20px_-5px_rgba(0,0,0,0.3)]', 'ring-1', 'ring-black/5');
                navbar.classList.add('bg-transparent', 'shadow-none');
                logoText.classList.remove('text-purple-700');
                logoText.classList.add('text-white');
                links.forEach(link => {
                    link.classList.remove('text-gray-700', 'hover:text-purple-700');
                    link.classList.add('text-white', 'hover:text-gray-200');
                });
                btnLogin.classList.remove('border-purple-700', 'text-purple-700', 'hover:bg-purple-50');
                btnLogin.classList.add('border-white', 'text-white', 'hover:bg-white/10');
                btnRegister.classList.remove('bg-purple-700', 'text-white', 'hover:bg-purple-800');
                btnRegister.classList.add('bg-white', 'text-purple-700', 'hover:bg-gray-100');
                mobileMenuContainer.classList.remove('border-purple-200/60');
                mobileMenuContainer.classList.add('border-white/30');
                mobileLinks.forEach(link => {
                    link.classList.remove('text-gray-700', 'hover:bg-purple-50', 'hover:text-purple-700');
                    link.classList.add('text-white', 'hover:bg-white/10', 'hover:text-gray-200');
                });
                if (mobileRegister) {
                    mobileRegister.classList.remove('bg-purple-700', 'text-white', 'hover:bg-purple-800');
                    mobileRegister.classList.add('bg-white', 'text-purple-700');
                }
            }
        };

        const onScroll = () => applyScrolledState(window.scrollY > 10);
        onScroll();
        window.addEventListener('scroll', onScroll);
    });
</script>

