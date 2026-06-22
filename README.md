# Pinnio

**Pinnio** adalah aplikasi social media berbasis web yang ditujukan untuk kalangan mahasiswa. Platform ini memungkinkan pengguna untuk mengunggah, berbagi, dan menikmati berbagai meme yang relevan dengan kehidupan perkuliahan, sehingga menciptakan ruang hiburan sekaligus interaksi sosial yang ringan dan menyenangkan.

## 👥 Contributors

Berikut adalah tim yang terlibat dalam pengembangan Pinnio:

1. Evan Rafa Radya Alifian
2. Muhammad Ali Murtadho
3. Mohammad Zaenal Abidin
4. Tsabita Qalbi
5. Ailsa Ratimaya Anindya

## ✨ Fitur Utama

Pinnio menyediakan berbagai fitur menarik untuk pengguna, di antaranya:

- 📸 Upload meme dengan mudah
- 👍 Like dan interaksi pada meme
- 💬 Komentar pada setiap postingan
- 🔐 Sistem autentikasi (login & register)
- 🧑‍🎓 Khusus untuk komunitas mahasiswa
- 📱 Tampilan responsive dengan Bootstrap

## 📁 Struktur Folder Project

Berikut adalah struktur folder pada project Pinnio:

```bash
pinnio/
│
├── public/                # Folder untuk asset frontend
│   ├── css/               # File CSS
│   └── js/                # File JavaScript
│
├── src/                   # Source code utama aplikasi
│   ├── Config/            # Konfigurasi aplikasi
│   ├── Controller/        # Controller (logic request/response)
│   ├── Exception/         # Custom exception handling
│   ├── middleware/        # Middleware aplikasi
│   ├── Model/             # Representasi data / entity
│   ├── Repository/        # Akses data (database layer)
│   ├── Service/           # Business logic
│   └── View/              # Tampilan (UI)
│       └── auth/          # View untuk autentikasi
│
├── vendor/                # Dependency dari Composer
│
├── .env                   # Konfigurasi environment
├── .env.example           # Contoh file environment
├── .gitignore             # File yang diabaikan Git
├── .htaccess              # Konfigurasi Apache
├── composer.json          # Konfigurasi dependency
├── composer.lock          # Lock versi dependency
├── index.php              # Entry point aplikasi
└── README.md              # Dokumentasi project
```

📝 Catatan

- Pastikan sudah menginstall Composer dan PHP versi terbaru.
- Gunakan server seperti XAMPP / Laragon / Apache untuk menjalankan project.
- Jika terjadi error pada dependency, jalankan ulang:

```bash
composer install
```

## ⚙️ Teknologi yang Digunakan

Project ini dibangun menggunakan teknologi berikut:

- PHP
- Bootstrap
- vlucas/phpdotenv

## 📥 Cara Clone Project

Clone repository dari GitHub dengan perintah berikut:

```bash
git clone https://github.com/evanalifian/pinnio.git
cd pinnio
```

## 🚀 Cara Menjalankan Project di Local

### 1. Install Dependency

Pastikan Composer sudah terinstall di komputer Anda, lalu jalankan perintah berikut di dalam folder project:

```bash
composer update
```

### 2. Konfigurasi Environment

Salin file `.env.example` menjadi `.env`:

```bash
ni .env.example .env
```

Kemudian sesuaikan konfigurasi di dalam file `.env` sesuai dengan kebutuhan (database, app URL, dll).

### 3. Setup Virtual Host

Tambahkan virtual host dengan nama:

```bash
pinnio.test
```

Contoh konfigurasi pada Apache:

```bash
<VirtualHost *:80>
    ServerName pinnio.test
    DocumentRoot /path/to/pinnio/public

    <Directory /path/to/pinnio/public>
        AllowOverride All
        Require all granted
    </Directory>
</VirtualHost>
```

Tambahkan juga pada file `hosts`:

```bash
127.0.0.1 pinnio.test
```

### 4. Jalankan Project

Setelah semua konfigurasi selesai, buka browser dan akses:

```bash
http://pinnio.test
```

## 🎯 Penutup

Dengan Pinnio, mahasiswa dapat berbagi humor dan pengalaman melalui meme dalam satu platform yang sederhana dan mudah digunakan.
