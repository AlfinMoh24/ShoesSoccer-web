<?php
// Konfigurasi database
$host = 'localhost';        // Nama host (misalnya: localhost)
$username = 'root';         // Nama pengguna database
$password = '';             // Kata sandi database
$database = 'shoes-soccer'; // Nama database

// Membuat koneksi
$conn = new mysqli($host, $username, $password, $database);

// Memeriksa koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
} else {
    // echo "Koneksi berhasil!";
}
