<?php
session_start(); // Memulai sesi PHP untuk menyimpan dan mengakses data sesi
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8"> <!-- Menetapkan karakter set untuk dokumen HTML sebagai UTF-8 -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> <!-- Menetapkan viewport untuk responsif di perangkat mobile -->
    <title>UKM Bulutangkis UINAM - Login</title> <!-- Menetapkan judul halaman -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css"> <!-- Menyertakan file CSS Bootstrap dari CDN untuk styling -->
    <style>
        /* Styling untuk bagian login */
        .login-section {
            padding: 80px 0; /* Menambahkan padding atas dan bawah */
            background: linear-gradient(135deg, #0d6efd, #0069d9); /* Background gradien biru */
            height: 100vh; /* Membuat tinggi bagian login 100% tinggi viewport */
        }

        .login-form {
            max-width: 400px; /* Membatasi lebar form */
            margin: 0 auto; /* Membuat form berada di tengah */
            padding: 40px; /* Menambahkan padding dalam form */
            background-color: #ffffff; /* Warna latar belakang form */
            border-radius: 8px; /* Membuat sudut form melengkung */
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.1); /* Menambahkan bayangan untuk form */
            border-top: 3px solid #0d6efd; /* Menambahkan garis atas berwarna biru */
        }

        .login-form h2 {
            text-align: center; /* Menempatkan judul di tengah */
            margin-bottom: 20px; /* Memberi jarak bawah */
            font-size: 26px; /* Ukuran font judul */
            color: #0d6efd; /* Warna teks biru */
            font-weight: bold; /* Menebalkan font judul */
        }

        .form-control {
            border-radius: 5px; /* Sudut input membulat */
            border-color: #0069d9; /* Warna border biru */
            box-shadow: none; /* Menghapus bayangan pada input */
        }

        .form-control:focus {
            border-color: #0d6efd; /* Ganti warna border saat fokus */
            box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25); /* Menambahkan bayangan saat fokus */
        }

        .btn-primary {
            background-color: #0069d9; /* Warna latar belakang tombol */
            border: none; /* Menghilangkan border tombol */
            padding: 12px; /* Menambahkan padding dalam tombol */
            font-size: 16px; /* Ukuran font tombol */
            border-radius: 5px; /* Membuat tombol melengkung */
            width: 100%; /* Membuat tombol memenuhi lebar form */
        }

        .btn-primary:hover {
            background-color: #0d6efd; /* Mengubah warna saat hover */
            border: none; /* Menghilangkan border */
        }

        .text-center {
            text-align: center; /* Menempatkan teks di tengah */
        }

        .mt-3 {
            margin-top: 1rem; /* Memberikan margin atas */
        }

        @media (max-width: 576px) {
            .login-form {
                padding: 30px; /* Mengurangi padding untuk layar kecil */
                width: 90%; /* Lebar form menjadi 90% pada perangkat kecil */
            }
        }
    </style>
</head>
<body>
    <!-- Navigasi Bar untuk aplikasi -->
    <nav class="navbar navbar-expand-lg navbar-light" style="background-color: #004085;">
        <div class="container-fluid">
            <a class="navbar-brand" href="index.html"> <!-- Tautan untuk kembali ke halaman utama -->
                <img src="Screenshot 2024-11-01 035903.png" alt="Logo UKM Bulutangkis" style="width: 50px; height: 50px; border-radius: 50%;"> <!-- Logo bulutangkis dengan gambar berbentuk lingkaran -->
                UKM Bulutangkis UINAM <!-- Nama UKM Bulutangkis -->
            </a>
        </div>
    </nav>

    <!-- Bagian login -->
    <section class="login-section">
        <div class="container mt-5"> <!-- Container untuk memusatkan form login -->
            <div class="login-form"> <!-- Form login -->
                <h2 class="text-center mb-4">Login</h2> <!-- Judul form login -->

                <?php
                // Menampilkan pesan error jika ada
                if (isset($_SESSION['error'])) { 
                    echo '<div style="color: red; font-weight: bold;">' . $_SESSION['error'] . '</div>'; // Menampilkan pesan error yang disimpan dalam sesi
                    unset($_SESSION['error']); // Menghapus pesan error setelah ditampilkan
                }
                ?>

                <!-- Form login -->
                <form action="login_process.php" method="POST"> <!-- Form mengirim data ke file login_process.php dengan metode POST -->
                    <div class="mb-3"> <!-- Elemen input untuk username -->
                        <label for="username" class="form-label">Username</label> <!-- Label untuk kolom username -->
                        <input type="text" class="form-control" id="username" name="username" required> <!-- Input untuk username -->
                    </div>
                    <div class="mb-3"> <!-- Elemen input untuk password -->
                        <label for="password" class="form-label">Password</label> <!-- Label untuk kolom password -->
                        <input type="password" class="form-control" id="password" name="password" required> <!-- Input untuk password -->
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Login</button> <!-- Tombol untuk login -->
                </form>

                <div class="mt-3 text-center"> <!-- Tautan untuk registrasi jika belum memiliki akun -->
                    <p>Belum punya akun? <a href="register.php">Daftar di sini</a></p> <!-- Tautan ke halaman pendaftaran -->
                </div>
            </div>
        </div>
    </section>

    <!-- Menyertakan file JavaScript Bootstrap untuk mendukung interaksi -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</body>
</html>
