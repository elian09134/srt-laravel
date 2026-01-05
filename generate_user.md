-- Generate Admin Account
INSERT INTO users (name, email, password, role, created_at, updated_at)
VALUES (
    'Administrator',
    'rekrutmensrt@gmail.com',
    '$2y$12$nF7ubr5p3Z5JkEPd4rAdA.u2yw3XikISP0G4sfekvNA18uni3AZbm',  -- Password: rekrutmensrt2025!
    'admin',
    NOW(),
    NOW()
);

-- Generate User Operasional
INSERT INTO users (name, email, password, role, created_at, updated_at)
VALUES (
    'Staff Operasional',
    'operasional@terangbysrt.com',
    '$2y$12$wewFUGiu.THDAJ7d7YRviets.5K5J9ZBAKvtndPjqkW7DNj.y0ZTi',  -- Password: ChangeMe!234
    'operasional',
    NOW(),
    NOW()
);

-- Generate User Regular (Pelamar)
INSERT INTO users (name, email, password, role, created_at, updated_at)
VALUES (
    'John Doe',
    'johndoe@example.com',
    '$2y$12$wewFUGiu.THDAJ7d7YRviets.5K5J9ZBAKvtndPjqkW7DNj.y0ZTi',  -- Password: ChangeMe!234
    'user',
    NOW(),
    NOW()
);

-- Tambahkan profile untuk user (optional, setelah user dibuat)
-- Ambil ID user terlebih dahulu, misal ID = 4
INSERT INTO user_profiles (user_id, phone_number, created_at, updated_at)
VALUES (
    4,  -- Ganti dengan ID user yang baru dibuat
    '081234567890',
    NOW(),
    NOW()
);



/opt/cpanel/ea-php82/root/usr/bin/php artisan tinker

<?php
bcrypt('rekrutmensrt2025!')