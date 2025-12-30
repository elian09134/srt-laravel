@extends('layouts.app')

@section('content')
<section class="py-16 bg-gray-50 min-h-screen">
    <div class="container mx-auto px-6 lg:px-24">
        <div class="max-w-4xl mx-auto bg-white rounded-xl shadow-md p-10">
            <h1 class="text-3xl font-bold text-gray-900 mb-4">Syarat & Ketentuan</h1>
            <p class="text-gray-600 mb-6">Diperbarui: {{ date('F j, Y') }}</p>

            <h2 class="text-xl font-semibold text-gray-800 mt-6 mb-2">1. Penerimaan Syarat</h2>
            <p class="text-gray-600">Dengan mengakses dan menggunakan situs TERANG By SRT, Anda menyetujui syarat dan ketentuan ini serta kebijakan privasi kami. Jika Anda tidak setuju, mohon untuk tidak menggunakan layanan ini.</p>

            <h2 class="text-xl font-semibold text-gray-800 mt-6 mb-2">2. Penggunaan Layanan</h2>
            <p class="text-gray-600">Anda setuju menggunakan situs ini hanya untuk tujuan yang sah dan sesuai peraturan yang berlaku. Dilarang mengunggah konten yang melanggar hak pihak lain, ilegal, atau berbahaya.</p>

            <h2 class="text-xl font-semibold text-gray-800 mt-6 mb-2">3. Aplikasi dan Rekrutmen</h2>
            <p class="text-gray-600">Informasi dan dokumen yang Anda kirimkan saat melamar pekerjaan adalah benar dan lengkap. Kami berhak menolak atau menghapus aplikasi yang tidak sesuai atau ditemukan mengandung informasi palsu.</p>

            <h2 class="text-xl font-semibold text-gray-800 mt-6 mb-2">4. Hak Kekayaan Intelektual</h2>
            <p class="text-gray-600">Semua konten di situs ini, termasuk teks, logo, dan materi visual, adalah milik TERANG By SRT atau pemegang lisensinya. Dilarang menyalin atau menggunakan materi tersebut tanpa izin tertulis.</p>

            <h2 class="text-xl font-semibold text-gray-800 mt-6 mb-2">5. Pembatasan Tanggung Jawab</h2>
            <p class="text-gray-600">Situs ini disediakan "sebagaimana adanya". TERANG By SRT tidak bertanggung jawab atas kerugian langsung atau tidak langsung akibat penggunaan situs, termasuk kehilangan data atau keuntungan.</p>

            <h2 class="text-xl font-semibold text-gray-800 mt-6 mb-2">6. Perubahan pada Syarat</h2>
            <p class="text-gray-600">Kami dapat memperbarui syarat ini kapan saja. Perubahan akan diunggah di halaman ini dengan tanggal revisi diperbarui. Penggunaan berkelanjutan setelah perubahan berarti Anda menerima syarat yang diperbarui.</p>

            <h2 class="text-xl font-semibold text-gray-800 mt-6 mb-2">7. Hukum yang Berlaku</h2>
            <p class="text-gray-600">Syarat ini diatur oleh hukum Republik Indonesia. Sengketa yang timbul akan diselesaikan sesuai peraturan perundang-undangan yang berlaku.</p>

            <h2 class="text-xl font-semibold text-gray-800 mt-6 mb-2">8. Kontak</h2>
            <p class="text-gray-600">Untuk pertanyaan mengenai syarat & ketentuan ini, silakan hubungi: <a href="mailto:rekrutmensrt@gmail.com" class="text-blue-600 hover:underline">rekrutmensrt@gmail.com</a>.</p>

            <div class="mt-8 text-right">
                <a href="{{ route('home') }}" class="inline-block px-6 py-2 bg-gray-100 text-gray-800 rounded-lg hover:bg-gray-200">Kembali ke Beranda</a>
            </div>
        </div>
    </div>
</section>
@endsection
