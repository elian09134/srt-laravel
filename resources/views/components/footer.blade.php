<footer class="relative bg-gradient-to-br from-gray-900 via-gray-800 to-gray-900 text-white overflow-hidden">
    <div class="absolute inset-0 bg-grid-pattern opacity-5"></div>
    <div class="container mx-auto px-6 py-16 relative z-10">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-12">
            <!-- Kolom 1: Logo & Social -->
            <div>
                <a href="{{ route('home') }}" class="flex items-center space-x-3 group">
                    <img src="{{ asset('images/terang.png') }}" alt="TERANG By SRT" class="h-12 w-auto transform group-hover:scale-105 transition-transform duration-300">
                    <div>
                        <span class="text-xl font-bold text-white">TERANG <span class="text-blue-400">By SRT</span></span>
                    </div>
                </a>
                <p class="mt-4 text-gray-400 text-sm leading-relaxed">
                    Memberikan solusi inovatif untuk pertumbuhan bisnis Anda.
                </p>
                <div class="mt-6 flex space-x-3">
                    <a href="#" class="w-10 h-10 bg-gray-800/50 backdrop-blur-sm rounded-xl flex items-center justify-center text-gray-400 hover:bg-blue-600 hover:text-white transition-all duration-300 hover:scale-110"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" class="w-10 h-10 bg-gray-800/50 backdrop-blur-sm rounded-xl flex items-center justify-center text-gray-400 hover:bg-blue-400 hover:text-white transition-all duration-300 hover:scale-110"><i class="fab fa-twitter"></i></a>
                    <a href="#" class="w-10 h-10 bg-gray-800/50 backdrop-blur-sm rounded-xl flex items-center justify-center text-gray-400 hover:bg-blue-700 hover:text-white transition-all duration-300 hover:scale-110"><i class="fab fa-linkedin-in"></i></a>
                    <a href="#" class="w-10 h-10 bg-gray-800/50 backdrop-blur-sm rounded-xl flex items-center justify-center text-gray-400 hover:bg-pink-500 hover:text-white transition-all duration-300 hover:scale-110"><i class="fab fa-instagram"></i></a>
                </div>
            </div>
            <!-- Kolom 2: Perusahaan -->
            <div>
                <h3 class="text-lg font-semibold text-white mb-1">Perusahaan</h3>
                <div class="w-12 h-1 bg-gradient-to-r from-blue-600 to-blue-400 rounded-full mb-4"></div>
                <ul class="space-y-3">
                    <li><a href="{{ route('home') }}#about-us" class="text-gray-400 hover:text-blue-400 transition-colors text-sm flex items-center group"><i class="fas fa-chevron-right text-xs mr-2 text-blue-500 transform group-hover:translate-x-1 transition-transform"></i>Tentang Kami</a></li>
                    <li><a href="{{ route('home') }}#business-scope" class="text-gray-400 hover:text-blue-400 transition-colors text-sm flex items-center group"><i class="fas fa-chevron-right text-xs mr-2 text-blue-500 transform group-hover:translate-x-1 transition-transform"></i>Lingkup Bisnis</a></li>
                    <li><a href="#" class="text-gray-400 hover:text-blue-400 transition-colors text-sm flex items-center group"><i class="fas fa-chevron-right text-xs mr-2 text-blue-500 transform group-hover:translate-x-1 transition-transform"></i>Tim Kami</a></li>
                </ul>
            </div>
            <!-- Kolom 3: Karir -->
            <div>
                <h3 class="text-lg font-semibold text-white mb-1">Karir</h3>
                <div class="w-12 h-1 bg-gradient-to-r from-blue-600 to-blue-400 rounded-full mb-4"></div>
                <ul class="space-y-3">
                    <li><a href="{{ route('karir') }}" class="text-gray-400 hover:text-blue-400 transition-colors text-sm flex items-center group"><i class="fas fa-chevron-right text-xs mr-2 text-blue-500 transform group-hover:translate-x-1 transition-transform"></i>Lowongan Kerja</a></li>
                    <li><a href="#" class="text-gray-400 hover:text-blue-400 transition-colors text-sm flex items-center group"><i class="fas fa-chevron-right text-xs mr-2 text-blue-500 transform group-hover:translate-x-1 transition-transform"></i>Budaya Perusahaan</a></li>
                </ul>
            </div>
            <!-- Kolom 4: Kontak -->
            <div>
                <h3 class="text-lg font-semibold text-white mb-1">Kontak</h3>
                <div class="w-12 h-1 bg-gradient-to-r from-blue-600 to-blue-400 rounded-full mb-4"></div>
                <ul class="space-y-4">
                    <li class="flex items-start">
                        <i class="fas fa-map-marker-alt text-blue-500 mt-1 mr-3"></i>
                        <span class="text-gray-400 text-sm">Jl. Sudirman No. 123, Jakarta Selatan, 12190</span>
                    </li>
                    <li class="flex items-start">
                            <i class="fas fa-envelope text-blue-500 mt-1 mr-3"></i>
                            <span class="text-gray-400 text-sm">rekrutmensrt@gmail.com</span>
                        </li>
                </ul>
            </div>
        </div>
        <div class="mt-12 border-t border-gray-700/50 pt-8 flex flex-col sm:flex-row justify-between items-center text-sm text-gray-500">
            <p>&copy; {{ date('Y') }} TERANG By SRT. All rights reserved.</p>
            <div class="mt-4 sm:mt-0 space-x-6">
                <a href="#" class="hover:text-blue-400 transition-colors">Kebijakan Privasi</a>
                <a href="#" class="hover:text-blue-400 transition-colors">Syarat & Ketentuan</a>
            </div>
        </div>
    </div>
</footer>
