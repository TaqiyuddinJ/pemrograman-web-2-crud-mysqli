<?php
$host     = "localhost";
$username = "root";
$password = ""; //
$database = "tugas_crud_db";

// 1. Membuat objek koneksi dari class mysqli
$conn = new mysqli($host, $username, $password, $database);

// 2. Memeriksa apakah koneksi berhasil atau gagal
if ($conn->connect_error) {
    // Tampilkan pesan error jika koneksi gagal
    die("Koneksi ke database gagal: " . $conn->connect_error);
}

// Koneksi berhasil, siap digunakan di berkas lain
?>