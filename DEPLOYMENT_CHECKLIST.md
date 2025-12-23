CHECKLIST PERSIAPAN DEPLOY PRODUCTION
======================================

PERSIAPAN SERVER
----------------
[ ] Server sudah disetup (VPS/Cloud)
[ ] PHP 8.1 atau lebih tinggi terinstall
[ ] Composer terinstall
[ ] MySQL/PostgreSQL terinstall
[ ] Nginx/Apache terinstall
[ ] Node.js dan NPM terinstall (untuk build assets)
[ ] Git terinstall
[ ] SSL certificate siap (Let's Encrypt atau lainnya)

KONFIGURASI ENVIRONMENT
------------------------
[ ] File .env production sudah dibuat
[ ] APP_ENV diset ke 'production'
[ ] APP_DEBUG diset ke 'false'
[ ] APP_KEY sudah di-generate (php artisan key:generate)
[ ] APP_URL diset ke domain production
[ ] Database credentials sudah benar
[ ] MAIL settings sudah dikonfigurasi
[ ] SESSION_DRIVER sudah diset (database recommended)
[ ] QUEUE_CONNECTION sudah dikonfigurasi
[ ] FILESYSTEM_DISK sudah dikonfigurasi

KEAMANAN
--------
[ ] .env file tidak ter-commit ke git
[ ] Password database menggunakan password kuat
[ ] HTTPS/SSL sudah aktif
[ ] SESSION_SECURE_COOKIE diset ke 'true'
[ ] Rate limiting sudah dikonfigurasi untuk:
    [ ] Login endpoint
    [ ] Registration endpoint
    [ ] Job application endpoint
[ ] Security headers middleware sudah ditambahkan
[ ] CSRF protection aktif (default Laravel)
[ ] XSS protection aktif (Blade escaping)
[ ] SQL injection protection aktif (Eloquent/Query Builder)
[ ] File upload validation sudah ketat
[ ] Admin routes dilindungi middleware auth + admin

DATABASE
--------
[ ] Database production sudah dibuat
[ ] Migration sudah dijalankan
[ ] Seeder data awal sudah dijalankan (jika perlu)
[ ] Backup database otomatis sudah dijadwalkan
[ ] Database credentials aman dan encrypted

DEPENDENCIES & BUILD
--------------------
[ ] composer install --optimize-autoloader --no-dev
[ ] npm install (di server atau lokal)
[ ] npm run build (untuk production assets)
[ ] php artisan config:cache
[ ] php artisan route:cache
[ ] php artisan view:cache
[ ] php artisan optimize

FILE PERMISSIONS
----------------
[ ] storage/ folder writable (chmod 775 atau 755)
[ ] bootstrap/cache/ folder writable
[ ] .env file tidak readable public (chmod 600)
[ ] Folder uploads writable
[ ] Log files writable

STORAGE & UPLOADS
-----------------
[ ] Symbolic link dibuat (php artisan storage:link)
[ ] Folder storage/app/public exists
[ ] Folder uploads/hr exists (untuk foto tim HR)
[ ] Backup storage sudah disetup
[ ] File size limits dikonfigurasi di php.ini

TESTING SEBELUM DEPLOY
-----------------------
[ ] Semua fitur ditest di staging/local
[ ] Form submission berfungsi
[ ] File upload berfungsi
[ ] Email notification berfungsi
[ ] Authentication berfungsi
[ ] Admin panel accessible
[ ] Rate limiting tested
[ ] Responsive design di mobile/tablet/desktop
[ ] Browser compatibility (Chrome, Firefox, Safari, Edge)

DEPLOYMENT
----------
[ ] Code di-push ke repository (GitHub/GitLab)
[ ] Pull code di server production
[ ] Jalankan migrations di production
[ ] Build assets di production atau upload hasil build
[ ] Clear cache setelah deploy
[ ] Test homepage loading
[ ] Test admin login
[ ] Test job application flow
[ ] Test file uploads

POST-DEPLOYMENT
---------------
[ ] Monitor error logs (storage/logs/laravel.log)
[ ] Setup monitoring (Sentry, New Relic, atau sejenisnya)
[ ] Setup uptime monitoring
[ ] Setup automated backups (database + files)
[ ] Setup cron jobs jika ada queue workers
[ ] Setup SSL auto-renewal
[ ] Test email delivery
[ ] Test performance (page load speed)
[ ] Monitor disk space usage

DNS & DOMAIN
------------
[ ] Domain sudah pointing ke server IP
[ ] A record sudah dikonfigurasi
[ ] WWW redirect sudah dikonfigurasi (jika perlu)
[ ] DNS propagation sudah selesai
[ ] SSL certificate valid untuk domain

OPTIMIZATION
------------
[ ] OPcache enabled di PHP
[ ] Gzip compression enabled
[ ] Browser caching enabled
[ ] Image optimization (compress images)
[ ] Lazy loading images (jika perlu)
[ ] Database indexes sudah optimal
[ ] Query optimization (N+1 problem solved)

BACKUP & RECOVERY
-----------------
[ ] Daily database backup
[ ] Weekly full backup (code + database + uploads)
[ ] Backup retention policy sudah ditentukan
[ ] Restore procedure sudah ditest
[ ] Offsite backup (S3, Google Cloud, dll)

DOKUMENTASI
-----------
[ ] README updated dengan deployment instructions
[ ] API documentation (jika ada)
[ ] Admin guide untuk client
[ ] Troubleshooting guide
[ ] Credentials disimpan aman (password manager)

COMPLIANCE & LEGAL
------------------
[ ] Privacy policy sudah ada
[ ] Terms of service sudah ada
[ ] Cookie consent (jika diperlukan)
[ ] GDPR compliance (jika target EU)
[ ] Data protection measures

MONITORING & MAINTENANCE
------------------------
[ ] Setup log monitoring
[ ] Setup error tracking (Sentry recommended)
[ ] Setup performance monitoring
[ ] Setup uptime alerts
[ ] Setup disk space alerts
[ ] Setup SSL expiry alerts
[ ] Scheduled maintenance window ditentukan

ROLLBACK PLAN
-------------
[ ] Backup sebelum deploy
[ ] Rollback procedure documented
[ ] Previous version code tersimpan
[ ] Database rollback script (jika ada breaking migration)

FINAL CHECKS
------------
[ ] Semua checklist di atas sudah completed
[ ] Client/stakeholder approval
[ ] Launch date & time confirmed
[ ] Support team ready
[ ] Go live!

CATATAN TAMBAHAN
----------------
Untuk aplikasi TERANG:
- Pastikan folder uploads/hr untuk foto team HR sudah ada
- Test fitur Meet Our Team dengan upload foto
- Test semua form kontak dan aplikasi lowongan
- Verifikasi rate limiting di login dan registration
- Check responsive design terutama di mobile
- Test admin panel untuk manage content, jobs, applicants
- Verifikasi email notifications untuk job applications

Security Headers yang perlu ditambahkan (create middleware):
- Strict-Transport-Security: max-age=31536000; includeSubDomains
- X-Frame-Options: SAMEORIGIN
- X-Content-Type-Options: nosniff
- X-XSS-Protection: 1; mode=block
- Content-Security-Policy: (sesuai kebutuhan)

Recommended Server Specs Minimum:
- 2 CPU cores
- 2GB RAM
- 20GB SSD storage
- Ubuntu 20.04 LTS atau lebih baru

Maintenance Tasks (monthly):
- Review error logs
- Update dependencies (composer update, npm update)
- Check disk space
- Review security advisories
- Test backup restore procedure
- Review performance metrics
