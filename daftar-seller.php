<?php

// Jika sesi pengguna sudah aktif, arahkan ke halaman lain
if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
    // Ganti 'index.php' dengan halaman tujuan jika pengguna sudah login
    header("Location: index.php");
    exit;
}
?>
<div class="login">
    <div class="container d-flex justify-content-center">
        <div class="container-login mb-4" style="width: 500px; grid-template-columns: repeat(1, 1fr)">
            <div class="form-login">
                <div class="fs-2">
                    Daftar Seller
                </div>
                <form action="action-seller.php" method="POST">
                    <div class="my-3">
                        <div class="input-box">
                            <i class="fa-solid fa-user"></i>
                            <input type="text" name="username" placeholder="Username" required>
                        </div>
                        <div class="input-box">
                            <i class="fa-solid fa-envelope"></i>
                            <input type="email" name="email" placeholder="Email" required>
                        </div>
                        <div class="input-box">
                        <i class="fa-solid fa-store"></i>
                            <input type="text" name="toko" placeholder="Nama Toko" required>
                        </div>
                        <div class="input-box">
                            <i class="fa-solid fa-lock"></i>
                            <input type="password" name="password" placeholder="Password" required>
                        </div>
                        <div class="input-box">
                            <i class="fa-solid fa-lock"></i>
                            <input type="password" name="confirm_password" placeholder="Konfirmasi Password" required>
                        </div>
                    </div>
                    <button type="submit" class="w-100 rounded btn-second d-flex justify-content-center mt-5 mb-3 py-2">Daftar</button>
                </form>
                <div class="text-center">Alredy have account? <a href="index.php?page=login" class="text-second">Sign In</a></div>
            </div>
        </div>
    </div>
</div>
