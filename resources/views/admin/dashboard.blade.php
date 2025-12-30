@extends('layouts.dashboard')

@section('title', 'Dashboard Admin')
@section('page-title', 'Dashboard Admin')
@section('page-subtitle', 'Selamat datang di panel administrasi Gawean.id')

@section('content')
    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm">Total User</p>
                    <p class="text-3xl font-bold text-gray-800">{{ $stats['total_users'] }}</p>
                </div>
                <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center">
                    <i class="fas fa-users text-blue-500 text-xl"></i>
                </div>
            </div>
            <div class="mt-3 text-sm text-gray-500">
                <span class="text-green-500">{{ $stats['total_pelamar'] }}</span> pelamar,
                <span class="text-purple-500">{{ $stats['total_hrd'] }}</span> HRD
            </div>
        </div>

        <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm">Total Perusahaan</p>
                    <p class="text-3xl font-bold text-gray-800">{{ $stats['total_companies'] }}</p>
                </div>
                <div class="w-12 h-12 bg-purple-100 rounded-xl flex items-center justify-center">
                    <i class="fas fa-building text-purple-500 text-xl"></i>
                </div>
            </div>
            <div class="mt-3 text-sm">
                <span class="text-yellow-500">{{ $stats['pending_companies'] }}</span> menunggu verifikasi
            </div>
        </div>

        <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm">Total Lowongan</p>
                    <p class="text-3xl font-bold text-gray-800">{{ $stats['total_jobs'] }}</p>
                </div>
                <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center">
                    <i class="fas fa-briefcase text-green-500 text-xl"></i>
                </div>
            </div>
            <div class="mt-3 text-sm">
                <span class="text-green-500">{{ $stats['active_jobs'] }}</span> lowongan aktif
            </div>
        </div>

        <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm">Total Lamaran</p>
                    <p class="text-3xl font-bold text-gray-800">{{ $stats['total_applications'] }}</p>
                </div>
                <div class="w-12 h-12 bg-yellow-100 rounded-xl flex items-center justify-center">
                    <i class="fas fa-file-alt text-yellow-500 text-xl"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Pending Companies -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-xl shadow-sm border border-gray-100">
                <div class="p-6 border-b border-gray-100">
                    <div class="flex items-center justify-between">
                        <h2 class="text-lg font-semibold text-gray-800">Perusahaan Menunggu Verifikasi</h2>
                        <a href="{{ route('admin.companies', ['status' => 'pending']) }}" class="text-blue-500 hover:text-blue-600 text-sm font-medium">
                            Lihat Semua <i class="fas fa-arrow-right ml-1"></i>
                        </a>
                    </div>
                </div>
                <div class="divide-y divide-gray-100">
                    @forelse($pendingCompanies as $company)
                        <div class="p-4 hover:bg-gray-50 transition-colors">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-4">
                                    <div class="w-12 h-12 bg-gradient-to-br from-blue-100 to-blue-50 rounded-xl flex items-center justify-center">
                                        <i class="fas fa-building text-blue-500"></i>
                                    </div>
                                    <div>
                                        <h4 class="font-medium text-gray-800">{{ $company->company_name }}</h4>
                                        <p class="text-sm text-gray-500">{{ $company->email_hrd }}</p>
                                    </div>
                                </div>
                                <div class="flex items-center gap-2">
                                    <form action="{{ route('admin.companies.approve', $company->id) }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit" class="w-8 h-8 bg-green-50 hover:bg-green-100 rounded-lg flex items-center justify-center text-green-500 transition-colors">
                                            <i class="fas fa-check"></i>
                                        </button>
                                    </form>
                                    <form action="{{ route('admin.companies.reject', $company->id) }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit" class="w-8 h-8 bg-red-50 hover:bg-red-100 rounded-lg flex items-center justify-center text-red-500 transition-colors">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="p-8 text-center">
                            <i class="fas fa-check-circle text-green-300 text-4xl mb-3"></i>
                            <p class="text-gray-500">Tidak ada perusahaan yang menunggu verifikasi</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="space-y-6">
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <h3 class="font-semibold text-gray-800 mb-4">Aksi Cepat</h3>
                <div class="space-y-3">
                    <a href="{{ route('admin.companies', ['status' => 'pending']) }}" class="flex items-center gap-3 p-3 rounded-lg hover:bg-yellow-50 text-gray-600 hover:text-yellow-600 transition-colors">
                        <div class="w-10 h-10 bg-yellow-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-clock text-yellow-500"></i>
                        </div>
                        <div>
                            <span class="font-medium">Verifikasi Perusahaan</span>
                            <p class="text-xs text-gray-400">{{ $stats['pending_companies'] }} menunggu</p>
                        </div>
                    </a>
                    <a href="{{ route('admin.users') }}" class="flex items-center gap-3 p-3 rounded-lg hover:bg-blue-50 text-gray-600 hover:text-blue-600 transition-colors">
                        <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-users text-blue-500"></i>
                        </div>
                        <span class="font-medium">Kelola User</span>
                    </a>
                    <a href="{{ route('admin.categories') }}" class="flex items-center gap-3 p-3 rounded-lg hover:bg-green-50 text-gray-600 hover:text-green-600 transition-colors">
                        <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-tags text-green-500"></i>
                        </div>
                        <span class="font-medium">Kelola Kategori</span>
                    </a>
                    <a href="{{ route('admin.reports') }}" class="flex items-center gap-3 p-3 rounded-lg hover:bg-purple-50 text-gray-600 hover:text-purple-600 transition-colors">
                        <div class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-chart-bar text-purple-500"></i>
                        </div>
                        <span class="font-medium">Lihat Laporan</span>
                    </a>
                </div>
            </div>

            <!-- Company Stats -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <h3 class="font-semibold text-gray-800 mb-4">Rekap Perusahaan</h3>
                <div class="space-y-3">
                    @foreach($companyStats->take(5) as $stat)
                        <div class="flex items-center justify-between">
                            <span class="text-gray-600 text-sm">{{ Str::limit($stat->company_name, 20) }}</span>
                            <span class="text-blue-500 font-medium">{{ $stat->total_lowongan }} lowongan</span>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Applications -->
    <div class="mt-8">
        <div class="bg-white rounded-xl shadow-sm border border-gray-100">
            <div class="p-6 border-b border-gray-100">
                <h2 class="text-lg font-semibold text-gray-800">Aktivitas Lamaran Terbaru</h2>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Pelamar</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Posisi</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Perusahaan</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Tanggal</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach($recentApplications as $app)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4">
                                    <p class="font-medium text-gray-800">{{ $app->user->name }}</p>
                                    <p class="text-xs text-gray-500">{{ $app->user->email }}</p>
                                </td>
                                <td class="px-6 py-4 text-gray-600">{{ $app->job->title }}</td>
                                <td class="px-6 py-4 text-gray-600">{{ $app->job->company->company_name }}</td>
                                <td class="px-6 py-4 text-gray-600">{{ $app->apply_date->format('d M Y') }}</td>
                                <td class="px-6 py-4">
                                    <span class="badge-status
                                        @if($app->status == 'pending') badge-pending
                                        @elseif($app->status == 'interview') badge-interview
                                        @elseif($app->status == 'accepted') badge-accepted
                                        @else badge-rejected @endif">
                                        {{ ucfirst($app->status) }}
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
