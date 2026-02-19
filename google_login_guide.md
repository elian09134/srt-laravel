# Panduan Implementasi Login Google (Laravel Socialite)

Dokumen ini menjelaskan langkah-langkah lengkap untuk mengaktifkan fitur **Login with Google** di aplikasi Terang By SRT menggunakan Laravel Socialite.

---

## 1. Persiapan Google Cloud Console

1.  Buka [Google Cloud Console](https://console.cloud.google.com/).
2.  **Buat Project Baru** (jika belum ada).
3.  Klik menu **APIs & Services > OAuth consent screen**:
    *   Pilih **User Type: External** > Klik **Create**.
    *   Isi App Name, User support email, dan Developer contact info (Isi seperlunya).
    *   Klik **Save and Continue** sampai selesai (Back to Dashboard).
4.  Klik menu **Credentials**:
    *   Klik **+ Create Credentials** > **OAuth client ID**.
    *   **Application type**: Web application.
    *   **Name**: Laravel Google Login (atau nama aplikasi Anda).
    *   **Authorized redirect URIs**:
        *   Lokal: `http://localhost:8000/auth/google/callback`
        *   Staging: `http://202.10.47.156/auth/google/callback`
        *   Production: `https://terangbysrt.com/auth/google/callback`
5.  Catat **Client ID** dan **Client Secret** yang muncul (Simpan di file `.env`, jangan di sini).

---

## 2. Instalasi & Konfigurasi Laravel

### Step 1: Install Package
```bash
composer require laravel/socialite
```

### Step 2: Konfigurasi `.env`
Tambahkan kredensial berikut ke file `.env` Anda:
```env
GOOGLE_CLIENT_ID=masukkan_client_id_anda
GOOGLE_CLIENT_SECRET=masukkan_client_secret_anda
GOOGLE_REDIRECT_URL=https://terangbysrt.com/auth/google/callback
```

### Step 3: Konfigurasi `config/services.php`
Daftarkan layanan Google di file `config/services.php`:
```php
'google' => [
    'client_id' => env('GOOGLE_CLIENT_ID'),
    'client_secret' => env('GOOGLE_CLIENT_SECRET'),
    'redirect' => env('GOOGLE_REDIRECT_URL'),
],
```

---

## 3. Persiapan Database

Kita perlu kolom untuk menyimpan ID unik dari Google. Buat migrasi baru:
```bash
php artisan make:migration add_google_id_to_users_table
```

Isi migrasinya:
```php
public function up()
{
    Schema::table('users', function (Blueprint $table) {
        $table->string('google_id')->nullable()->after('id');
        $table->string('avatar')->nullable()->after('password');
    });
}
```

---

## 4. Implementasi Kode

### Step 1: Buat Controller
```bash
php artisan make:controller Auth/GoogleController
```

### Step 2: Tambahkan Method Login
Buka `app/Http/Controllers/Auth/GoogleController.php` dan gunakan rujukan di `implementation_plan.md` untuk logic Socialite.

### Step 3: Tambahkan Route
```php
use App\Http\Controllers\Auth\GoogleController;

Route::get('auth/google', [GoogleController::class, 'redirectToGoogle'])->name('auth.google');
Route::get('auth/google/callback', [GoogleController::class, 'handleGoogleCallback']);
```

---

## 5. Menghubungkan Tombol UI

Buka file login Anda (`resources/views/auth/login.blade.php`) dan update link tombol Google-nya ke `route('auth.google')`.
