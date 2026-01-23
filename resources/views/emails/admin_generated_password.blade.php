<html>
<body style="font-family: Inter, system-ui, -apple-system, 'Segoe UI', Roboto, 'Helvetica Neue', Arial; color:#111827;">
    <p>Halo {{ $user->name ?? $name ?? $user->email }},</p>

    <p>Administrator telah menyetujui permintaan reset password Anda. Berikut password sementara Anda untuk akun terang by srt:</p>

    <p style="font-family: monospace; font-size: 18px; background:#f4f4f4; padding:10px; display:inline-block;">{{ $temporaryPassword }}</p>

    <p>Silakan login menggunakan password tersebut lalu segera ganti password Anda melalui halaman profil.</p>

    <p>Jika Anda tidak mengajukan permintaan ini, abaikan email ini atau hubungi administrator.</p>

    <p>Salam,<br>TERANG By SRT</p>
</body>
</html>
