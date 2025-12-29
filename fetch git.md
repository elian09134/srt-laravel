ssh root@202.10.47.161

cd /home/hcmsrt/terangbysrt

git fetch --all
git reset --hard origin/main

/opt/cpanel/ea-php82/root/usr/bin/php artisan config:clear
/opt/cpanel/ea-php82/root/usr/bin/php artisan view:clear
/opt/cpanel/ea-php82/root/usr/bin/php artisan route:cache
/opt/cpanel/ea-php82/root/usr/bin/php artisan config:cache

W4qDN%4LAg%7ND