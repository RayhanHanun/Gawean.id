@extends('layouts.dashboard')

@section('title', 'Kelola Lowongan')
@section('page-title', 'Kelola Lowongan')
@section('page-subtitle', 'Buat dan kelola lowongan pekerjaan')

@section('content')
    <div class="flex items-center justify-between mb-6">
        <div>
            <p class="text-gray-500">Total {{ $jobs->total() }} lowongan</p>
        </div>
        @if($company->isApproved())
            <a href="{{ route('hrd.jobs.create') }}" class="btn-gawean">
                <i class="fas fa-plus mr-2"></i>Tambah Lowongan
            </a>
        @else
            <button disabled class="bg-gray-300 text-gray-500 font-semibold py-2.5 px-6 rounded-lg cursor-not-allowed">
                <i class="fas fa-lock mr-2"></i>Menunggu Verifikasi
            </button>
        @endif
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Posisi</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Kategori</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Lokasi</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Pelamar</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Deadline</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($jobs as $job)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4">
                                <p class="font-medium text-gray-800">{{ $job->title }}</p>
                                <p class="text-xs text-gray-500">ID: {{ $job->id }}</p>
                            </td>
                            <td class="px-6 py-4 text-gray-600">{{ $job->category->name ?? '-' }}</td>
                            <td class="px-6 py-4 text-gray-600">{{ $job->location }}</td>
                            <td class="px-6 py-4">
                                <a href="{{ route('hrd.applicants', $job->id) }}" class="text-blue-500 hover:underline">
                                    {{ $job->applications_count }} pelamar
                                </a>
                            </td>
                            <td class="px-6 py-4 text-gray-600">{{ $job->deadline->format('d M Y') }}</td>
                            <td class="px-6 py-4">
                                <span class="badge-status {{ $job->status == 'open' ? 'badge-accepted' : 'badge-rejected' }}">
                                    {{ $job->status == 'open' ? 'Aktif' : 'Tutup' }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-2">
                                    <a href="{{ route('hrd.jobs.edit', $job->id) }}"
                                       class="w-8 h-8 bg-blue-50 hover:bg-blue-100 rounded-lg flex items-center justify-center text-blue-500 transition-colors">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a href="{{ route('hrd.applicants', $job->id) }}"
                                       class="w-8 h-8 bg-green-50 hover:bg-green-100 rounded-lg flex items-center justify-center text-green-500 transition-colors">
                                        <i class="fas fa-users"></i>
                                    </a>
                                    <form action="{{ route('hrd.jobs.delete', $job->id) }}" method="POST"
                                          onsubmit="return confirm('Yakin ingin menghapus lowongan ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="w-8 h-8 bg-red-50 hover:bg-red-100 rounded-lg flex items-center justify-center text-red-500 transition-colors">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-12 text-center">
                                <i class="fas fa-briefcase text-gray-300 text-5xl mb-4"></i>
                                <p class="text-gray-500 mb-2">Belum ada lowongan</p>
                                @if($company->isApproved())
                                    <a href="{{ route('hrd.jobs.create') }}" class="text-blue-500 hover:underline">
                                        Buat lowongan pertama Anda
                                    </a>
                                @endif
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($jobs->hasPages())
            <div class="p-6 border-t border-gray-100">
                {{ $jobs->links() }}
            </div>
        @endif
    </div>
@endsection
