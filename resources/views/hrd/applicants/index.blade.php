@extends('layouts.dashboard')

@section('title', 'Kelola Pelamar')
@section('page-title', 'Kelola Pelamar')
@section('page-subtitle', 'Review dan kelola lamaran masuk')

@section('content')
    <!-- Filter by Job -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4 mb-6">
        <div class="flex flex-col md:flex-row gap-4 items-center">
            <span class="text-gray-600 font-medium">Filter berdasarkan lowongan:</span>
            <div class="flex flex-wrap gap-2">
                <a href="{{ route('hrd.applicants') }}"
                   class="px-4 py-2 rounded-lg text-sm font-medium transition-colors
                   {{ !$jobId ? 'bg-blue-500 text-white' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">
                    Semua
                </a>
                @foreach($jobs as $job)
                    <a href="{{ route('hrd.applicants', $job->id) }}"
                       class="px-4 py-2 rounded-lg text-sm font-medium transition-colors
                       {{ $jobId == $job->id ? 'bg-blue-500 text-white' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">
                        {{ Str::limit($job->title, 20) }}
                    </a>
                @endforeach
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="p-6 border-b border-gray-100">
            <p class="text-gray-500">Total {{ $applications->total() }} pelamar</p>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Pelamar</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Posisi</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Tanggal</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Skills</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($applications as $app)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-blue-600 rounded-full flex items-center justify-center text-white font-semibold">
                                        {{ strtoupper(substr($app->user->name, 0, 1)) }}
                                    </div>
                                    <div>
                                        <p class="font-medium text-gray-800">{{ $app->user->name }}</p>
                                        <p class="text-xs text-gray-500">{{ $app->user->email }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <p class="text-gray-700">{{ $app->job->title }}</p>
                            </td>
                            <td class="px-6 py-4 text-gray-600">
                                {{ $app->apply_date->format('d M Y') }}
                            </td>
                            <td class="px-6 py-4">
                                <p class="text-sm text-gray-600">{{ Str::limit($app->user->profile->skills ?? '-', 30) }}</p>
                            </td>
                            <td class="px-6 py-4">
                                <span class="badge-status
                                    @if($app->status == 'pending') badge-pending
                                    @elseif($app->status == 'interview') badge-interview
                                    @elseif($app->status == 'accepted') badge-accepted
                                    @else badge-rejected @endif">
                                    {{ ucfirst($app->status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <a href="{{ route('hrd.applicant.show', $app->id) }}"
                                   class="text-blue-500 hover:text-blue-600 font-medium text-sm">
                                    Review <i class="fas fa-chevron-right ml-1"></i>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center">
                                <i class="fas fa-users text-gray-300 text-5xl mb-4"></i>
                                <p class="text-gray-500">Belum ada pelamar</p>
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
@endsection
