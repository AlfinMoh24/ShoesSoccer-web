<?php
include '../config.php';

session_start();

if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: ../index.php");
    exit;
}

if ($_SESSION['level'] !== 'user') {
    header("Location: ../index.php");
    exit;
}

$page = isset($_GET['page']) ? $_GET['page'] : 'preferences';

$user_id = $_SESSION['user_id'];

$keranjang = "SELECT * FROM cart WHERE user_id = $user_id";
$cart = $conn->query($keranjang);

$transaksi = "SELECT * FROM transaksi WHERE user_id = $user_id AND status = 'Belum Dibayar'";
$tran = $conn->query($transaksi);
?>

<!DOCTYPE html>
<html lang="en" data-bs-theme="light">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>ShoesSoccer</title>
    <!-- fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">
    <!-- css -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <link rel="stylesheet" href="../assets/css/style.css">
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.10.5/dist/cdn.min.js" defer></script>
    <style>
        .dropdown-menu[data-bs-popper] {
            left: auto !important;
            right: 0px !important;
            margin-top: 10px;
        }

        .btn-check {
            display: none;
        }

        /* Warna tombol saat dipilih */
        .btn-outline-dark:checked+.btn {
            background-color: #343a40;
            color: #fff;
            border-color: #343a40;
        }

        /* Warna tombol saat hover */
        .btn-outline-dark:hover {
            background-color: #343a40 !important;
            color: #fff !important;
            border-color: #343a40;
        }

        .btn:disabled {
            color: white;
        }

        .offcanvas.offcanvas-end {
            width: 300px !important;
        }
    </style>
    <script type="text/javascript"
        src="https://app.sandbox.midtrans.com/snap/snap.js"
        data-client-key="SB-Mid-client-fLxxY8JcCqDRS2zv"></script>
</head>

