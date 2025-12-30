@extends('layouts.dashboard')

@section('title', 'Edit Lowongan')
@section('page-title', 'Edit Lowongan')
@section('page-subtitle', 'Perbarui informasi lowongan')

@section('content')
    <div class="max-w-3xl">
        <div class="bg-white rounded-xl shadow-sm border border-gray-100">
            <div class="p-6 border-b border-gray-100">
                <h2 class="text-lg font-semibold text-gray-800">Edit: {{ $job->title }}</h2>
                <p class="text-sm text-gray-500">ID: {{ $job->id }}</p>
            </div>

            <form action="{{ route('hrd.jobs.update', $job->id) }}" method="POST" class="p-6 space-y-6">
                @csrf
                @method('PUT')

                <div>
                    <label for="title" class="block text-sm font-medium text-gray-700 mb-2">Judul Posisi *</label>
                    <input type="text" id="title" name="title" value="{{ old('title', $job->title) }}" required
                           class="input-gawean @error('title') border-red-500 @enderror">
                    @error('title')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="category_id" class="block text-sm font-medium text-gray-700 mb-2">Kategori *</label>
                        <select id="category_id" name="category_id" required
                                class="input-gawean @error('category_id') border-red-500 @enderror">
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}" {{ old('category_id', $job->category_id) == $cat->id ? 'selected' : '' }}>
                                    {{ $cat->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('category_id')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="location" class="block text-sm font-medium text-gray-700 mb-2">Lokasi *</label>
                        <input type="text" id="location" name="location" value="{{ old('location', $job->location) }}" required
                               class="input-gawean @error('location') border-red-500 @enderror">
                        @error('location')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div>
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-2">Deskripsi Pekerjaan *</label>
                    <textarea id="description" name="description" rows="6" required
                              class="input-gawean @error('description') border-red-500 @enderror">{{ old('description', $job->description) }}</textarea>
                    @error('description')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div>
                        <label for="salary_range" class="block text-sm font-medium text-gray-700 mb-2">Range Gaji</label>
                        <input type="text" id="salary_range" name="salary_range"
                               value="{{ old('salary_range', $job->salary_range) }}"
                               class="input-gawean @error('salary_range') border-red-500 @enderror">
                        @error('salary_range')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="deadline" class="block text-sm font-medium text-gray-700 mb-2">Deadline *</label>
                        <input type="date" id="deadline" name="deadline"
                               value="{{ old('deadline', $job->deadline->format('Y-m-d')) }}" required
                               class="input-gawean @error('deadline') border-red-500 @enderror">
                        @error('deadline')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="status" class="block text-sm font-medium text-gray-700 mb-2">Status *</label>
                        <select id="status" name="status" required
                                class="input-gawean @error('status') border-red-500 @enderror">
                            <option value="open" {{ old('status', $job->status) == 'open' ? 'selected' : '' }}>Buka</option>
                            <option value="closed" {{ old('status', $job->status) == 'closed' ? 'selected' : '' }}>Tutup</option>
                        </select>
                        @error('status')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="flex items-center justify-end gap-4 pt-4 border-t border-gray-100">
                    <a href="{{ route('hrd.jobs') }}" class="btn-gawean-outline">Batal</a>
                    <button type="submit" class="btn-gawean">
                        <i class="fas fa-save mr-2"></i>Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
