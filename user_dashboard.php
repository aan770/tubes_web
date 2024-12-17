<?php
session_start(); // Memulai sesi PHP untuk menyimpan data pengguna yang login
include 'config.php'; // Memasukkan file konfigurasi database

// Cek apakah pengguna sudah login dan role-nya adalah 'user'
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'user') {
    header("Location: login.php"); // Jika bukan user, redirect ke halaman login
    exit(); // Menghentikan eksekusi script
}

// Ambil data pengguna yang sedang login
$user_id = $_SESSION['user_id']; // Mengambil ID pengguna dari sesi
$sql = "SELECT * FROM users WHERE id = ?"; // Query untuk mendapatkan data pengguna berdasarkan ID
$stmt = $conn->prepare($sql); // Menyiapkan statement SQL
$stmt->bind_param("i", $user_id); // Mengikat parameter ID pengguna ke query
$stmt->execute(); // Menjalankan query
$result = $stmt->get_result(); // Mengambil hasil query
$user = $result->fetch_assoc(); // Mengambil data pengguna dalam bentuk array asosiatif
$stmt->close(); // Menutup statement

// Ambil postingan yang diunggah oleh admin
$sql_admin_posts = "SELECT p.*, u.username AS author_name 
                    FROM posts p 
                    JOIN users u ON p.author_id = u.id 
                    WHERE u.role = 'admin'"; // Query untuk mendapatkan postingan milik admin
$posts_result = $conn->query($sql_admin_posts); // Menjalankan query dan menyimpan hasilnya

// Proses pembaruan profil jika form dikirim
if ($_SERVER['REQUEST_METHOD'] === 'POST') { // Mengecek apakah metode request adalah POST
    $username = $_POST['username']; // Mengambil input username dari form
    // Mengecek apakah password diisi, jika tidak, gunakan password lama
    $password = $_POST['password'] ? password_hash($_POST['password'], PASSWORD_DEFAULT) : $user['password'];

    // Query untuk mengupdate data pengguna
    $sql_update = "UPDATE users SET username = ?, password = ? WHERE id = ?";
    $stmt_update = $conn->prepare($sql_update); // Menyiapkan statement SQL
    $stmt_update->bind_param("ssi", $username, $password, $user_id); // Mengikat parameter ke query

    // Mengeksekusi query update
    if ($stmt_update->execute()) {
        $_SESSION['message'] = "Profil berhasil diperbarui!"; // Set pesan sukses ke sesi
        header("Location: user_dashboard.php"); // Redirect kembali ke dashboard
        exit();
    } else {
        $_SESSION['message'] = "Error: " . $stmt_update->error; // Set pesan error jika gagal
    }
    $stmt_update->close(); // Menutup statement update
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8"> <!-- Menentukan encoding karakter -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> <!-- Agar responsif di perangkat mobile -->
    <title>User Dashboard</title> <!-- Judul halaman -->
    <!-- Menggunakan CDN Bootstrap untuk gaya tampilan -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css">
</head>
<body>
    <!-- Navbar untuk navigasi -->
    <nav class="navbar navbar-expand-lg navbar-light" style="background-color: #004085;">
        <a class="navbar-brand text-white" href="#">User Dashboard</a> <!-- Nama dashboard -->
        <a href="logout.php" class="btn btn-danger" onclick="return confirmLogout();">Logout</a>
        <!-- Tombol logout -->
    </nav>

    <div class="container-fluid mt-5"> <!-- Container utama dengan margin atas, menggunakan container-fluid -->
        <!-- Tampilkan pesan jika ada di sesi -->
        <?php if (isset($_SESSION['message'])) { ?>
            <div class="alert alert-info" role="alert">
                <?= $_SESSION['message'] ?> <!-- Menampilkan pesan dari sesi -->
            </div>
            <?php unset($_SESSION['message']); ?> <!-- Menghapus pesan setelah ditampilkan -->
        <?php } ?>

        <!-- Form Edit Profil -->
        <h2>Edit Profil</h2>
        <form action="user_dashboard.php" method="POST"> <!-- Form dengan metode POST -->
            <div class="row mb-3"> <!-- Row untuk input form -->
                <div class="col-md-6"> <!-- Kolom untuk username -->
                    <label for="username" class="form-label">Username</label>
                    <input type="text" class="form-control" id="username" name="username" value="<?= htmlspecialchars($user['username']) ?>" required>
                </div>
                <div class="col-md-6"> <!-- Kolom untuk password -->
                    <label for="password" class="form-label">Password (Kosongkan jika tidak ingin mengubah)</label>
                    <input type="password" class="form-control" id="password" name="password">
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Perbarui Profil</button> <!-- Tombol submit -->
        </form>

        <!-- Daftar Postingan Admin -->
        <h2 class="mt-5">Postingan dari Admin</h2>
        <?php if ($posts_result->num_rows > 0) { ?> <!-- Cek apakah ada postingan -->
            <table class="table table-striped"> <!-- Tabel Bootstrap -->
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Judul</th>
                        <th>Konten</th>
                        <th>Gambar</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($post = $posts_result->fetch_assoc()) { ?> <!-- Looping data postingan -->
                        <tr>
                            <td><?= $post['id'] ?></td> <!-- Menampilkan ID postingan -->
                            <td><?= htmlspecialchars($post['title']) ?></td> <!-- Menampilkan judul postingan -->
                            <!-- Menampilkan seluruh konten -->
                            <td><?= nl2br(htmlspecialchars($post['content'])) ?></td> <!-- Menampilkan konten dengan format baris baru jika ada -->
                            <td>
                                <?php if ($post['image']) { ?>
                                    <!-- Menampilkan gambar postingan -->
                                    <img src="uploads/<?= htmlspecialchars($post['image']) ?>" alt="Image" class="img-fluid" style="max-width: 150px; height: auto;">
                                <?php } else { ?>
                                    No Image
                                <?php } ?>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        <?php } else { ?> <!-- Jika tidak ada postingan -->
            <p>Tidak ada postingan yang diunggah oleh admin.</p>
        <?php } ?>
    </div>

    <script>
    function confirmLogout() {
        return confirm("Apakah Anda yakin ingin logout?");
    }
</script>

    <!-- Script Bootstrap untuk fungsi interaktif -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</body>
</html>
