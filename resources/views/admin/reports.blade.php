@extends('layouts.dashboard')

@section('title', 'Laporan')
@section('page-title', 'Laporan & Statistik')
@section('page-subtitle', 'Lihat statistik platform Gawean.id')

@section('content')
    <!-- Popular Jobs -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 mb-8">
        <div class="p-6 border-b border-gray-100">
            <h2 class="text-lg font-semibold text-gray-800"><i class="fas fa-fire text-orange-500 mr-2"></i>Lowongan Terpopuler</h2>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase">No</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase">Posisi</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase">Perusahaan</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase">Pelamar</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach($popularJobs as $index => $job)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4">
                                <div class="w-8 h-8 bg-gradient-to-br from-blue-500 to-blue-600 rounded-full flex items-center justify-center text-white font-bold text-sm">
                                    {{ $index + 1 }}
                                </div>
                            </td>
                            <td class="px-6 py-4 font-medium text-gray-800">{{ $job->posisi }}</td>
                            <td class="px-6 py-4 text-gray-600">{{ $job->company_name }}</td>
                            <td class="px-6 py-4">
                                <span class="px-3 py-1 bg-blue-50 text-blue-600 rounded-full text-sm font-semibold">
                                    {{ $job->total_pelamar }} pelamar
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <span class="badge-status {{ $job->status == 'open' ? 'badge-accepted' : 'badge-rejected' }}">
                                    {{ $job->status == 'open' ? 'Aktif' : 'Tutup' }}
                                </span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Category Statistics -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100">
            <div class="p-6 border-b border-gray-100">
                <h2 class="text-lg font-semibold text-gray-800"><i class="fas fa-chart-pie text-blue-500 mr-2"></i>Statistik Kategori</h2>
            </div>
            <div class="p-6">
                <div class="space-y-4">
                    @foreach($categoryStats as $stat)
                        @php
                            $maxJobs = $categoryStats->max('jumlah_lowongan') ?: 1;
                            $percentage = ($stat->jumlah_lowongan / $maxJobs) * 100;
                        @endphp
                        <div>
                            <div class="flex items-center justify-between mb-1">
                                <span class="text-gray-700 font-medium">{{ $stat->kategori_pekerjaan }}</span>
                                <span class="text-blue-600 font-semibold">{{ $stat->jumlah_lowongan }} lowongan</span>
                            </div>
                            <div class="w-full bg-gray-100 rounded-full h-3">
                                <div class="bg-gradient-to-r from-blue-500 to-blue-600 h-3 rounded-full transition-all duration-500"
                                     style="width: {{ $percentage }}%"></div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Company Statistics -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100">
            <div class="p-6 border-b border-gray-100">
                <h2 class="text-lg font-semibold text-gray-800"><i class="fas fa-building text-green-500 mr-2"></i>Rekap Perusahaan</h2>
            </div>
            <div class="p-6">
                <div class="space-y-4">
                    @foreach($companyStats as $stat)
                        <div class="flex items-center justify-between p-4 bg-gray-50 rounded-xl">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 bg-gradient-to-br from-blue-100 to-blue-50 rounded-lg flex items-center justify-center">
                                    <i class="fas fa-building text-blue-500"></i>
                                </div>
                                <span class="font-medium text-gray-800">{{ $stat->company_name }}</span>
                            </div>
                            <span class="px-3 py-1 bg-green-100 text-green-700 rounded-full text-sm font-semibold">
                                {{ $stat->total_lowongan }} lowongan
                            </span>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection
