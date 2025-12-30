@extends('layouts.dashboard')

@section('title', 'Dashboard Pelamar')
@section('page-title', 'Dashboard')
@section('page-subtitle', 'Selamat datang kembali, ' . auth()->user()->name)

@section('content')
    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm">Total Lamaran</p>
                    <p class="text-3xl font-bold text-gray-800">{{ $stats['total_applications'] }}</p>
                </div>
                <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center">
                    <i class="fas fa-file-alt text-blue-500 text-xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm">Menunggu</p>
                    <p class="text-3xl font-bold text-yellow-500">{{ $stats['pending'] }}</p>
                </div>
                <div class="w-12 h-12 bg-yellow-100 rounded-xl flex items-center justify-center">
                    <i class="fas fa-clock text-yellow-500 text-xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm">Interview</p>
                    <p class="text-3xl font-bold text-blue-500">{{ $stats['interview'] }}</p>
                </div>
                <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center">
                    <i class="fas fa-user-tie text-blue-500 text-xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm">Diterima</p>
                    <p class="text-3xl font-bold text-green-500">{{ $stats['accepted'] }}</p>
                </div>
                <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center">
                    <i class="fas fa-check-circle text-green-500 text-xl"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Recent Applications -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-xl shadow-sm border border-gray-100">
                <div class="p-6 border-b border-gray-100">
                    <div class="flex items-center justify-between">
                        <h2 class="text-lg font-semibold text-gray-800">Lamaran Terbaru</h2>
                        <a href="{{ route('pelamar.applications') }}" class="text-blue-500 hover:text-blue-600 text-sm font-medium">
                            Lihat Semua <i class="fas fa-arrow-right ml-1"></i>
                        </a>
                    </div>
                </div>
                <div class="divide-y divide-gray-100">
                    @forelse($recentApplications as $app)
                        <div class="p-4 hover:bg-gray-50 transition-colors">
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 bg-gradient-to-br from-blue-100 to-blue-50 rounded-xl flex items-center justify-center">
                                    <i class="fas fa-briefcase text-blue-500"></i>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <h4 class="font-medium text-gray-800 truncate">{{ $app->job->title }}</h4>
                                    <p class="text-sm text-gray-500">{{ $app->job->company->company_name }}</p>
                                </div>
                                <div class="text-right">
                                    <span class="badge-status
                                        @if($app->status == 'pending') badge-pending
                                        @elseif($app->status == 'interview') badge-interview
                                        @elseif($app->status == 'accepted') badge-accepted
                                        @else badge-rejected @endif">
                                        {{ $app->status_label }}
                                    </span>
                                    <p class="text-xs text-gray-400 mt-1">{{ $app->apply_date->format('d M Y') }}</p>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="p-8 text-center">
                            <i class="fas fa-inbox text-gray-300 text-4xl mb-3"></i>
                            <p class="text-gray-500">Belum ada lamaran</p>
                            <a href="{{ route('jobs.search') }}" class="text-blue-500 hover:underline text-sm">Cari lowongan sekarang</a>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Profile Summary -->
        <div class="space-y-6">
            <!-- Profile Card -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <div class="text-center mb-4">
                    <div class="w-20 h-20 bg-gradient-to-br from-blue-500 to-blue-600 rounded-full flex items-center justify-center mx-auto mb-3">
                        <span class="text-white text-2xl font-bold">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</span>
                    </div>
                    <h3 class="font-semibold text-gray-800">{{ auth()->user()->name }}</h3>
                    <p class="text-sm text-gray-500">{{ auth()->user()->email }}</p>
                </div>

                @if($profile)
                    <div class="space-y-3 pt-4 border-t border-gray-100">
                        @if($profile->phone_number)
                            <div class="flex items-center gap-3 text-sm">
                                <i class="fas fa-phone text-gray-400 w-5"></i>
                                <span class="text-gray-600">{{ $profile->phone_number }}</span>
                            </div>
                        @endif
                        @if($profile->cv_file)
                            <div class="flex items-center gap-3 text-sm">
                                <i class="fas fa-file-pdf text-gray-400 w-5"></i>
                                <span class="text-green-600"><i class="fas fa-check-circle mr-1"></i>CV Uploaded</span>
                            </div>
                        @else
                            <div class="flex items-center gap-3 text-sm">
                                <i class="fas fa-file-pdf text-gray-400 w-5"></i>
                                <span class="text-red-500"><i class="fas fa-times-circle mr-1"></i>Belum upload CV</span>
                            </div>
                        @endif
                    </div>
                @endif

                <a href="{{ route('pelamar.profile') }}" class="btn-gawean-outline w-full text-center block mt-4 text-sm">
                    <i class="fas fa-edit mr-2"></i>Edit Profil
                </a>
            </div>

            <!-- Quick Tips -->
            <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl p-6 text-white">
                <h3 class="font-semibold mb-3"><i class="fas fa-lightbulb mr-2"></i>Tips</h3>
                <ul class="text-sm space-y-2 text-blue-100">
                    <li><i class="fas fa-check mr-2"></i>Lengkapi profil Anda</li>
                    <li><i class="fas fa-check mr-2"></i>Upload CV terbaru</li>
                    <li><i class="fas fa-check mr-2"></i>Tambahkan skill Anda</li>
                    <li><i class="fas fa-check mr-2"></i>Rutin cek status lamaran</li>
                </ul>
            </div>
        </div>
    </div>

    <!-- Recommended Jobs -->
    @if($recommendedJobs->count() > 0)
        <div class="mt-8">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-lg font-semibold text-gray-800">Lowongan Rekomendasi</h2>
                <a href="{{ route('jobs.search') }}" class="text-blue-500 hover:text-blue-600 text-sm font-medium">
                    Lihat Semua <i class="fas fa-arrow-right ml-1"></i>
                </a>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($recommendedJobs as $job)
                    <div class="card-job p-5">
                        <div class="flex items-start gap-4">
                            <div class="w-12 h-12 bg-gradient-to-br from-blue-100 to-blue-50 rounded-xl flex items-center justify-center flex-shrink-0">
                                <i class="fas fa-building text-blue-500"></i>
                            </div>
                            <div class="flex-1 min-w-0">
                                <h4 class="font-semibold text-gray-800 truncate">{{ $job->title }}</h4>
                                <p class="text-blue-500 text-sm">{{ $job->company->company_name }}</p>
                                <div class="flex items-center gap-2 text-xs text-gray-500 mt-2">
                                    <span><i class="fas fa-map-marker-alt mr-1"></i>{{ $job->location }}</span>
                                </div>
                            </div>
                        </div>
                        <a href="{{ route('jobs.show', $job->id) }}" class="mt-4 block text-center bg-blue-50 hover:bg-blue-100 text-blue-600 py-2 rounded-lg text-sm font-medium transition-colors">
                            Lihat Detail
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    @endif
@endsection
