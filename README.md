## SRT Recruitment — Project README

This repository is a Laravel-based recruitment site for SRT. It provides job listings, candidate registration, application submission, and an admin panel to manage applicants and a talent pool.

Quick links
- Admin applicants list: [resources/views/admin/applicants.blade.php](resources/views/admin/applicants.blade.php)
- Admin applicant detail: [resources/views/admin/applicants/show.blade.php](resources/views/admin/applicants/show.blade.php)
- Application model: [app/Models/Application.php](app/Models/Application.php)
- Application submission controller: [app/Http/Controllers/ApplicationController.php](app/Http/Controllers/ApplicationController.php)
- Admin controllers: [app/Http/Controllers/Admin](app/Http/Controllers/Admin)
- Routes: [routes/web.php](routes/web.php)

Features
- Candidate registration and profile management.
- Public careers pages (`/karir` and job detail `/karir/{job}`).
- Users can submit applications with optional cover letter. Applications store a snapshot of applicant data to preserve registration info at time of apply.
- Admin panel (under `/admin`) to view applicants, change statuses, add to talent pool, and view applicant details.
- Applicant detail auto-marks status to **Lamaran Dilihat** when opened and provides quick action buttons for stages (Psikotest, Interview HR/User, Offering Letter, Diterima, Ditolak).
- WhatsApp contact button on applicant detail (uses `wa.me`) when phone number is available.

Database changes (recent)
- `2025_12_18_090000_add_cover_letter_to_applications_table.php` — adds `cover_letter` to `applications`.
- `2025_12_18_100000_add_applicant_snapshot_to_applications_table.php` — adds `applicant_name`, `applicant_email`, `applicant_phone`, `applicant_last_position`, `applicant_last_education` to `applications`.

Local setup
1. Copy `.env.example` to `.env` and configure DB and `APP_URL`.
2. Install PHP deps: `composer install`.
3. Install JS deps and build: `npm install` then `npm run build` (or `npm run dev`).
4. Create storage symlink: `php artisan storage:link`.
5. Run migrations: `php artisan migrate`.
6. (Optional) Backfill existing `applications` snapshots from users/profiles. A Tinker chunked script is available during development.

Useful commands
- Start server: `php artisan serve`
- Tinker: `php artisan tinker`
- Run tests: `php artisan test`

Notes for maintainers
- Admin routes are protected by `auth` and `admin` middleware. Ensure admin users have `role` set appropriately.
- Phone normalization for WhatsApp: non-digits removed; leading `0` is replaced with Indonesian country code `62` by default.
- Application snapshots preserve user data at apply time — this is intentional so applicant history remains accurate.

Need help?
If you want me to add notifications, CV upload, or automated tests, tell me which feature to implement next.

