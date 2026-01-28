#!/bin/bash

# ================================================
# SIMARDAS - Shared Hosting Deployment Script
# ================================================
# Run this script via SSH on your Domainesia hosting
# 
# Usage: bash deploy/setup_hosting.sh
# ================================================

echo "🚀 SIMARDAS Deployment Script"
echo "=============================="

# Configuration - adjust these paths if needed
LARAVEL_ROOT="/home/simardas/simardas"
PUBLIC_HTML="/home/simardas/public_html"

# Check if we're in the right place
if [ ! -d "$LARAVEL_ROOT" ]; then
    echo "❌ Error: Laravel directory not found at $LARAVEL_ROOT"
    exit 1
fi

echo "📁 Laravel root: $LARAVEL_ROOT"
echo "📁 Public HTML:  $PUBLIC_HTML"

# Step 1: Copy index.php to public_html
echo ""
echo "1️⃣ Copying index.php to public_html..."
cp "$LARAVEL_ROOT/deploy/index.php" "$PUBLIC_HTML/index.php"

# Step 2: Copy .htaccess to public_html
echo "2️⃣ Copying .htaccess to public_html..."
cp "$LARAVEL_ROOT/deploy/.htaccess_public_html" "$PUBLIC_HTML/.htaccess"

# Step 3: Create symlinks for public assets
echo "3️⃣ Creating symlinks for assets..."

# Remove existing if present
rm -rf "$PUBLIC_HTML/images" 2>/dev/null
rm -rf "$PUBLIC_HTML/build" 2>/dev/null
rm -rf "$PUBLIC_HTML/storage" 2>/dev/null

# Create symlinks
ln -s "$LARAVEL_ROOT/public/images" "$PUBLIC_HTML/images"
ln -s "$LARAVEL_ROOT/public/build" "$PUBLIC_HTML/build"
ln -s "$LARAVEL_ROOT/storage/app/public" "$PUBLIC_HTML/storage"

echo "   ✅ Symlinked: images -> $LARAVEL_ROOT/public/images"
echo "   ✅ Symlinked: build -> $LARAVEL_ROOT/public/build"
echo "   ✅ Symlinked: storage -> $LARAVEL_ROOT/storage/app/public"

# Step 4: Set permissions
echo "4️⃣ Setting permissions..."
chmod -R 755 "$LARAVEL_ROOT/storage"
chmod -R 755 "$LARAVEL_ROOT/bootstrap/cache"

# Step 5: Create required directories
echo "5️⃣ Creating required directories..."
mkdir -p "$LARAVEL_ROOT/storage/app/backup"
mkdir -p "$LARAVEL_ROOT/storage/app/restore"
mkdir -p "$LARAVEL_ROOT/storage/app/restore_temp"
mkdir -p "$LARAVEL_ROOT/storage/app/public/documents"
mkdir -p "$LARAVEL_ROOT/storage/framework/cache"
mkdir -p "$LARAVEL_ROOT/storage/framework/sessions"
mkdir -p "$LARAVEL_ROOT/storage/framework/views"
mkdir -p "$LARAVEL_ROOT/storage/logs"

# Step 6: Clear caches
echo "6️⃣ Clearing caches..."
cd "$LARAVEL_ROOT"
php artisan config:clear
php artisan cache:clear
php artisan view:clear
php artisan route:clear

# Step 7: Run migrations
echo "7️⃣ Running migrations..."
php artisan migrate --force

echo ""
echo "✅ Deployment complete!"
echo ""
echo "📋 Checklist:"
echo "   [ ] Update .env with correct APP_URL=https://simardas.my.id"
echo "   [ ] Update .env with correct ASSET_URL=https://simardas.my.id"
echo "   [ ] Update .env with correct database credentials"
echo "   [ ] Test image loading: https://simardas.my.id/images/Logo_kabupaten_serang.png"
echo "   [ ] Test login functionality"
echo "   [ ] Test backup & restore"
