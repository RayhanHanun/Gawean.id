@extends('layouts.dashboard')

@section('title', 'Profil Perusahaan')
@section('page-title', 'Profil Perusahaan')
@section('page-subtitle', 'Kelola informasi perusahaan Anda')

@section('content')
    <div class="max-w-3xl">
        @if($company)
            <div class="bg-white rounded-xl shadow-sm border border-gray-100">
                <div class="p-6 border-b border-gray-100">
                    <div class="flex items-center justify-between">
                        <div>
                            <h2 class="text-lg font-semibold text-gray-800">Informasi Perusahaan</h2>
                            <p class="text-sm text-gray-500">ID: {{ $company->id }}</p>
                        </div>
                        <span class="badge-status
                            @if($company->status_verifikasi == 'approved') badge-accepted
                            @elseif($company->status_verifikasi == 'pending') badge-pending
                            @else badge-rejected @endif">
                            {{ ucfirst($company->status_verifikasi) }}
                        </span>
                    </div>
                </div>

                <form action="{{ route('hrd.company.update') }}" method="POST" class="p-6 space-y-6">
                    @csrf
                    @method('PUT')

                    <div>
                        <label for="company_name" class="block text-sm font-medium text-gray-700 mb-2">Nama Perusahaan *</label>
                        <input type="text" id="company_name" name="company_name"
                               value="{{ old('company_name', $company->company_name) }}" required
                               class="input-gawean @error('company_name') border-red-500 @enderror">
                        @error('company_name')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="description" class="block text-sm font-medium text-gray-700 mb-2">Deskripsi Perusahaan</label>
                        <textarea id="description" name="description" rows="4"
                                  class="input-gawean @error('description') border-red-500 @enderror"
                                  placeholder="Ceritakan tentang perusahaan Anda...">{{ old('description', $company->description) }}</textarea>
                        @error('description')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="address" class="block text-sm font-medium text-gray-700 mb-2">Alamat *</label>
                        <textarea id="address" name="address" rows="2" required
                                  class="input-gawean @error('address') border-red-500 @enderror"
                                  placeholder="Alamat lengkap perusahaan">{{ old('address', $company->address) }}</textarea>
                        @error('address')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="website" class="block text-sm font-medium text-gray-700 mb-2">Website</label>
                        <input type="text" id="website" name="website"
                               value="{{ old('website', $company->website) }}"
                               class="input-gawean @error('website') border-red-500 @enderror"
                               placeholder="www.perusahaan.com">
                        @error('website')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex justify-end pt-4">
                        <button type="submit" class="btn-gawean">
                            <i class="fas fa-save mr-2"></i>Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        @else
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-8 text-center">
                <i class="fas fa-building text-gray-300 text-5xl mb-4"></i>
                <h3 class="text-lg font-semibold text-gray-800 mb-2">Belum Ada Profil Perusahaan</h3>
                <p class="text-gray-500 mb-4">Lengkapi profil perusahaan untuk dapat memposting lowongan</p>
                <a href="{{ route('hrd.company.create') }}" class="btn-gawean">
                    <i class="fas fa-plus mr-2"></i>Buat Profil Perusahaan
                </a>
            </div>
        @endif
    </div>
@endsection
