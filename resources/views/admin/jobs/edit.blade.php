@extends('layouts.dashboard')

@section('title', 'Edit Lowongan')
@section('page-title', 'Edit Lowongan')
@section('page-subtitle', 'Perbarui informasi lowongan kerja')

@section('content')
    <div class="max-w-2xl mx-auto">
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-8">

            <!-- Header -->
            <div class="mb-6">
                <h2 class="text-2xl font-bold text-gray-800">{{ $job->title }}</h2>
                <p class="text-gray-500 text-sm mt-1">ID: {{ $job->id }}</p>
            </div>

            <!-- Form -->
            <form action="{{ route('admin.jobs.update', $job->id) }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')

                <!-- Judul Lowongan -->
                <div>
                    <label for="title" class="block text-sm font-semibold text-gray-700 mb-2">
                        Judul Lowongan <span class="text-red-500">*</span>
                    </label>
                    <input type="text" id="title" name="title" value="{{ old('title', $job->title) }}"
                           class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('title') border-red-500 @enderror"
                           placeholder="Masukkan judul lowongan">
                    @error('title')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Kategori -->
                <div>
                    <label for="category_id" class="block text-sm font-semibold text-gray-700 mb-2">
                        Kategori <span class="text-red-500">*</span>
                    </label>
                    <select id="category_id" name="category_id"
                            class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('category_id') border-red-500 @enderror">
                        <option value="">-- Pilih Kategori --</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id', $job->category_id) == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('category_id')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Perusahaan (Readonly) -->
                <div>
                    <label for="company_name" class="block text-sm font-semibold text-gray-700 mb-2">
                        Perusahaan
                    </label>
                    <input type="text" id="company_name" value="{{ $job->company->company_name ?? 'N/A' }}"
                           class="w-full px-4 py-2 border border-gray-200 rounded-lg bg-gray-50 text-gray-600 cursor-not-allowed"
                           disabled>
                    <p class="text-gray-400 text-xs mt-1">Perusahaan tidak dapat diubah</p>
                </div>

                <!-- Gaji -->
                <div>
                    <label for="salary_range" class="block text-sm font-semibold text-gray-700 mb-2">
                        Rentang Gaji
                    </label>
                    <input type="text" id="salary_range" name="salary_range" value="{{ old('salary_range', $job->salary_range) }}"
                           class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('salary_range') border-red-500 @enderror"
                           placeholder="Contoh: Rp 5.000.000 - Rp 8.000.000 atau Disembunyikan">
                    @error('salary_range')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Lokasi -->
                <div>
                    <label for="location" class="block text-sm font-semibold text-gray-700 mb-2">
                        Lokasi <span class="text-red-500">*</span>
                    </label>
                    <input type="text" id="location" name="location" value="{{ old('location', $job->location) }}"
                           class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('location') border-red-500 @enderror"
                           placeholder="Contoh: Jakarta, Indonesia">
                    @error('location')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Deadline -->
                <div>
                    <label for="deadline" class="block text-sm font-semibold text-gray-700 mb-2">
                        Deadline <span class="text-red-500">*</span>
                    </label>
                    <input type="date" id="deadline" name="deadline" value="{{ old('deadline', $job->deadline?->format('Y-m-d')) }}"
                           class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('deadline') border-red-500 @enderror">
                    @error('deadline')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Deskripsi -->
                <div>
                    <label for="description" class="block text-sm font-semibold text-gray-700 mb-2">
                        Deskripsi <span class="text-red-500">*</span>
                    </label>
                    <textarea id="description" name="description" rows="6"
                              class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('description') border-red-500 @enderror"
                              placeholder="Masukkan deskripsi lowongan...">{{ old('description', $job->description) }}</textarea>
                    @error('description')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Status -->
                <div>
                    <label for="status" class="block text-sm font-semibold text-gray-700 mb-2">
                        Status <span class="text-red-500">*</span>
                    </label>
                    <select id="status" name="status"
                            class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('status') border-red-500 @enderror">
                        <option value="open" {{ old('status', $job->status) == 'open' ? 'selected' : '' }}>
                            Buka
                        </option>
                        <option value="closed" {{ old('status', $job->status) == 'closed' ? 'selected' : '' }}>
                            Tutup
                        </option>
                    </select>
                    @error('status')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Action Buttons -->
                <div class="flex gap-3 pt-6 border-t border-gray-100">
                    <a href="{{ route('admin.jobs') }}"
                       class="flex-1 px-4 py-2 border border-gray-200 text-gray-700 font-medium rounded-lg hover:bg-gray-50 transition-colors text-center">
                        Batal
                    </a>
                    <button type="submit"
                            class="flex-1 px-4 py-2 bg-blue-500 text-white font-medium rounded-lg hover:bg-blue-600 transition-colors">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
