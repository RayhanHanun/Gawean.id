@extends('layouts.dashboard')

@section('title', 'Daftar Perusahaan')
@section('page-title', 'Daftar Perusahaan')
@section('page-subtitle', 'Lengkapi profil perusahaan Anda untuk mulai memposting lowongan')

@section('content')
    <div class="max-w-2xl mx-auto">
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-8">
            <div class="text-center mb-8">
                <div class="w-20 h-20 bg-gradient-to-br from-blue-100 to-blue-50 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-building text-blue-500 text-3xl"></i>
                </div>
                <h2 class="text-2xl font-bold text-gray-800">Daftarkan Perusahaan Anda</h2>
                <p class="text-gray-500 mt-2">Isi informasi perusahaan untuk memulai rekrutmen</p>
            </div>

            <form action="{{ route('hrd.company.store') }}" method="POST" class="space-y-6">
                @csrf

                <div>
                    <label for="company_name" class="block text-sm font-medium text-gray-700 mb-2">
                        Nama Perusahaan <span class="text-red-500">*</span>
                    </label>
                    <input type="text" id="company_name" name="company_name" value="{{ old('company_name') }}"
                           class="input-gawean @error('company_name') border-red-500 @enderror"
                           placeholder="PT. Nama Perusahaan" required>
                    @error('company_name')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                        Deskripsi Perusahaan
                    </label>
                    <textarea id="description" name="description" rows="4"
                              class="input-gawean @error('description') border-red-500 @enderror"
                              placeholder="Ceritakan tentang perusahaan Anda...">{{ old('description') }}</textarea>
                    @error('description')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="address" class="block text-sm font-medium text-gray-700 mb-2">
                        Alamat Perusahaan <span class="text-red-500">*</span>
                    </label>
                    <textarea id="address" name="address" rows="2"
                              class="input-gawean @error('address') border-red-500 @enderror"
                              placeholder="Jl. Nama Jalan No. 123, Kota" required>{{ old('address') }}</textarea>
                    @error('address')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="website" class="block text-sm font-medium text-gray-700 mb-2">
                        Website
                    </label>
                    <div class="flex">
                        <span class="inline-flex items-center px-4 border border-r-0 border-gray-200 rounded-l-xl bg-gray-50 text-gray-500 text-sm">
                            https://
                        </span>
                        <input type="text" id="website" name="website" value="{{ old('website') }}"
                               class="flex-1 px-4 py-3 border border-gray-200 rounded-r-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all @error('website') border-red-500 @enderror"
                               placeholder="www.perusahaan.com">
                    </div>
                    @error('website')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="bg-yellow-50 border border-yellow-200 rounded-xl p-4">
                    <div class="flex gap-3">
                        <i class="fas fa-info-circle text-yellow-500 mt-1"></i>
                        <div>
                            <p class="font-medium text-yellow-800">Proses Verifikasi</p>
                            <p class="text-sm text-yellow-700 mt-1">
                                Setelah mendaftar, perusahaan Anda akan diverifikasi oleh Admin.
                                Proses ini membutuhkan waktu 1-2 hari kerja.
                            </p>
                        </div>
                    </div>
                </div>

                <button type="submit" class="btn-gawean w-full">
                    <i class="fas fa-paper-plane mr-2"></i>Daftarkan Perusahaan
                </button>
            </form>
        </div>
    </div>
@endsection
