@extends('layouts.dashboard')

@section('title', 'Detail Pengguna')
@section('page-title', 'Detail Pengguna')
@section('page-subtitle', 'Informasi lengkap pengguna')

@section('content')
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- User Info -->
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <div class="flex items-start gap-6">
                    <div class="w-20 h-20 bg-gradient-to-br from-blue-500 to-blue-600 rounded-full flex items-center justify-center text-white text-2xl font-bold">
                        {{ strtoupper(substr($user->name, 0, 1)) }}
                    </div>
                    <div class="flex-1">
                        <h2 class="text-xl font-bold text-gray-800">{{ $user->name }}</h2>
                        <p class="text-gray-500 mb-3">{{ $user->email }}</p>
                        <div class="flex flex-wrap gap-3">
                            <span class="px-3 py-1 rounded-full text-xs font-semibold
                                @if($user->role == 'admin') bg-red-100 text-red-700
                                @elseif($user->role == 'hrd') bg-blue-100 text-blue-700
                                @else bg-green-100 text-green-700 @endif">
                                {{ ucfirst($user->role) }}
                            </span>
                            <span class="text-sm text-gray-500">
                                <i class="fas fa-calendar-alt mr-1"></i>
                                Bergabung: {{ $user->created_at ? $user->created_at->format('d M Y') : '-' }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            @if($user->role == 'pelamar' && $user->profile)
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                    <h3 class="font-semibold text-gray-800 mb-4"><i class="fas fa-user-circle mr-2 text-blue-500"></i>Profil Pelamar</h3>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <p class="text-sm text-gray-500">Telepon</p>
                            <p class="font-medium text-gray-800">{{ $user->profile->phone_number ?? '-' }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">CV</p>
                            <p class="font-medium text-gray-800">{{ $user->profile->cv_file ? 'Uploaded' : 'Belum upload' }}</p>
                        </div>
                    </div>
                    @if($user->profile->skills)
                        <div class="mt-4">
                            <p class="text-sm text-gray-500 mb-2">Skills</p>
                            <div class="flex flex-wrap gap-2">
                                @foreach(explode(', ', $user->profile->skills) as $skill)
                                    <span class="px-3 py-1 bg-blue-50 text-blue-600 rounded-full text-sm">{{ trim($skill) }}</span>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
            @endif

            @if($user->role == 'hrd' && $user->company)
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                    <h3 class="font-semibold text-gray-800 mb-4"><i class="fas fa-building mr-2 text-purple-500"></i>Perusahaan</h3>
                    <div class="space-y-4">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm text-gray-500">Nama Perusahaan</p>
                                <p class="font-medium text-gray-800">{{ $user->company->company_name }}</p>
                            </div>
                            <span class="badge-status
                                @if($user->company->status_verifikasi == 'approved') badge-accepted
                                @elseif($user->company->status_verifikasi == 'pending') badge-pending
                                @else badge-rejected @endif">
                                {{ ucfirst($user->company->status_verifikasi) }}
                            </span>
                        </div>
                        @if($user->company->address)
                            <div>
                                <p class="text-sm text-gray-500">Alamat</p>
                                <p class="text-gray-700">{{ $user->company->address }}</p>
                            </div>
                        @endif
                    </div>
                </div>
            @endif

            @if($user->role == 'pelamar' && $user->applications->count() > 0)
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                    <h3 class="font-semibold text-gray-800 mb-4"><i class="fas fa-file-alt mr-2 text-purple-500"></i>Riwayat Lamaran</h3>
                    <div class="space-y-3">
                        @foreach($user->applications as $app)
                            <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                                <div>
                                    <p class="font-medium text-gray-800">{{ $app->job->title }}</p>
                                    <p class="text-sm text-gray-500">{{ $app->apply_date->format('d M Y') }}</p>
                                </div>
                                <span class="badge-status
                                    @if($app->status == 'pending') badge-pending
                                    @elseif($app->status == 'interview') badge-interview
                                    @elseif($app->status == 'accepted') badge-accepted
                                    @else badge-rejected @endif">
                                    {{ ucfirst($app->status) }}
                                </span>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>

        <div class="space-y-6">
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <h3 class="font-semibold text-gray-800 mb-4">Info Akun</h3>
                <div class="space-y-4">
                    <div>
                        <p class="text-sm text-gray-500">User ID</p>
                        <p class="font-mono text-gray-800">{{ $user->id }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Role</p>
                        <p class="font-medium text-gray-800 capitalize">{{ $user->role }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Tanggal Daftar</p>
                        <p class="font-medium text-gray-800">{{ $user->created_at ? $user->created_at->format('d M Y H:i') : '-' }}</p>
                    </div>
                </div>
            </div>

            <a href="{{ route('admin.users') }}" class="btn-gawean-outline w-full text-center block">
                <i class="fas fa-arrow-left mr-2"></i>Kembali
            </a>
        </div>
    </div>
@endsection
