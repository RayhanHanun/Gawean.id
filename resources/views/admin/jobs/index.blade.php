@extends('layouts.dashboard')

@section('title', 'Kelola Lowongan')
@section('page-title', 'Kelola Lowongan')
@section('page-subtitle', 'Lihat semua lowongan yang terdaftar')

@section('content')
    <!-- Filter Tabs -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4 mb-6">
        <div class="flex flex-wrap gap-2">
            <a href="{{ route('admin.jobs', ['status' => 'all']) }}"
               class="px-4 py-2 rounded-lg text-sm font-medium transition-colors
               {{ $status == 'all' ? 'bg-blue-500 text-white' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">
                Semua
            </a>
            <a href="{{ route('admin.jobs', ['status' => 'open']) }}"
               class="px-4 py-2 rounded-lg text-sm font-medium transition-colors
               {{ $status == 'open' ? 'bg-green-500 text-white' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">
                Aktif
            </a>
            <a href="{{ route('admin.jobs', ['status' => 'closed']) }}"
               class="px-4 py-2 rounded-lg text-sm font-medium transition-colors
               {{ $status == 'closed' ? 'bg-red-500 text-white' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">
                Tutup
            </a>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="p-6 border-b border-gray-100">
            <p class="text-gray-500">Total {{ $jobs->total() }} lowongan</p>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase">ID</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase">Posisi</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase">Perusahaan</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase">Kategori</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase">Pelamar</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase">Deadline</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($jobs as $job)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 text-gray-600 text-sm">{{ $job->id }}</td>
                            <td class="px-6 py-4">
                                <p class="font-medium text-gray-800">{{ $job->title }}</p>
                                <p class="text-xs text-gray-500">{{ $job->location }}</p>
                            </td>
                            <td class="px-6 py-4 text-gray-600">{{ $job->company->company_name }}</td>
                            <td class="px-6 py-4 text-gray-600">{{ $job->category->name ?? '-' }}</td>
                            <td class="px-6 py-4">
                                <span class="px-3 py-1 bg-blue-50 text-blue-600 rounded-full text-sm">
                                    {{ $job->applications_count }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-gray-600 text-sm">{{ $job->deadline->format('d M Y') }}</td>
                            <td class="px-6 py-4">
                                <span class="badge-status {{ $job->status == 'open' ? 'badge-accepted' : 'badge-rejected' }}">
                                    {{ $job->status == 'open' ? 'Aktif' : 'Tutup' }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-12 text-center">
                                <i class="fas fa-briefcase text-gray-300 text-5xl mb-4"></i>
                                <p class="text-gray-500">Tidak ada lowongan ditemukan</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($jobs->hasPages())
            <div class="p-6 border-t border-gray-100">
                {{ $jobs->appends(['status' => $status])->links() }}
            </div>
        @endif
    </div>
@endsection
