@extends('layouts.dashboard')

@section('title', 'Lamaran Saya')
@section('page-title', 'Lamaran Saya')
@section('page-subtitle', 'Pantau status semua lamaran Anda')

@section('content')
    <div class="bg-white rounded-xl shadow-sm border border-gray-100">
        <div class="p-6 border-b border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-lg font-semibold text-gray-800">Daftar Lamaran</h2>
                    <p class="text-sm text-gray-500">Total {{ $applications->total() }} lamaran</p>
                </div>
                <a href="{{ route('jobs.search') }}" class="btn-gawean text-sm">
                    <i class="fas fa-search mr-2"></i>Cari Lowongan Baru
                </a>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Posisi</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Perusahaan</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Tanggal Lamar</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($applications as $app)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 bg-gradient-to-br from-blue-100 to-blue-50 rounded-lg flex items-center justify-center flex-shrink-0">
                                        <i class="fas fa-briefcase text-blue-500"></i>
                                    </div>
                                    <div>
                                        <p class="font-medium text-gray-800">{{ $app->job->title }}</p>
                                        <p class="text-xs text-gray-500">{{ $app->job->category->name ?? '-' }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <p class="text-gray-700">{{ $app->job->company->company_name }}</p>
                                <p class="text-xs text-gray-500">{{ $app->job->location }}</p>
                            </td>
                            <td class="px-6 py-4">
                                <p class="text-gray-700">{{ $app->apply_date->format('d M Y') }}</p>
                            </td>
                            <td class="px-6 py-4">
                                <span class="badge-status
                                    @if($app->status == 'pending') badge-pending
                                    @elseif($app->status == 'interview') badge-interview
                                    @elseif($app->status == 'accepted') badge-accepted
                                    @else badge-rejected @endif">
                                    {{ $app->status_label }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-2">
                                    <a href="{{ route('jobs.show', $app->job_id) }}"
                                       class="text-blue-500 hover:text-blue-600 text-sm font-medium">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    @if($app->status == 'pending')
                                        <form action="{{ route('pelamar.application.cancel', $app->id) }}" method="POST"
                                              onsubmit="return confirm('Yakin ingin membatalkan lamaran ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-500 hover:text-red-600 text-sm">
                                                <i class="fas fa-times"></i>
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center">
                                <i class="fas fa-inbox text-gray-300 text-5xl mb-4"></i>
                                <p class="text-gray-500 mb-2">Belum ada lamaran</p>
                                <a href="{{ route('jobs.search') }}" class="text-blue-500 hover:underline">
                                    Cari lowongan dan mulai melamar
                                </a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($applications->hasPages())
            <div class="p-6 border-t border-gray-100">
                {{ $applications->links() }}
            </div>
        @endif
    </div>

    <!-- Status Legend -->
    <div class="mt-6 bg-white rounded-xl shadow-sm border border-gray-100 p-6">
        <h3 class="font-semibold text-gray-800 mb-4">Keterangan Status</h3>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            <div class="flex items-center gap-3">
                <span class="badge-status badge-pending">Pending</span>
                <span class="text-sm text-gray-600">Menunggu review</span>
            </div>
            <div class="flex items-center gap-3">
                <span class="badge-status badge-interview">Interview</span>
                <span class="text-sm text-gray-600">Dipanggil interview</span>
            </div>
            <div class="flex items-center gap-3">
                <span class="badge-status badge-accepted">Diterima</span>
                <span class="text-sm text-gray-600">Lamaran diterima</span>
            </div>
            <div class="flex items-center gap-3">
                <span class="badge-status badge-rejected">Ditolak</span>
                <span class="text-sm text-gray-600">Lamaran ditolak</span>
            </div>
        </div>
    </div>
@endsection
