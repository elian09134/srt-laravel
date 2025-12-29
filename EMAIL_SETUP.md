# Setup Email untuk Forgot Password

## Konfigurasi Gmail SMTP

### 1. Setup App Password di Google Account
1. Buka https://myaccount.google.com/security
2. Aktifkan **2-Step Verification** jika belum
3. Cari **App passwords** atau buka https://myaccount.google.com/apppasswords
4. Pilih **Mail** sebagai app, pilih **Other** sebagai device
5. Masukkan nama: "Laravel TERANG By SRT"
6. Google akan generate 16-digit app password
7. Copy password tersebut (format: xxxx xxxx xxxx xxxx)

### 2. Update .env di Server
```bash
ssh root@202.10.47.161
cd /home/hcmsrt/terangbysrt
nano .env
```

Update bagian mail:
```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your-email@gmail.com
MAIL_PASSWORD=xxxx-xxxx-xxxx-xxxx  # App password dari step 1
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=noreply@terangbysrt.com
MAIL_FROM_NAME="${APP_NAME}"
```

### 3. Clear Cache
```bash
/opt/cpanel/ea-php82/root/usr/bin/php artisan config:clear
/opt/cpanel/ea-php82/root/usr/bin/php artisan cache:clear
```

## Test Forgot Password

1. Buka https://terangbysrt.com/login
2. Klik "Lupa Password?"
3. Masukkan email terdaftar
4. Cek inbox email untuk link reset password
5. Klik link dan masukkan password baru

## Troubleshooting

### Email tidak terkirim
- Pastikan App Password sudah benar (tanpa spasi)
- Cek `storage/logs/laravel.log` untuk error
- Pastikan firewall tidak block port 587
- Cek quota email harian Google (500 email/hari untuk Gmail)

### Link expired
- Default expire: 60 menit
- Ubah di `config/auth.php`:
```php
'passwords' => [
    'users' => [
        'expire' => 60, // dalam menit
    ],
],
```

## Alternatif Email Provider

### Mailgun (Recommended untuk produksi)
```env
MAIL_MAILER=mailgun
MAILGUN_DOMAIN=your-domain.com
MAILGUN_SECRET=your-mailgun-api-key
```

### SendGrid
```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.sendgrid.net
MAIL_PORT=587
MAIL_USERNAME=apikey
MAIL_PASSWORD=your-sendgrid-api-key
MAIL_ENCRYPTION=tls
```

### AWS SES
```env
MAIL_MAILER=ses
AWS_ACCESS_KEY_ID=your-access-key
AWS_SECRET_ACCESS_KEY=your-secret-key
AWS_DEFAULT_REGION=us-east-1
```
