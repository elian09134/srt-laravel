<div style="font-family: Inter, system-ui, -apple-system, 'Segoe UI', Roboto, 'Helvetica Neue', Arial; color:#111827;">
    <h2>Halo {{ $name }},</h2>
    <p>Administrator telah menyetujui permintaan reset password Anda. Berikut password sementara Anda:</p>
    <div style="padding:12px;background:#f3f4f6;border-radius:8px;display:inline-block;font-weight:600;margin:10px 0;">{{ $temporaryPassword }}</div>
    <p>Silakan login menggunakan password tersebut, lalu segera ganti password Anda melalui halaman profil.</p>
    <p>Jika Anda tidak mengajukan permintaan ini, abaikan email ini dan hubungi administrator.</p>
    <p>Salam,<br>Tim TERANG By SRT</p>
</div>
<html>
<body>
    <p>Halo {{ $user->name ?? $user->email }},</p>

    <p>Administrator telah menyetujui permintaan reset password Anda. Berikut password sementara Anda:</p>

    <p style="font-family: monospace; font-size: 18px; background:#f4f4f4; padding:10px; display:inline-block;">{{ $temporaryPassword }}</p>

    <p>Silakan login menggunakan password tersebut lalu segera ganti password Anda melalui halaman profil.</p>

    <p>Jika Anda tidak mengajukan permintaan ini, abaikan email ini atau hubungi administrator.</p>

    <p>Salam,<br>TERANG By SRT</p>
</body>
</html>
