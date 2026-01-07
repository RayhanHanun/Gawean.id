@extends('layouts.app')

@section('title', 'Daftar - Gawean.id')

@section('content')
<div class="min-h-screen bg-gray-50 flex justify-center pt-24 pb-12 px-4" style="padding-top: 8rem;">
    <div class="w-full max-w-lg">
        <div class="bg-white rounded-2xl shadow-xl p-8 border border-gray-100">
            <div class="text-center mb-8">
                <h1 class="text-2xl font-bold text-gray-900">Buat Akun Baru</h1>
                <p class="text-gray-500 mt-2 text-sm">Mulai karir atau rekrutmen Anda bersama Gawean.id</p>
            </div>

            <div class="flex gap-2 mb-6 bg-gray-100 p-1 rounded-xl">
                <button type="button" onclick="switchRole('pelamar')" id="tab-pelamar"
                        class="flex-1 py-3 px-4 rounded-lg text-sm font-semibold transition-all duration-200 bg-white text-purple-700 shadow-sm ring-1 ring-black/5">
                    <i class="fas fa-user mr-2"></i>Pencari Kerja
                </button>
                <button type="button" onclick="switchRole('hrd')" id="tab-hrd"
                        class="flex-1 py-3 px-4 rounded-lg text-sm font-semibold transition-all duration-200 text-gray-500 hover:text-gray-700 hover:bg-gray-200">
                    <i class="fas fa-building mr-2"></i>Perusahaan/HRD
                </button>
            </div>

            <form action="{{ route('register') }}" method="POST" class="space-y-5">
                @csrf
                <input type="hidden" name="role" id="role" value="pelamar">

                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Nama Lengkap</label>
                    <div class="relative">
                        <i class="fas fa-user absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"></i>
                        <input type="text" id="name" name="name" value="{{ old('name') }}" required
                               class="w-full pl-11 pr-4 py-3 rounded-xl border border-gray-300 focus:border-purple-500 focus:ring-2 focus:ring-purple-200 outline-none transition-all"
                               placeholder="Nama lengkap Anda">
                    </div>
                    @error('name')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                    <div class="relative">
                        <i class="fas fa-envelope absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"></i>
                        <input type="email" id="email" name="email" value="{{ old('email') }}" required
                               class="w-full pl-11 pr-4 py-3 rounded-xl border border-gray-300 focus:border-purple-500 focus:ring-2 focus:ring-purple-200 outline-none transition-all"
                               placeholder="nama@email.com">
                    </div>
                    @error('email')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-2">Password</label>
                        <div class="relative">
                            <i class="fas fa-lock absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"></i>
                            <input type="password" id="password" name="password" required
                                   class="w-full pl-11 pr-4 py-3 rounded-xl border border-gray-300 focus:border-purple-500 focus:ring-2 focus:ring-purple-200 outline-none transition-all"
                                   placeholder="Min. 8 karakter">
                        </div>
                    </div>
                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">Konfirmasi</label>
                        <div class="relative">
                            <i class="fas fa-lock absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"></i>
                            <input type="password" id="password_confirmation" name="password_confirmation" required
                                   class="w-full pl-11 pr-4 py-3 rounded-xl border border-gray-300 focus:border-purple-500 focus:ring-2 focus:ring-purple-200 outline-none transition-all"
                                   placeholder="Ulangi password">
                        </div>
                    </div>
                </div>
                @error('password')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror

                <div id="fields-pelamar">
                    <div>
                        <label for="phone_number" class="block text-sm font-medium text-gray-700 mb-2">Nomor Telepon <span class="text-gray-400 font-normal">(opsional)</span></label>
                        <div class="relative">
                            <i class="fas fa-phone absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"></i>
                            <input type="text" id="phone_number" name="phone_number" value="{{ old('phone_number') }}"
                                   class="w-full pl-11 pr-4 py-3 rounded-xl border border-gray-300 focus:border-purple-500 focus:ring-2 focus:ring-purple-200 outline-none transition-all"
                                   placeholder="08xxxxxxxxxx">
                        </div>
                    </div>
                </div>

                <div id="fields-hrd" class="hidden space-y-4">
                    <div>
                        <label for="company_name" class="block text-sm font-medium text-gray-700 mb-2">Nama Perusahaan</label>
                        <div class="relative">
                            <i class="fas fa-building absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"></i>
                            <input type="text" id="company_name" name="company_name" value="{{ old('company_name') }}"
                                   class="w-full pl-11 pr-4 py-3 rounded-xl border border-gray-300 focus:border-purple-500 focus:ring-2 focus:ring-purple-200 outline-none transition-all"
                                   placeholder="PT Nama Perusahaan">
                        </div>
                        @error('company_name')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="company_address" class="block text-sm font-medium text-gray-700 mb-2">Alamat Perusahaan</label>
                        <div class="relative">
                            <i class="fas fa-map-marker-alt absolute left-4 top-4 text-gray-400"></i>
                            <textarea id="company_address" name="company_address" rows="2"
                                      class="w-full pl-11 pr-4 py-3 rounded-xl border border-gray-300 focus:border-purple-500 focus:ring-2 focus:ring-purple-200 outline-none transition-all"
                                      placeholder="Alamat lengkap perusahaan">{{ old('company_address') }}</textarea>
                        </div>
                        @error('company_address')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="company_website" class="block text-sm font-medium text-gray-700 mb-2">Website <span class="text-gray-400 font-normal">(opsional)</span></label>
                        <div class="relative">
                            <i class="fas fa-globe absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"></i>
                            <input type="text" id="company_website" name="company_website" value="{{ old('company_website') }}"
                                   class="w-full pl-11 pr-4 py-3 rounded-xl border border-gray-300 focus:border-purple-500 focus:ring-2 focus:ring-purple-200 outline-none transition-all"
                                   placeholder="www.perusahaan.com">
                        </div>
                    </div>

                    <div class="bg-yellow-50 border border-yellow-200 rounded-xl p-4">
                        <div class="flex gap-3">
                            <i class="fas fa-info-circle text-yellow-600 mt-0.5"></i>
                            <div class="text-sm text-yellow-800">
                                <p class="font-bold">Perlu Verifikasi</p>
                                <p>Akun perusahaan memerlukan verifikasi admin sebelum dapat memposting lowongan.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex items-start gap-2 pt-2">
                    <input type="checkbox" required class="mt-1 h-4 w-4 text-purple-600 border-gray-300 rounded focus:ring-purple-500">
                    <span class="text-sm text-gray-600 leading-snug">
                        Saya setuju dengan <a href="#" class="text-purple-600 hover:underline font-medium">Syarat & Ketentuan</a>
                        dan <a href="#" class="text-purple-600 hover:underline font-medium">Kebijakan Privasi</a>
                    </span>
                </div>

                <button type="submit" class="w-full bg-gradient-to-r from-purple-600 to-indigo-600 hover:from-purple-700 hover:to-indigo-700 text-white font-bold py-3 px-4 rounded-xl shadow-lg shadow-purple-500/30 transition-all duration-300 transform hover:-translate-y-0.5">
                    <i class="fas fa-user-plus mr-2"></i>Daftar Sekarang
                </button>
            </form>

            <div class="relative my-8">
                <div class="absolute inset-0 flex items-center">
                    <div class="w-full border-t border-gray-200"></div>
                </div>
                <div class="relative flex justify-center text-sm">
                    <span class="px-4 bg-white text-gray-500">Sudah punya akun?</span>
                </div>
            </div>

            <a href="{{ route('login') }}" class="w-full flex justify-center items-center py-3 px-4 border-2 border-purple-100 rounded-xl text-purple-600 font-semibold hover:bg-purple-50 transition-colors">
                <i class="fas fa-sign-in-alt mr-2"></i>Masuk Disini
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

    // Helper classes
    const activeClass = "bg-white text-purple-700 shadow-sm ring-1 ring-black/5";
    const inactiveClass = "text-gray-500 hover:text-gray-700 hover:bg-gray-200";

    if (role === 'pelamar') {
        tabPelamar.className = `flex-1 py-3 px-4 rounded-lg text-sm font-semibold transition-all duration-200 ${activeClass}`;
        tabHrd.className = `flex-1 py-3 px-4 rounded-lg text-sm font-semibold transition-all duration-200 ${inactiveClass}`;
        fieldsPelamar.classList.remove('hidden');
        fieldsHrd.classList.add('hidden');
    } else {
        tabHrd.className = `flex-1 py-3 px-4 rounded-lg text-sm font-semibold transition-all duration-200 ${activeClass}`;
        tabPelamar.className = `flex-1 py-3 px-4 rounded-lg text-sm font-semibold transition-all duration-200 ${inactiveClass}`;
        fieldsHrd.classList.remove('hidden');
        fieldsPelamar.classList.add('hidden');
    }
}
</script>
@endpush
@endsection
