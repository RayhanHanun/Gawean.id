<footer class="bg-gray-950 text-gray-100 mt-auto border-t border-gray-900">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
            <!-- Brand -->
            <div class="col-span-1 md:col-span-2">
                <div class="flex items-center gap-2 mb-4">
                    <div class="w-10 h-10 bg-gradient-to-br from-purple-500 to-indigo-600 rounded-lg flex items-center justify-center">
                        <span class="text-white font-bold text-xl">G</span>
                    </div>
                    <span class="text-xl font-bold text-white">Gawean<span class="text-transparent bg-clip-text bg-gradient-to-r from-purple-400 to-indigo-400">.id</span></span>
                </div>
                <p class="text-gray-300 mb-4 max-w-md">
                    Platform lowongan kerja terpercaya di Indonesia. Temukan pekerjaan impianmu atau rekrut talenta terbaik untuk perusahaanmu.
                </p>
                <div class="flex gap-4">
                    <a href="#" class="w-10 h-10 bg-gray-900 hover:bg-gray-800 border border-gray-800 hover:border-purple-400 rounded-lg flex items-center justify-center transition-all duration-300">
                        <i class="fab fa-facebook-f text-gray-300 hover:text-white"></i>
                    </a>
                    <a href="#" class="w-10 h-10 bg-gray-900 hover:bg-gray-800 border border-gray-800 hover:border-purple-400 rounded-lg flex items-center justify-center transition-all duration-300">
                        <i class="fab fa-twitter text-gray-300 hover:text-white"></i>
                    </a>
                    <a href="#" class="w-10 h-10 bg-gray-900 hover:bg-gray-800 border border-gray-800 hover:border-purple-400 rounded-lg flex items-center justify-center transition-all duration-300">
                        <i class="fab fa-instagram text-gray-300 hover:text-white"></i>
                    </a>
                    <a href="#" class="w-10 h-10 bg-gray-900 hover:bg-gray-800 border border-gray-800 hover:border-purple-400 rounded-lg flex items-center justify-center transition-all duration-300">
                        <i class="fab fa-linkedin-in text-gray-300 hover:text-white"></i>
                    </a>
                </div>
            </div>

            <!-- Quick Links -->
            <div>
                <h4 class="font-semibold text-lg mb-4 text-white">Tautan Cepat</h4>
                <ul class="space-y-2">
                    <li><a href="{{ route('jobs.search') }}" class="text-gray-300 hover:text-purple-300 transition-colors flex items-center gap-2"><i class="fas fa-chevron-right text-xs text-purple-400"></i>Cari Lowongan</a></li>
                    <li><a href="{{ route('register') }}" class="text-gray-300 hover:text-purple-300 transition-colors flex items-center gap-2"><i class="fas fa-chevron-right text-xs text-purple-400"></i>Daftar Akun</a></li>
                    <li><a href="#" class="text-gray-300 hover:text-purple-300 transition-colors flex items-center gap-2"><i class="fas fa-chevron-right text-xs text-purple-400"></i>Tentang Kami</a></li>
                    <li><a href="#" class="text-gray-300 hover:text-purple-300 transition-colors flex items-center gap-2"><i class="fas fa-chevron-right text-xs text-purple-400"></i>Kontak</a></li>
                </ul>
            </div>

            <!-- For Companies -->
            <div>
                <h4 class="font-semibold text-lg mb-4 text-white">Untuk Perusahaan</h4>
                <ul class="space-y-2">
                    <li><a href="{{ route('register') }}" class="text-gray-300 hover:text-purple-300 transition-colors flex items-center gap-2"><i class="fas fa-chevron-right text-xs text-purple-400"></i>Pasang Lowongan</a></li>
                    <li><a href="#" class="text-gray-300 hover:text-purple-300 transition-colors flex items-center gap-2"><i class="fas fa-chevron-right text-xs text-purple-400"></i>Harga & Paket</a></li>
                    <li><a href="#" class="text-gray-300 hover:text-purple-300 transition-colors flex items-center gap-2"><i class="fas fa-chevron-right text-xs text-purple-400"></i>Panduan HRD</a></li>
                </ul>
            </div>
        </div>

        <div class="border-t border-gray-900 mt-8 pt-8 flex flex-col md:flex-row justify-between items-center">
            <p class="text-gray-400 text-sm">&copy; {{ date('Y') }} Gawean.id. All rights reserved.</p>
            <div class="flex gap-6 mt-4 md:mt-0">
                <a href="#" class="text-gray-300 hover:text-purple-300 text-sm transition-colors">Kebijakan Privasi</a>
                <a href="#" class="text-gray-300 hover:text-purple-300 text-sm transition-colors">Syarat & Ketentuan</a>
            </div>
        </div>
    </div>
</footer>
