<?php
session_start();  // Memulai sesi untuk melacak status login pengguna
include 'config.php';  // Meng-include file koneksi database

// Pastikan hanya admin yang bisa mengakses halaman ini
if ($_SESSION['role'] !== 'admin') {  // Mengecek apakah pengguna yang login adalah admin
    header("Location: ../login.php");  // Jika bukan admin, arahkan ke halaman login
    exit();  // Menghentikan eksekusi lebih lanjut
}

// Tampilkan daftar pengguna dari database
$sql = "SELECT * FROM users";  // Query untuk mengambil semua data pengguna
$result = $conn->query($sql);  // Eksekusi query dan simpan hasilnya

// Tampilkan daftar postingan dari database
$sql_posts = "SELECT * FROM posts";  // Query untuk mengambil semua data postingan
$posts_result = $conn->query($sql_posts);  // Eksekusi query dan simpan hasilnya

// Menghapus pengguna jika form penghapusan dikirim
if (isset($_POST['delete_user_id'])) {  // Mengecek apakah form penghapusan pengguna sudah dikirim
    $user_id_to_delete = $_POST['delete_user_id'];  // Mendapatkan ID pengguna yang ingin dihapus

    // Menghapus pengguna dari database
    $sql_delete_user = "DELETE FROM users WHERE id = $user_id_to_delete";  // Query untuk menghapus pengguna
    if ($conn->query($sql_delete_user) === TRUE) {  // Eksekusi query, jika berhasil
        $_SESSION['message'] = "Pengguna berhasil dihapus!";  // Set pesan sukses
    } else {  // Jika terjadi error
        $_SESSION['message'] = "Error: " . $conn->error;  // Set pesan error
    }
}

// Menghapus postingan jika form penghapusan dikirim
if (isset($_POST['delete_post_id'])) {  // Mengecek apakah form penghapusan postingan sudah dikirim
    $post_id_to_delete = $_POST['delete_post_id'];  // Mendapatkan ID postingan yang ingin dihapus

    // Menghapus postingan dari database
    $sql_delete_post = "DELETE FROM posts WHERE id = $post_id_to_delete";  // Query untuk menghapus postingan
    if ($conn->query($sql_delete_post) === TRUE) {  // Eksekusi query, jika berhasil
        $_SESSION['message'] = "Postingan berhasil dihapus!";  // Set pesan sukses
    } else {  // Jika terjadi error
        $_SESSION['message'] = "Error: " . $conn->error;  // Set pesan error
    }
}

// Ambil pesan session jika ada dan hapus setelah ditampilkan
$message = isset($_SESSION['message']) ? $_SESSION['message'] : '';  // Mendapatkan pesan dari session
unset($_SESSION['message']);  // Menghapus pesan setelah ditampilkan
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css">  <!-- Menghubungkan Bootstrap untuk styling -->
</head>
<body>
    <!-- Navbar dengan background warna biru dan tombol logout -->
    <nav class="navbar navbar-expand-lg navbar-light" style="background-color: #004085;">
        <a class="navbar-brand" href="#">Admin Dashboard</a>
        <a href="logout.php" class="btn btn-danger" onclick="return confirmLogout();">Logout</a>  <!-- Tombol logout -->
    </nav>

    <div class="container mt-5">
        <!-- Tampilkan pesan jika ada -->
        <?php if ($message) { ?>  <!-- Mengecek jika ada pesan -->
            <div class="alert alert-info" role="alert">
                <?= $message ?>  <!-- Menampilkan pesan -->
            </div>
        <?php } ?>

        <h2>Daftar Pengguna</h2>
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Username</th>
                        <th>Role</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()) { ?>  <!-- Menampilkan setiap pengguna dalam tabel -->
                        <tr>
                            <td><?= $row['id'] ?></td>  <!-- Menampilkan ID pengguna -->
                            <td><?= $row['username'] ?></td>  <!-- Menampilkan username -->
                            <td><?= ucfirst($row['role']) ?></td>  <!-- Menampilkan role pengguna dengan format kapital pertama -->
                            <td>
                                <a href="edit_user.php?id=<?= $row['id'] ?>" class="btn btn-warning btn-sm">Edit</a>  <!-- Tombol Edit pengguna -->
                                <!-- Form penghapusan pengguna -->
                                <form action="" method="POST" style="display:inline;">
                                    <input type="hidden" name="delete_user_id" value="<?= $row['id'] ?>">  <!-- ID pengguna yang akan dihapus -->
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus pengguna ini?')">Hapus</button>  <!-- Tombol hapus dengan konfirmasi -->
                                </form>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>

        <h2>Daftar Postingan</h2>
        <a href="create_post.php" class="btn btn-primary mb-3">Tambah Postingan</a>  <!-- Tombol untuk menambah postingan -->
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Judul</th>
                        <th>Konten</th>
                        <th>Gambar</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($post = $posts_result->fetch_assoc()) { ?>  <!-- Menampilkan setiap postingan dalam tabel -->
                        <tr>
                            <td><?= $post['id'] ?></td>  <!-- Menampilkan ID postingan -->
                            <td><?= $post['title'] ?></td>  <!-- Menampilkan judul postingan -->
                            <td><?= substr($post['content'], 0, 50) . '...' ?></td>  <!-- Menampilkan sebagian konten postingan -->
                            <td>
                                <?php if ($post['image']) { ?>  <!-- Mengecek apakah ada gambar -->
                                    <!-- Tampilkan gambar dengan ukuran lebih besar -->
                                    <img src="uploads/<?= htmlspecialchars($post['image']) ?>" alt="Image" style="width: 200px; height: auto;">
                                <?php } else { ?>
                                    No Image  <!-- Menampilkan teks jika tidak ada gambar -->
                                <?php } ?>
                            </td>
                            <td>
                                <a href="edit_post.php?id=<?= $post['id'] ?>" class="btn btn-warning btn-sm">Edit</a>  <!-- Tombol Edit postingan -->
                                <!-- Form penghapusan postingan -->
                                <form action="" method="POST" style="display:inline;">
                                    <input type="hidden" name="delete_post_id" value="<?= $post['id'] ?>">  <!-- ID postingan yang akan dihapus -->
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus postingan ini?')">Hapus</button>  <!-- Tombol hapus dengan konfirmasi -->
                                </form>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>

    <script>
    // Fungsi konfirmasi untuk logout
    function confirmLogout() {
        return confirm("Apakah Anda yakin ingin logout?");
    }
</script>
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>  <!-- Menghubungkan Bootstrap JS -->
</body>
</html>
