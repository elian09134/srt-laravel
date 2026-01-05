# SECURITY & DDOS PROTECTION

## 🔒 Proteksi DDoS yang Sudah Diterapkan

### 1. Rate Limiting per Endpoint

**Authentication Routes:**
- Register: 3 requests/menit
- Login: 5 requests/menit (+ internal rate limiter 5 attempts per email+IP)
- Forgot Password: 3 requests/10 menit
- Email Verification: 6 requests/menit

**Application Routes:**
- Job Application Submit: 10 requests/menit
- Job Search API: 60 requests/menit
- Employee Register: 3 requests/menit
- FPTK Submit: 5 requests/menit

**AI Agent:**
- AI Query: 10 requests/menit

### 2. IP-Based Protection (BlockSuspiciousIps Middleware)

**Automatic IP Blocking:**
- Tracks all incoming requests per IP
- Blocks IP if > 100 requests in 1 minute
- Block duration: 10 minutes
- All violations logged

**Manual IP Block (via Tinker):**
```php
// Block specific IP for 1 hour
Cache::put('blocked_ip:123.45.67.89', true, now()->addHour());

// Check if IP is blocked
Cache::has('blocked_ip:123.45.67.89');

// Unblock IP
Cache::forget('blocked_ip:123.45.67.89');
```

### 3. Laravel Built-in Security

- ✅ CSRF Protection (all POST routes)
- ✅ SQL Injection Protection (Eloquent ORM)
- ✅ XSS Protection (Blade escaping)
- ✅ Session Security (database driver)
- ✅ Password Hashing (bcrypt)

### 4. Database Query Optimization

- Pagination di semua list view
- Eager loading relationships
- Index pada kolom yang sering dicari

## 🚀 Rekomendasi Tambahan

### 1. Server Level (Cloudflare/Nginx)

**Cloudflare (RECOMMENDED):**
```
- Enable "Under Attack Mode" jika diserang
- DDoS Protection: ON
- Bot Fight Mode: ON
- Challenge Passage: 30 minutes
- Rate Limiting Rules via Cloudflare Dashboard
```

**Nginx Rate Limiting:**
```nginx
# /etc/nginx/nginx.conf
http {
    limit_req_zone $binary_remote_addr zone=global:10m rate=50r/s;
    limit_req zone=global burst=100 nodelay;
}
```

### 2. Monitoring & Alerting

**Laravel Logs:**
```bash
# Monitor blocked IPs
tail -f storage/logs/laravel.log | grep "Blocked IP"

# Monitor suspicious activity
tail -f storage/logs/laravel.log | grep "excessive requests"
```

**Setup Alert (via cron):**
```bash
# /home/hcmsrt/terangbysrt/monitor-ddos.sh
#!/bin/bash
ATTACKS=$(tail -100 /home/hcmsrt/terangbysrt/storage/logs/laravel.log | grep -c "Blocked IP")
if [ $ATTACKS -gt 10 ]; then
    echo "DDoS Attack Detected: $ATTACKS blocked IPs" | mail -s "ALERT: DDoS" admin@terangbysrt.com
fi
```

### 3. Cache Driver

**Production .env:**
```env
# Change from database to Redis for better performance
CACHE_DRIVER=redis
SESSION_DRIVER=redis
QUEUE_CONNECTION=redis

# Redis config
REDIS_HOST=127.0.0.1
REDIS_PASSWORD=null
REDIS_PORT=6379
```

### 4. Firewall Rules (Server)

**UFW (Ubuntu):**
```bash
# Allow specific IPs only for admin
sudo ufw allow from YOUR_OFFICE_IP to any port 22

# Rate limit HTTP
sudo ufw limit 80/tcp
sudo ufw limit 443/tcp
```

**Fail2Ban (Install):**
```bash
sudo apt install fail2ban
sudo systemctl enable fail2ban
sudo systemctl start fail2ban

# Create Laravel jail
sudo nano /etc/fail2ban/jail.local
```

```ini
[laravel-ddos]
enabled = true
filter = laravel-ddos
logpath = /home/hcmsrt/terangbysrt/storage/logs/laravel.log
maxretry = 5
bantime = 600
findtime = 60
```

## 📊 Performance Optimization

### 1. Enable OPcache
```ini
# php.ini
opcache.enable=1
opcache.memory_consumption=256
opcache.interned_strings_buffer=16
opcache.max_accelerated_files=10000
opcache.validate_timestamps=0
```

### 2. Laravel Optimization Commands
```bash
# Production deployment
/opt/cpanel/ea-php82/root/usr/bin/php artisan config:cache
/opt/cpanel/ea-php82/root/usr/bin/php artisan route:cache
/opt/cpanel/ea-php82/root/usr/bin/php artisan view:cache
/opt/cpanel/ea-php82/root/usr/bin/php artisan event:cache

# Optimize composer autoload
composer install --optimize-autoloader --no-dev
```

### 3. Database Optimization
```sql
-- Add indexes untuk performa
ALTER TABLE applications ADD INDEX idx_job_created (job_id, created_at);
ALTER TABLE applications ADD INDEX idx_user_status (user_id, status);
ALTER TABLE jobs ADD INDEX idx_active_created (is_active, created_at);
```

## 🔧 Emergency Response

### If Under Attack:

1. **Check blocked IPs:**
```php
// Tinker
DB::table('cache')->where('key', 'like', 'blocked_ip:%')->get();
```

2. **Block IP range:**
```php
// Block entire subnet
for($i=0; $i<256; $i++) {
    Cache::put("blocked_ip:123.45.67.{$i}", true, now()->addDay());
}
```

3. **Enable maintenance mode:**
```bash
php artisan down --secret="emergency-access-token"
# Access via: https://terangbysrt.com/emergency-access-token
```

4. **Clear all rate limiters:**
```php
Cache::flush(); // WARNING: Clears ALL cache
```

5. **Contact Cloudflare Support** (if using Cloudflare)

## ✅ Checklist Deploy

- [ ] Rate limiting enabled on all routes
- [ ] IP blocking middleware active
- [ ] Cloudflare proxy enabled (orange cloud)
- [ ] HTTPS enforced
- [ ] APP_DEBUG=false in production
- [ ] Log monitoring setup
- [ ] Backup strategy implemented
- [ ] Redis/Memcached configured
- [ ] Database indexes optimized
- [ ] Server firewall configured

## 📞 Emergency Contacts

- Server Admin: [Your Contact]
- Cloudflare Support: support.cloudflare.com
- Hosting Provider: [cPanel Support]

---
**Last Updated:** January 5, 2026
**Maintained by:** Development Team
