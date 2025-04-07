# Evaluasi Fullstack Programmer

## Persyaratan

Sebelum menggunakan proyek ini, pastikan kamu sudah menginstal persyaratan berikut:
- **PHP** >= 8.2
- **Composer**
- **MySQL** atau database lainnya

## Langkah-Langkah Setup

Berikut adalah langkah-langkah untuk meng-clone dan menjalankan proyek Laravel ini:

### 1. Clone Repository

Untuk mendapatkan salinan proyek di lokal, jalankan perintah berikut:

```bash
git clone https://github.com/PutraWiraG/EvaluasiFullstack.git
```

### 2. Composer Install

Setelah berhasil menyalin proyek ini, maka buka proyek ini menggunakan cmd dan jalankan perintah berikut:

```bash
composer install
```

### 3. Konfigurasi Environment

Duplikasi file .env.example menjadi .env dan sesuaikan pengaturan environment tersebut seperti yang ada dibawah ini:

```bash
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE={{sesuaikan}}
DB_USERNAME={{sesuaikan}}
DB_PASSWORD={{sesuaikan}}

```

### 4. Generate APP KEY

Setelah environment variabel telah disesuaikan maka langkah selanjutnya yakni generate app key dengan menjalankan perintah berikut:

```bash
php artisan key:generate
```

### 5. Migrasi dan Seeder Database

Untuk membuat tabel database dan mengisi data awal, jalankan perintah berikut:

```bash
php artisan migrate:fresh
```

### 6. NPM Init dan Install Mocha

Jalankan perintah dibawah ini untuk menggunakan unit testing mocha

```bash
npm init -y
npm install mocha chai supertest --save-dev
```

### 7. Jalankan Aplikasi

Setalah itu Jalankan aplikasi dengan menjalankan perintah berikut:

```bash
php artisan serve
```

### 8. Jalankan Unit Testing Mocha

Terakhir yakni menjalankan unit testing mocha dengan menjalankan perintah berikut:

```bash
npm test
```


### 9. Link Dokumentasi Swagger

Untuk melihat dokumentasi api yang dibuat dapat dilihat melalui link berikut:
```bash
http://127.0.0.1:8000/api/documentation
```
