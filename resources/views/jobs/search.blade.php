@extends('layouts.app')

@section('title', 'Cari Lowongan - Gawean.id')

@push('styles')
<style>
    /* Reuse landing hero circuit pattern */
    .circuit-pattern {
        background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg stroke='%236366f1' stroke-opacity='0.08' stroke-width='1'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
    }
</style>
@endpush

@section('content')
    <!-- Search Header -->
    <section class="relative overflow-hidden text-white pt-24 pb-16 bg-gradient-to-br from-gray-950 via-indigo-950 to-gray-900">
        <div class="absolute inset-0 circuit-pattern opacity-40"></div>
        <div class="absolute top-16 left-10 w-64 h-64 bg-purple-600/20 rounded-full blur-3xl"></div>
        <div class="absolute bottom-10 right-6 w-80 h-80 bg-indigo-600/20 rounded-full blur-3xl"></div>

        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 z-10">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">
                <div>
                    <p class="text-sm uppercase tracking-wide text-purple-300/80 mb-2">Temukan Pekerjaan Impian</p>
                    <h1 class="text-3xl md:text-4xl font-bold">Cari Lowongan Kerja</h1>
                    <p class="text-gray-300 mt-2 max-w-2xl">Filter lowongan terbaik dengan pencarian cepat berbasis kategori, lokasi, dan kata kunci.</p>
                </div>
            </div>

            <form action="{{ route('jobs.search') }}" method="GET" class="bg-white/10 backdrop-blur-xl border border-white/10 rounded-2xl p-6 shadow-2xl">
                <div class="flex flex-col md:flex-row gap-4">
                    <div class="flex-1 relative">
                        <i class="fas fa-search absolute left-4 top-1/2 -translate-y-1/2 text-gray-300"></i>
                        <input type="text" name="keyword" value="{{ $keyword ?? '' }}"
                               placeholder="Posisi, perusahaan, atau keyword..."
                               class="w-full pl-12 pr-4 py-3 rounded-xl border border-white/10 bg-white/90 text-gray-900 placeholder-gray-500 focus:border-purple-500 focus:ring-2 focus:ring-purple-200 outline-none transition-all">
                    </div>
                    <div class="md:w-48 relative">
                        <i class="fas fa-map-marker-alt absolute left-4 top-1/2 -translate-y-1/2 text-gray-300"></i>
                        <input type="text" name="location" value="{{ $location ?? '' }}"
                               placeholder="Lokasi..."
                               class="w-full pl-12 pr-4 py-3 rounded-xl border border-white/10 bg-white/90 text-gray-900 placeholder-gray-500 focus:border-purple-500 focus:ring-2 focus:ring-purple-200 outline-none transition-all">
                    </div>
                    <div class="md:w-52">
                        <select name="category" class="w-full px-4 py-3 rounded-xl border border-white/10 bg-white/90 text-gray-900 placeholder-gray-500 focus:border-purple-500 focus:ring-2 focus:ring-purple-200 outline-none transition-all">
                            <option value="">Semua Kategori</option>
                            @foreach($allCategories as $cat)
                                <option value="{{ $cat->id }}" {{ ($categoryId ?? '') == $cat->id ? 'selected' : '' }}>
                                    {{ $cat->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="bg-gradient-to-r from-purple-600 to-indigo-600 hover:from-purple-500 hover:to-indigo-500 text-white font-semibold py-3 px-6 rounded-xl transition-all duration-200 shadow-lg shadow-purple-500/30 flex items-center justify-center gap-2">
                        <i class="fas fa-search"></i>
                        <span>Cari</span>
                    </button>
                </div>
            </form>
        </div>
    </section>

    <!-- Results Section -->
    <section class="py-12 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Results Info -->
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-8">
                <div>
                    <h2 class="text-xl font-semibold text-gray-800">
                        @if($keyword || $location || $categoryId)
                            Hasil Pencarian
                        @else
                            Semua Lowongan Aktif
                        @endif
                    </h2>
                    <p class="text-gray-500">Ditemukan {{ $jobs->total() }} lowongan</p>
                </div>

                @if($keyword || $location || $categoryId)
                    <a href="{{ route('jobs.search') }}" class="text-purple-600 hover:text-purple-700 text-sm font-medium">
                        <i class="fas fa-times mr-1"></i>Reset Filter
                    </a>
                @endif
            </div>

            <!-- Job Cards -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                @forelse($jobs as $job)
                    <div class="card-job p-6">
                        <div class="flex gap-4">
                            <div class="w-16 h-16 bg-gradient-to-br from-purple-100 to-indigo-100 rounded-xl flex items-center justify-center flex-shrink-0">
                                <i class="fas fa-building text-purple-600 text-2xl"></i>
                            </div>
                            <div class="flex-1 min-w-0">
                                <div class="flex items-start justify-between gap-4 mb-2">
                                    <h3 class="text-lg font-semibold text-gray-800">{{ $job->title }}</h3>
                                    @if($job->isOpen() && !$job->isExpired())
                                        <span class="badge-status badge-accepted flex-shrink-0">Aktif</span>
                                    @else
                                        <span class="badge-status badge-rejected flex-shrink-0">Tutup</span>
                                    @endif
                                </div>
                                <p class="text-purple-600 font-medium mb-2">{{ $job->company->company_name }}</p>
                                <div class="flex flex-wrap items-center gap-3 text-sm text-gray-500 mb-3">
                                    <span class="flex items-center gap-1">
                                        <i class="fas fa-map-marker-alt"></i> {{ $job->location }}
                                    </span>
                                    <span class="flex items-center gap-1">
                                        <i class="fas fa-money-bill-wave"></i> {{ $job->formatted_salary }}
                                    </span>
                                    <span class="flex items-center gap-1">
                                        <i class="fas fa-tag"></i> {{ $job->category->name }}
                                    </span>
                                </div>
                                <p class="text-gray-600 text-sm mb-4 line-clamp-2">{{ Str::limit($job->description, 120) }}</p>
                                <div class="flex items-center justify-between">
                                    <span class="text-xs text-gray-400">
                                        <i class="fas fa-calendar-alt mr-1"></i> Deadline: {{ $job->deadline->format('d M Y') }}
                                    </span>
                                    <a href="{{ route('jobs.show', $job->id) }}" class="bg-purple-50 hover:bg-purple-100 text-purple-700 px-4 py-2 rounded-lg text-sm font-medium transition-colors">
                                        Lihat Detail <i class="fas fa-chevron-right ml-1"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-2 text-center py-16">
                        <i class="fas fa-search text-gray-300 text-6xl mb-4"></i>
                        <h3 class="text-xl font-semibold text-gray-700 mb-2">Tidak Ada Hasil</h3>
                        <p class="text-gray-500 mb-6">Lowongan yang Anda cari tidak ditemukan</p>
                        <a href="{{ route('jobs.search') }}" class="btn-gawean">
                            <i class="fas fa-redo mr-2"></i>Lihat Semua Lowongan
                        </a>
                    </div>
                @endforelse
            </div>

            <!-- Pagination -->
            @if($jobs->hasPages())
                <div class="mt-8">
                    {{ $jobs->withQueryString()->links() }}
                </div>
            @endif
        </div>
    </section>
@endsection
