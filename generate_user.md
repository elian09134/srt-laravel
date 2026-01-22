-- Clean up previous attempts (Drop Users)
DELETE FROM users WHERE email IN (
    'divisiminimarket@gmail.com', 'divisiwrapping@gmail.com', 'hansmks.hlp@gmail.com',
    'divisireflexiology@gmail.com', 'divisicelluller@gmail.com', 'divisifnb@gmail.com',
    'divisimoneychanger@gmail.com', 'divisibizdev@gmail.com'
);

-- Generate User Minimarket
INSERT INTO users (name, email, password, role, division, created_at, updated_at)
VALUES (
    'Minimarket',
    'divisiminimarket@gmail.com',
    '$2y$12$t5tE8YPqgxUTbfXvMuWBlOCbe5Rwra8wvsWKNPxyE1RfliaF91KBm', -- Password: Minimarket2026!
    'operasional',
    'minimarket',
    NOW(),
    NOW()
);

-- Generate User Wrapping
INSERT INTO users (name, email, password, role, division, created_at, updated_at)
VALUES (
    'Wrapping',
    'divisiwrapping@gmail.com',
    '$2y$12$HEzji.uiO.0Smrwxds1jmOe/THTwdg7iSdNXVuLVbAgR50d4ohYY6', -- Password: Wrappingsrt2026
    'operasional',
    'wrapping',
    NOW(),
    NOW()
);

-- Generate User Hans
INSERT INTO users (name, email, password, role, division, created_at, updated_at)
VALUES (
    'Hans',
    'hansmks.hlp@gmail.com',
    '$2y$12$0JUW4VeAPSuzlk7Ke/rcQ.KHGdFAYQ2KOqcB3yqEykvVe3l4k7u9q', -- Password: Hanshlp2026
    'operasional',
    'hans',
    NOW(),
    NOW()
);

-- Generate User Reflexiology
INSERT INTO users (name, email, password, role, division, created_at, updated_at)
VALUES (
    'Reflexiology',
    'divisireflexiology@gmail.com',
    '$2y$12$JZGQ5anpsaY.dYsZdKaLee/YLbkyEswI4ROvWZ53/ATprDdyxvQ6m', -- Password: Reflexiology2026!
    'operasional',
    'reflexiology',
    NOW(),
    NOW()
);

-- Generate User Celluller
INSERT INTO users (name, email, password, role, division, created_at, updated_at)
VALUES (
    'Celluller',
    'divisicelluller@gmail.com',
    '$2y$12$msTfM12P.43hEs6tR1V8aenVeial64fL0FdWUHNVHiewyIC8uPvAe', -- Password: Celluller2026!
    'operasional',
    'celluller',
    NOW(),
    NOW()
);

-- Generate User FnB
INSERT INTO users (name, email, password, role, division, created_at, updated_at)
VALUES (
    'FnB',
    'divisifnb@gmail.com',
    '$2y$12$pimydU0dZtqtf9FloJpDautxjsTN8cgWfCsYqXJFl9dVp3YPmBV52', -- Password: FnB2026!
    'operasional',
    'fnb',
    NOW(),
    NOW()
);

-- Generate User Money Changer
INSERT INTO users (name, email, password, role, division, created_at, updated_at)
VALUES (
    'Money Changer',
    'divisimoneychanger@gmail.com',
    '$2y$12$M5YtduxVGg0VsGaviWQEqukCqsO0mJ2pRovDCv1/F2D7cj6WLBxhS', -- Password: MoneyChanger2026!
    'operasional',
    'money changer',
    NOW(),
    NOW()
);

-- Generate User Business Development
INSERT INTO users (name, email, password, role, division, created_at, updated_at)
VALUES (
    'Business Development',
    'divisibizdev@gmail.com',
    '$2y$12$YYF10Ss/8s5JLph3swyH/O/XEyQ..lzFzWfVsgJNa5RKZmqFS9cye', -- Password: BizDev2026!
    'operasional',
    'bussiness development',
    NOW(),
    NOW()
);


-- ALTERNATIVE: Run using php artisan tinker
/*
php artisan tinker

// Hapus user lama jika ada
App\Models\User::whereIn('email', [
    'divisiminimarket@gmail.com', 'divisiwrapping@gmail.com', 'hansmks.hlp@gmail.com',
    'divisireflexiology@gmail.com', 'divisicelluller@gmail.com', 'divisifnb@gmail.com',
    'divisimoneychanger@gmail.com', 'divisibizdev@gmail.com'
])->delete();

// Buat ulang user
$users = [
    ['name' => 'Minimarket', 'email' => 'divisiminimarket@gmail.com', 'password' => 'Minimarket2026!', 'division' => 'minimarket'],
    ['name' => 'Wrapping', 'email' => 'divisiwrapping@gmail.com', 'password' => 'Wrappingsrt2026', 'division' => 'wrapping'],
    ['name' => 'Hans', 'email' => 'hansmks.hlp@gmail.com', 'password' => 'Hanshlp2026', 'division' => 'hans'],
    ['name' => 'Reflexiology', 'email' => 'divisireflexiology@gmail.com', 'password' => 'Reflexiology2026!', 'division' => 'reflexiology'],
    ['name' => 'Celluller', 'email' => 'divisicelluller@gmail.com', 'password' => 'Celluller2026!', 'division' => 'celluller'],
    ['name' => 'FnB', 'email' => 'divisifnb@gmail.com', 'password' => 'FnB2026!', 'division' => 'fnb'],
    ['name' => 'Money Changer', 'email' => 'divisimoneychanger@gmail.com', 'password' => 'MoneyChanger2026!', 'division' => 'money changer'],
    ['name' => 'Business Development', 'email' => 'divisibizdev@gmail.com', 'password' => 'BizDev2026!', 'division' => 'bussiness development'],
];

foreach ($users as $u) {
    App\Models\User::create([
        'name' => $u['name'],
        'email' => $u['email'],
        'password' => $u['password'],
        'role' => 'operasional',
        'division' => $u['division']
    ]);
}
*/