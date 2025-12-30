@extends('layouts.dashboard')

@section('title', 'Profil Saya')
@section('page-title', 'Profil Saya')
@section('page-subtitle', 'Kelola informasi profil Anda')

@section('content')
    <div class="max-w-3xl">
        <div class="bg-white rounded-xl shadow-sm border border-gray-100">
            <div class="p-6 border-b border-gray-100">
                <h2 class="text-lg font-semibold text-gray-800">Informasi Profil</h2>
                <p class="text-sm text-gray-500">Pastikan profil Anda lengkap agar peluang diterima lebih besar</p>
            </div>

            <form action="{{ route('pelamar.profile.update') }}" method="POST" enctype="multipart/form-data" class="p-6 space-y-6">
                @csrf
                @method('PUT')

                <!-- Profile Picture Preview -->
                <div class="flex items-center gap-6">
                    <div class="w-24 h-24 bg-gradient-to-br from-blue-500 to-blue-600 rounded-full flex items-center justify-center">
                        <span class="text-white text-3xl font-bold">{{ strtoupper(substr($user->name, 0, 1)) }}</span>
                    </div>
                    <div>
                        <h3 class="font-semibold text-gray-800">{{ $user->name }}</h3>
                        <p class="text-gray-500">{{ $user->email }}</p>
                        <p class="text-xs text-gray-400 mt-1">ID: {{ $user->id }}</p>
                    </div>
                </div>

                <hr class="border-gray-100">

                <!-- Name -->
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Nama Lengkap</label>
                    <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}" required
                           class="input-gawean @error('name') border-red-500 @enderror">
                    @error('name')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Phone -->
                <div>
                    <label for="phone_number" class="block text-sm font-medium text-gray-700 mb-2">Nomor Telepon</label>
                    <input type="text" id="phone_number" name="phone_number"
                           value="{{ old('phone_number', $profile->phone_number ?? '') }}"
                           placeholder="08xxxxxxxxxx"
                           class="input-gawean @error('phone_number') border-red-500 @enderror">
                    @error('phone_number')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Skills -->
                <div>
                    <label for="skills" class="block text-sm font-medium text-gray-700 mb-2">
                        Keahlian / Skills
                        <span class="text-gray-400 font-normal">(pisahkan dengan koma)</span>
                    </label>
                    <textarea id="skills" name="skills" rows="3"
                              placeholder="Contoh: PHP, Laravel, MySQL, JavaScript"
                              class="input-gawean @error('skills') border-red-500 @enderror">{{ old('skills', $profile->skills ?? '') }}</textarea>
                    @error('skills')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- CV Upload -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">CV / Resume</label>

                    @if($profile && $profile->cv_file)
                        <div class="bg-green-50 border border-green-200 rounded-lg p-4 mb-4">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center">
                                        <i class="fas fa-file-pdf text-green-600"></i>
                                    </div>
                                    <div>
                                        <p class="font-medium text-green-800">{{ $profile->cv_file }}</p>
                                        <p class="text-xs text-green-600">CV sudah diupload</p>
                                    </div>
                                </div>
                                <a href="{{ asset('storage/cv/' . $profile->cv_file) }}" target="_blank"
                                   class="text-green-600 hover:text-green-700">
                                    <i class="fas fa-download"></i>
                                </a>
                            </div>
                        </div>
                    @endif

                    <div class="border-2 border-dashed border-gray-200 rounded-lg p-6 text-center hover:border-blue-300 transition-colors">
                        <input type="file" id="cv_file" name="cv_file" accept=".pdf,.doc,.docx" class="hidden"
                               onchange="updateFileName(this)">
                        <label for="cv_file" class="cursor-pointer">
                            <div class="w-12 h-12 bg-blue-50 rounded-lg flex items-center justify-center mx-auto mb-3">
                                <i class="fas fa-cloud-upload-alt text-blue-500 text-xl"></i>
                            </div>
                            <p class="text-gray-600 font-medium" id="file-label">
                                @if($profile && $profile->cv_file)
                                    Ganti dengan file baru
                                @else
                                    Upload CV Anda
                                @endif
                            </p>
                            <p class="text-gray-400 text-sm mt-1">PDF, DOC, DOCX (Max 2MB)</p>
                        </label>
                    </div>
                    @error('cv_file')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Submit -->
                <div class="flex justify-end pt-4">
                    <button type="submit" class="btn-gawean">
                        <i class="fas fa-save mr-2"></i>Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>

@push('scripts')
<script>
function updateFileName(input) {
    const label = document.getElementById('file-label');
    if (input.files && input.files[0]) {
        label.textContent = input.files[0].name;
    }
}
</script>
@endpush
@endsection
