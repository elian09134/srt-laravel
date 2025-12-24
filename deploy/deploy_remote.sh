#!/usr/bin/env bash
# Helper script template for remote deployment tasks (run on server)
# Usage: Place this script on the server in the project folder and run as the deploy user.

set -euo pipefail

echo "Running remote deploy helper..."

# ensure composer exists
if ! command -v composer >/dev/null 2>&1; then
  echo "Composer not found. Install Composer or run composer locally and upload vendor/"
fi

composer install --no-dev --prefer-dist --optimize-autoloader --no-interaction || true

php artisan migrate --force || true
php artisan config:cache || true
php artisan route:cache || true
php artisan view:cache || true
php artisan storage:link || true

echo "Remote deploy helper finished."
