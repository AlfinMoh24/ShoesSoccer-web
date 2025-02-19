<?php
session_start(); // Memulai sesi

// Menghapus semua data sesi
session_unset(); // Menghapus semua variabel sesi
session_destroy(); // Menghancurkan sesi

// Mengarahkan ke halaman login setelah logout dengan query string
header("Location: index.php?logout=true");
exit;
?>
