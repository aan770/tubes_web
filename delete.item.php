<?php
session_start();  // Memulai sesi untuk melacak status login pengguna
include 'config.php';  // Meng-include file koneksi ke database

// Mengecek apakah metode permintaan adalah POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {  
    $type = $_POST['type'];  // Mengambil jenis entitas yang akan dihapus ('user' atau 'post')
    $id = $_POST['id'];  // Mengambil ID entitas yang akan dihapus

    if ($type == 'user') {  // Jika jenisnya adalah 'user'
        // Query untuk menghapus pengguna berdasarkan ID
        $sql = "DELETE FROM users WHERE id = ?";  
        $stmt = $conn->prepare($sql);  // Menyiapkan statement untuk mencegah SQL injection
        $stmt->bind_param("i", $id);  // Mengikat parameter ID sebagai integer ('i')

        if ($stmt->execute()) {  // Mengeksekusi query
            echo 'success';  // Jika berhasil, tampilkan 'success'
        } else {
            echo 'failure';  // Jika gagal, tampilkan 'failure'
        }

    } elseif ($type == 'post') {  // Jika jenisnya adalah 'post'
        // Query untuk menghapus postingan berdasarkan ID
        $sql = "DELETE FROM posts WHERE id = ?";
        $stmt = $conn->prepare($sql);  // Menyiapkan statement untuk mencegah SQL injection
        $stmt->bind_param("i", $id);  // Mengikat parameter ID sebagai integer ('i')

        if ($stmt->execute()) {  // Mengeksekusi query
            echo 'success';  // Jika berhasil, tampilkan 'success'
        } else {
            echo 'failure';  // Jika gagal, tampilkan 'failure'
        }
    }
}
?>
