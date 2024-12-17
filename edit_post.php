<?php
session_start(); // Memulai sesi untuk mengakses data sesi pengguna
include 'config.php'; // Meng-include file koneksi ke database

// Pastikan pengguna login sebagai admin, jika tidak redirect ke halaman login
if ($_SESSION['role'] !== 'admin') {
    header("Location: login.php"); // Redirect ke halaman login jika bukan admin
    exit(); // Menghentikan eksekusi script jika bukan admin
}

// Ambil ID dari URL menggunakan parameter 'id'
if (isset($_GET['id'])) {
    $post_id = $_GET['id']; // Menyimpan ID postingan yang akan diedit

    // Ambil data postingan berdasarkan ID yang diambil dari URL
    $sql = "SELECT * FROM posts WHERE id = $post_id";
    $result = $conn->query($sql); // Menjalankan query untuk mengambil data
    $post = $result->fetch_assoc(); // Mengambil data postingan sebagai array asosiasi

    // Proses ketika form disubmit (POST)
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $title = $_POST['title']; // Menyimpan judul yang di-input oleh admin
        $content = $_POST['content']; // Menyimpan konten yang di-input oleh admin
        $image = $post['image']; // Menyimpan gambar lama sebagai default

        // Cek jika ada gambar baru yang di-upload oleh admin
        if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
            $file_name = $_FILES['image']['name']; // Nama file gambar baru
            $file_tmp = $_FILES['image']['tmp_name']; // Lokasi sementara file gambar
            $target_dir = "uploads/"; // Direktori untuk menyimpan gambar
            $target_file = $target_dir . basename($file_name); // Lokasi tujuan file gambar yang di-upload

            // Pindahkan gambar yang di-upload ke folder tujuan
            if (move_uploaded_file($file_tmp, $target_file)) {
                $image = $file_name; // Jika berhasil, update nama file gambar yang akan disimpan
            } else {
                echo "Gagal meng-upload gambar."; // Menampilkan pesan error jika gagal upload
            }
        }

        // Query untuk update data postingan berdasarkan ID
        $sql_update = "UPDATE posts SET title = '$title', content = '$content', image = '$image' WHERE id = $post_id";
        if ($conn->query($sql_update) === TRUE) {
            $_SESSION['message'] = "Postingan berhasil diupdate!"; // Set pesan sukses
            header("Location: admin_dashboard.php"); // Redirect ke dashboard admin setelah update berhasil
            exit(); // Menghentikan eksekusi setelah redirect
        } else {
            echo "Error: " . $conn->error; // Menampilkan error jika query update gagal
        }
    }
} else {
    header("Location: admin_dashboard.php"); // Redirect jika ID tidak ditemukan di URL
    exit(); // Menghentikan eksekusi
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8"> <!-- Set charset untuk memastikan karakter yang benar -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> <!-- Set viewport untuk tampilan responsif -->
    <title>Edit Postingan</title> <!-- Judul halaman -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css"> <!-- Meng-include Bootstrap CSS -->
    <style>
        /* Styling tambahan untuk halaman */
        body {
            background-color: #f8f9fa; /* Warna latar belakang halaman */
        }
        .container {
            max-width: 800px; /* Menentukan lebar maksimum form */
            margin-top: 20px; /* Jarak dari atas halaman */
            background-color: #ffffff; /* Warna latar belakang form */
            padding: 30px; /* Padding dalam form */
            border-radius: 8px; /* Membulatkan sudut form */
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1); /* Memberikan efek bayangan */
        }
        h2 {
            margin-bottom: 30px; /* Jarak bawah untuk heading */
        }
        form label {
            font-weight: bold; /* Menebalkan label input form */
        }
        form .mb-3 {
            margin-bottom: 15px; /* Jarak bawah untuk setiap elemen form */
        }
        form .btn {
            background-color: #0d6efd; /* Warna latar belakang tombol */
            border: none; /* Menghilangkan border tombol */
        }
        form .btn:hover {
            background-color: #0056b3; /* Warna tombol saat hover */
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Edit Postingan</h2>
        <!-- Menampilkan pesan jika ada -->
        <?php if (isset($_SESSION['message'])): ?>
            <div class="alert alert-success"><?= $_SESSION['message']; ?></div> <!-- Pesan sukses jika ada -->
            <?php unset($_SESSION['message']); endif; ?>
        
        <form method="POST" enctype="multipart/form-data">
            <!-- Input untuk judul postingan -->
            <div class="mb-3">
                <label for="title">Judul Postingan</label>
                <input type="text" class="form-control" id="title" name="title" value="<?= $post['title'] ?>" required>
            </div>

            <!-- Input untuk konten postingan -->
            <div class="mb-3">
                <label for="content">Konten Postingan</label>
                <textarea class="form-control" id="content" name="content" rows="5" required><?= $post['content'] ?></textarea>
            </div>

            <!-- Input untuk upload gambar baru -->
            <div class="mb-3">
                <label for="image">Upload Gambar Baru (opsional)</label>
                <input type="file" class="form-control" id="image" name="image" accept="image/*">
            </div>

            <!-- Menampilkan gambar lama jika ada -->
            <div class="mb-3">
                <img src="uploads/<?= $post['image'] ?>" alt="Gambar Postingan" style="width: 200px;">
            </div>

            <!-- Tombol untuk simpan perubahan -->
            <button type="submit" class="btn btn-primary w-100">Simpan Perubahan</button>
        </form>
        
        <!-- Tombol untuk kembali ke dashboard -->
        <a href="admin_dashboard.php" class="btn btn-secondary mt-3">Kembali ke Dashboard</a>
    </div>

    <!-- Meng-include Bootstrap JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</body>
</html>
