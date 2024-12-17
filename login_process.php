\<?php
session_start(); // Memulai sesi, untuk menyimpan data sesi pengguna

include 'config.php'; // Menyertakan file konfigurasi yang berisi pengaturan koneksi ke database

// Ambil data dari form login
$username = $_POST['username']; // Menyimpan input 'username' dari form login ke variabel $username
$password = $_POST['password']; // Menyimpan input 'password' dari form login ke variabel $password

// Query untuk memeriksa username di database
$sql = "SELECT * FROM users WHERE username = '$username'"; // Membuat query SQL untuk mencari pengguna berdasarkan username
$result = $conn->query($sql); // Menjalankan query SQL pada koneksi database dan menyimpan hasilnya ke variabel $result

if ($result->num_rows > 0) { // Memeriksa apakah ada hasil yang ditemukan di database
    $user = $result->fetch_assoc(); // Mengambil hasil dari query sebagai array asosiatif dan menyimpannya ke variabel $user

    // Verifikasi password
    if (password_verify($password, $user['password'])) { // Memeriksa apakah password yang dimasukkan cocok dengan yang ada di database
        // Simpan session
        $_SESSION['user_id'] = $user['id']; // Menyimpan id pengguna ke dalam sesi
        $_SESSION['role'] = $user['role']; // Menyimpan role pengguna ke dalam sesi

        // Redirect berdasarkan role
        if ($user['role'] === 'admin') { // Memeriksa apakah pengguna memiliki role 'admin'
            $_SESSION['message'] = "Login sukses, selamat datang admin!"; // Menyimpan pesan sukses login untuk admin
            header("Location: admin_dashboard.php"); // Mengarahkan pengguna ke dashboard admin
        } else {
            $_SESSION['message'] = "Login sukses, selamat datang!"; // Menyimpan pesan sukses login untuk pengguna biasa
            header("Location: user_dashboard.php"); // Mengarahkan pengguna ke dashboard pengguna biasa
        }
        exit(); // Menghentikan eksekusi lebih lanjut setelah pengalihan
    } else {
        $_SESSION['error'] = "Password salah!"; // Menyimpan pesan error jika password salah
        header("Location: login.php"); // Mengarahkan kembali ke halaman login
        exit(); // Menghentikan eksekusi lebih lanjut
    }
} else {
    $_SESSION['error'] = "Username tidak ditemukan!"; // Menyimpan pesan error jika username tidak ditemukan
    header("Location: login.php"); // Mengarahkan kembali ke halaman login
    exit(); // Menghentikan eksekusi lebih lanjut
}
