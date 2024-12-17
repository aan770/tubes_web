<?php
session_start();  // Memulai sesi untuk melacak status login pengguna
include 'config.php';  // Meng-include file koneksi database (pastikan file koneksi ada dan benar)


// Cek apakah user yang sedang login adalah admin
if ($_SESSION['role'] !== 'admin') {  // Mengecek apakah nilai role pengguna adalah admin
    header("Location: login.php");  // Jika bukan admin, arahkan ke halaman login
    exit();  // Menghentikan eksekusi lebih lanjut
}

// Mengecek apakah ada parameter 'id' yang diteruskan melalui URL (GET)
if (isset($_GET['id'])) {  
    $post_id = $_GET['id'];  // Menyimpan nilai ID postingan yang ingin dihapus

    // Query untuk menghapus postingan berdasarkan ID yang diterima
    $sql_delete = "DELETE FROM posts WHERE id = $post_id";  

    // Mengeksekusi query untuk menghapus postingan
    if ($conn->query($sql_delete) === TRUE) {  // Jika penghapusan berhasil
        header("Location: admin_dashboard.php");  // Redirect ke dashboard admin setelah postingan dihapus
    } else {  // Jika terjadi error saat eksekusi query
        echo "Error: " . $conn->error;  // Menampilkan pesan error
    }
}
?>
