@extends('layouts.app')

@section('title', 'Cari Lowongan - Gawean.id')

@section('content')
    <!-- Search Header -->
    <section class="bg-gradient-to-r from-blue-600 to-blue-500 text-white py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h1 class="text-3xl font-bold mb-6">Cari Lowongan Kerja</h1>

            <form action="{{ route('jobs.search') }}" method="GET" class="bg-white rounded-xl p-4 shadow-lg">
                <div class="flex flex-col md:flex-row gap-4">
                    <div class="flex-1 relative">
                        <i class="fas fa-search absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"></i>
                        <input type="text" name="keyword" value="{{ $keyword ?? '' }}"
                               placeholder="Posisi, perusahaan, atau keyword..."
                               class="w-full pl-12 pr-4 py-3 rounded-lg border border-gray-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 outline-none text-gray-700">
                    </div>
                    <div class="md:w-48 relative">
                        <i class="fas fa-map-marker-alt absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"></i>
                        <input type="text" name="location" value="{{ $location ?? '' }}"
                               placeholder="Lokasi..."
                               class="w-full pl-12 pr-4 py-3 rounded-lg border border-gray-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 outline-none text-gray-700">
                    </div>
                    <div class="md:w-48">
                        <select name="category" class="w-full px-4 py-3 rounded-lg border border-gray-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 outline-none text-gray-700">
                            <option value="">Semua Kategori</option>
                            @foreach($allCategories as $cat)
                                <option value="{{ $cat->id }}" {{ ($categoryId ?? '') == $cat->id ? 'selected' : '' }}>
                                    {{ $cat->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white font-semibold py-3 px-6 rounded-lg transition-all duration-200">
                        <i class="fas fa-search mr-2"></i>Cari
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
                    <a href="{{ route('jobs.search') }}" class="text-blue-500 hover:text-blue-600 text-sm font-medium">
                        <i class="fas fa-times mr-1"></i>Reset Filter
                    </a>
                @endif
            </div>

            <!-- Job Cards -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                @forelse($jobs as $job)
                    <div class="card-job p-6">
                        <div class="flex gap-4">
                            <div class="w-16 h-16 bg-gradient-to-br from-blue-100 to-blue-50 rounded-xl flex items-center justify-center flex-shrink-0">
                                <i class="fas fa-building text-blue-500 text-2xl"></i>
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
                                <p class="text-blue-500 font-medium mb-2">{{ $job->company->company_name }}</p>
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
                                    <a href="{{ route('jobs.show', $job->id) }}" class="bg-blue-50 hover:bg-blue-100 text-blue-600 px-4 py-2 rounded-lg text-sm font-medium transition-colors">
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
