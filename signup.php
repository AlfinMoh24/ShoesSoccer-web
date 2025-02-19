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
        <div class="container-login mb-4">
            <!-- login left -->
            <div class="login-cover">
                <div class="h-100 p-4 d-flex flex-column align-items-center justify-content-center">
                    <div class="fs-2 fw-bold text-light">
                        SHOESSOCCER
                    </div>
                    <div class="fs-6 fw-semibold text-light text-center">
                        Lorem ipsum dolor sit amet consectetur adipisicing elit.
                    </div>
                </div>
            </div>
            <!-- form sign up -->
            <div class="form-login">
                <div class="fs-2">
                    Sign Up
                </div>
                <form action="action-signup.php" method="POST">
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
                            <i class="fa-solid fa-lock"></i>
                            <input type="password" name="password" placeholder="Password" required>
                        </div>
                        <div class="input-box">
                            <i class="fa-solid fa-lock"></i>
                            <input type="password" name="confirm_password" placeholder="Konfirmasi Password" required>
                        </div>
                    </div>
                    <button type="submit" class="w-100 rounded btn-second d-flex justify-content-center mt-5 mb-3 py-2">Sign Up</button>
                </form>
                <div class="text-center">Alredy have account? <a href="index.php?page=login" class="text-second">Sign In</a></div>
            </div>
        </div>
    </div>
</div>
