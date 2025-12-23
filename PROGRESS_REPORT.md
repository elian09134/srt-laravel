Laporan Progres - 2025-12-18

Ringkasan:
- Antarmuka profil diterjemahkan ke Bahasa Indonesia dan diperbarui tampilannya.
- Memperbaiki rute penghapusan profil, unggah foto, dan error Blade `$slot`.
- Mengimplementasikan alur pengiriman lamaran (`POST /karir/{job}/apply`) dengan kolom `cover_letter` dan snapshot data pelamar.
- Menambahkan migrasi untuk `cover_letter` dan snapshot pelamar; data lama di-backfill menggunakan Tinker.
- Halaman detail pelamar untuk admin dibuat dengan tombol aksi dan tautan kontak WhatsApp.
- Riwayat lamaran untuk pengguna ditambahkan; tombol "Lihat Detail" sekarang mengarah ke halaman detail pengguna.
- Halaman detail lamaran pengguna dibuat di resources/views/applications/show.blade.php.
- Perubahan telah di-commit dan di-push ke `origin/main`.

Yang masih tertunda / Catatan:
- Fitur unggah & parse CV ditunda sesuai permintaan.
- Suite test lokal gagal hingga PHP mengaktifkan PDO SQLite (`extension=pdo_sqlite`, `extension=sqlite3`).
- Pertimbangkan pemeriksaan akses tambahan dan perbaikan tampilan mobile untuk halaman lamaran.

Langkah selanjutnya:
- Verifikasi pengecekan kepemilikan pada controller/route `applications.show` di staging.
- Lanjutkan implementasi unggah/parse CV jika diminta.
- Jalankan kembali test setelah mengaktifkan PDO SQLite di PHP lokal.
