@extends('layouts.dashboard')

@section('title', 'Kelola Kategori')
@section('page-title', 'Kelola Kategori')
@section('page-subtitle', 'Tambah dan kelola kategori pekerjaan')

@section('content')
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Add Category Form -->
        <div>
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <h3 class="font-semibold text-gray-800 mb-4">Tambah Kategori Baru</h3>
                <form action="{{ route('admin.categories.store') }}" method="POST" class="space-y-4">
                    @csrf
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Nama Kategori</label>
                        <input type="text" id="name" name="name" required
                               class="input-gawean @error('name') border-red-500 @enderror"
                               placeholder="Contoh: Data Science">
                        @error('name')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <button type="submit" class="btn-gawean w-full">
                        <i class="fas fa-plus mr-2"></i>Tambah Kategori
                    </button>
                </form>
            </div>
        </div>

        <!-- Categories List -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="p-6 border-b border-gray-100">
                    <h3 class="font-semibold text-gray-800">Daftar Kategori</h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase">ID</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase">Nama</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase">Jumlah Lowongan</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @foreach($categories as $category)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 text-gray-600 text-sm">{{ $category->id }}</td>
                                    <td class="px-6 py-4">
                                        <form action="{{ route('admin.categories.update', $category->id) }}" method="POST" class="flex items-center gap-2">
                                            @csrf
                                            @method('PUT')
                                            <input type="text" name="name" value="{{ $category->name }}"
                                                   class="border-0 bg-transparent font-medium text-gray-800 focus:bg-gray-100 rounded px-2 py-1 -ml-2">
                                            <button type="submit" class="text-blue-500 hover:text-blue-600">
                                                <i class="fas fa-save"></i>
                                            </button>
                                        </form>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="px-3 py-1 bg-blue-50 text-blue-600 rounded-full text-sm">
                                            {{ $category->jobs_count }} lowongan
                                        </span>
                                    </td>
                                    <td class="px-6 py-4">
                                        @if($category->jobs_count == 0)
                                            <form action="{{ route('admin.categories.delete', $category->id) }}" method="POST"
                                                  onsubmit="return confirm('Yakin ingin menghapus kategori ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-500 hover:text-red-600">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        @else
                                            <span class="text-gray-400 text-sm" title="Tidak dapat dihapus karena memiliki lowongan">
                                                <i class="fas fa-lock"></i>
                                            </span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Category Statistics -->
    <div class="mt-8">
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <h3 class="font-semibold text-gray-800 mb-6">Statistik Kategori</h3>
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4">
                @foreach($categoryStats as $stat)
                    <div class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-xl p-4 text-center">
                        <p class="text-2xl font-bold text-blue-600">{{ $stat->jumlah_lowongan }}</p>
                        <p class="text-sm text-blue-800">{{ $stat->kategori_pekerjaan }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection
