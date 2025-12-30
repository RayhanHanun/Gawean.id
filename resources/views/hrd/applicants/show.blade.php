@extends('layouts.dashboard')

@section('title', 'Detail Pelamar')
@section('page-title', 'Detail Pelamar')
@section('page-subtitle', 'Review dan update status lamaran')

@section('content')
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Applicant Info -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Profile Card -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <div class="flex items-start gap-6">
                    <div class="w-20 h-20 bg-gradient-to-br from-blue-500 to-blue-600 rounded-full flex items-center justify-center text-white text-2xl font-bold">
                        {{ strtoupper(substr($application->user->name, 0, 1)) }}
                    </div>
                    <div class="flex-1">
                        <h2 class="text-xl font-bold text-gray-800">{{ $application->user->name }}</h2>
                        <p class="text-gray-500 mb-3">{{ $application->user->email }}</p>
                        <div class="flex flex-wrap gap-4 text-sm text-gray-600">
                            @if($application->user->profile && $application->user->profile->phone_number)
                                <span><i class="fas fa-phone mr-2 text-gray-400"></i>{{ $application->user->profile->phone_number }}</span>
                            @endif
                            <span><i class="fas fa-calendar-alt mr-2 text-gray-400"></i>Melamar: {{ $application->apply_date->format('d M Y') }}</span>
                        </div>
                    </div>
                    <span class="badge-status
                        @if($application->status == 'pending') badge-pending
                        @elseif($application->status == 'interview') badge-interview
                        @elseif($application->status == 'accepted') badge-accepted
                        @else badge-rejected @endif text-sm">
                        {{ ucfirst($application->status) }}
                    </span>
                </div>
            </div>

            <!-- Skills -->
            @if($application->user->profile && $application->user->profile->skills)
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                    <h3 class="font-semibold text-gray-800 mb-4"><i class="fas fa-tools mr-2 text-blue-500"></i>Skills</h3>
                    <div class="flex flex-wrap gap-2">
                        @foreach(explode(', ', $application->user->profile->skills) as $skill)
                            <span class="px-3 py-1 bg-blue-50 text-blue-600 rounded-full text-sm">{{ trim($skill) }}</span>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- CV -->
            @if($application->user->profile && $application->user->profile->cv_file)
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                    <h3 class="font-semibold text-gray-800 mb-4"><i class="fas fa-file-pdf mr-2 text-blue-500"></i>CV / Resume</h3>
                    <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                        <div class="flex items-center gap-3">
                            <div class="w-12 h-12 bg-red-100 rounded-lg flex items-center justify-center">
                                <i class="fas fa-file-pdf text-red-500 text-xl"></i>
                            </div>
                            <div>
                                <p class="font-medium text-gray-800">{{ $application->user->profile->cv_file }}</p>
                                <p class="text-xs text-gray-500">Dokumen CV</p>
                            </div>
                        </div>
                        <a href="{{ asset('storage/cv/' . $application->user->profile->cv_file) }}" target="_blank"
                           class="btn-gawean text-sm">
                            <i class="fas fa-download mr-2"></i>Download
                        </a>
                    </div>
                </div>
            @endif

            <!-- Notes -->
            @if($application->notes)
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                    <h3 class="font-semibold text-gray-800 mb-4"><i class="fas fa-sticky-note mr-2 text-blue-500"></i>Catatan</h3>
                    <p class="text-gray-600">{{ $application->notes }}</p>
                </div>
            @endif
        </div>

        <!-- Sidebar - Update Status -->
        <div class="space-y-6">
            <!-- Job Applied -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <h3 class="font-semibold text-gray-800 mb-4">Posisi Dilamar</h3>
                <div class="flex items-start gap-3">
                    <div class="w-12 h-12 bg-gradient-to-br from-blue-100 to-blue-50 rounded-xl flex items-center justify-center">
                        <i class="fas fa-briefcase text-blue-500"></i>
                    </div>
                    <div>
                        <p class="font-semibold text-gray-800">{{ $application->job->title }}</p>
                        <p class="text-sm text-gray-500">{{ $application->job->location }}</p>
                    </div>
                </div>
            </div>

            <!-- Update Status Form -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <h3 class="font-semibold text-gray-800 mb-4">Update Status</h3>

                <form action="{{ route('hrd.applicant.status', $application->id) }}" method="POST" class="space-y-4">
                    @csrf
                    @method('PUT')

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Status Lamaran</label>
                        <select name="status" class="input-gawean" required>
                            <option value="pending" {{ $application->status == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="interview" {{ $application->status == 'interview' ? 'selected' : '' }}>Interview</option>
                            <option value="accepted" {{ $application->status == 'accepted' ? 'selected' : '' }}>Diterima</option>
                            <option value="rejected" {{ $application->status == 'rejected' ? 'selected' : '' }}>Ditolak</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Catatan Internal</label>
                        <textarea name="notes" rows="3" class="input-gawean" placeholder="Catatan untuk tim HR...">{{ $application->notes }}</textarea>
                    </div>

                    <button type="submit" class="btn-gawean w-full">
                        <i class="fas fa-save mr-2"></i>Update Status
                    </button>
                </form>

                @if($application->status != 'accepted')
                    <div class="mt-4 p-3 bg-yellow-50 rounded-lg">
                        <p class="text-xs text-yellow-700">
                            <i class="fas fa-info-circle mr-1"></i>
                            Jika status diubah menjadi "Diterima", lowongan akan otomatis ditutup.
                        </p>
                    </div>
                @endif
            </div>

            <!-- Back Button -->
            <a href="{{ route('hrd.applicants') }}" class="btn-gawean-outline w-full text-center block">
                <i class="fas fa-arrow-left mr-2"></i>Kembali ke Daftar
            </a>
        </div>
    </div>
@endsection
