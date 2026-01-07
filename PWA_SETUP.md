# PWA (Progressive Web App) Setup - TERANG By SRT

## ✅ Fitur PWA yang Sudah Diimplementasi

### 1. Manifest File
- **Lokasi**: `public/manifest.json`
- **Fitur**:
  - App name & short name
  - Icons berbagai ukuran (72px - 512px)
  - Theme color (#2563eb - biru)
  - Display mode: standalone
  - Shortcuts ke halaman penting
  - Categories & screenshots

### 2. Service Worker
- **Lokasi**: `public/sw.js`
- **Kemampuan**:
  - Offline caching strategy
  - Cache-first untuk aset statis
  - Network-first untuk API
  - Background sync untuk form submissions
  - Push notifications support
  - Auto-update detection

### 3. Offline Page
- **Lokasi**: `public/offline.html`
- Halaman indah yang muncul saat tidak ada koneksi internet
- Button untuk retry koneksi

### 4. PWA Meta Tags
Sudah ditambahkan di semua layouts:
- `app.blade.php` (user layout)
- `guest.blade.php` (auth layout)
- `admin.blade.php` (admin panel)

Meta tags yang ditambahkan:
- Theme color untuk status bar
- Mobile web app capable
- Apple touch icons
- App title untuk home screen
- Description untuk SEO

### 5. Service Worker Registration
Auto-register di semua halaman dengan fitur:
- Update detection & prompt
- Install prompt handler
- Online/offline event listeners
- App installed event tracking

## 📱 Cara Install PWA

### Android (Chrome/Edge):
1. Buka website di Chrome/Edge
2. Klik menu (3 titik)
3. Pilih "Install app" atau "Add to Home screen"
4. Ikuti prompt instalasi

### iOS (Safari):
1. Buka website di Safari
2. Tap tombol Share (kotak dengan panah)
3. Scroll dan tap "Add to Home Screen"
4. Beri nama dan tap "Add"

### Desktop (Chrome/Edge):
1. Klik icon install di address bar (⊕)
2. Atau: Settings → Install TERANG By SRT
3. App akan muncul seperti aplikasi native

## 🔧 Yang Perlu Dilengkapi

### 1. Generate PWA Icons
Saat ini icons masih placeholder. Perlu generate dari logo:

**Ukuran yang dibutuhkan:**
- 72x72px
- 96x96px
- 128x128px
- 144x144px
- 152x152px
- 192x192px
- 384x384px
- 512x512px

**Tools untuk generate:**
- https://www.pwabuilder.com/imageGenerator
- https://realfavicongenerator.net/
- Atau manual resize dengan Photoshop/Figma

**Simpan di**: `public/images/icon-{size}.png`

### 2. Screenshot untuk App Store
Untuk fitur app screenshot di PWA stores:
- Ukuran: 540x720px (portrait)
- Format: PNG
- Simpan di: `public/images/screenshot1.png`

### 3. Push Notifications (Optional)
Untuk enable push notifications:

```php
// Install package
composer require laravel-notification-channels/webpush

// Generate VAPID keys
php artisan webpush:vapid

// Update .env
VAPID_PUBLIC_KEY=...
VAPID_PRIVATE_KEY=...
```

## 🎨 Customization

### Update Theme Color
Edit di `public/manifest.json`:
```json
"theme_color": "#2563eb",  // Ganti dengan warna brand
"background_color": "#ffffff"
```

### Update App Name
Edit di `public/manifest.json`:
```json
"name": "TERANG By SRT - Sistem Rekrutmen",
"short_name": "TERANG SRT"
```

### Update Shortcuts
Edit shortcuts di `public/manifest.json` untuk quick access:
```json
"shortcuts": [
  {
    "name": "Cari Lowongan",
    "url": "/karir"
  }
]
```

## 🧪 Testing PWA

### Chrome DevTools:
1. F12 → Application tab
2. Check:
   - Manifest section
   - Service Workers
   - Cache Storage
   - Offline checkbox untuk test offline mode

### Lighthouse Audit:
1. F12 → Lighthouse tab
2. Select "Progressive Web App"
3. Generate report
4. Fix issues yang muncul

### Online Tools:
- https://www.pwascanner.com/
- https://www.pwabuilder.com/
- Chrome DevTools Lighthouse

## 📊 PWA Best Practices

✅ Sudah diimplementasi:
- Service worker registration
- Offline fallback page
- Theme color
- Viewport meta tag
- HTTPS ready (di production)
- Responsive design
- Fast load time

⚠️ Perlu perhatian:
- Generate proper icons (gunakan logo asli)
- Add screenshot untuk app listing
- Test di berbagai devices
- Optimize cache strategy per route
- Add analytics untuk track PWA installs

## 🚀 Deployment Checklist

Sebelum deploy ke production:

1. ✅ Generate semua icon sizes dari logo
2. ✅ Update theme_color sesuai brand
3. ✅ Test di Chrome, Safari, Edge
4. ✅ Run Lighthouse audit
5. ✅ Ensure HTTPS enabled
6. ✅ Test offline functionality
7. ✅ Test install prompt
8. ✅ Clear old service workers di production

## 📝 Notes

- Service worker akan auto-update setiap kali ada perubahan
- Cached files akan di-refresh setiap install baru
- Offline page akan muncul saat tidak ada koneksi
- Push notifications optional, bisa ditambah nanti
- PWA dapat di-uninstall dari home screen seperti app biasa

## 🔗 Resources

- [PWA Documentation](https://web.dev/progressive-web-apps/)
- [Workbox (Advanced SW)](https://developers.google.com/web/tools/workbox)
- [PWA Builder](https://www.pwabuilder.com/)
- [Manifest Generator](https://tomitm.github.io/appmanifest/)
