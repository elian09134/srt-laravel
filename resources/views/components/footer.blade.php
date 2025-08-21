<footer class="bg-[#1A2238] text-white">
    <div class="container mx-auto px-6 py-16">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-12">
            <!-- Kolom 1: Logo & Social -->
            <div>
                <a href="{{ route('home') }}" class="text-2xl font-bold">
                    <span class="bg-white text-[#1A2238] px-2 py-1 rounded-md">SRT</span> Corp
                </a>
                <p class="mt-4 text-gray-400">
                    Memberikan solusi inovatif untuk pertumbuhan bisnis Anda.
                </p>
                <div class="mt-6 flex space-x-4">
                    <a href="#" class="w-10 h-10 bg-gray-700 rounded-full flex items-center justify-center text-gray-400 hover:bg-blue-600 hover:text-white transition-colors"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" class="w-10 h-10 bg-gray-700 rounded-full flex items-center justify-center text-gray-400 hover:bg-blue-400 hover:text-white transition-colors"><i class="fab fa-twitter"></i></a>
                    <a href="#" class="w-10 h-10 bg-gray-700 rounded-full flex items-center justify-center text-gray-400 hover:bg-blue-700 hover:text-white transition-colors"><i class="fab fa-linkedin-in"></i></a>
                    <a href="#" class="w-10 h-10 bg-gray-700 rounded-full flex items-center justify-center text-gray-400 hover:bg-pink-500 hover:text-white transition-colors"><i class="fab fa-instagram"></i></a>
                </div>
            </div>
            <!-- Kolom 2: Perusahaan -->
            <div>
                <h3 class="text-lg font-semibold">Perusahaan</h3>
                <ul class="mt-4 space-y-3">
                    <li><a href="{{ route('home') }}#about-us" class="text-gray-400 hover:text-white transition-colors">Tentang Kami</a></li>
                    <li><a href="{{ route('home') }}#business-scope" class="text-gray-400 hover:text-white transition-colors">Lingkup Bisnis</a></li>
                    <li><a href="#" class="text-gray-400 hover:text-white transition-colors">Tim Kami</a></li>
                </ul>
            </div>
            <!-- Kolom 3: Karir -->
            <div>
                <h3 class="text-lg font-semibold">Karir</h3>
                <ul class="mt-4 space-y-3">
                    <li><a href="{{ route('karir') }}" class="text-gray-400 hover:text-white transition-colors">Lowongan Kerja</a></li>
                    <li><a href="#" class="text-gray-400 hover:text-white transition-colors">Budaya Perusahaan</a></li>
                </ul>
            </div>
            <!-- Kolom 4: Kontak -->
            <div>
                <h3 class="text-lg font-semibold">Kontak</h3>
                <ul class="mt-4 space-y-4">
                    <li class="flex items-start">
                        <i class="fas fa-map-marker-alt text-orange-400 mt-1 mr-3"></i>
                        <span class="text-gray-400">Jl. Sudirman No. 123, Jakarta Selatan, 12190</span>
                    </li>
                    <li class="flex items-start">
                        <i class="fas fa-envelope text-orange-400 mt-1 mr-3"></i>
                        <span class="text-gray-400">info@srtcorp.com</span>
                    </li>
                </ul>
            </div>
        </div>
        <div class="mt-12 border-t border-gray-700 pt-8 flex flex-col sm:flex-row justify-between items-center text-sm text-gray-500">
            <p>&copy; {{ date('Y') }} SRT Corp. All rights reserved.</p>
            <div class="mt-4 sm:mt-0 space-x-6">
                <a href="#" class="hover:text-white transition-colors">Kebijakan Privasi</a>
                <a href="#" class="hover:text-white transition-colors">Syarat & Ketentuan</a>
            </div>
        </div>
    </div>
</footer>
