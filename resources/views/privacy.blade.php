@extends('layouts.app')

@section('content')
<section class="py-16 bg-gray-50 min-h-screen">
    <div class="container mx-auto px-6 lg:px-24">
        <div class="max-w-4xl mx-auto bg-white rounded-xl shadow-md p-10">
            <h1 class="text-3xl font-bold text-gray-900 mb-4">Kebijakan Privasi</h1>
            <p class="text-gray-600 mb-6">Diperbarui: {{ date('F j, Y') }}</p>

            <h2 class="text-xl font-semibold text-gray-800 mt-6 mb-2">1. Informasi yang Kami Kumpulkan</h2>
            <p class="text-gray-600">Kami mengumpulkan informasi yang Anda berikan langsung kepada kami, seperti nama, alamat email, riwayat pekerjaan, dan dokumen yang diunggah (mis. CV). Kami juga mengumpulkan informasi teknis secara otomatis, seperti alamat IP dan data penggunaan situs.</p>

            <h2 class="text-xl font-semibold text-gray-800 mt-6 mb-2">2. Bagaimana Kami Menggunakan Informasi</h2>
            <p class="text-gray-600">Informasi digunakan untuk memproses aplikasi pekerjaan, menghubungi pelamar, meningkatkan layanan, serta keperluan administratif dan kepatuhan hukum.</p>

            <h2 class="text-xl font-semibold text-gray-800 mt-6 mb-2">3. Pengungkapan kepada Pihak Ketiga</h2>
            <p class="text-gray-600">Kami tidak menjual data pribadi. Data dapat dibagikan kepada pihak terkait jika diperlukan untuk proses rekrutmen, penyedia layanan pihak ketiga yang membantu operasional situs, atau bila diwajibkan oleh hukum.</p>

            <h2 class="text-xl font-semibold text-gray-800 mt-6 mb-2">4. Keamanan Data</h2>
            <p class="text-gray-600">Kami menerapkan langkah-langkah teknis dan organisasi untuk melindungi data pribadi dari akses tidak sah atau pengungkapan. Namun tidak ada metode transmisi atau penyimpanan yang 100% aman.</p>

            <h2 class="text-xl font-semibold text-gray-800 mt-6 mb-2">5. Hak Anda</h2>
            <p class="text-gray-600">Anda berhak meminta akses, koreksi, atau penghapusan data pribadi Anda. Untuk permintaan terkait data, hubungi kami melalui alamat email di bawah.</p>

            <h2 class="text-xl font-semibold text-gray-800 mt-6 mb-2">6. Perubahan pada Kebijakan Ini</h2>
            <p class="text-gray-600">Kami dapat memperbarui kebijakan ini dari waktu ke waktu. Perubahan akan diberitahukan di situs ini dengan tanggal revisi yang diperbarui di bagian atas.</p>

            <h2 class="text-xl font-semibold text-gray-800 mt-6 mb-2">7. Kontak</h2>
            <p class="text-gray-600">Untuk pertanyaan mengenai kebijakan privasi ini atau permintaan data, silakan hubungi: <a href="mailto:rekrutmensrt@gmail.com" class="text-blue-600 hover:underline">rekrutmensrt@gmail.com</a>.</p>

            <div class="mt-8 text-right">
                <a href="{{ route('home') }}" class="inline-block px-6 py-2 bg-gray-100 text-gray-800 rounded-lg hover:bg-gray-200">Kembali ke Beranda</a>
            </div>
        </div>
    </div>
</section>
@endsection
