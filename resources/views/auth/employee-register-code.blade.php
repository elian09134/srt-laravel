<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi Undangan - TERANG By SRT</title>
    <!-- Tailwind CSS built with Vite; avoid CDN in production -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style> 
        body { font-family: 'Inter', sans-serif; }
        #qr-reader {
            width: 100%;
            border: 2px solid #e5e7eb;
            border-radius: 0.5rem;
            margin-top: 1rem;
        }
    </style>
</head>
<body class="bg-slate-50">
    <div class="flex min-h-screen items-center justify-center">
        <div class="w-full max-w-md p-8 space-y-6 bg-white rounded-lg shadow-md">
            <div class="text-center">
                <a href="{{ route('home') }}" class="inline-flex items-center justify-center">
                    <img src="{{ asset('images/terang.png') }}" alt="TERANG By SRT" class="h-12 w-auto">
                </a>
                <h1 class="mt-6 text-2xl font-bold text-gray-900">Pendaftaran Karyawan</h1>
                <p class="mt-2 text-gray-600">Silakan masukkan kode undangan yang Anda terima dari HR atau pindai QR code.</p>
            </div>

            <form id="code-form" method="POST" action="{{ route('employee.register.verify') }}">
                @csrf
                <div>
                    <label for="invitation_code" class="block text-sm font-medium text-gray-700">Kode Undangan</label>
                    <input id="invitation_code" type="text" name="invitation_code" required autofocus class="mt-1 block w-full px-4 py-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                    @error('invitation_code')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <!-- Tombol Aksi -->
                <div class="mt-6 space-y-4">
                    <button type="submit" class="w-full flex justify-center py-3 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700">
                        Lanjutkan
                    </button>
                    <button type="button" id="scan-qr-btn" class="w-full flex justify-center py-3 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                        Pindai QR Code
                    </button>
                </div>
            </form>
            
            <!-- Area untuk scanner QR -->
            <div id="qr-reader" class="hidden"></div>
            <div id="qr-reader-results"></div>
        </div>
    </div>

    <!-- Library untuk Scan QR Code -->
    <script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const scanBtn = document.getElementById('scan-qr-btn');
            const qrReaderElement = document.getElementById('qr-reader');
            const codeInput = document.getElementById('invitation_code');
            const codeForm = document.getElementById('code-form');

            function onScanSuccess(decodedText, decodedResult) {
                // `decodedText` berisi URL lengkap, kita hanya butuh kodenya
                try {
                    const url = new URL(decodedText);
                    const code = url.searchParams.get('code');
                    if (code) {
                        codeInput.value = code;
                        // Otomatis submit form setelah berhasil scan
                        codeForm.submit();
                    } else {
                        alert('QR Code tidak valid.');
                    }
                } catch (e) {
                    // Jika QR code tidak berisi URL, coba gunakan teksnya langsung
                    codeInput.value = decodedText;
                    codeForm.submit();
                }
            }

            function onScanFailure(error) {
                // Tidak perlu melakukan apa-apa, biarkan user mencoba lagi
            }

            const html5QrcodeScanner = new Html5Qrcode("qr-reader");

            scanBtn.addEventListener('click', () => {
                qrReaderElement.classList.toggle('hidden');
                if (!qrReaderElement.classList.contains('hidden')) {
                    html5QrcodeScanner.start(
                        { facingMode: "environment" }, // Gunakan kamera belakang
                        {
                            fps: 10,
                            qrbox: { width: 250, height: 250 }
                        },
                        onScanSuccess,
                        onScanFailure
                    );
                } else {
                    html5QrcodeScanner.stop().catch(err => console.log("Gagal menghentikan scanner."));
                }
            });
        });
    </script>
</body>
</html>
