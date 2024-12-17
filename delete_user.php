<?php
session_start();  // Memulai sesi untuk melacak status login pengguna
include 'config.php';  // Meng-include file koneksi database (pastikan file koneksi ada dan benar)

// Cek apakah user yang sedang login adalah admin
if ($_SESSION['role'] !== 'admin') {  // Mengecek apakah nilai role pengguna adalah admin
    header("Location: login.php");  // Jika bukan admin, arahkan ke halaman login
    exit();  // Menghentikan eksekusi lebih lanjut
}

// Mengecek apakah parameter 'id' ada di URL (GET)
if (isset($_GET['id'])) {  
    $user_id = $_GET['id'];  // Menyimpan nilai ID pengguna yang ingin dihapus

    // Mengecek apakah permintaan untuk menghapus sudah diberikan (POST)
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {  
        // Query untuk menghapus pengguna berdasarkan ID yang diterima
        $sql_delete = "DELETE FROM users WHERE id = $user_id";  

        // Mengeksekusi query untuk menghapus pengguna
        if ($conn->query($sql_delete) === TRUE) {  // Jika penghapusan berhasil
            header("Location: admin_dashboard.php");  // Redirect ke dashboard admin setelah pengguna dihapus
            exit();  // Menghentikan eksekusi lebih lanjut
        } else {  // Jika terjadi error saat eksekusi query
            echo "Error: " . $conn->error;  // Menampilkan pesan error
        }
    }
} else {
    // Jika ID pengguna tidak ada, arahkan kembali ke dashboard admin
    header("Location: admin_dashboard.php");
    exit();  // Menghentikan eksekusi lebih lanjut
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hapus Pengguna</title>
    <script>
        // Konfirmasi penghapusan sebelum melanjutkan
        function confirmDelete() {
            return confirm("Apakah Anda yakin ingin menghapus pengguna ini?");
        }
    </script>
</head>
<body>
    <h3>Hapus Pengguna</h3>
    <p>Apakah Anda yakin ingin menghapus pengguna ini?</p>
    
    <!-- Form penghapusan dengan konfirmasi JavaScript -->
    <form method="POST" onsubmit="return confirmDelete();">
        <button type="submit" class="btn btn-danger">Hapus Pengguna</button>
        <a href="admin_dashboard.php" class="btn btn-secondary">Batal</a> <!-- Link untuk batal -->
    </form>
</body>
</html>
