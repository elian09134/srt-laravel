# Panduan Lengkap Sistem Rekrutmen & FPTK

Dokumen ini adalah panduan teknis dan operasional untuk penggunaan sistem Rekrutmen & FPTK (Form Permintaan Tenaga Kerja).

**Akses Sistem:**
*   **Web Public**: Halaman utama untuk pelamar.
*   **URL Admin**: `/admin` (Hanya untuk Role HR/Admin)
*   **URL Operasional**: `/fptk` (Hanya untuk Role Operasional)

---

## DAFTAR ISI
1.  [Modul 1: Pelamar (Applicant)](#1-modul-pelamar-applicant)
2.  [Modul 2: Operasional (User Requester)](#2-modul-operasional-user-requester)
3.  [Modul 3: HR & Administrator](#3-modul-hr--administrator)
4.  [Daftar Status & Alur Kerja](#4-daftar-status--alur-kerja)
5.  [Troubleshooting](#5-troubleshooting)

---

## 1. Modul Pelamar (Applicant)
Ditujukan untuk kandidat eksternal yang mencari pekerjaan.

### 1.1 Registrasi & Akun
1.  **Membuat Akun**:
    *   Klik **Register**. Masukkan Nama Lengkap, Email aktif, dan Password.
    *   **Lupa Password**: Klik "Forgot your password?" di halaman login. Masukkan email, sistem akan mengirimkan link reset password (jika konfigurasi email aktif) atau hubungi admin untuk reset manual.
    *   **Hapus Akun**: Pelamar dapat menghapus akun permanen melalui menu Profile -> Delete Account (membutuhkan konfirmasi password).

### 1.2 Manajemen Profil
Menu **Profile** adalah pusat data diri pelamar. Data ini akan otomatis terlampir saat melamar kerja.
*   **Informasi Dasar**:
    *   Nickname, No. Telepon (Wajib).
    *   Tanggal Lahir, Tentang Saya (Bio singkat).
*   **Pendidikan & Keahlian**:
    *   Pendidikan Terakhir (SMA/D3/S1/dll), Nama Institusi, Jurusan.
    *   **Skills**: Daftar keahlian (pisahkan dengan koma).
    *   **Bahasa**: Kemampuan bahasa asing.
*   **Pengalaman Kerja**:
    *   Pelamar bisa menambahkan banyak riwayat pekerjaan.
    *   Field: Nama Perusahaan, Posisi, Tanggal Mulai/Selesai, Durasi (bulan), Deskripsi Pekerjaan.
*   **Unggahan**:
    *   **Foto Profil**: Format JPG/PNG, maks 2MB.

### 1.3 Melamar Pekerjaan
1.  Buka menu **Karir**.
2.  Pilih lowongan untuk melihat detail (Kualifikasi, Deskripsi, Lokasi).
3.  Klik **Apply / Lamar**.
4.  Data profil saat ini akan dikunci sebagai snapshot untuk lamaran tersebut.

### 1.4 Memantau Status
Di menu **Riwayat Lamaran** (`/applications`), pelamar bisa melihat:
*   Posisi yang dilamar & Tanggal melamar.
*   **Status Terkini** (Lihat Bab 4 untuk arti status).
*   Sejarah perubahan status (misal: dari "Baru" berubah ke "Psikotest" pada tanggal sekian).

---

## 2. Modul Operasional (User Requester)
Role khusus untuk Kepala Divisi/Cabang yang membutuhkan penambahan pegawai.

### 2.1 Dashboard Operasional
User Operasional tidak memiliki akses ke halaman `/admin`. Akses utama mereka adalah halaman **FPTK** di menu navigasi atas.

### 2.2 Membuat FPTK Baru
Form Permintaan Tenaga Kerja (FPTK) digunakan untuk mengajukan rekrutmen baru ke HR.
1.  Masuk ke menu **FPTK** -> **Buat Baru**.
2.  **Data Posisi**:
    *   Posisi yang dibutuhkan, Divisi, dan Lokasi Penempatan.
    *   **Jumlah**: Pisahkan jumlah Pria dan Wanita yang diminta.
    *   **Tanggal Dibutuhkan**: Kapan karyawan harus mulai bekerja.
3.  **Kualifikasi & Detail**:
    *   Kisaran Gaji & Golongan (Level).
    *   Syarat Pendidikan, Usia, Pengalaman, Keterampilan.
    *   **Uraian Tugas (Jobdesk)**: Jelaskan tanggung jawab posisi ini.
    *   **Jenis Status**: Penambahan Baru / Penggantian / Sementara.
4.  **Otorisasi**:
    *   Masukkan Nama Pemohon (Signer Name).
    *   Upload/Input Tanda Tangan Digital.
5.  Klik **Kirim**. Status awal: `Pending`.

### 2.3 Monitoring Pengajuan
Di menu **My FPTK**, user bisa memantau:
*   **Status Approval**: Apakah disetujui HR atau Ditolak.
*   **Progres Rekrutmen**: Jika FPTK disetujui dan lowongan sudah tayang, user bisa melihat jumlah pelamar yang masuk untuk posisi tersebut secara *real-time*.

---

## 3. Modul HR & Administrator
Role dengan hak akses penuh untuk mengelola rekrutmen. Akses via `/admin`.

### 3.1 Overview Dashboard
Ringkasan real-time yang menampilkan:
*   **Total Applicants**: Jumlah seluruh lamaran masuk.
*   **Total Active Jobs**: Jumlah lowongan yang sedang tayang.
*   **Talent Pool**: Jumlah kandidat potensial yang disimpan.
*   **Statistik**: Grafik sebaran status pelamar (berapa yang Diterima, Ditolak, dll).
*   **Recent Activity**: Daftar lowongan aktif terbaru beserta jumlah pelamarnya.

### 3.2 Manajemen Lowongan (Jobs)
*   **Create Job**: Membuat lowongan baru. Bisa dikaitkan dengan ID FPTK yang sudah disetujui.
*   **Visibility**: Toggle "Active" untuk menayangkan/menyembunyikan lowongan di web publik tanpa menghapusnya.
*   **Edit/Delete**: Mengubah konten iklan lowongan.

### 3.3 Proses Seleksi Pelamar
Menu **Applicants** adalah workspace utama rekruter.
1.  **Screening**:
    *   Lihat daftar pelamar. Gunakan filter **Job** untuk memilah per posisi.
    *   Klik **Nama Pelamar** untuk melihat CV dan Profil lengkap.
    *   *Auto-update*: Status pelamar otomatis berubah dari `Baru` ke `Lamaran Dilihat` saat profil dibuka.
2.  **Update Status**:
    *   Ubah status manual sesuai tahap: `Psikotest`, `Wawancara HR`, `Wawancara User`, dll.
    *   Setiap perubahan status tercatat di **History** pelamar.
3.  **Hire / Reject**:
    *   Jika status diubah ke `Diterima`, sistem meminta input **Tanggal Bergabung (Join Date)**.
4.  **Talent Pool**:
    *   Tombol "Add to Talent Pool": Memasukkan kandidat ke database cadangan (Talent Pool) dan mengubah status lamaran saat ini menjadi `Shortlist`.

### 3.4 Approval FPTK
Menu **Permintaan Tenaga Kerja (FPTK)**:
*   Review pengajuan dari user Operasional.
*   **Approve**: Menyetujui permintaan. HR kemudian bisa membuat Job Posting baru.
*   **Reject**: Menolak permintaan (Wajib isi alasan penolakan pada `Admin Note`).
*   **Export PDF**: Mencetak form FPTK resmi (termasuk tanda tangan user dan admin) untuk arsip fisik.

### 3.5 Password Reset Requests
Jika sistem email tidak berjalan, pelamar mungkin meminta reset password manual.
*   Menu **Password Requests**.
*   Admin bisa **Approve** permintaan reset.
*   Sistem akan menghasilkan **Password Sementara** acak.
*   Admin bisa mengirim password tersebut ke user secara manual atau via sistem (jika email aktif).

### 3.6 Talent Pool
Menu **Talent Pool**:
Dashboard khusus untuk melihat daftar kandidat potensial yang pernah disimpan. Berguna untuk mencari kandidat tanpa membuka lowongan baru.

### 3.7 CMS (Konten Website)
*   **Site Content**: Mengubah teks statis di halaman Home/About.
*   **Media Gallery**: Mengupload foto kegiatan/budaya perusahaan untuk branding di halaman Karir.

---

## 4. Daftar Status & Alur Kerja

### Status Lamaran (Application Status)
Urutan logis (namun tidak mengikat):
1.  **Baru**: Default saat pelamar submit.
2.  **Lamaran Dilihat**: Otomatis saat HR membuka detail.
3.  **Psikotest**: Kandidat diundang tes psikologi.
4.  **Wawancara HR**: Lolos tes, lanjut interview HR.
5.  **Wawancara User**: Interview dengan user operasional.
6.  **Offering Letter**: Negosiasi gaji/penawaran resmi.
7.  **Shortlist**: Kandidat bagus tapi belum diproses/masuk Talent Pool.
8.  **Diterima**: Hired.
9.  **Tidak Lanjut**: Rejected/Gugur.

### Status FPTK
1.  **Pending**: Menunggu review HR.
2.  **Approved**: Disetujui, siap proses rekrutmen.
3.  **Rejected**: Ditolak (cek alasan di notes).

---

## 5. Troubleshooting (Masalah Umum)

*   **Email Tidak Masuk**:
    *   Cek folder Spam.
    *   Hubungi Admin untuk memastikan konfigurasi SMTP server berjalan.
    *   Gunakan fitur "Password Request" jika lupa password dan email tidak sampai.
*   **Gagal Upload Foto**:
    *   Pastikan format JPG/PNG dan ukuran file di bawah 2MB.
*   **Halaman Kosong/Error**:
    *   Refresh halaman.
    *   Pastikan koneksi internet stabil.
