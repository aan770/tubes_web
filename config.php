<?php
// Informasi koneksi database
$servername = "localhost"; // Server database, biasanya 'localhost' atau IP server
$username = "root";        // Username untuk mengakses database
$password = "";            // Password untuk mengakses database (kosong untuk root di lokal)
$dbname = "ukm_bulutangkis"; // Nama database yang digunakan

// Membuat koneksi ke database menggunakan MySQLi
$conn = new mysqli($servername, $username, $password, $dbname);

// Memeriksa apakah koneksi berhasil
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error); // Menampilkan pesan jika koneksi gagal
}
?>
