# PWA Testing Guide

## Cara Test PWA Install Button

### 1. Requirement Browser
PWA hanya berfungsi pada:
- ✅ Chrome/Edge (Desktop & Mobile)
- ✅ Firefox (dengan dukungan terbatas)
- ✅ Safari (iOS 11.3+)
- ❌ Tidak berfungsi pada localhost HTTP (harus HTTPS atau localhost tertentu)

### 2. Cara Melihat Install Button

#### Di Localhost (Development)
```bash
# Jalankan server Laravel
php artisan serve

# Buka di browser: http://localhost:8000 atau http://127.0.0.1:8000
# Install button MUNGKIN tidak muncul karena service worker perlu HTTPS
```

#### Di Production (HTTPS)
1. Deploy ke server dengan HTTPS
2. Buka website di browser
3. Tunggu beberapa detik
4. Install button akan muncul otomatis jika:
   - ✅ Manifest valid
   - ✅ Service Worker terdaftar
   - ✅ Icon tersedia
   - ✅ HTTPS aktif
   - ✅ PWA belum terinstall sebelumnya

### 3. Testing via Chrome DevTools

1. Buka Chrome DevTools (F12)
2. Tab "Application"
3. Cek bagian:
   - **Manifest**: Harus terdeteksi dan valid
   - **Service Workers**: Harus status "activated and running"
   - **Storage > Cache Storage**: Harus ada cache setelah load pertama

### 4. Manual Trigger Install (Jika Button Tidak Muncul)

Di Chrome, klik icon install di address bar (kanan atas):
- Desktop: Icon ⊕ atau icon install di omnibar
- Mobile: Banner "Add to Home Screen" di bottom

### 5. Test Offline Mode

1. Install PWA terlebih dahulu
2. Buka DevTools > Network tab
3. Set "Offline" mode
4. Refresh halaman
5. Harus tampil `offline.html` dengan tombol retry

### 6. Force Update Service Worker

```javascript
// Buka Console dan jalankan:
navigator.serviceWorker.getRegistrations().then(function(registrations) {
    for(let registration of registrations) {
        registration.update();
    }
});
```

### 7. Clear Cache (Untuk Testing Ulang)

```javascript
// Di Console:
caches.keys().then(function(names) {
    for (let name of names) caches.delete(name);
});

// Unregister service worker:
navigator.serviceWorker.getRegistrations().then(function(registrations) {
    for(let registration of registrations) {
        registration.unregister();
    }
});
```

## Troubleshooting

### Install Button Tidak Muncul?

**Penyebab Umum:**
1. ❌ **Bukan HTTPS** - PWA memerlukan HTTPS (atau localhost)
2. ❌ **PWA sudah terinstall** - Cek di chrome://apps atau app drawer
3. ❌ **Icon tidak valid** - Pastikan `/images/terang.png` accessible
4. ❌ **Manifest error** - Cek di DevTools > Application > Manifest
5. ❌ **Service Worker gagal** - Cek di DevTools > Application > Service Workers
6. ❌ **Browser tidak support** - Gunakan Chrome/Edge terbaru

**Solusi:**
```bash
# 1. Cek manifest accessible
curl https://your-domain.com/manifest.json

# 2. Cek icon accessible
curl https://your-domain.com/images/terang.png

# 3. Cek service worker accessible
curl https://your-domain.com/sw.js

# 4. Hard refresh (Ctrl+Shift+R) untuk clear cache
# 5. Test di Incognito mode untuk menghindari cache issue
```

### Service Worker Tidak Terdaftar?

1. Cek Console untuk error
2. Pastikan `/sw.js` accessible (200 OK)
3. Hard refresh (Ctrl+Shift+R)
4. Unregister lalu register ulang:
```javascript
navigator.serviceWorker.getRegistrations().then(registrations => {
    registrations.forEach(reg => reg.unregister());
    location.reload();
});
```

### Cache Tidak Bekerja?

1. Cek di DevTools > Application > Cache Storage
2. Harus ada cache dengan nama `terang-srt-v1`
3. Cek isi cache, harus berisi file static (CSS, JS, images)

## Test Checklist

- [ ] Manifest terdeteksi di DevTools
- [ ] Service Worker status "activated"
- [ ] Install button muncul (desktop & mobile)
- [ ] Install button bisa diklik dan trigger prompt
- [ ] Setelah install, app muncul di app list
- [ ] App bisa dibuka dari home screen/app drawer
- [ ] Offline mode berfungsi (tampil offline.html)
- [ ] Online detection berfungsi (reload otomatis saat online)
- [ ] Cache terisi setelah load pertama
- [ ] Navigasi berfungsi normal dalam PWA

## Production Deployment

Sebelum deploy, pastikan:

1. ✅ Server menggunakan HTTPS
2. ✅ File `/images/terang.png` exists dan accessible
3. ✅ File `/manifest.json` accessible
4. ✅ File `/sw.js` accessible
5. ✅ File `/offline.html` accessible
6. ✅ Meta tags PWA ada di semua layout
7. ✅ Service worker registration script ada di layout

## Monitoring PWA Usage

Track install event di Google Analytics:

```javascript
window.addEventListener('appinstalled', () => {
    // Send to analytics
    gtag('event', 'pwa_installed', {
        'event_category': 'PWA',
        'event_label': 'App Installed'
    });
});
```

## Resources

- [PWA Checklist](https://web.dev/pwa-checklist/)
- [Lighthouse PWA Audit](https://developers.google.com/web/tools/lighthouse)
- [Can I Use - Service Workers](https://caniuse.com/serviceworkers)
- [Web.dev PWA Training](https://web.dev/progressive-web-apps/)

## Quick Commands

```bash
# Test manifest validity
npx pwa-asset-generator ./public/images/terang.png ./public/images/icons --manifest ./public/manifest.json

# Run Lighthouse PWA audit
npx lighthouse https://your-domain.com --view

# Check service worker status via curl
curl -I https://your-domain.com/sw.js
```
