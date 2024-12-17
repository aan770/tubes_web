<?php
session_start(); // Memulai session, agar bisa menyimpan pesan atau data session seperti error atau username

include 'config.php'; // Memasukkan file konfigurasi yang berisi koneksi ke database

// Mengambil data yang dikirimkan dari form registrasi
$username = $_POST['username']; // Mengambil username dari form
$password = $_POST['password']; // Mengambil password dari form
$role = $_POST['role']; // Mengambil role dari form (misalnya 'user' atau 'admin')

// Cek apakah username yang dimasukkan sudah terdaftar di database
$sql_check = "SELECT * FROM users WHERE username = '$username'"; // Query untuk mencari username yang sudah ada
$result = $conn->query($sql_check); // Menjalankan query untuk mencari data di database

if ($result->num_rows > 0) { // Jika ada baris (user) yang ditemukan dengan username yang sama
    // Username sudah ada, tampilkan pesan error
    $_SESSION['error'] = "Username sudah terdaftar!"; // Menyimpan pesan error di session
    header("Location: register.php"); // Redirect kembali ke halaman registrasi
    exit(); // Menghentikan eksekusi script lebih lanjut
} else {
    // Jika username belum ada, enkripsi password sebelum disimpan ke database
    $hashed_password = password_hash($password, PASSWORD_DEFAULT); // Enkripsi password menggunakan algoritma password_hash

    // Query untuk memasukkan data pengguna baru ke dalam tabel 'users'
    $sql = "INSERT INTO users (username, password, role) VALUES ('$username', '$hashed_password', '$role')";

    if ($conn->query($sql) === TRUE) { // Jika query berhasil dieksekusi dan data berhasil disimpan
        // Menyimpan informasi pengguna di session
        $_SESSION['username'] = $username; // Menyimpan username ke session
        $_SESSION['role'] = $role; // Menyimpan role pengguna ke session

        // Mengatur cookie untuk menyimpan username dan role selama 1 minggu (untuk mengingat login)
        setcookie('username', $username, time() + (7 * 24 * 60 * 60), "/"); // Membuat cookie untuk username
        setcookie('role', $role, time() + (7 * 24 * 60 * 60), "/"); // Membuat cookie untuk role pengguna

        // Menyimpan pesan sukses di session
        $_SESSION['message'] = "Registrasi berhasil! Silakan login."; // Pesan sukses registrasi

        header("Location: login.php"); // Redirect pengguna ke halaman login setelah registrasi berhasil
        exit(); // Menghentikan eksekusi script lebih lanjut
    } else {
        // Jika terjadi error saat eksekusi query, tampilkan pesan error
        echo "Error: " . $conn->error; // Menampilkan pesan error query dari database
    }
}
?>
