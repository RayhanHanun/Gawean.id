@extends('layouts.app')

@section('title', $job->title . ' - Gawean.id')

@section('content')
    <!-- Job Header -->
    <section class="bg-white border-b border-gray-100 mt-16">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="flex flex-col md:flex-row gap-6 items-start">
                <div class="w-20 h-20 bg-gradient-to-br from-blue-100 to-blue-50 rounded-2xl flex items-center justify-center flex-shrink-0">
                    <i class="fas fa-building text-blue-500 text-3xl"></i>
                </div>
                <div class="flex-1">
                    <div class="flex items-start justify-between gap-4 mb-2">
                        <h1 class="text-2xl md:text-3xl font-bold text-gray-800">{{ $job->title }}</h1>
                        @if($job->isOpen() && !$job->isExpired())
                            <span class="badge-status badge-accepted">Aktif</span>
                        @else
                            <span class="badge-status badge-rejected">Tutup</span>
                        @endif
                    </div>
                    <p class="text-xl text-blue-500 font-semibold mb-4">{{ $job->company->company_name }}</p>
                    <div class="flex flex-wrap items-center gap-4 text-gray-600">
                        <span class="flex items-center gap-2">
                            <i class="fas fa-map-marker-alt text-gray-400"></i> {{ $job->location }}
                        </span>
                        <span class="flex items-center gap-2">
                            <i class="fas fa-money-bill-wave text-gray-400"></i> {{ $job->formatted_salary }}
                        </span>
                        <span class="flex items-center gap-2">
                            <i class="fas fa-tag text-gray-400"></i> {{ $job->category->name }}
                        </span>
                        <span class="flex items-center gap-2">
                            <i class="fas fa-calendar-alt text-gray-400"></i> Deadline: {{ $job->deadline->format('d M Y') }}
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Job Content -->
    <section class="py-8 bg-gray-50">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Main Content -->
                <div class="lg:col-span-2 space-y-6">
                    <div class="bg-white rounded-xl p-6 shadow-sm">
                        <h2 class="text-lg font-semibold text-gray-800 mb-4">Deskripsi Pekerjaan</h2>
                        <div class="prose max-w-none text-gray-600">
                            {!! nl2br(e($job->description)) !!}
                        </div>
                    </div>

                    <!-- Company Info -->
                    <div class="bg-white rounded-xl p-6 shadow-sm">
                        <h2 class="text-lg font-semibold text-gray-800 mb-4">Tentang Perusahaan</h2>
                        <div class="flex items-start gap-4">
                            <div class="w-14 h-14 bg-gradient-to-br from-blue-100 to-blue-50 rounded-xl flex items-center justify-center flex-shrink-0">
                                <i class="fas fa-building text-blue-500 text-xl"></i>
                            </div>
                            <div>
                                <h3 class="font-semibold text-gray-800">{{ $job->company->company_name }}</h3>
                                @if($job->company->website)
                                    <a href="https://{{ $job->company->website }}" target="_blank" class="text-blue-500 text-sm hover:underline">
                                        <i class="fas fa-globe mr-1"></i>{{ $job->company->website }}
                                    </a>
                                @endif
                                @if($job->company->description)
                                    <p class="text-gray-600 mt-2 text-sm">{{ $job->company->description }}</p>
                                @endif
                                @if($job->company->address)
                                    <p class="text-gray-500 text-sm mt-2">
                                        <i class="fas fa-map-marker-alt mr-1"></i>{{ $job->company->address }}
                                    </p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Sidebar -->
                <div class="space-y-6">
                    <!-- Apply Card -->
                    <div class="bg-white rounded-xl p-6 shadow-sm sticky top-24">
                        <h3 class="font-semibold text-gray-800 mb-4">Tertarik dengan posisi ini?</h3>

                        @auth
                            @if(auth()->user()->isPelamar())
                                @if($hasApplied)
                                    <div class="bg-green-50 border border-green-200 rounded-lg p-4 mb-4">
                                        <div class="flex items-center gap-2 text-green-700">
                                            <i class="fas fa-check-circle"></i>
                                            <span class="font-medium">Anda sudah melamar</span>
                                        </div>
                                        <p class="text-green-600 text-sm mt-1">Pantau status lamaran di dashboard Anda</p>
                                    </div>
                                    <a href="{{ route('pelamar.applications') }}" class="btn-gawean-outline w-full text-center block">
                                        <i class="fas fa-file-alt mr-2"></i>Lihat Lamaran
                                    </a>
                                @elseif($job->isOpen() && !$job->isExpired())
                                    <form action="{{ route('pelamar.apply', $job->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn-gawean w-full">
                                            <i class="fas fa-paper-plane mr-2"></i>Lamar Sekarang
                                        </button>
                                    </form>
                                    <p class="text-gray-500 text-xs text-center mt-3">
                                        Pastikan profil dan CV Anda sudah lengkap
                                    </p>
                                @else
                                    <div class="bg-red-50 border border-red-200 rounded-lg p-4">
                                        <div class="flex items-center gap-2 text-red-700">
                                            <i class="fas fa-times-circle"></i>
                                            <span class="font-medium">Lowongan sudah ditutup</span>
                                        </div>
                                    </div>
                                @endif
                            @else
                                <p class="text-gray-500 text-sm mb-4">Login sebagai pencari kerja untuk melamar</p>
                                <a href="{{ route('login') }}" class="btn-gawean w-full text-center block">
                                    <i class="fas fa-sign-in-alt mr-2"></i>Login untuk Melamar
                                </a>
                            @endif
                        @else
                            <p class="text-gray-500 text-sm mb-4">Masuk atau daftar untuk melamar pekerjaan ini</p>
                            <a href="{{ route('login') }}" class="btn-gawean w-full text-center block mb-3">
                                <i class="fas fa-sign-in-alt mr-2"></i>Masuk
                            </a>
                            <a href="{{ route('register') }}" class="btn-gawean-outline w-full text-center block">
                                <i class="fas fa-user-plus mr-2"></i>Daftar
                            </a>
                        @endauth
                    </div>

                    <!-- Job Info -->
                    <div class="bg-white rounded-xl p-6 shadow-sm">
                        <h3 class="font-semibold text-gray-800 mb-4">Informasi Lowongan</h3>
                        <div class="space-y-4">
                            <div class="flex justify-between">
                                <span class="text-gray-500">ID Lowongan</span>
                                <span class="font-medium text-gray-800">{{ $job->id }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-500">Kategori</span>
                                <span class="font-medium text-gray-800">{{ $job->category->name }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-500">Deadline</span>
                                <span class="font-medium text-gray-800">{{ $job->deadline->format('d M Y') }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-500">Pelamar</span>
                                <span class="font-medium text-gray-800">{{ $job->applicant_count }} orang</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Related Jobs -->
            @if($relatedJobs->count() > 0)
                <div class="mt-12">
                    <h2 class="text-xl font-bold text-gray-800 mb-6">Lowongan Serupa</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        @foreach($relatedJobs as $related)
                            <div class="card-job p-5">
                                <div class="flex gap-4">
                                    <div class="w-12 h-12 bg-gradient-to-br from-blue-100 to-blue-50 rounded-xl flex items-center justify-center flex-shrink-0">
                                        <i class="fas fa-building text-blue-500"></i>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <h3 class="font-semibold text-gray-800 truncate">{{ $related->title }}</h3>
                                        <p class="text-blue-500 text-sm">{{ $related->company->company_name }}</p>
                                        <div class="flex items-center gap-3 text-xs text-gray-500 mt-2">
                                            <span><i class="fas fa-map-marker-alt mr-1"></i>{{ $related->location }}</span>
                                        </div>
                                        <a href="{{ route('jobs.show', $related->id) }}" class="text-blue-500 hover:underline text-sm mt-2 inline-block">
                                            Lihat Detail →
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </section>
@endsection
