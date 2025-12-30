@extends('layouts.app')

@section('title', 'Daftar - Gawean.id')

@section('content')
<div class="min-h-[calc(100vh-4rem)] flex items-center justify-center py-12 px-4 bg-gray-50">
    <div class="w-full max-w-lg">
        <div class="bg-white rounded-2xl shadow-xl p-8">
            <!-- Logo -->
            <div class="text-center mb-8">
                <div class="inline-flex items-center gap-2 mb-4">
                    <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl flex items-center justify-center">
                        <span class="text-white font-bold text-2xl">G</span>
                    </div>
                </div>
                <h1 class="text-2xl font-bold text-gray-800">Buat Akun Baru</h1>
                <p class="text-gray-500 mt-2">Bergabung dengan Gawean.id sekarang</p>
            </div>

            <!-- Role Tabs -->
            <div class="flex gap-2 mb-6 bg-gray-100 p-1 rounded-xl">
                <button type="button" onclick="switchRole('pelamar')" id="tab-pelamar"
                        class="flex-1 py-3 px-4 rounded-lg text-sm font-semibold transition-all duration-200 bg-white text-blue-600 shadow-sm">
                    <i class="fas fa-user mr-2"></i>Pencari Kerja
                </button>
                <button type="button" onclick="switchRole('hrd')" id="tab-hrd"
                        class="flex-1 py-3 px-4 rounded-lg text-sm font-semibold transition-all duration-200 text-gray-600 hover:bg-gray-50">
                    <i class="fas fa-building mr-2"></i>Perusahaan/HRD
                </button>
            </div>

            <!-- Form -->
            <form action="{{ route('register') }}" method="POST" class="space-y-5">
                @csrf
                <input type="hidden" name="role" id="role" value="pelamar">

                <!-- Common Fields -->
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Nama Lengkap</label>
                    <div class="relative">
                        <i class="fas fa-user absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"></i>
                        <input type="text" id="name" name="name" value="{{ old('name') }}" required
                               class="input-gawean pl-11 @error('name') border-red-500 @enderror"
                               placeholder="Nama lengkap Anda">
                    </div>
                    @error('name')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                    <div class="relative">
                        <i class="fas fa-envelope absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"></i>
                        <input type="email" id="email" name="email" value="{{ old('email') }}" required
                               class="input-gawean pl-11 @error('email') border-red-500 @enderror"
                               placeholder="nama@email.com">
                    </div>
                    @error('email')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-2">Password</label>
                        <div class="relative">
                            <i class="fas fa-lock absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"></i>
                            <input type="password" id="password" name="password" required
                                   class="input-gawean pl-11 @error('password') border-red-500 @enderror"
                                   placeholder="Min. 6 karakter">
                        </div>
                        @error('password')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">Konfirmasi</label>
                        <div class="relative">
                            <i class="fas fa-lock absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"></i>
                            <input type="password" id="password_confirmation" name="password_confirmation" required
                                   class="input-gawean pl-11"
                                   placeholder="Ulangi password">
                        </div>
                    </div>
                </div>

                <!-- Pelamar Fields -->
                <div id="fields-pelamar">
                    <div>
                        <label for="phone_number" class="block text-sm font-medium text-gray-700 mb-2">Nomor Telepon <span class="text-gray-400">(opsional)</span></label>
                        <div class="relative">
                            <i class="fas fa-phone absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"></i>
                            <input type="text" id="phone_number" name="phone_number" value="{{ old('phone_number') }}"
                                   class="input-gawean pl-11"
                                   placeholder="08xxxxxxxxxx">
                        </div>
                    </div>
                </div>

                <!-- HRD Fields -->
                <div id="fields-hrd" class="hidden space-y-4">
                    <div>
                        <label for="company_name" class="block text-sm font-medium text-gray-700 mb-2">Nama Perusahaan</label>
                        <div class="relative">
                            <i class="fas fa-building absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"></i>
                            <input type="text" id="company_name" name="company_name" value="{{ old('company_name') }}"
                                   class="input-gawean pl-11 @error('company_name') border-red-500 @enderror"
                                   placeholder="PT Nama Perusahaan">
                        </div>
                        @error('company_name')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="company_address" class="block text-sm font-medium text-gray-700 mb-2">Alamat Perusahaan</label>
                        <div class="relative">
                            <i class="fas fa-map-marker-alt absolute left-4 top-4 text-gray-400"></i>
                            <textarea id="company_address" name="company_address" rows="2"
                                      class="input-gawean pl-11 @error('company_address') border-red-500 @enderror"
                                      placeholder="Alamat lengkap perusahaan">{{ old('company_address') }}</textarea>
                        </div>
                        @error('company_address')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="company_website" class="block text-sm font-medium text-gray-700 mb-2">Website <span class="text-gray-400">(opsional)</span></label>
                        <div class="relative">
                            <i class="fas fa-globe absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"></i>
                            <input type="text" id="company_website" name="company_website" value="{{ old('company_website') }}"
                                   class="input-gawean pl-11"
                                   placeholder="www.perusahaan.com">
                        </div>
                    </div>

                    <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                        <div class="flex gap-3">
                            <i class="fas fa-info-circle text-yellow-500 mt-0.5"></i>
                            <div class="text-sm text-yellow-700">
                                <p class="font-medium">Perlu Verifikasi</p>
                                <p>Akun perusahaan memerlukan verifikasi admin sebelum dapat memposting lowongan.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex items-start gap-2">
                    <input type="checkbox" required class="checkbox checkbox-primary checkbox-sm mt-1">
                    <span class="text-sm text-gray-600">
                        Saya setuju dengan <a href="#" class="text-blue-500 hover:underline">Syarat & Ketentuan</a>
                        dan <a href="#" class="text-blue-500 hover:underline">Kebijakan Privasi</a>
                    </span>
                </div>

                <button type="submit" class="btn-gawean w-full py-3">
                    <i class="fas fa-user-plus mr-2"></i>Daftar Sekarang
                </button>
            </form>

            <!-- Divider -->
            <div class="relative my-8">
                <div class="absolute inset-0 flex items-center">
                    <div class="w-full border-t border-gray-200"></div>
                </div>
                <div class="relative flex justify-center text-sm">
                    <span class="px-4 bg-white text-gray-500">Sudah punya akun?</span>
                </div>
            </div>

            <a href="{{ route('login') }}" class="btn-gawean-outline w-full py-3 text-center block">
                <i class="fas fa-sign-in-alt mr-2"></i>Masuk
            </a>
        </div>
    </div>
