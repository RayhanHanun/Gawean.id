@extends('layouts.dashboard')

@section('title', 'Dashboard HRD')
@section('page-title', 'Dashboard')
@section('page-subtitle', 'Kelola lowongan dan pelamar perusahaan Anda')

@section('content')
    @if(!$company->isApproved())
        <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 mb-6 rounded-r-lg">
            <div class="flex items-center gap-3">
                <i class="fas fa-exclamation-triangle text-yellow-500 text-xl"></i>
                <div>
                    <p class="font-semibold text-yellow-800">Akun Menunggu Verifikasi</p>
                    <p class="text-yellow-700 text-sm">Perusahaan Anda sedang dalam proses verifikasi oleh admin. Anda belum dapat memposting lowongan.</p>
                </div>
            </div>
        </div>
    @endif

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm">Total Lowongan</p>
                    <p class="text-3xl font-bold text-gray-800">{{ $stats['total_jobs'] }}</p>
                </div>
                <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center">
                    <i class="fas fa-briefcase text-blue-500 text-xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm">Lowongan Aktif</p>
                    <p class="text-3xl font-bold text-green-500">{{ $stats['active_jobs'] }}</p>
                </div>
                <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center">
                    <i class="fas fa-check-circle text-green-500 text-xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm">Total Pelamar</p>
                    <p class="text-3xl font-bold text-purple-500">{{ $stats['total_applications'] }}</p>
                </div>
                <div class="w-12 h-12 bg-purple-100 rounded-xl flex items-center justify-center">
                    <i class="fas fa-users text-purple-500 text-xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm">Perlu Direview</p>
                    <p class="text-3xl font-bold text-yellow-500">{{ $stats['pending_applications'] }}</p>
                </div>
                <div class="w-12 h-12 bg-yellow-100 rounded-xl flex items-center justify-center">
                    <i class="fas fa-clock text-yellow-500 text-xl"></i>
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
                        <h2 class="text-lg font-semibold text-gray-800">Pelamar Terbaru</h2>
                        <a href="{{ route('hrd.applicants') }}" class="text-blue-500 hover:text-blue-600 text-sm font-medium">
                            Lihat Semua <i class="fas fa-arrow-right ml-1"></i>
                        </a>
                    </div>
                </div>
                <div class="divide-y divide-gray-100">
                    @forelse($recentApplications as $app)
                        <div class="p-4 hover:bg-gray-50 transition-colors">
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-blue-600 rounded-full flex items-center justify-center text-white font-semibold">
                                    {{ strtoupper(substr($app->user->name, 0, 1)) }}
                                </div>
                                <div class="flex-1 min-w-0">
                                    <h4 class="font-medium text-gray-800">{{ $app->user->name }}</h4>
                                    <p class="text-sm text-gray-500">Melamar: {{ $app->job->title }}</p>
                                </div>
                                <div class="text-right">
                                    <span class="badge-status
                                        @if($app->status == 'pending') badge-pending
                                        @elseif($app->status == 'interview') badge-interview
                                        @elseif($app->status == 'accepted') badge-accepted
                                        @else badge-rejected @endif">
                                        {{ ucfirst($app->status) }}
                                    </span>
                                    <p class="text-xs text-gray-400 mt-1">{{ $app->apply_date->format('d M Y') }}</p>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="p-8 text-center">
                            <i class="fas fa-inbox text-gray-300 text-4xl mb-3"></i>
                            <p class="text-gray-500">Belum ada pelamar masuk</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Company Info & Quick Actions -->
        <div class="space-y-6">
            <!-- Company Card -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <div class="flex items-start gap-4 mb-4">
                    <div class="w-14 h-14 bg-gradient-to-br from-blue-100 to-blue-50 rounded-xl flex items-center justify-center">
                        <i class="fas fa-building text-blue-500 text-xl"></i>
                    </div>
                    <div>
                        <h3 class="font-semibold text-gray-800">{{ $company->company_name }}</h3>
                        <span class="badge-status
                            @if($company->status_verifikasi == 'approved') badge-accepted
                            @elseif($company->status_verifikasi == 'pending') badge-pending
                            @else badge-rejected @endif mt-1 inline-block">
                            {{ ucfirst($company->status_verifikasi) }}
                        </span>
                    </div>
                </div>
                @if($company->address)
                    <p class="text-sm text-gray-500"><i class="fas fa-map-marker-alt mr-2"></i>{{ Str::limit($company->address, 50) }}</p>
                @endif
                <a href="{{ route('hrd.company') }}" class="btn-gawean-outline w-full text-center block mt-4 text-sm">
                    <i class="fas fa-edit mr-2"></i>Edit Profil Perusahaan
                </a>
            </div>

            <!-- Quick Actions -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <h3 class="font-semibold text-gray-800 mb-4">Aksi Cepat</h3>
                <div class="space-y-3">
                    @if($company->isApproved())
                        <a href="{{ route('hrd.jobs.create') }}" class="flex items-center gap-3 p-3 rounded-lg hover:bg-blue-50 text-gray-600 hover:text-blue-600 transition-colors">
                            <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                                <i class="fas fa-plus text-blue-500"></i>
                            </div>
                            <span class="font-medium">Posting Lowongan Baru</span>
                        </a>
                    @endif
                    <a href="{{ route('hrd.jobs') }}" class="flex items-center gap-3 p-3 rounded-lg hover:bg-blue-50 text-gray-600 hover:text-blue-600 transition-colors">
                        <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-briefcase text-green-500"></i>
                        </div>
                        <span class="font-medium">Kelola Lowongan</span>
                    </a>
                    <a href="{{ route('hrd.applicants') }}" class="flex items-center gap-3 p-3 rounded-lg hover:bg-blue-50 text-gray-600 hover:text-blue-600 transition-colors">
                        <div class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-user-friends text-purple-500"></i>
                        </div>
                        <span class="font-medium">Review Pelamar</span>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Jobs Overview -->
    @if($jobs->count() > 0)
        <div class="mt-8">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-lg font-semibold text-gray-800">Lowongan Anda</h2>
                <a href="{{ route('hrd.jobs') }}" class="text-blue-500 hover:text-blue-600 text-sm font-medium">
                    Lihat Semua <i class="fas fa-arrow-right ml-1"></i>
                </a>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($jobs as $job)
                    <div class="card-job p-5">
                        <div class="flex items-start justify-between mb-3">
                            <h4 class="font-semibold text-gray-800">{{ $job->title }}</h4>
                            <span class="badge-status {{ $job->status == 'open' ? 'badge-accepted' : 'badge-rejected' }}">
                                {{ $job->status == 'open' ? 'Aktif' : 'Tutup' }}
                            </span>
                        </div>
                        <div class="flex items-center gap-4 text-sm text-gray-500 mb-4">
                            <span><i class="fas fa-users mr-1"></i>{{ $job->applications_count }} pelamar</span>
                            <span><i class="fas fa-map-marker-alt mr-1"></i>{{ $job->location }}</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-xs text-gray-400">Deadline: {{ $job->deadline->format('d M Y') }}</span>
                            <a href="{{ route('hrd.jobs.edit', $job->id) }}" class="text-blue-500 hover:text-blue-600 text-sm font-medium">
                                Edit <i class="fas fa-chevron-right ml-1"></i>
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif
@endsection
