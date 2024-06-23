# Simple Post

## Author

**Putu Maha Girinda Praba**\
Politeknik Negeri Bali

[![portfolio](https://img.shields.io/badge/my_portfolio-000?style=for-the-badge&logo=ko-fi&logoColor=white)](https://mahagirinda.github.io)
[![linkedin](https://img.shields.io/badge/linkedin-0A66C2?style=for-the-badge&logo=linkedin&logoColor=white)](https://www.linkedin.com/in/mahagirinda/)


## Pembuka

Aplikasi ini adalah web berbasis **Framework Laravel** dengan platform blogging sederhana yang memungkinkan pengguna untuk membuat postingan, berkomentar pada postingan, dan berinteraksi dengan pengguna lain. 

Aplikasi ini memiliki panel admin terpisah untuk mengelola pengguna, postingan, komentar, dan kategori.

## Fitur

**User** :

- Membuat dan mengedit profil
- Membuat, mengedit, dan melihat postingan
- Berkomentar pada postingan
- Melihat postingan berdasarkan kategori
- Melihat profil dan postingan pengguna lain

**Admin** :

- Manajemen pengguna *(membuat, mengedit, melihat)*
- Manajemen postingan *(membuat, mengedit, melihat)*
- Manajemen komentar *(membuat, mengedit, melihat)*
- Manajemen kategori *(membuat, mengedit, melihat)*

## Requirement

- PHP >= 8.1
- Composer
- MySQL or MariaDB
- Apache or Nginx

## Langkah Instalasi

**1. Clone dari repository local:**

   ```bash
   git clone <repository-url>
   cd <project-directory>
   ```

**2. Instal dependensi:**

   ```bash
   composer install
   ```

**3. Atur variabel env:**

   ```bash
   cp .env.example .env
   ```
   * anda dapat membuat manual file `.env` pada root directory
   * sesuaikan isi `.env` sesuai `host, usernama, password database` yang adan pakai

**4. Buat key aplikasi :**

   ```bash
   php artisan key:generate
   ```

**5. Jalankan migrasi dan seed basis data :**

   ```bash
   php artisan migrate --seed
   ```

## Struktur Aplikasi
- `Database Design` : [klik link untuk melihat diagram](https://drawsql.app/teams/pos-app-apis/diagrams/simple-post)
- `Controllers`: Berisi logika untuk menangani permintaan dan mengembalikan respons.
- `Models`: Mewakili tabel basis data dan menyediakan cara untuk berinteraksi dengan data.
- `Views`: Berisi template HTML untuk merender antarmuka pengguna.
- `Routes`: Mendefinisikan URL aplikasi dan memetakannya ke pengontrol dan tindakan.

## Route List

Rute Publik:
- `/home:` Menampilkan halaman beranda.
- `/users/{id}`: Menampilkan profil pengguna.
- `/my-profile`: Menampilkan profil pengguna yang sedang login.
- `/post/create:` Menampilkan formulir pembuatan postingan.
- `/post/view/{id}`: Menampilkan postingan.
- `/comment/create`: Membuat komentar.

Rute Admin:
- `/dashboard`: Menampilkan dasbor admin.
- `/post/inquiry`: Menampilkan formulir pertanyaan postingan.
- `/post/edit/{id}`: Menampilkan formulir pengeditan postingan.
- `/comment/inquiry`: Menampilkan formulir pertanyaan komentar.
- `/comment/edit/{id}`: Menampilkan formulir pengeditan komentar.
- `/user/inquiry`: Menampilkan formulir pertanyaan pengguna.
- `/user/create`: Menampilkan formulir pembuatan pengguna.
- `/user/edit/{id}`: Menampilkan formulir pengeditan pengguna.
- `/category/inquiry`: Menampilkan formulir pertanyaan kategori.
- `/category/create`: Menampilkan formulir pembuatan kategori.
- `/category/edit/{id}`: Menampilkan formulir pengeditan kategori.
   
