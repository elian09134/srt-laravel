# Deployment guide — TERANG By SRT

This document explains steps to prepare your VPS (Ubuntu 22 with WHM/cPanel) and configure GitHub Actions CI/CD to deploy the Laravel app.

Important: You need SSH access to the cPanel account (shell access) and a cPanel account where the site's files will live. If you only have WHM root, create a cPanel account for `terangbysrt.com` and enable SSH access for that account.

## DNS
- Create an A record for `terangbysrt.com` pointing to `202.10.47.161`.
- Optionally create `www` as a CNAME to `terangbysrt.com` or A record to the same IP.

## Server (cPanel) preparation
1. In WHM, create a cPanel account for the domain `terangbysrt.com` (or use an existing one). Note the cPanel username (e.g., `terang`).
2. Enable SSH access for the cPanel account (give shell access).
3. Upload your GitHub Actions public deploy key to `~/.ssh/authorized_keys` for the deploy user, or add the key in cPanel's SSH Access interface.
4. Ensure PHP 8.x and required PHP extensions are installed for the app (cPanel PHP Selector or EasyApache). Install Composer on the server or plan to upload vendor/ from CI.
5. Create a MySQL database and user via cPanel -> MySQL Databases. Save DB name, user, and password.
6. Configure the Document Root: point domain or addon domain to the Laravel `public/` folder (e.g., `/home/terang/terangbysrt/public`).
7. Ensure `storage/` and `bootstrap/cache` directories are writable by the web user.

## GitHub repository: required secrets
In the repo Settings → Secrets → Actions, add the following:
- `DEPLOY_HOST` — `202.10.47.161`
- `DEPLOY_USER` — the SSH username for the cPanel account (e.g., `terang`)
- `DEPLOY_PORT` — SSH port (defaults to `22`)
- `DEPLOY_PATH` — path to the Laravel project on the server (e.g., `/home/terang/terangbysrt`)
- `SSH_PRIVATE_KEY` — private key corresponding to the public key installed on the server (no passphrase recommended for automation)

## CI/CD behavior
- On push to `main`, GitHub Actions will:
  - build frontend assets (`npm ci && npm run build`) in CI,
  - rsync project files to the server (excluding `vendor`, `node_modules`, `.env`, `storage`),
  - SSH into the server to run `composer install`, `php artisan migrate`, clear/cache config/routes/views, and create storage symlink.

If you prefer not to run `composer` on the server, you can run `composer install --no-dev` in CI and rsync `vendor/` as part of the artifact (change the rsync excludes accordingly).

## Post-deploy checks
- Visit `https://terangbysrt.com` after DNS propagated.
- Verify `APP_ENV=production`, `APP_DEBUG=false` in `.env` on the server.
- Check storage link: the `public/storage` should point to `storage/app/public`.

## Useful commands (run locally to test or on server as needed)
```bash
# clear cached views on server
php artisan view:clear
php artisan route:clear
php artisan config:clear
php artisan cache:clear
```

## Notes and caveats
- WHM/cPanel setups sometimes restrict global commands; consider using the cPanel `Terminal` tool or enable SSH for the account.
- If Node or Composer are not available on the cPanel account, build assets and vendor locally in CI and rsync them to the server.