</div>

@push('scripts')
<script>
function switchRole(role) {
    document.getElementById('role').value = role;

    // Update tabs
    const tabPelamar = document.getElementById('tab-pelamar');
    const tabHrd = document.getElementById('tab-hrd');
    const fieldsPelamar = document.getElementById('fields-pelamar');
    const fieldsHrd = document.getElementById('fields-hrd');

    if (role === 'pelamar') {
        tabPelamar.className = 'flex-1 py-3 px-4 rounded-lg text-sm font-semibold transition-all duration-200 bg-white text-blue-600 shadow-sm';
        tabHrd.className = 'flex-1 py-3 px-4 rounded-lg text-sm font-semibold transition-all duration-200 text-gray-600 hover:bg-gray-50';
        fieldsPelamar.classList.remove('hidden');
        fieldsHrd.classList.add('hidden');
    } else {
        tabHrd.className = 'flex-1 py-3 px-4 rounded-lg text-sm font-semibold transition-all duration-200 bg-white text-blue-600 shadow-sm';
        tabPelamar.className = 'flex-1 py-3 px-4 rounded-lg text-sm font-semibold transition-all duration-200 text-gray-600 hover:bg-gray-50';
        fieldsHrd.classList.remove('hidden');
        fieldsPelamar.classList.add('hidden');
    }
}
</script>
@endpush
@endsection
