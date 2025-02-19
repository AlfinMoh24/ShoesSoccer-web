<?php
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    if ($password != $confirm_password) {
        die("Password dan konfirmasi password tidak cocok.");
    }

    $hashed_password = password_hash($password, PASSWORD_DEFAULT);


    try {
        // Query untuk menyimpan data
        $sql = "INSERT INTO users (username, email, password, level) VALUES (?, ?, ?, 'user')";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sss", $username, $email, $hashed_password);

        if ($stmt->execute()) {
            echo "<script>alert('Pendaftaran berhasil!');</script>";
            echo "<script>window.location.href = 'index.php?page=login';</script>";
        } else {
            echo "Gagal mendaftar: " . $stmt->error;
        }
    } catch (mysqli_sql_exception $e) {
        // Tangkap error duplicate entry
        if ($e->getCode() == 1062) { // 1062 adalah kode error untuk duplicate entry di MySQL
            echo "<script>alert('Username atau email sudah digunakan, silakan pilih yang lain.'); window.history.back();</script>";
        } else {
            // Tampilkan pesan error lain
            echo "Error: " . $e->getMessage();
        }
    }

    $stmt->close();
    $conn->close();
}
