@if(session('success'))
    <div class="bg-green-500/10 border border-green-500/20 p-4 mx-4 mt-4 rounded-xl backdrop-blur-sm" role="alert">
        <div class="flex items-center">
            <i class="fas fa-check-circle text-green-400 mr-3"></i>
            <p class="text-green-300">{{ session('success') }}</p>
        </div>
    </div>
@endif

@if(session('error'))
    <div class="bg-red-500/10 border border-red-500/20 p-4 mx-4 mt-4 rounded-xl backdrop-blur-sm" role="alert">
        <div class="flex items-center">
            <i class="fas fa-exclamation-circle text-red-400 mr-3"></i>
            <p class="text-red-300">{{ session('error') }}</p>
        </div>
    </div>
@endif

@if(session('warning'))
    <div class="bg-yellow-500/10 border border-yellow-500/20 p-4 mx-4 mt-4 rounded-xl backdrop-blur-sm" role="alert">
        <div class="flex items-center">
            <i class="fas fa-exclamation-triangle text-yellow-400 mr-3"></i>
            <p class="text-yellow-300">{{ session('warning') }}</p>
        </div>
    </div>
@endif

@if(session('info'))
    <div class="bg-blue-500/10 border border-blue-500/20 p-4 mx-4 mt-4 rounded-xl backdrop-blur-sm" role="alert">
        <div class="flex items-center">
            <i class="fas fa-info-circle text-blue-400 mr-3"></i>
            <p class="text-blue-300">{{ session('info') }}</p>
        </div>
    </div>
@endif
