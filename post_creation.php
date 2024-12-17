<?php
include 'config.php'; // Memasukkan file konfigurasi database untuk menghubungkan ke database

// Proses upload gambar
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['image'])) { // Mengecek apakah request adalah POST dan ada file gambar yang di-upload
    $image = $_FILES['image']; // Menyimpan informasi file yang di-upload dalam variabel $image
    $target_directory = "uploads"; // Direktori tujuan untuk menyimpan gambar yang di-upload
    $target_file = $target_directory . basename($image['name']); // Menentukan nama file yang akan disimpan di server
    $image_file_type = strtolower(pathinfo($target_file, PATHINFO_EXTENSION)); // Mendapatkan ekstensi file dan mengubahnya menjadi huruf kecil

    // Validasi file gambar (misal, hanya file gambar yang diizinkan)
    if (in_array($image_file_type, ['jpg', 'jpeg', 'png', 'gif'])) { // Mengecek apakah ekstensi file adalah salah satu dari yang diperbolehkan
        if (move_uploaded_file($image['tmp_name'], $target_file)) { // Memindahkan file dari temporary directory ke direktori tujuan
            // Jika gambar berhasil di-upload, simpan path-nya ke database
            $title = $_POST['title']; // Mengambil judul postingan dari form
            $content = $_POST['content']; // Mengambil konten postingan dari form
            $author_id = $_SESSION['user_id']; // Mengambil ID penulis dari sesi (pengguna yang sedang login)
            $sql_insert = "INSERT INTO posts (title, content, author_id, image_path) VALUES (?, ?, ?, ?)"; // Query untuk menyimpan postingan ke dalam database
            $stmt = $conn->prepare($sql_insert); // Menyiapkan query untuk eksekusi
            $stmt->bind_param("ssis", $title, $content, $author_id, $target_file); // Mengikat parameter untuk query (title, content, author_id, image_path)
            $stmt->execute(); // Menjalankan query untuk menyimpan data ke database
            $stmt->close(); // Menutup statement setelah selesai

            header("Location: user_dashboard.php"); // Mengarahkan pengguna ke halaman dashboard setelah berhasil menambahkan postingan
            exit(); // Menghentikan eksekusi lebih lanjut
        } else {
            $_SESSION['message'] = "Gagal meng-upload gambar!"; // Menyimpan pesan error jika gambar gagal di-upload
        }
    } else {
        $_SESSION['message'] = "Hanya gambar yang diperbolehkan!"; // Menyimpan pesan error jika file yang di-upload bukan gambar
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8"> <!-- Menentukan encoding karakter untuk halaman web -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> <!-- Pengaturan untuk memastikan halaman responsif di perangkat mobile -->
    <title>Tambah Postingan</title> <!-- Judul halaman -->
</head>
<body>
    <form action="post_creation.php" method="POST" enctype="multipart/form-data"> <!-- Form untuk membuat postingan baru, dengan enctype untuk upload file -->
        <input type="text" name="title" placeholder="Judul Postingan" required><br> <!-- Input untuk judul postingan -->
        <textarea name="content" placeholder="Konten Postingan" required></textarea><br> <!-- Textarea untuk konten postingan -->
        <input type="file" name="image" accept="image/*"><br> <!-- Input untuk memilih gambar, hanya menerima file gambar -->
        <button type="submit">Tambah Postingan</button> <!-- Tombol untuk mengirim form -->
    </form>
</body>
</html>
