@php
    // Cek tipe pesan yang ada di session
    $type = null;
    $message = null;

    if (Session::has('success')) {
        $type = 'success';
        $message = Session::get('success');
    } elseif (Session::has('error')) {
        $type = 'error';
        $message = Session::get('error');
    } elseif (Session::has('warning')) {
        $type = 'warning';
        $message = Session::get('warning');
    } elseif (Session::has('info')) {
        $type = 'info';
        $message = Session::get('info');
    }

    // Konfigurasi tampilan berdasarkan tipe
    $config = [
        'success' => [
            'icon' => 'fa-check-circle',
            'color' => 'text-green-500',
            'border' => 'border-green-500',
            'title' => 'Berhasil!'
        ],
        'error' => [
            'icon' => 'fa-times-circle',
            'color' => 'text-red-500',
            'border' => 'border-red-500',
            'title' => 'Gagal!'
        ],
        'warning' => [
            'icon' => 'fa-exclamation-triangle',
            'color' => 'text-yellow-500',
            'border' => 'border-yellow-500',
            'title' => 'Perhatian'
        ],
        'info' => [
            'icon' => 'fa-info-circle',
            'color' => 'text-blue-500',
            'border' => 'border-blue-500',
            'title' => 'Informasi'
        ]
    ];
@endphp

@if ($message)
    <div id="flash-message"
         style="z-index: 9999;"
         class="fixed top-24 right-5 max-w-sm w-full bg-white border-l-4 {{ $config[$type]['border'] }} rounded-lg shadow-2xl overflow-hidden transform transition-all duration-500 flex items-start animate-slide-in-right">

        <div class="p-4 flex items-center w-full">
            <div class="flex-shrink-0 {{ $config[$type]['color'] }}">
                <i class="fas {{ $config[$type]['icon'] }} text-2xl"></i>
            </div>

            <div class="ml-3 w-0 flex-1 pt-0.5">
                <p class="text-sm font-bold text-gray-900">{{ $config[$type]['title'] }}</p>
                <p class="text-sm text-gray-500 mt-1">{{ $message }}</p>
            </div>

            <div class="ml-4 flex-shrink-0 flex">
                <button onclick="document.getElementById('flash-message').remove()" class="bg-white rounded-md inline-flex text-gray-400 hover:text-gray-500 focus:outline-none transition-colors">
                    <span class="sr-only">Tutup</span>
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>
    </div>

    <script>
        // Otomatis hilang setelah 5 detik
        setTimeout(function() {
            var flash = document.getElementById('flash-message');
            if (flash) {
                flash.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
                flash.style.opacity = '0';
                flash.style.transform = 'translateX(100%)'; // Geser ke kanan saat hilang
                setTimeout(() => flash.remove(), 500);
            }
        }, 5000);
    </script>

    <style>
        @keyframes slideInRight {
            from { transform: translateX(100%); opacity: 0; }
            to { transform: translateX(0); opacity: 1; }
        }
        .animate-slide-in-right {
            animation: slideInRight 0.5s ease-out forwards;
        }
    </style>
@endif
