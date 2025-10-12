# Aplikasi Vue 3 + Vite dengan MultiBahasa

Template ini membantu Anda memulai pengembangan dengan Vue 3 di Vite. Template ini menggunakan Vue 3 `<script setup>` SFCs, lihat [dokumentasi script setup](https://v3.vuejs.org/api/sfc-script-setup.html#sfc-script-setup) untuk mempelajari lebih lanjut.

Pelajari lebih lanjut tentang Dukungan IDE untuk Vue di [Panduan Vue Docs Scaling up](https://vuejs.org/guide/scaling-up/tooling.html#ide-support).

## Fitur MultiBahasa

Aplikasi ini mendukung dua bahasa:
- Bahasa Indonesia
- Bahasa Inggris

### Instalasi dan Deploy ke Web Hosting

#### 1. Persiapan Instalasi Lokal

1. **Instalasi Dependencies PHP**
   ```bash
   composer install
   ```

2. **Buat File Environment**
   ```bash
   cp .env.example .env
   ```

3. **Generate Application Key**
   ```bash
   php artisan key:generate
   ```

4. **Konfigurasi Database**
   Buka file `.env` dan sesuaikan dengan konfigurasi database Anda:
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=nama_database_anda
   DB_USERNAME=username_database
   DB_PASSWORD=password_database
   ```

5. **Instalasi Dependencies Frontend**
   ```bash
   npm install
   ```

6. **Build Asset untuk Produksi**
   ```bash
   npm run build
   ```

7. **Jalankan Migrasi Database**
   ```bash
   php artisan migrate
   ```

8. **Jalankan Server Development**
   ```bash
   php artisan serve
   ```

Atau Anda bisa menjalankan skrip setup otomatis:
```bash
composer run setup
```

#### 2. Deployment ke Hosting Bersama (Shared Hosting)

##### Persiapan Sebelum Deployment

1. **Konfigurasi Environment Production**:
   - Modifikasi file `.env` dengan pengaturan produksi:
   ```env
   APP_ENV=production
   APP_DEBUG=false
   APP_URL=https://domain-anda.com
   
   DB_CONNECTION=mysql
   DB_HOST=localhost
   DB_PORT=3306
   DB_DATABASE=database_hosting
   DB_USERNAME=username_database
   DB_PASSWORD=password_database
   ```

2. **Persiapkan Proyek untuk Deployment**:
   ```bash
   # Instal hanya dependencies produksi
   composer install --optimize-autoloader --no-dev
   
   # Build asset frontend untuk produksi
   npm run build
   ```

3. **Optimasi Laravel untuk Produksi**:
   ```bash
   php artisan config:cache
   php artisan route:cache
   php artisan view:cache
   php artisan event:cache
   ```

##### Upload dan Deploy

4. **Upload File ke Hosting**:
   - Upload semua file dan folder ke direktori `public_html`, `www`, atau `htdocs` di hosting Anda
   - Penting: Folder `public` harus menjadi root web (atau ganti namanya sesuai kebutuhan hosting)

5. **Set Permission File**:
   - Direktori `storage` dan `bootstrap/cache` harus dapat ditulis (biasanya chmod 755 atau 775)
   - Jika hosting control panel Anda tidak mendukung akses command-line, set ini melalui FTP/file manager

6. **Setup Database**:
   - Buat database di hosting control panel (cPanel, Plesk, dll)
   - Buat user database dan tetapkan ke database Anda
   - Perbarui file `.env` dengan kredensial database

7. **Jalankan migrasi database**:
   - Jika hosting Anda menyediakan SSH access:
   ```bash
   php artisan migrate --force
   ```
   - Jika tidak ada akses SSH, Anda mungkin perlu menggunakan metode import database:
     - Jalankan `php artisan migrate:status` secara lokal untuk melihat migrasi yang ada
     - Export skema database dan import melalui phpMyAdmin atau alat serupa
     - Atau gunakan `php artisan migrate --pretend` untuk melihat SQL mentah dan eksekusi secara manual

8. **Verifikasi Deployment**:
   - Akses domain Anda untuk memeriksa apakah aplikasi Laravel berhasil dimuat
   - Periksa file log Laravel jika ada error (`storage/logs/laravel.log`)

#### 3. Deployment ke Server VPS/Dedicated

##### Setup Server

1. **Instal Software yang Dibutuhkan**:
   - Update sistem:
     ```bash
     sudo apt update && sudo apt upgrade -y
     ```
   - Instal web server (Nginx atau Apache):
     ```bash
     sudo apt install nginx
     ```
   - Instal PHP dan ekstensi yang dibutuhkan:
     ```bash
     sudo apt install php8.3 php8.3-fpm php8.3-cli php8.3-common php8.3-mysql php8.3-zip php8.3-gd php8.3-mbstring php8.3-curl php8.3-xml php8.3-bcmath php8.3-json php8.3-ctype php8.3-tokenizer php8.3-fileinfo
     ```
   - Instal Composer:
     ```bash
     curl -sS https://getcomposer.org/installer | php
     sudo mv composer.phar /usr/local/bin/composer
     sudo chmod +x /usr/local/bin/composer
     ```
   - Instal Node.js dan npm jika belum terinstal:
     ```bash
     curl -fsSL https://deb.nodesource.com/setup_22.x | sudo -E bash -
     sudo apt-get install -y nodejs
     ```

2. **Setup Database** (MySQL/MariaDB):
   ```bash
   sudo apt install mysql-server
   sudo mysql_secure_installation
   ```

##### Deployment Aplikasi

3. **Deploy aplikasi Laravel Anda**:
   - Buat direktori untuk aplikasi Anda:
     ```bash
     sudo mkdir -p /var/www/nama-aplikasi-anda
     ```
   - Transfer file aplikasi Laravel Anda ke `/var/www/nama-aplikasi-anda` menggunakan Git, SCP, atau metode lainnya
   - Set kepemilikan yang benar:
     ```bash
     sudo chown -R www-data:www-data /var/www/nama-aplikasi-anda
     ```

4. **Konfigurasi Environment**:
   - Salin file `.env.production` Anda (atau rename `.env.example` dan ubah sesuai kebutuhan) ke `/var/www/nama-aplikasi-anda`
   - Konfigurasi pengaturan database di file `.env`

5. **Instal Dependencies**:
   ```bash
   cd /var/www/nama-aplikasi-anda
   composer install --optimize-autoloader --no-dev
   npm install
   npm run build
   ```

6. **Set Permission yang Benar**:
   ```bash
   sudo chmod -R 755 /var/www/nama-aplikasi-anda
   sudo chmod -R 775 /var/www/nama-aplikasi-anda/storage
   sudo chmod -R 775 /var/www/nama-aplikasi-anda/bootstrap/cache
   ```

7. **Konfigurasi web server**:
   - Untuk Nginx, buat file konfigurasi:
     ```bash
     sudo nano /etc/nginx/sites-available/nama-aplikasi-anda
     ```
   - Tambahkan konfigurasi berikut:
     ```nginx
     server {
         listen 80;
         server_name domain-anda.com;
         root /var/www/nama-aplikasi-anda/public;
         index index.php index.html index.htm;

         access_log /var/log/nginx/nama-aplikasi-anda_access.log;
         error_log /var/log/nginx/nama-aplikasi-anda_error.log;

         location / {
             try_files $uri $uri/ /index.php?$query_string;
         }

         location ~ \.php$ {
             include snippets/fastcgi-php.conf;
             fastcgi_pass unix:/var/run/php/php8.3-fpm.sock;
             fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
             include fastcgi_params;
         }

         location ~ /\.ht {
             deny all;
         }

         location ~* \.php$ {
             fastcgi_pass unix:/run/php/php8.3-fpm.sock;
             include fastcgi_params;
             fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
         }
     }
     ```
   - Aktifkan situs:
     ```bash
     sudo ln -s /etc/nginx/sites-available/nama-aplikasi-anda /etc/nginx/sites-enabled/
     sudo nginx -t
     sudo systemctl reload nginx
     ```

8. **Konfigurasi Database**:
   ```bash
   sudo mysql -u root -p
   CREATE DATABASE nama_database_anda;
   CREATE USER 'user_database_anda'@'localhost' IDENTIFIED BY 'password_yang_kuat';
   GRANT ALL ON nama_database_anda.* TO 'user_database_anda'@'localhost';
   FLUSH PRIVILEGES;
   EXIT;
   ```

9. **Jalankan migrasi database**:
   ```bash
   cd /var/www/nama-aplikasi-anda
   php artisan migrate --force
   ```

10. **Setup SSL dengan Let's Encrypt** (direkomendasikan):
    ```bash
    sudo apt install certbot python3-certbot-nginx
    sudo certbot --nginx -d domain-anda.com
    ```

11. **Setup Queue Worker (jika dibutuhkan)**:
    Untuk aplikasi yang menggunakan queue, buat service systemd:
    ```bash
    sudo nano /etc/systemd/system/laravel-worker.service
    ```
    Tambahkan:
    ```ini
    [Unit]
    Description=Laravel Worker
    After=network.target

    [Service]
    Type=forking
    User=www-data
    Group=www-data
    WorkingDirectory=/var/www/nama-aplikasi-anda
    ExecStart=/usr/bin/php /var/www/nama-aplikasi-anda/artisan queue:work --daemon
    Restart=always
    RestartSec=3

    [Install]
    WantedBy=multi-user.target
    ```
    Aktifkan service:
    ```bash
    sudo systemctl enable laravel-worker
    sudo systemctl start laravel-worker
    ```

#### 4. Konfigurasi Environment

##### Persyaratan Server
Server Anda harus memenuhi persyaratan berikut:

1. **Versi PHP**: 8.2 atau lebih tinggi (persyaratan Laravel 12)

2. **Ekstensi PHP**:
   - BCMath PHP Extension
   - Ctype PHP Extension
   - cURL PHP Extension
   - DOM PHP Extension
   - Fileinfo PHP Extension
   - JSON PHP Extension
   - Mbstring PHP Extension
   - OpenSSL PHP Extension
   - PCRE PHP Extension
   - PDO PHP Extension
   - Tokenizer PHP Extension
   - XML PHP Extension
   - Zlib PHP Extension (untuk Laravel Octane)

3. **Ekstensi Tambahan yang Disarankan**:
   - Redis (jika menggunakan Redis untuk caching/queues)
   - Imagick (untuk pemrosesan gambar)
   - GMP (untuk operasi matematika kompleks)

##### Permission File
1. **Direktori**: `storage`, `bootstrap/cache`, dan subdirektori mereka perlu izin tulis
2. **Permission yang Disarankan**:
   - Direktori: 755 atau 775
   - File: 644 atau 664
   - `storage` dan `bootstrap/cache`: 775 untuk memungkinkan akses tulis dari web server

##### Konfigurasi Variabel Environment

1. **Pengaturan Environment Produksi**:
   ```env
   APP_ENV=production
   APP_DEBUG=false
   APP_URL=https://domain-anda.com
   ```

2. **Konfigurasi Database**:
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=nama_database_anda
   DB_USERNAME=user_database_anda
   DB_PASSWORD=password_database_anda
   ```

3. **Pengaturan Cache dan Session**:
   ```env
   CACHE_DRIVER=file
   SESSION_DRIVER=file
   QUEUE_CONNECTION=database
   ```

4. **Optimisasi Produksi Pilihan**:
   ```env
   LOG_CHANNEL=errorlog
   LOG_LEVEL=error
   ```

5. **Penyimpanan File (jika menggunakan cloud storage)**:
   ```env
   FILESYSTEM_DISK=public
   # Untuk cloud storage seperti AWS S3:
   # FILESYSTEM_DISK=s3
   # AWS_ACCESS_KEY_ID=kunci_anda
   # AWS_SECRET_ACCESS_KEY=secret_anda
   # AWS_DEFAULT_REGION=us-east-1
   # AWS_BUCKET=bucket_anda
   ```

#### 5. Prosedur Migrasi Database

##### Migrasi di Environment Produksi

1. **Sebelum Menjalankan Migrasi**:
   - Selalu backup database sebelum menjalankan migrasi di produksi
   - Uji migrasi di environment staging yang menyerupai produksi
   - Pastikan file `.env` memiliki kredensial database yang benar

2. **Menjalankan Migrasi**:
   ```bash
   # Jalankan migrasi dengan flag --force untuk menjalankan di environment produksi
   php artisan migrate --force
   
   # Jika Anda juga perlu mens seed database
   php artisan migrate --seed --force
   ```

3. **Metode Alternatif - SQL Manual**:
   Jika Anda tidak memiliki akses SSH untuk menjalankan perintah artisan:
   - Jalankan migrasi secara lokal: `php artisan migrate:status` untuk melihat migrasi yang telah dijalankan
   - Gunakan `php artisan migrate --pretend --force` untuk melihat SQL mentah untuk setiap migrasi
   - Eksekusi SQL secara manual melalui alat pengelolaan database hosting Anda (seperti phpMyAdmin)

4. **Mengembalikan Migrasi** (jika diperlukan):
   ```bash
   # Mengembalikan batch migrasi terakhir
   php artisan migrate:rollback --force
   
   # Mengembalikan jumlah batch tertentu
   php artisan migrate:rollback --step=3 --force
   ```

5. **Memeriksa Status Migrasi**:
   ```bash
   php artisan migrate:status
   ```

#### 6. Tugas Setelah Deployment

1. **Verifikasi Aplikasi Berfungsi**:
   - Akses domain Anda untuk memastikan aplikasi Laravel dimuat dengan benar
   - Uji berbagai halaman untuk memastikan fungsionalitas
   - Periksa console browser untuk error frontend
   - Uji form dan interaksi pengguna

2. **Optimasi Cache dan Clear**:
   ```bash
   # Clear konfigurasi cache jika diperlukan
   php artisan config:clear
   php artisan cache:clear
   
   # Re-optimize cache produksi
   php artisan config:cache
   php artisan route:cache
   php artisan view:cache
   ```

3. **Setup Monitoring Error**:
   - Konfigurasikan logging Laravel di `config/logging.php`
   - Pertimbangkan untuk mengintegrasikan dengan layanan seperti Sentry, Bugsnag, atau yang serupa
   - Setup notifikasi email untuk error kritis di `.env`:
   ```env
   LOG_CHANNEL=mail
   MAIL_MAILER=smtp
   # ... konfigurasi mail
   ```

4. **Pemeriksaan Keamanan**:
   - Verifikasi bahwa `APP_DEBUG=false` di file `.env` Anda
   - Pastikan file sensitif tidak dapat diakses (cek bahwa file storage tidak dapat diakses secara langsung)
   - Verifikasi bahwa direktori `storage/logs` dan direktori sensitif lainnya tidak dapat diakses dari web

5. **Optimasi Performa**:
   - Monitor waktu load halaman
   - Pertimbangkan untuk mengimplementasikan mekanisme caching bawaan Laravel
   - Setup CDN untuk asset jika diperlukan
   - Optimasi gambar dan asset

6. **Setup Scheduler Artisan** (jika aplikasi Anda menggunakan scheduled tasks):
   - Tambahkan scheduler Laravel ke crontab Anda:
   ```bash
   # Edit crontab
   crontab -e
   
   # Tambahkan baris ini untuk menjalankan scheduler setiap menit
   * * * * * cd /path-ke-proyek-anda && php artisan schedule:run >> /dev/null 2>&1
   ```

7. **Setup Queue Worker** (jika aplikasi Anda menggunakan queue):
   ```bash
   # Di produksi, gunakan database, Redis, atau Amazon SQS sebagai driver queue
   php artisan queue:work --daemon --tries=3
   ```
   Pertimbangkan untuk setup process monitor seperti Supervisor untuk menjaga queue worker tetap berjalan:
   ```ini
   [program:laravel-worker]
   process_name=%(program_name)s_%(process_num)02d
   command=php /path-ke-proyek-anda/artisan queue:work --tries=3
   autostart=true
   autorestart=true
   user=www-data
   numprocs=2
   redirect_stderr=true
   stdout_logfile=/path-ke-proyek-anda/worker.log
   ```

8. **Monitoring dan Maintenance**:
   - Setup rotasi log untuk mencegah file log menjadi terlalu besar
   - Jadwalkan backup database secara reguler
   - Pertimbangkan untuk menggunakan Laravel Telescope untuk debugging di development (tapi jangan aktifkan di produksi)
   - Monitor space storage, terutama di direktori `storage`

9. **SEO dan Analytics**:
   - Tambahkan situs Anda ke Google Search Console dan Bing Webmaster Tools
   - Implementasikan Google Analytics atau tools analytics lainnya
   - Pastikan file `robots.txt` Anda dikonfigurasi dengan benar
   - Submit sitemap Anda jika Anda memiliki salah satu

10. **Strategi Backup**:
   - Setup backup otomatis untuk database Anda
   - Backup secara reguler file code dan konfigurasi
   - Pertimbangkan menggunakan paket backup Laravel seperti Spatie Laravel Backup:
   ```bash
   composer require spatie/laravel-backup
   php artisan backup:run
   ```

11. **Testing Environment Produksi**:
   - Jalankan subset tes penting jika memungkinkan
   - Uji fungsionalitas registrasi/login pengguna
   - Uji workflow pengguna lengkap yang relevan dengan aplikasi Anda
   - Verifikasi bahwa upload file berfungsi jika aplikasi Anda mendukungnya

12. **Daftar Periksa Akhir**:
   - [ ] Aplikasi dimuat dengan benar
   - [ ] Variabel environment diset dengan benar
   - [ ] Koneksi database berfungsi
   - [ ] Semua layanan eksternal (API, dll.) dapat diakses
   - [ ] Form dan input pengguna berfungsi dengan benar
   - [ ] Error dan exception handling berfungsi sebagaimana mestinya
   - [ ] Logging berfungsi
   - [ ] Header keamanan diset
   - [ ] SSL certificate valid (jika berlaku)

## Fitur MultiBahasa

Aplikasi ini menyertakan tombol pemilihan bahasa untuk beralih antara Bahasa Indonesia dan Bahasa Inggris. Fungsionalitas ini diterapkan di seluruh aplikasi melalui komponen LanguageSelector yang tersedia di navbar.

Tombol pemilihan bahasa menyimpan preferensi pengguna di localStorage sehingga bahasa yang dipilih akan tetap aktif saat pengguna kembali ke aplikasi.