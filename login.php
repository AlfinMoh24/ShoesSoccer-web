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
        <div class="container-login">
            <div class="form-login">
                <div class="fs-2">
                    Sign In
                </div>
                <form action="action-login.php" method="POST">
                    <div class="my-3">
                        <div class="input-box">
                            <i class="fa-solid fa-envelope"></i>
                            <input type="text" name="username" placeholder="username" required>
                        </div>
                        <div class="input-box">
                            <i class="fa-solid fa-lock"></i>
                            <input type="password" name="password" placeholder="******" required>
                        </div>
                    </div>
                    <a href="" class="text-second fw-semibold">Forget Password?</a>
                    <button type="submit" class="w-100 rounded btn-second d-flex justify-content-center mt-5 mb-3 py-2">Sign in</button>
                </form>
                <div class="text-center">Don't have an account? <a href="index.php?page=signup" class="text-second">Sign Up</a></div>
            </div>
            <div class="login-cover">
                <div class="h-100 p-4 d-flex flex-column align-items-center justify-content-center">
                    <div class="fs-2 fw-bold text-light">SHOESSOCCER</div>
                    <div class="fs-6 fw-semibold text-light text-center">
                        Lorem ipsum dolor sit amet consectetur adipisicing elit.
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>