# T-PWEB
Tugas kuliah pemrograman web

Menggunakan PHP

Sebuah web untuk catatan (Belum ada fitur yang bagus cuma bisa CRUD database)
Keamanan belum ada, masih sebatas hashing password

## GitHub Pages

Repository ini sudah dilengkapi dengan GitHub Actions untuk otomatis deploy ke GitHub Pages. Halaman landing page statis akan tersedia di `https://farelyudapratama.github.io/T-PWEB/`

**Catatan:** GitHub Pages hanya bisa menampilkan file statis (HTML, CSS, JS). Aplikasi PHP ini membutuhkan server lokal dengan PHP dan MySQL untuk berjalan sepenuhnya.

### Cara Mengaktifkan GitHub Pages

1. Buka Settings → Pages di repository ini
2. Pada bagian "Source", pilih "GitHub Actions"
3. Workflow akan otomatis berjalan setiap ada push ke branch `main`
4. Halaman akan tersedia dalam beberapa menit setelah deployment

### Cara Menjalankan Aplikasi Secara Lokal

Lihat instruksi lengkap di halaman GitHub Pages atau ikuti langkah berikut:

1. Clone repository
2. Install XAMPP atau server PHP + MySQL
3. Buat database `notes-1` di MySQL
4. Buat tabel `users` dan `notes` sesuai struktur di file PHP
5. Jalankan Apache dan MySQL
6. Akses `http://localhost/T-PWEB/`
