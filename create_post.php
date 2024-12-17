


<?php
session_start();  // Memulai sesi untuk melacak status login pengguna
include 'config.php';  // Meng-include file koneksi database

// Pastikan hanya admin yang bisa mengakses halaman ini
if ($_SESSION['role'] !== 'admin') {  // Mengecek apakah pengguna yang login adalah admin
    header("Location: ../login.php");  // Jika bukan admin, arahkan ke halaman login
    exit();  // Menghentikan eksekusi lebih lanjut
}

// Proses penambahan postingan baru
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_post'])) {  // Mengecek apakah form telah dikirim
    $title = $_POST['title'];  // Mendapatkan judul postingan dari form
    $content = $_POST['content'];  // Mendapatkan konten postingan dari form
    $image = $_FILES['image']['name'];  // Mendapatkan nama file gambar yang diunggah (jika ada)

    // Proses upload gambar (jika ada gambar yang diunggah)
    if ($image) {
        $target_dir = "uploads/";  // Direktori tujuan untuk menyimpan gambar
        $target_file = $target_dir . basename($image);  // Lokasi lengkap file gambar
        move_uploaded_file($_FILES['image']['tmp_name'], $target_file);  // Memindahkan file gambar dari sementara ke direktori tujuan
    }

    // Menyimpan postingan ke dalam database
    $sql_post = "INSERT INTO posts (title, content, author_id, image) VALUES (?, ?, ?, ?)";  // Query untuk menyimpan postingan
    $stmt_post = $conn->prepare($sql_post);  // Menyiapkan query untuk dieksekusi dengan parameter
    $stmt_post->bind_param("ssis", $title, $content, $_SESSION['user_id'], $image);  // Mengikat parameter untuk query (title, content, author_id, image)
    if ($stmt_post->execute()) {  // Eksekusi query, jika berhasil
        $_SESSION['message'] = "Postingan berhasil ditambahkan!";  // Set pesan sukses
        header("Location: admin_dashboard.php");  // Redirect ke dashboard admin setelah berhasil
        exit();
    } else {  // Jika terjadi error
        $_SESSION['message'] = "Error: " . $stmt_post->error;  // Set pesan error
    }
    $stmt_post->close();  // Menutup statement setelah eksekusi
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Postingan</title>
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
        <?php if (isset($_SESSION['message'])) { ?>  <!-- Mengecek apakah ada pesan di session -->
            <div class="alert alert-info" role="alert">
                <?= $_SESSION['message'] ?>  <!-- Menampilkan pesan -->
            </div>
            <?php unset($_SESSION['message']); ?>  <!-- Menghapus pesan setelah ditampilkan -->
        <?php } ?>

        <h2>Tambah Postingan</h2>
        <form action="create_post.php" method="POST" enctype="multipart/form-data">  <!-- Form untuk menambah postingan, termasuk input gambar -->
            <div class="mb-3">
                <label for="title" class="form-label">Judul</label>
                <input type="text" class="form-control" name="title" required>  <!-- Input untuk judul -->
            </div>
            <div class="mb-3">
                <label for="content" class="form-label">Konten</label>
                <textarea class="form-control" name="content" required></textarea>  <!-- Textarea untuk konten -->
            </div>
            <div class="mb-3">
                <label for="image" class="form-label">Gambar (opsional)</label>
                <input type="file" class="form-control" name="image">  <!-- Input file untuk gambar -->
            </div>
            <button type="submit" class="btn btn-primary" name="add_post">Tambah Postingan</button>  <!-- Tombol untuk submit form -->
        </form>

        <!-- Tombol Kembali ke Dashboard -->
        <a href="admin_dashboard.php" class="btn btn-secondary mt-3">Kembali ke Dashboard</a>  <!-- Tombol kembali ke dashboard -->
    </div>

    <script>
    // Fungsi konfirmasi untuk logout
    function confirmLogout() {
        return confirm("Apakah Anda yakin ingin logout?");  // Konfirmasi logout
    }
</script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>  <!-- Menghubungkan Bootstrap JS -->
</body>
</html>
