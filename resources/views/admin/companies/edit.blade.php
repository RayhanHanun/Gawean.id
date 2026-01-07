@extends('layouts.dashboard')

@section('title', 'Edit Perusahaan')
@section('page-title', 'Edit Perusahaan')
@section('page-subtitle', 'Perbarui data perusahaan dan status verifikasi')

@section('content')
    <div class="max-w-4xl mx-auto">
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <div class="mb-6">
                <h2 class="text-xl font-semibold text-gray-800">Form Edit Perusahaan</h2>
                <p class="text-sm text-gray-500">Sesuaikan informasi perusahaan lalu simpan perubahan.</p>
            </div>

            @if ($errors->any())
                <div class="mb-4 rounded-lg border border-red-200 bg-red-50 text-red-700 px-4 py-3">
                    <ul class="list-disc list-inside text-sm">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('admin.companies.update', $company->id) }}" method="POST" class="space-y-5">
                @csrf
                @method('PUT')

                <div class="grid md:grid-cols-2 gap-4">
                    <div>
                        <label for="company_name" class="block text-sm font-medium text-gray-700 mb-1">Nama Perusahaan</label>
                        <input type="text" id="company_name" name="company_name" value="{{ old('company_name', $company->company_name) }}" required
                               class="w-full rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500" placeholder="PT Contoh Makmur">
                    </div>
                    <div>
                        <label for="address" class="block text-sm font-medium text-gray-700 mb-1">Alamat</label>
                        <input type="text" id="address" name="address" value="{{ old('address', $company->address) }}"
                               class="w-full rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500" placeholder="Jl. Raya No. 1, Jakarta">
                    </div>
                </div>

                <div class="grid md:grid-cols-2 gap-4">
                    <div>
                        <label for="website" class="block text-sm font-medium text-gray-700 mb-1">Website</label>
                        <input type="text" id="website" name="website" value="{{ old('website', $company->website) }}"
                               class="w-full rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500" placeholder="example.com">
                    </div>
                    <div>
                        <label for="status_verifikasi" class="block text-sm font-medium text-gray-700 mb-1">Status Verifikasi</label>
                        <select id="status_verifikasi" name="status_verifikasi" required
                                class="w-full rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500">
                            <option value="pending" {{ old('status_verifikasi', $company->status_verifikasi) == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="approved" {{ old('status_verifikasi', $company->status_verifikasi) == 'approved' ? 'selected' : '' }}>Verified</option>
                            <option value="rejected" {{ old('status_verifikasi', $company->status_verifikasi) == 'rejected' ? 'selected' : '' }}>Rejected</option>
                        </select>
                    </div>
                </div>

                <div>
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Deskripsi</label>
                    <textarea id="description" name="description" rows="4"
                              class="w-full rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500" placeholder="Jelaskan profil perusahaan">{{ old('description', $company->description) }}</textarea>
                </div>

                <div class="flex items-center justify-between pt-2">
                    <a href="{{ route('admin.companies') }}" class="inline-flex items-center px-4 py-2 text-sm font-semibold text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-lg transition">
                        Batal
                    </a>
                    <button type="submit" class="inline-flex items-center px-4 py-2 text-sm font-semibold text-white bg-blue-600 hover:bg-blue-700 rounded-lg shadow-sm transition">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
