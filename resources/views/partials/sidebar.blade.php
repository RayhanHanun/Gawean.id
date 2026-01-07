@php
    $user = auth()->user();
    $role = $user->role;
@endphp

<aside class="fixed left-0 top-0 h-screen w-64 bg-white border-r border-gray-100 shadow-sm z-50">
    <!-- Logo -->
    <div class="flex items-center px-6 py-5 border-b border-gray-100">
        <span class="text-xl font-bold text-gray-800 ml-1">Gawean<span class="text-blue-500">.id</span></span>
    </div>

    <!-- Navigation -->
    <nav class="p-4 space-y-2">
        @if($role === 'admin')
            <a href="{{ route('admin.dashboard') }}" class="sidebar-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <i class="fas fa-tachometer-alt w-5"></i>
                <span>Dashboard</span>
            </a>
            <a href="{{ route('admin.companies') }}" class="sidebar-link {{ request()->routeIs('admin.companies*') ? 'active' : '' }}">
                <i class="fas fa-building w-5"></i>
                <span>Perusahaan</span>
            </a>
            <a href="{{ route('admin.users') }}" class="sidebar-link {{ request()->routeIs('admin.users*') ? 'active' : '' }}">
                <i class="fas fa-users w-5"></i>
                <span>Pengguna</span>
            </a>
            <a href="{{ route('admin.jobs') }}" class="sidebar-link {{ request()->routeIs('admin.jobs*') ? 'active' : '' }}">
                <i class="fas fa-briefcase w-5"></i>
                <span>Lowongan</span>
            </a>
            <a href="{{ route('admin.categories') }}" class="sidebar-link {{ request()->routeIs('admin.categories*') ? 'active' : '' }}">
                <i class="fas fa-tags w-5"></i>
                <span>Kategori</span>
            </a>
            <a href="{{ route('admin.reports') }}" class="sidebar-link {{ request()->routeIs('admin.reports') ? 'active' : '' }}">
                <i class="fas fa-chart-bar w-5"></i>
                <span>Laporan</span>
            </a>

        @elseif($role === 'hrd')
            <a href="{{ route('hrd.dashboard') }}" class="sidebar-link {{ request()->routeIs('hrd.dashboard') ? 'active' : '' }}">
                <i class="fas fa-tachometer-alt w-5"></i>
                <span>Dashboard</span>
            </a>
            <a href="{{ route('hrd.company') }}" class="sidebar-link {{ request()->routeIs('hrd.company*') ? 'active' : '' }}">
                <i class="fas fa-building w-5"></i>
                <span>Profil Perusahaan</span>
            </a>
            <a href="{{ route('hrd.jobs') }}" class="sidebar-link {{ request()->routeIs('hrd.jobs*') ? 'active' : '' }}">
                <i class="fas fa-briefcase w-5"></i>
                <span>Kelola Lowongan</span>
            </a>
            <a href="{{ route('hrd.applicants') }}" class="sidebar-link {{ request()->routeIs('hrd.applicants*') || request()->routeIs('hrd.applicant*') ? 'active' : '' }}">
                <i class="fas fa-user-friends w-5"></i>
                <span>Pelamar</span>
            </a>

        @elseif($role === 'pelamar')
            <a href="{{ route('pelamar.dashboard') }}" class="sidebar-link {{ request()->routeIs('pelamar.dashboard') ? 'active' : '' }}">
                <i class="fas fa-tachometer-alt w-5"></i>
                <span>Dashboard</span>
            </a>
            <a href="{{ route('pelamar.profile') }}" class="sidebar-link {{ request()->routeIs('pelamar.profile') ? 'active' : '' }}">
                <i class="fas fa-user w-5"></i>
                <span>Profil Saya</span>
            </a>
            <a href="{{ route('pelamar.applications') }}" class="sidebar-link {{ request()->routeIs('pelamar.applications') ? 'active' : '' }}">
                <i class="fas fa-file-alt w-5"></i>
                <span>Lamaran Saya</span>
            </a>
            <a href="{{ route('jobs.search') }}" class="sidebar-link">
                <i class="fas fa-search w-5"></i>
                <span>Cari Lowongan</span>
            </a>
        @endif

        <div class="pt-4 border-t border-gray-100 mt-4">
            <a href="{{ route('home') }}" class="sidebar-link">
                <i class="fas fa-home w-5"></i>
                <span>Ke Beranda</span>
            </a>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="sidebar-link w-full text-left text-red-500 hover:bg-red-50 hover:text-red-600">
                    <i class="fas fa-sign-out-alt w-5"></i>
                    <span>Logout</span>
                </button>
            </form>
        </div>
    </nav>
</aside>
