<?php
session_start(); // Memulai sesi untuk mengakses data pengguna yang login
include 'config.php'; // Meng-include file koneksi ke database

// Pastikan hanya admin yang bisa mengakses halaman ini
if ($_SESSION['role'] !== 'admin') {
    header("Location: ../login.php"); // Redirect ke halaman login jika bukan admin
    exit(); // Menghentikan eksekusi script jika bukan admin
}

if (isset($_GET['id'])) { // Mengecek apakah ID pengguna ada di URL
    $user_id = $_GET['id']; // Menyimpan ID pengguna yang akan diedit

    // Ambil data pengguna berdasarkan ID
    $sql = "SELECT * FROM users WHERE id = $user_id"; // Query untuk mengambil data pengguna
    $result = $conn->query($sql); // Menjalankan query

    if ($result->num_rows > 0) { // Jika pengguna ditemukan
        $user = $result->fetch_assoc(); // Mengambil data pengguna sebagai array asosiasi
    } else {
        echo "Pengguna tidak ditemukan!"; // Jika pengguna tidak ditemukan, tampilkan pesan error
        exit(); // Menghentikan eksekusi jika pengguna tidak ada
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') { // Jika form disubmit dengan method POST
    // Ambil data dari form
    $username = $_POST['username']; // Menyimpan username yang diinput
    $role = $_POST['role']; // Menyimpan role yang diinput

    // Query untuk update data pengguna berdasarkan ID
    $sql_update = "UPDATE users SET username = ?, role = ? WHERE id = ?"; // Query update data pengguna
    $stmt = $conn->prepare($sql_update); // Menyiapkan query untuk di-execute
    $stmt->bind_param("ssi", $username, $role, $user_id); // Mengikat parameter pada query (string untuk username dan role, integer untuk id)

    if ($stmt->execute()) { // Jika update berhasil dieksekusi
        header("Location: admin_dashboard.php"); // Redirect ke dashboard admin
    } else {
        echo "Error: " . $conn->error; // Menampilkan pesan error jika query gagal
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8"> <!-- Set charset untuk memastikan karakter yang benar -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> <!-- Set viewport untuk tampilan responsif -->
    <title>Edit Pengguna</title> <!-- Judul halaman -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css"> <!-- Meng-include Bootstrap CSS untuk styling -->
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light" style="background-color: #004085;">
        <a class="navbar-brand" href="#">Admin Dashboard</a> <!-- Nama dashboard -->
        <a href="../logout.php" class="btn btn-danger">Logout</a> <!-- Tombol logout -->
    </nav>

    <div class="container mt-5">
        <h2>Edit Pengguna</h2> <!-- Judul halaman -->

        <!-- Form untuk mengedit data pengguna -->
        <form method="POST">
            <!-- Input untuk username pengguna -->
            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" class="form-control" id="username" name="username" value="<?= $user['username'] ?>" required>
            </div>

            <!-- Input untuk role pengguna -->
            <div class="mb-3">
                <label for="role" class="form-label">Role</label>
                <select class="form-select" id="role" name="role" required>
                    <!-- Pilihan role, default-nya yang terpilih adalah role pengguna saat ini -->
                    <option value="admin" <?= $user['role'] === 'admin' ? 'selected' : '' ?>>Admin</option>
                    <option value="user" <?= $user['role'] === 'user' ? 'selected' : '' ?>>User</option>
                </select>
            </div>

            <!-- Tombol untuk submit form dan tombol untuk kembali ke dashboard -->
            <div class="mb-3">
                <button type="submit" class="btn btn-primary">Update</button>
                <a href="admin_dashboard.php" class="btn btn-secondary">Kembali</a>
            </div>
        </form>
    </div>

</body>
</html>