<body>
    <!-- Header Navbar -->
    <nav class="navbar navbar-expand-lg fixed-top" style="border-bottom: 1px solid #e6e7e8;">
        <div class="container-fluid">
            <a class="navbar-brand fs-4 fw-bold" href="index.php?page=home"><span class="text-second">SHOES</span>SOCCER</a>
            <!-- Toggler for mobile -->
            <div class="navbar-toggler">
                <div class="d-flex">
                    <div class="search-shoes bg-prime rounded-pill py-2 px-3">
                        <form class="d-flex" x-data="{ open: false }" action="search-recommendation.php" method="POST">
                            <!-- Input Search -->
                            <input
                                type="text"
                                name="search-oi"
                                class="bg-prime"
                                placeholder="Cari Sepatu..."
                                aria-label="Search"
                                style="display: none;"
                                x-show="open"
                                x-transition />

                            <!-- Toggle Button -->
                            <button
                                type="submit"
                                x-show="open"
                                x-transition>
                                <i class="bi bi-search fw-bold"></i>
                                &nbsp;&nbsp;&nbsp;
                            </button>
                            <!-- Toggle Button -->
                            <button
                                type="button"
                                @click="open = !open"
                                aria-expanded="false">
                                <!-- Search Icon -->
                                <i class="bi bi-search fw-bold" x-show="!open"></i>
                                <!-- Close Icon -->
                                <i class="fa-solid fa-xmark" x-show="open"></i>
                            </button>
                        </form>
                    </div>
                    <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas"
                        data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                </div>
            </div>
            <!-- Navbar content for larger screens -->
            <div class="collapse navbar-collapse text-prime fw-semibold" id="navbarNav">
                <ul class="navbar-nav ms-auto fs-7">
                    <li class="nav-item bg-prime py-2 px-3 me-3" style="width:35vw; border-radius:15px">
                        <form class="d-flex" action="search-recommendation.php" method="POST">
                            <i class="bi bi-search fw-bold me-3"></i>
                            <input type="text" class="bg-prime w-100"
                            placeholder="Cari Sepatu..." name="search-oi" id="" aria-label="Search">
                        </form>
                        
                    </li>
                    <li class="nav-item px-2">
                        <a class="nav-link" href="index.php?page=home#">Home</a>
                    </li>
                    <li class="nav-item px-2">
                        <a class="nav-link" href="index.php?page=home#produk">Shoes</a>
                    </li>
                    <li class="nav-item px-2">
                        <a class="nav-link" href="index.php?page=home#kontak">Kontak</a>
                    </li>
                    <li class="nav-item px-2">
                        <a class="nav-link" href="index.php?page=home#faq">Faq</a>
                    </li>

                    <li class="d-flex gap-2">
                        <button class="btn-outline-second rounded-pill fs-8 px-3 ms-2" onclick="window.location.href='index.php?page=cart'"><i class="fa-solid fa-cart-shopping"></i>
                            <?php if ($cart->num_rows > 0): ?>
                                <span class="notif-jumlah"><?php echo $cart->num_rows ?></span>
                            <?php endif ?>
                        </button>
                        <!-- <button class="btn-outline-second rounded-pill fs-8 px-4" data-bs-toggle="modal" data-bs-target="#logoutModal"> Logout</button> -->
                        <div class="dropdown ">
                            <button class="btn-second rounded-pill rounded-pill fs-8 px-3 no-arrow dropdown-toggle  h-100" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fas fa-user"></i>
                                <?php if ($tran->num_rows > 0): ?>
                                    <span class="notif-jumlah-2"><?php echo $tran->num_rows ?></span>
                                <?php endif ?>
                            </button>
                            <ul class="dropdown-menu ">
                                <li>
                                    <a href="index.php?page=transaksi" class="dropdown-item d-flex justify-content-end fs-7" href="#">
                                        <?php if ($tran->num_rows > 0): ?>
                                            <span class="notif-jumlah-3"><?php echo $tran->num_rows ?></span>
                                        <?php endif ?>
                                        Pesanan Saya
                                    </a>
                                </li>
                                <li>
                                    <a href="index.php?page=preferences" class="dropdown-item d-flex justify-content-end fs-7" href="#">
                                        Preferences
                                    </a>
                                </li>
                                <li><button class="dropdown-item d-flex justify-content-end fs-7" data-bs-toggle="modal" data-bs-target="#logoutModal">Logout</button></li>
                            </ul>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Offcanvas sidebar for mobile -->
    <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="offcanvasNavbarLabel">Menu</h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <ul class="navbar-nav">
                <li class="nav-item py-2">
                    <a class="nav-link active" href="index.php?page=home#">Home</a>
                </li>
                <li class="nav-item py-2">
                    <a class="nav-link" href="index.php?page=home#produk">Shoes</a>
                </li>
                <li class="nav-item py-2">
                    <a class="nav-link" href="index.php?page=home#kontak">Kontak</a>
                </li>
                <li class="nav-item py-2">
                    <a class="nav-link" href="index.php?page=home#faq">Faq</a>
                </li>
                <li class="nav-item py-2">
                    <a class="nav-link" href="index.php?page=cart">
                        <div class="d-flex justify-content-between">
                            Keranjang
                            <?php if ($cart->num_rows > 0): ?>
                                <span class="notif-jumlah-3"><?php echo $cart->num_rows ?></span>
                            <?php endif ?>
                        </div>
                    </a>
                </li>
                <li class="nav-item py-2">
                    <a class="nav-link" href="index.php?page=transaksi">
                        <div class="d-flex justify-content-between">
                            Pesanan Saya
                            <?php if ($tran->num_rows > 0): ?>
                                <span class="notif-jumlah-3"><?php echo $tran->num_rows ?></span>
                            <?php endif ?>
                        </div>
                    </a>
                </li>
                <li class="nav-item py-2">
                    <a class="nav-link" href="index.php?page=preferences">
                        Preferences
                    </a>
                </li>
                <li class="nav-item py-2">
                    <button class="nav-link" data-bs-toggle="modal" data-bs-target="#logoutModal">Logout</button>
                </li>
            </ul>
        </div>
    </div>

    <!-- page -->
    <?php
    // Menampilkan konten berdasarkan halaman yang dipilih
    switch ($page) {
        case 'preferences':
            include 'page/chatbot.php';
            break;
        case 'home':
            include 'page/home.php';
            break;
        case 'produk':
            include 'page/produk.php';
            break;
        case 'transaksi':
            include 'page/transaksi.php';
            break;
        case 'transaksi-detail':
            include 'page/transaksi-detail.php';
            break;
        case 'cart':
            include 'page/keranjang.php';
            break;
        case 'all-produk':
            include 'page/all-produk.php';
            break;
        case 'search':
            include 'page/search.php';
            break;
        default:
            echo "<h1>Halaman tidak ditemukan</h1>";
            break;
    }
    ?>

    <!-- Footer -->
    <footer class="bg-second text-white pt-5 ">
        <div class="container text-start">
            <div class="row">
                <div class="col-md-3 col-5 mt-3 mx-auto ">
                    <h5 class="text-uppercase mb-4 font-weight-bold">Quick Links</h5>
                    <p><a href="#" class="text-white" style="text-decoration: none;">Home</a></p>
                    <p><a href="#produk" class="text-white" style="text-decoration: none;">Shoes</a></p>
                    <p><a href="#kontak" class="text-white" style="text-decoration: none;">Kontak</a></p>
                    <p><a href="#faq" class="text-white" style="text-decoration: none;">Faq</a></p>
                </div>
                <div class="col-md-3 col-6 mt-3 mx-auto">
                    <h5 class="text-uppercase mb-4 font-weight-bold">Contact</h5>
                    <p><i class="fas fa-home mr-3"></i> &nbsp; Malang, Indonesia</p>
                    <p><i class="fas fa-envelope mr-3"></i> &nbsp; info@company.com</p>
                    <p><i class="fas fa-phone mr-3"></i> &nbsp; +62 XXX XXX XXX</p>
                    <p><i class="fas fa-print mr-3"></i> &nbsp; +62 XXX XXX XXX</p>
                </div>
                <div class="col-md-3 mt-md-3 mx-auto ps-4 ps-md-0 mt-5">
                    <h5 class="text-uppercase mb-4 font-weight-bold">Follow Us</h5>
                    <a href="#" class="btn btn-floating m-1" style="background-color: #3b5998" role="button"><i
                            class="text-light fab fa-facebook-f"></i></a>
                    <a href="#" class="btn btn-floating m-1" style="background-color: #dd4b39" role="button"><i
                            class="text-light fab fa-google"></i></a>
                    <a href="#" class="btn btn-floating m-1" style="background-color: #ac2bac" role="button"><i
                            class="text-light fab fa-instagram"></i></a>
                </div>
            </div>
            <!-- Copyright -->
            <hr>
            <div class="row d-flex justify-content-center fs-8">
                <div class="col-md-7 col-lg-8">
                    <p class="text-center text-md-left">
                        Copyright © 2024 ShoesSoccer. All rights reserved
                    </p>
                </div>
            </div>
        </div>
    </footer>

    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Logout</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-prime">Are you sure want to logout</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Cancel</button>
                    <a class="btn btn-second" href="../logout.php">Yes</a>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script src="https://storage.ko-fi.com/cdn/scripts/overlay-widget.js"></script>
    <script src="../assets/js/script.js"></script>
    <script>
        var swiper = new Swiper(".mySwiper", {
            slidesPerView: 1,
            spaceBetween: 30,
            loop: true,
            pagination: {
                el: ".swiper-pagination",
                clickable: true,
            },
            navigation: {
                nextEl: ".swiper-button-next",
                prevEl: ".swiper-button-prev",
            },
        });
    </script>
    <script>
        // Function to process and send data via POST
        async function processSearch(input) {
            // const extractedData = processInput(input);
            const searchInput = input;
            // Send data to server using POST
            try {
                const response = await fetch('search-recommendation.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        action: 'search_recommendation',
                        search_input: searchInput
                    })
                })

                // Handle server response
                const result = await response.json();
                console.log("Server Response:", result);
                window.location = 'index.php?page=search&q=' + searchInput;
            } catch (error) {
                console.error("Error sending data to server:", error);
            }
        }
    </script>
</body>

</html>