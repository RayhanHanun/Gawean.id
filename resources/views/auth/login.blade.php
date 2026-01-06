@extends('layouts.app')

@section('title', 'Masuk - Gawean.id')

@section('content')
<div class="min-h-screen bg-gray-50 flex items-center justify-center px-4 pt-20">
    <div class="w-full max-w-md">
        <div class="bg-white rounded-2xl shadow-xl p-8 border border-gray-100">
            <div class="text-center mb-8">
                <div class="inline-flex items-center justify-center w-12 h-12 mb-4 rounded-xl bg-gradient-to-br from-purple-600 to-indigo-600 shadow-lg shadow-purple-500/20">
                    <span class="text-white font-bold text-2xl">G</span>
                </div>
                <h1 class="text-2xl font-bold text-gray-900">Selamat Datang</h1>
                <p class="text-sm text-gray-500 mt-2">Masuk untuk melanjutkan aktivitas Anda</p>
            </div>

            <form action="{{ route('login') }}" method="POST" class="space-y-5">
                @csrf

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                    <div class="relative">
                        <i class="fas fa-envelope absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"></i>
                        <input type="email" name="email" value="{{ old('email') }}" required
                               class="w-full pl-11 pr-4 py-3 rounded-xl border border-gray-300 focus:border-purple-500 focus:ring-2 focus:ring-purple-200 outline-none transition-all"
                               placeholder="contoh@email.com">
                    </div>
                    @error('email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                    <div class="relative">
                        <i class="fas fa-lock absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"></i>
                        <input type="password" name="password" required
                               class="w-full pl-11 pr-4 py-3 rounded-xl border border-gray-300 focus:border-purple-500 focus:ring-2 focus:ring-purple-200 outline-none transition-all"
                               placeholder="••••••••">
                    </div>
                    @error('password') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="flex items-center justify-between text-sm">
                    <label class="flex items-center text-gray-600 cursor-pointer">
                        <input type="checkbox" name="remember" class="mr-2 rounded text-purple-600 focus:ring-purple-500">
                        Ingat Saya
                    </label>
                    <a href="#" class="text-purple-600 hover:text-purple-700 font-medium">Lupa Password?</a>
                </div>

                <button type="submit" class="w-full py-3 bg-gradient-to-r from-purple-600 to-indigo-600 hover:from-purple-700 hover:to-indigo-700 text-white font-bold rounded-xl shadow-lg transition-all transform hover:-translate-y-0.5">
                    Masuk Sekarang
                </button>
            </form>

            <div class="mt-8 text-center text-sm text-gray-500">
                Belum punya akun?
                <a href="{{ route('register') }}" class="font-bold text-purple-600 hover:underline">Daftar Gratis</a>
            </div>
        </div>
    </div>
</div>
@endsection
