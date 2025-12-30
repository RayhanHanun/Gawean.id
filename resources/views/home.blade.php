@extends('layouts.app')

@section('title', 'Gawean.id - Platform Lowongan Kerja Indonesia')

@push('styles')
<style>
    /* Custom animations */
    @keyframes float {
        0%, 100% { transform: translateY(0px); }
        50% { transform: translateY(-20px); }
    }
    @keyframes gradient-shift {
        0% { background-position: 0% 50%; }
        50% { background-position: 100% 50%; }
        100% { background-position: 0% 50%; }
    }
    .animate-float,
    .animate-float-delayed {
        animation: none;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    .animate-float:hover,
    .animate-float-delayed:hover {
        transform: translateY(-6px);
        box-shadow: 0 12px 36px rgba(99, 102, 241, 0.22);
    }
    .gradient-animate {
        background-size: 200% 200%;
        animation: gradient-shift 8s ease infinite;
    }
    /* Circuit pattern background */
    .circuit-pattern {
        background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg stroke='%236366f1' stroke-opacity='0.08' stroke-width='1'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
    }

    /* Glassmorphism card */
    .glass-card {
        background: rgba(30, 27, 75, 0.5);
        backdrop-filter: blur(12px);
        border: 1px solid rgba(139, 92, 246, 0.2);
    }
    /* Light mode card */
    .light-card {
        background: white;
        border: 1px solid rgba(139, 92, 246, 0.1);
        transition: all 0.3s ease;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
    }
    .light-card:hover {
        border-color: rgba(139, 92, 246, 0.3);
        box-shadow: 0 8px 32px rgba(139, 92, 246, 0.15);
        transform: translateY(-4px);
    }
    /* Gradient text */
    .gradient-text {
        background: linear-gradient(135deg, #a78bfa 0%, #818cf8 50%, #6366f1 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }
    /* removed unused dark-card and neon-border definitions */
</style>
@endpush

@section('content')
    <!-- Hero Section - Dark Futuristic Theme -->
    <section class="relative min-h-screen bg-gradient-to-br from-gray-950 via-indigo-950 to-gray-900 overflow-hidden">
        <!-- Background Pattern Overlay -->
        <div class="absolute inset-0 circuit-pattern opacity-40"></div>

        <!-- Animated Gradient Orbs -->
        <div class="absolute top-20 left-10 w-72 h-72 bg-purple-600/20 rounded-full blur-3xl animate-float"></div>
        <div class="absolute bottom-20 right-10 w-96 h-96 bg-indigo-600/20 rounded-full blur-3xl animate-float-delayed"></div>
        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[600px] h-[600px] bg-violet-600/10 rounded-full blur-3xl"></div>

        <!-- Main Content -->
        <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-screen flex items-center">
            <div class="flex flex-col items-center gap-8 w-full">
                <!-- Hero Content -->
                <div class="w-full max-w-4xl text-center mx-auto">
                    <!-- Badge -->
                    <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full glass-card mb-8">
                        <span class="w-2 h-2 bg-green-400 rounded-full animate-pulse"></span>
                        <span class="text-gray-300 text-sm font-medium">Platform Karir #1 di Indonesia</span>
                    </div>

                    <!-- Main Headline -->
                    <h1 class="text-4xl md:text-5xl lg:text-6xl xl:text-7xl font-bold text-white leading-tight mb-6">
                        Transformasi
                        <span class="gradient-text">Karir Anda</span>
                        <br>Dimulai dari Sini
                    </h1>

                    <!-- Sub-headline -->
                    <p class="text-lg md:text-xl text-gray-400 mb-10 max-w-2xl mx-auto leading-relaxed">
                        Temukan peluang terbaik dari perusahaan terpercaya di Indonesia dengan platform berbasis data yang modern dan terdepan.
                    </p>

                    <!-- CTA Buttons -->
                    <div class="flex flex-col sm:flex-row gap-4 justify-center mb-12">
                        <a href="{{ route('jobs.search') }}"
                           class="group px-8 py-4 bg-gradient-to-r from-purple-600 via-violet-600 to-indigo-600 hover:from-purple-500 hover:via-violet-500 hover:to-indigo-500 rounded-xl font-semibold text-white transition-all duration-300 shadow-lg shadow-purple-500/25 hover:shadow-purple-500/40 flex items-center justify-center gap-2 gradient-animate">
                            <i class="fas fa-rocket"></i>
                            Mulai Mencari Kerja
                            <i class="fas fa-arrow-right transform group-hover:translate-x-1 transition-transform"></i>
                        </a>
                        <a href="{{ route('register') }}"
                           class="px-8 py-4 border border-gray-600 hover:border-purple-500 hover:bg-purple-500/10 rounded-xl font-semibold text-white transition-all duration-300 flex items-center justify-center gap-2">
                            <i class="fas fa-building"></i>
                            Untuk Perusahaan
                        </a>
                    </div>

                    <!-- Trust Badges -->
                    <div class="flex flex-wrap items-center gap-6 justify-center text-gray-500 text-sm">
                        <div class="flex items-center gap-2">
                            <i class="fas fa-shield-alt text-purple-400"></i>
                            <span>Terverifikasi</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <i class="fas fa-bolt text-purple-400"></i>
                            <span>Proses Cepat</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <i class="fas fa-lock text-purple-400"></i>
                            <span>Data Aman</span>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <!-- Straight Divider -->
        <div class="absolute bottom-0 left-0 right-0 h-1 bg-gradient-to-r from-purple-600/30 via-violet-600/50 to-indigo-600/30"></div>
    </section>

    <!-- Statistics Section -->
    <section class="py-20 bg-white relative overflow-hidden">

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="text-center mb-16">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">Platform Terpercaya</h2>
                <p class="text-gray-600 max-w-2xl mx-auto">Bergabung dengan ribuan profesional yang telah menemukan karir impian mereka</p>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                <!-- Stat Card 1 -->
                <div class="light-card rounded-2xl p-8 text-center group">
                    <div class="w-16 h-16 bg-gradient-to-br from-purple-100 to-indigo-100 rounded-2xl flex items-center justify-center mx-auto mb-4 group-hover:scale-110 transition-transform">
                        <i class="fas fa-briefcase text-purple-600 text-2xl"></i>
                    </div>
                    <div class="text-4xl md:text-5xl font-bold text-gray-900 mb-2">
                        <span class="counter" data-target="{{ $stats['total_jobs'] }}">0</span>+
                    </div>
                    <p class="text-gray-500">Lowongan Aktif</p>
                </div>

                <!-- Stat Card 2 -->
                <div class="light-card rounded-2xl p-8 text-center group">
                    <div class="w-16 h-16 bg-gradient-to-br from-blue-100 to-cyan-100 rounded-2xl flex items-center justify-center mx-auto mb-4 group-hover:scale-110 transition-transform">
                        <i class="fas fa-building text-blue-600 text-2xl"></i>
                    </div>
                    <div class="text-4xl md:text-5xl font-bold text-gray-900 mb-2">
                        <span class="counter" data-target="{{ $stats['total_companies'] }}">0</span>+
                    </div>
                    <p class="text-gray-500">Perusahaan</p>
                </div>

                <!-- Stat Card 3 -->
                <div class="light-card rounded-2xl p-8 text-center group">
                    <div class="w-16 h-16 bg-gradient-to-br from-green-100 to-emerald-100 rounded-2xl flex items-center justify-center mx-auto mb-4 group-hover:scale-110 transition-transform">
                        <i class="fas fa-users text-green-600 text-2xl"></i>
                    </div>
                    <div class="text-4xl md:text-5xl font-bold text-gray-900 mb-2">
                        <span class="counter" data-target="{{ $stats['total_users'] }}">0</span>+
                    </div>
                    <p class="text-gray-500">Pencari Kerja</p>
                </div>

                <!-- Stat Card 4 -->
                <div class="light-card rounded-2xl p-8 text-center group">
                    <div class="w-16 h-16 bg-gradient-to-br from-pink-100 to-rose-100 rounded-2xl flex items-center justify-center mx-auto mb-4 group-hover:scale-110 transition-transform">
                        <i class="fas fa-handshake text-pink-600 text-2xl"></i>
                    </div>
                    <div class="text-4xl md:text-5xl font-bold text-gray-900 mb-2">
                        <span class="counter" data-target="100">0</span>%
                    </div>
                    <p class="text-gray-500">Gratis Selamanya</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Popular Jobs Section -->
    <section class="py-20 bg-gradient-to-b from-white to-gray-50 relative overflow-hidden">

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="flex flex-col md:flex-row justify-between items-center mb-12">
                <div class="text-center md:text-left mb-6 md:mb-0">
                    <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">
                        <i class="fas fa-fire text-orange-500 mr-2"></i>Lowongan Terpopuler
                    </h2>
                    <p class="text-gray-600">Lowongan dengan pelamar terbanyak minggu ini</p>
                </div>
                <a href="{{ route('jobs.search') }}"
                   class="px-6 py-3 border-2 border-purple-300 hover:bg-purple-50 text-purple-600 hover:text-purple-700 rounded-xl font-medium transition-all duration-300 flex items-center gap-2">
                    Lihat Semua
                    <i class="fas fa-arrow-right"></i>
                </a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($popularJobs as $job)
                    <div class="light-card rounded-2xl overflow-hidden group">
                        <div class="p-6">
                            <div class="flex items-start justify-between mb-4">
                                <div class="w-14 h-14 bg-gradient-to-br from-purple-100 to-indigo-100 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform">
                                    <i class="fas fa-building text-purple-600 text-xl"></i>
                                </div>
                                <span class="px-3 py-1 rounded-full text-xs font-medium {{ $job->status === 'open' ? 'bg-green-100 text-green-600' : 'bg-red-100 text-red-600' }}">
                                    {{ $job->status === 'open' ? 'Buka' : 'Tutup' }}
                                </span>
                            </div>
                            <h3 class="text-lg font-semibold text-gray-900 mb-2 group-hover:text-purple-600 transition-colors">
                                {{ $job->posisi }}
                            </h3>
                            <p class="text-gray-600 mb-4">{{ $job->company_name }}</p>
                            <div class="flex items-center gap-2 text-sm text-purple-600">
                                <i class="fas fa-users"></i>
                                <span>{{ $job->total_pelamar }} Pelamar</span>
                            </div>
                        </div>
                        <div class="px-6 py-4 bg-gray-50 border-t border-purple-100">
                            <a href="{{ route('jobs.search', ['keyword' => $job->posisi]) }}"
                               class="text-purple-600 hover:text-purple-700 font-medium text-sm flex items-center gap-2 group-hover:gap-3 transition-all">
                                Lihat Lowongan <i class="fas fa-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="col-span-3 text-center py-16">
                        <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <i class="fas fa-briefcase text-gray-400 text-3xl"></i>
                        </div>
                        <p class="text-gray-500">Belum ada lowongan tersedia</p>
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    <!-- Active Jobs Section -->
    <section class="py-20 bg-white relative overflow-hidden">


        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="flex flex-col md:flex-row justify-between items-center mb-12">
                <div class="text-center md:text-left mb-6 md:mb-0">
                    <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">
                        <i class="fas fa-sparkles text-yellow-500 mr-2"></i>Lowongan Terbaru
                    </h2>
                    <p class="text-gray-600">Temukan peluang karir terbaru dari perusahaan terpercaya</p>
                </div>
                <a href="{{ route('jobs.search') }}"
                   class="px-6 py-3 border-2 border-purple-300 hover:bg-purple-50 text-purple-600 hover:text-purple-700 rounded-xl font-medium transition-all duration-300 flex items-center gap-2">
                    Lihat Semua
                    <i class="fas fa-arrow-right"></i>
                </a>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                @forelse($activeJobs as $job)
                    <div class="light-card rounded-2xl p-6 flex gap-5 group">
                        <div class="w-16 h-16 bg-gradient-to-br from-indigo-100 to-purple-100 rounded-xl flex items-center justify-center flex-shrink-0 group-hover:scale-110 transition-transform">
                            <i class="fas fa-building text-indigo-600 text-2xl"></i>
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="flex items-start justify-between gap-4 mb-2">
                                <h3 class="text-lg font-semibold text-gray-900 truncate group-hover:text-purple-600 transition-colors">{{ $job->title }}</h3>
                                <span class="px-3 py-1 bg-green-100 text-green-600 text-xs rounded-full flex-shrink-0">Aktif</span>
                            </div>
                            <p class="text-purple-600 font-medium mb-3">{{ $job->company_name }}</p>
                            <div class="flex flex-wrap items-center gap-4 text-sm text-gray-500 mb-4">
                                <span class="flex items-center gap-1">
                                    <i class="fas fa-map-marker-alt text-gray-400"></i> {{ $job->location }}
                                </span>
                                <span class="flex items-center gap-1">
                                    <i class="fas fa-money-bill-wave text-gray-400"></i>
                                    {{ $job->salary_range === 'Disembunyikan' ? 'Gaji Dirahasiakan' : $job->salary_range }}
                                </span>
                                <span class="flex items-center gap-1">
                                    <i class="fas fa-tag text-gray-400"></i> {{ $job->category }}
                                </span>
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="text-xs text-gray-500">
                                    <i class="fas fa-calendar-alt mr-1"></i> Deadline: {{ \Carbon\Carbon::parse($job->deadline)->format('d M Y') }}
                                </span>
                                <a href="{{ route('jobs.show', $job->job_id) }}"
                                   class="text-purple-600 hover:text-purple-700 text-sm font-medium flex items-center gap-1 group-hover:gap-2 transition-all">
                                    Detail <i class="fas fa-chevron-right"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-2 text-center py-16">
                        <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <i class="fas fa-search text-gray-400 text-3xl"></i>
                        </div>
                        <p class="text-gray-500">Belum ada lowongan aktif</p>
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    <!-- Categories Section -->
    <section class="py-20 bg-gradient-to-b from-gray-50 to-white relative overflow-hidden">

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="text-center mb-12">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">
                    <i class="fas fa-th-large text-purple-600 mr-2"></i>Kategori Pekerjaan
                </h2>
                <p class="text-gray-600 max-w-2xl mx-auto">Jelajahi lowongan berdasarkan bidang keahlian Anda</p>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                @forelse($categories as $category)
                    <a href="{{ route('jobs.search', ['category' => $category->category_id]) }}"
                       class="light-card p-6 rounded-2xl text-center group">
                        <div class="w-16 h-16 bg-gradient-to-br from-purple-100 to-indigo-100 rounded-2xl flex items-center justify-center mx-auto mb-4 group-hover:scale-110 transition-transform">
                            @php
                                $icons = [
                                    'Programmer' => 'fa-laptop-code',
                                    'Desain Grafis' => 'fa-palette',
                                    'Digital Marketing' => 'fa-bullhorn',
                                    'default' => 'fa-briefcase'
                                ];
                                $icon = $icons[$category->kategori_pekerjaan] ?? $icons['default'];
                            @endphp
                            <i class="fas {{ $icon }} text-purple-600 text-2xl"></i>
                        </div>
                        <h3 class="font-semibold text-gray-900 mb-2 group-hover:text-purple-600 transition-colors">{{ $category->kategori_pekerjaan }}</h3>
                        <p class="text-sm text-gray-500">{{ $category->jumlah_lowongan }} lowongan</p>
                    </a>
                @empty
                    <div class="col-span-4 text-center py-16">
                        <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <i class="fas fa-folder-open text-gray-400 text-3xl"></i>
                        </div>
                        <p class="text-gray-500">Belum ada kategori tersedia</p>
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-24 bg-[#0f0f23] relative overflow-hidden">

        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[800px] h-[800px] bg-purple-600/10 rounded-full blur-3xl"></div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="grid lg:grid-cols-2 gap-12 items-center">
                <div class="text-center lg:text-left">
                    <h2 class="text-3xl md:text-4xl lg:text-5xl font-bold text-white mb-6 leading-tight">
                        Siap Menemukan
                        <span class="gradient-text">Pekerjaan Impian?</span>
                    </h2>
                    <p class="text-lg text-gray-400 mb-10 max-w-xl mx-auto lg:mx-0">
                        Bergabunglah dengan ribuan pencari kerja lainnya dan temukan peluang karir terbaik di Indonesia.
                    </p>
                    <div class="flex flex-col sm:flex-row gap-4 justify-center lg:justify-start">
                        <a href="{{ route('register') }}"
                           class="px-8 py-4 bg-gradient-to-r from-purple-600 to-indigo-600 hover:from-purple-500 hover:to-indigo-500 rounded-xl font-semibold text-white transition-all duration-300 shadow-lg shadow-purple-500/25 flex items-center justify-center gap-2">
                            <i class="fas fa-user-plus"></i>
                            Daftar Sekarang
                        </a>
                        <a href="{{ route('jobs.search') }}"
                           class="px-8 py-4 border border-gray-700 hover:border-purple-500 hover:bg-purple-500/10 rounded-xl font-semibold text-white transition-all duration-300 flex items-center justify-center gap-2">
                            <i class="fas fa-search"></i>
                            Jelajahi Lowongan
                        </a>
                    </div>
                </div>

                <!-- Features Cards -->
                <div class="space-y-4">
                    <div class="glass-card rounded-2xl p-6 flex items-center gap-5 hover:border-purple-500/50 transition-all group">
                        <div class="w-14 h-14 bg-gradient-to-br from-green-500/20 to-emerald-500/20 rounded-xl flex items-center justify-center flex-shrink-0 group-hover:scale-110 transition-transform">
                            <i class="fas fa-check text-green-400 text-xl"></i>
                        </div>
                        <div>
                            <h4 class="font-semibold text-white mb-1">Gratis Selamanya</h4>
                            <p class="text-gray-400 text-sm">Tidak ada biaya pendaftaran untuk pencari kerja</p>
                        </div>
                    </div>

                    <div class="glass-card rounded-2xl p-6 flex items-center gap-5 hover:border-purple-500/50 transition-all group">
                        <div class="w-14 h-14 bg-gradient-to-br from-blue-500/20 to-cyan-500/20 rounded-xl flex items-center justify-center flex-shrink-0 group-hover:scale-110 transition-transform">
                            <i class="fas fa-shield-alt text-blue-400 text-xl"></i>
                        </div>
                        <div>
                            <h4 class="font-semibold text-white mb-1">Perusahaan Terverifikasi</h4>
                            <p class="text-gray-400 text-sm">Semua perusahaan telah diverifikasi oleh tim kami</p>
                        </div>
                    </div>

                    <div class="glass-card rounded-2xl p-6 flex items-center gap-5 hover:border-purple-500/50 transition-all group">
                        <div class="w-14 h-14 bg-gradient-to-br from-yellow-500/20 to-amber-500/20 rounded-xl flex items-center justify-center flex-shrink-0 group-hover:scale-110 transition-transform">
                            <i class="fas fa-bolt text-yellow-400 text-xl"></i>
                        </div>
                        <div>
                            <h4 class="font-semibold text-white mb-1">Proses Cepat</h4>
                            <p class="text-gray-400 text-sm">Lamar pekerjaan dalam hitungan detik</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- For Companies Section -->
    <section class="py-20 bg-gradient-to-br from-purple-50 to-indigo-50 relative overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-3xl p-8 md:p-12 overflow-hidden relative border border-purple-100 shadow-xl shadow-purple-100/50 transform transition-all duration-300 ease-in-out hover:-translate-y-2 hover:shadow-2xl hover:border-purple-200">

                <div class="relative z-10 max-w-2xl">
                    <span class="inline-flex items-center gap-2 px-4 py-2 bg-purple-100 text-purple-700 rounded-full text-sm font-medium mb-6">
                        <i class="fas fa-building"></i>
                        Untuk Perusahaan
                    </span>
                    <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">
                        Rekrut Talenta Terbaik untuk Tim Anda
                    </h2>
                    <p class="text-gray-600 mb-8 text-lg">
                        Pasang lowongan dan jangkau ribuan kandidat berkualitas. Proses rekrutmen lebih mudah dan efisien dengan Gawean.id
                    </p>
                    <a href="{{ route('register') }}"
                       class="inline-flex items-center px-8 py-4 bg-gradient-to-r from-purple-600 to-indigo-600 hover:from-purple-500 hover:to-indigo-500 text-white font-semibold rounded-xl transition-all duration-300 shadow-lg shadow-purple-500/25 gap-2">
                        <i class="fas fa-rocket"></i>
                        Daftar sebagai HRD
                        <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Navbar scroll effect
    const navbar = document.getElementById('navbar');
    const heroSection = document.querySelector('section.relative.min-h-screen');
    const heroHeight = heroSection ? heroSection.offsetHeight : 0;

    window.addEventListener('scroll', function() {
        const scrollY = window.scrollY;
        if (scrollY > 50) {
            navbar.classList.remove('navbar-transparent');
            navbar.classList.add('navbar-white');
        } else {
            navbar.classList.remove('navbar-white');
            navbar.classList.add('navbar-transparent');
        }
    }, { passive: true });

    // Counter animation
    const counters = document.querySelectorAll('.counter');
    const DEFAULT_DURATION = 1000; // milliseconds for full count (adjust to taste)

    const animateCounter = (counter, duration = DEFAULT_DURATION) => {
        const raw = counter.getAttribute('data-target') || '0';
        const target = parseInt(String(raw).replace(/[^0-9]/g, ''), 10) || 0;
        const start = performance.now();

        const tick = (now) => {
            const elapsed = now - start;
            const progress = Math.min(elapsed / duration, 1);
            const value = Math.floor(progress * target);
            counter.textContent = value.toLocaleString('id-ID');

            if (progress < 1) {
                requestAnimationFrame(tick);
            } else {
                counter.textContent = target.toLocaleString('id-ID');
            }
        };

        requestAnimationFrame(tick);
    };

    const observer = new IntersectionObserver((entries, obs) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const el = entry.target;
                if (!el.classList.contains('counted')) {
                    el.classList.add('counted');
                    // Read optional data-duration (ms) from markup to allow per-counter control
                    const durationAttr = parseInt(el.getAttribute('data-duration') || '', 10);
                    const duration = Number.isFinite(durationAttr) ? durationAttr : DEFAULT_DURATION;
                    animateCounter(el, duration);
                    obs.unobserve(el);
                }
            }
        });
    }, { threshold: 0.5, rootMargin: '0px 0px -100px 0px' });

    counters.forEach(c => observer.observe(c));
});
</script>
@endpush
