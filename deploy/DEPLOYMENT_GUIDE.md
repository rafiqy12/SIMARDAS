# 🚀 SIMARDAS - Panduan Deployment Shared Hosting

## 📋 Struktur Hosting

```
/home/simardas/
├── public_html/          ← Domain root (https://simardas.my.id)
│   ├── index.php         ← Modified Laravel bootstrap
│   ├── .htaccess         ← Rewrite rules
│   ├── images/           ← SYMLINK to simardas/public/images
│   ├── build/            ← SYMLINK to simardas/public/build
│   └── storage/          ← SYMLINK to simardas/storage/app/public
│
└── simardas/             ← Laravel project root
    ├── app/
    ├── bootstrap/
    ├── config/
    ├── database/
    ├── deploy/           ← Deployment files
    ├── public/
    │   └── images/       ← Actual image files
    ├── resources/
    ├── routes/
    ├── storage/
    └── vendor/
```

---

## 🔧 Langkah Deployment

### **Metode 1: Menggunakan Script Otomatis (Recommended)**

```bash
# SSH ke hosting
ssh simardas@simardas.my.id

# Masuk ke folder Laravel
cd /home/simardas/simardas

# Pull dari GitHub
git pull origin master

# Jalankan script deployment
bash deploy/setup_hosting.sh
```

---

### **Metode 2: Manual Setup**

#### Step 1: Copy Bootstrap Files

```bash
# Copy modified index.php
cp /home/simardas/simardas/deploy/index.php /home/simardas/public_html/index.php

# Copy .htaccess
cp /home/simardas/simardas/deploy/.htaccess_public_html /home/simardas/public_html/.htaccess
```

#### Step 2: Create Symlinks

```bash
# Masuk ke public_html
cd /home/simardas/public_html

# Hapus yang lama (jika ada)
rm -rf images build storage

# Buat symlinks
ln -s /home/simardas/simardas/public/images images
ln -s /home/simardas/simardas/public/build build
ln -s /home/simardas/simardas/storage/app/public storage
```

#### Step 3: Create Required Directories

```bash
cd /home/simardas/simardas

mkdir -p storage/app/backup
mkdir -p storage/app/restore
mkdir -p storage/app/restore_temp
mkdir -p storage/app/public/documents
mkdir -p storage/framework/{cache,sessions,views}
mkdir -p storage/logs
```

#### Step 4: Set Permissions

```bash
chmod -R 755 storage
chmod -R 755 bootstrap/cache
```

#### Step 5: Update Environment

Edit `/home/simardas/simardas/.env`:

```env
APP_NAME=SIMARDAS
APP_ENV=production
APP_DEBUG=false
APP_URL=https://simardas.my.id
ASSET_URL=https://simardas.my.id

DB_CONNECTION=mysql
DB_HOST=localhost
DB_PORT=3306
DB_DATABASE=simardas_db
DB_USERNAME=simardas_user
DB_PASSWORD=your_password

SESSION_DRIVER=database
CACHE_STORE=database
```

#### Step 6: Clear Caches & Migrate

```bash
cd /home/simardas/simardas

php artisan config:clear
php artisan cache:clear
php artisan view:clear
php artisan route:clear
php artisan migrate --force
```

---

## ⚠️ Troubleshooting

### Images Still Not Loading?

1. **Cek symlink:**
   ```bash
   ls -la /home/simardas/public_html/
   # Pastikan images -> /home/simardas/simardas/public/images
   ```

2. **Cek permission:**
   ```bash
   chmod -R 755 /home/simardas/simardas/public/images
   ```

3. **Test direct access:**
   ```
   https://simardas.my.id/images/Logo_kabupaten_serang.png
   ```

### Backup/Restore Fails?

1. **Cek directory exists:**
   ```bash
   ls -la /home/simardas/simardas/storage/app/
   # Harus ada: backup/, restore/, restore_temp/
   ```

2. **Cek permissions:**
   ```bash
   chmod -R 755 /home/simardas/simardas/storage/app/backup
   chmod -R 755 /home/simardas/simardas/storage/app/restore
   ```

3. **Cek log error:**
   ```bash
   tail -50 /home/simardas/simardas/storage/logs/laravel.log
   ```

### 500 Internal Server Error?

1. **Enable debug temporarily:**
   ```env
   APP_DEBUG=true
   ```

2. **Check error log:**
   ```bash
   tail -100 /home/simardas/simardas/storage/logs/laravel.log
   ```

3. **Check Apache error log (if accessible):**
   ```bash
   tail -100 ~/logs/error.log
   ```

---

## 📋 Verifikasi Deployment

Setelah deployment, test:

| Test | URL | Expected |
|------|-----|----------|
| Homepage | https://simardas.my.id | Login page |
| Logo | https://simardas.my.id/images/Logo_kabupaten_serang.png | Image loads |
| Login | https://simardas.my.id (POST) | Dashboard redirect |
| Backup | Dashboard > Backup | Creates backup successfully |

---

## 🔄 Update dari GitHub

```bash
cd /home/simardas/simardas
git pull origin master
php artisan migrate --force
php artisan config:clear
php artisan cache:clear
php artisan view:clear
```
