ssh root@202.10.47.161

W4qDN%4LAg%7ND


cd /home/hcmsrt/terangbysrt

git fetch --all
git reset --hard origin/main

/opt/cpanel/ea-php82/root/usr/bin/php artisan config:clear
/opt/cpanel/ea-php82/root/usr/bin/php artisan view:clear
/opt/cpanel/ea-php82/root/usr/bin/php artisan route:cache
/opt/cpanel/ea-php82/root/usr/bin/php artisan config:cache

b x b g o x e k c m s l f s b o


= App\Models\User {#5755
    name: "Operasional Satu",
    email: "operasional@example.com",
    #password: "$2y$12$wewFUGiu.THDAJ7d7YRviets.5K5J9ZBAKvtndPjqkW7DNj.y0ZTi",
    role: "operasional",
    updated_at: "2025-12-31 06:18:45",
    created_at: "2025-12-31 06:18:45",

    <?php
use App\Models\User;
// create operasional user (replace email and phone as needed)
$user = User::create([
  'name' => 'Operasional Satu',
  'email' => 'operasional@example.com',
  'password' => bcrypt('ChangeMe!234'),
  'role' => 'operasional',
]);
// optionally add profile phone
$user->profile()->create(['phone_number' => '081234567890']);
$user 