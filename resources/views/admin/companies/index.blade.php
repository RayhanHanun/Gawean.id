@extends('layouts.dashboard')

@section('title', 'Kelola Perusahaan')
@section('page-title', 'Kelola Perusahaan')
@section('page-subtitle', 'Verifikasi dan kelola perusahaan terdaftar')

@section('content')
    <!-- Filter Tabs -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4 mb-6">
        <div class="flex flex-wrap gap-2">
            <a href="{{ route('admin.companies', ['status' => 'all']) }}"
               class="px-4 py-2 rounded-lg text-sm font-medium transition-colors
               {{ $status == 'all' ? 'bg-blue-500 text-white' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">
                Semua
            </a>
            <a href="{{ route('admin.companies', ['status' => 'pending']) }}"
               class="px-4 py-2 rounded-lg text-sm font-medium transition-colors
               {{ $status == 'pending' ? 'bg-yellow-500 text-white' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">
                Pending
            </a>
            <a href="{{ route('admin.companies', ['status' => 'approved']) }}"
               class="px-4 py-2 rounded-lg text-sm font-medium transition-colors
               {{ $status == 'approved' ? 'bg-green-500 text-white' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">
                Approved
            </a>
            <a href="{{ route('admin.companies', ['status' => 'rejected']) }}"
               class="px-4 py-2 rounded-lg text-sm font-medium transition-colors
               {{ $status == 'rejected' ? 'bg-red-500 text-white' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">
                Rejected
            </a>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="p-6 border-b border-gray-100">
            <p class="text-gray-500">Total {{ $companies->total() }} perusahaan</p>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase">ID</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase">Perusahaan</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase">HRD</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase">Alamat</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase">Status</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($companies as $company)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 text-gray-600 text-sm">{{ $company->id }}</td>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 bg-gradient-to-br from-blue-100 to-blue-50 rounded-lg flex items-center justify-center">
                                        <i class="fas fa-building text-blue-500"></i>
                                    </div>
                                    <div>
                                        <p class="font-medium text-gray-800">{{ $company->company_name }}</p>
                                        @if($company->website)
                                            <a href="https://{{ $company->website }}" target="_blank" class="text-xs text-blue-500 hover:underline">{{ $company->website }}</a>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <p class="text-gray-700">{{ $company->user->name }}</p>
                                <p class="text-xs text-gray-500">{{ $company->user->email }}</p>
                            </td>
                            <td class="px-6 py-4 text-gray-600 text-sm">{{ Str::limit($company->address, 30) }}</td>
                            <td class="px-6 py-4">
                                <span class="badge-status
                                    @if($company->status_verifikasi == 'approved') badge-accepted
                                    @elseif($company->status_verifikasi == 'pending') badge-pending
                                    @else badge-rejected @endif">
                                    {{ ucfirst($company->status_verifikasi) }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-2">
                                    @if($company->status_verifikasi == 'pending')
                                        <form action="{{ route('admin.companies.approve', $company->id) }}" method="POST" class="inline">
                                            @csrf
                                            <button type="submit" class="w-8 h-8 bg-green-50 hover:bg-green-100 rounded-lg flex items-center justify-center text-green-500 transition-colors" title="Approve">
                                                <i class="fas fa-check"></i>
                                            </button>
                                        </form>
                                        <form action="{{ route('admin.companies.reject', $company->id) }}" method="POST" class="inline">
                                            @csrf
                                            <button type="submit" class="w-8 h-8 bg-red-50 hover:bg-red-100 rounded-lg flex items-center justify-center text-red-500 transition-colors" title="Reject">
                                                <i class="fas fa-times"></i>
                                            </button>
                                        </form>
                                    @elseif($company->status_verifikasi == 'rejected')
                                        <form action="{{ route('admin.companies.approve', $company->id) }}" method="POST" class="inline">
                                            @csrf
                                            <button type="submit" class="text-green-500 hover:text-green-600 text-sm font-medium">
                                                <i class="fas fa-redo mr-1"></i>Approve
                                            </button>
                                        </form>
                                    @else
                                        <span class="text-gray-400 text-sm"><i class="fas fa-check-circle mr-1"></i>Verified</span>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center">
                                <i class="fas fa-building text-gray-300 text-5xl mb-4"></i>
                                <p class="text-gray-500">Tidak ada perusahaan ditemukan</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($companies->hasPages())
            <div class="p-6 border-t border-gray-100">
                {{ $companies->appends(['status' => $status])->links() }}
            </div>
        @endif
    </div>
@endsection
