<?php
session_start();

// Koneksi ke database
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil data dari form
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Query untuk mendapatkan pengguna berdasarkan username
    $sql = "SELECT id, username, password, level FROM users WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    // Jika pengguna ditemukan
    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();

        // Verifikasi password
        if (password_verify($password, $user['password'])) {
            $_SESSION['logged_in'] = true;
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['level'] = $user['level'];

            if ($user['level'] === 'admin' || $user['level'] === 'seller') {
                header("Location: admin/index.php");
            } elseif ($user['level'] === 'user') {
                header("Location: user/index.php");
            } else {
                header("Location: index.php"); // Default redirect untuk level lain
            }
            exit;
        } else {
            echo "<script>alert('Password salah!'); window.location.href='index.php?page=login';</script>";
        }
    } else {
        echo "<script>alert('Username tidak ditemukan!'); window.location.href='index.php?page=login';</script>";
    }

    $stmt->close();
    $conn->close();
}
