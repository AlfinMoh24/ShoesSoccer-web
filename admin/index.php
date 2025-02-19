<?php
session_start();

// Periksa apakah pengguna sudah login
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: ../index.php");
    exit;
}
if ($_SESSION['level'] !== 'admin' && $_SESSION['level'] !== 'seller') {
    // Jika bukan admin atau seller, arahkan ke halaman lain
    header("Location: ../index.php");
    exit();
}
$user_id = $_SESSION['user_id'];
$level = $_SESSION['level'];

include '../config.php'; // Menghubungkan ke database

// Menentukan halaman yang dipilih berdasarkan parameter 'page' di URL
$page = isset($_GET['page']) ? $_GET['page'] : 'produk'; // Default ke 'brand' jika tidak ada parameter 'page'
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Data Master - Admin Panel</title>
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
    <link href="vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/dropify/css/dropify.min.css">
    <style>
        .dropify-wrapper .dropify-message p {
            font-size: 16px;
        }

        .close-sidebar {
            padding: 10px 18px;
            border-radius: 50%;
            border: 2px solid grey;
            position: absolute;
            top: 10px;
            /* font-size: 18x; */
            font-weight: 700;
            left: calc(6.5rem);
        }

        .dropdown-menu {
            display: none;
            position: absolute;
            right: 0;
            background: white;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
            border-radius: 5px;
            padding: 10px;
            z-index: 1000;
        }

        .dropdown-menu.show {
            display: block;
        }

        @media (max-width: 768px) {
            .sidebar {
                position: fixed;
                z-index: 999;
            }
        }
    </style>
</head>

<body id="page-top">
    <div id="wrapper">
        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="#">
                <div class="sidebar-brand-text mx-3">SHOESSHOCCER</div>
            </a>
            <hr class="sidebar-divider my-0">
            <li class="nav-item">
                <a class="nav-link" href="index.php?page=produk">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Produk</span></a>
            </li>
            <?php if ($_SESSION['level'] === 'admin'): ?>
                <li class="nav-item">
                    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePages"
                        aria-expanded="true" aria-controls="collapsePages">
                        <i class="fas fa-fw fa-folder"></i>
                        <span>Data Master</span>
                    </a>
                    <div id="collapsePages" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
                        <div class="bg-white py-2 collapse-inner rounded">
                            <a class="collapse-item" href="index.php?page=brand">Brand</a>
                            <a class="collapse-item" href="index.php?page=surface">Surface</a>
                            <a class="collapse-item" href="index.php?page=position">Position</a>
                            <a class="collapse-item" href="index.php?page=material">Material</a>
                            <a class="collapse-item" href="index.php?page=series">Series</a>
                            <a class="collapse-item" href="index.php?page=model">Model</a>
                        </div>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="index.php?page=user-recommendation">
                        <i class="fa fa-shopping-cart"></i>
                        <span>User Recommendation</span></a>
                </li>
            <?php endif; ?>
            <li class="nav-item">
                <a class="nav-link" href="index.php?page=transaksi">
                    <i class="fa fa-credit-card"></i>
                    <span>Transaksi</span></a>
            </li>
            <?php if ($_SESSION['level'] === 'admin'): ?>
                <li class="nav-item">
                    <a class="nav-link" href="index.php?page=user">
                        <i class="fas fa-fw fa-user"></i>
                        <span>User</span></a>
                </li>
            <?php endif; ?>
            <li class="nav-item">
                <a class="nav-link" href="index.php?page=profil">
                    <i class="fas fa-fw fa-user"></i>
                    <span>Profil</span></a>
            </li>
            <hr class="sidebar-divider d-md-block">
            <div class="text-center d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>
        </ul>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <?php
        $user_id = $_SESSION['user_id'];

        // Query untuk mengambil data milik pengguna yang sedang login
        $sql = "SELECT * FROM users WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc()
        ?>
        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small"><?php echo $row['username'] ?></span>
                                <img class="img-profile rounded-circle" src="img/undraw_profile.svg">
                            </a>
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="userDropdown" id="dropdownMenu">
                                <a class="dropdown-item" href="index.php?page=profil">
                                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Profile
                                </a>
                                <a class="dropdown-item" href="#">
                                    <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Settings
                                </a>
                                <a class="dropdown-item" href="#">
                                    <i class="fas fa-list fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Activity Log
                                </a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Logout
                                </a>
                            </div>
                        </li>
                    </ul>
                </nav>

                <!-- Dynamic Content -->
                <div class="container-fluid">
                    <?php
                    // Menampilkan konten berdasarkan halaman yang dipilih
                    switch ($page) {
                        case 'user':
                            include 'page/user.php';
                            break;
                        case 'user-recommendation':
                            include 'page/user-recommendation.php';
                            break;
                        case 'recommendation-detail':
                            include 'page/recommendation-detail.php';
                            break;
                        case 'transaksi':
                            include 'page/transaksi.php';
                            break;
                        case 'produk':
                            include 'page/produk.php';
                            break;
                        case 'brand':
                            include 'page/brand.php';
                            break;
                        case 'surface':
                            include 'page/surface.php';
                            break;
                        case 'position':
                            include 'page/position.php';
                            break;
                        case 'material':
                            include 'page/material.php';
                            break;
                        case 'series':
                            include 'page/series.php';
                            break;
                        case 'model':
                            include 'page/model.php';
                            break;
                        case 'tambah-produk':
                            include 'page/form-tambah.php';
                            break;
                        case 'edit-produk':
                            include 'page/form-edit.php';
                            break;
                        case 'detail-produk':
                            include 'page/produk-detail.php';
                            break;
                        case 'profil':
                            include 'page/profil.php';
                            break;
                        default:
                            echo "<h1>Halaman tidak ditemukan</h1>";
                            break;
                    }
                    ?>
                </div>
                <!-- End of Dynamic Content -->
            </div>

            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; Your Website 2020</span>
                    </div>
                </div>
            </footer>
        </div>
    </div>

    <!-- Logout Modal -->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Logout</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Are you sure want to logout</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-primary" href="../logout.php">Yes</a>
                </div>
            </div>
        </div>
    </div>
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
    <script src="js/sb-admin-2.min.js"></script>
    <script src="vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="vendor/datatables/dataTables.bootstrap4.min.js"></script>
    <script src="js/demo/datatables-demo.js"></script>
    <script src="../assets/dropify/js/dropify.min.js"></script>
    <script>
        function checkScreenSize() {
            var element = document.getElementById("accordionSidebar");

            if (window.innerWidth <= 768) { // Jika lebar layar kurang dari atau sama dengan 768px (mobile)
                element.classList.add("toggled"); // Menambahkan kelas 'active'
            } else {
                element.classList.remove("toggled"); // Menghapus kelas 'active'
            }
        }

        // Menjalankan fungsi saat halaman dimuat dan saat ukuran layar berubah
        window.onload = checkScreenSize;
        window.onresize = checkScreenSize;
    </script>
    <script>
        $(function() {
            'use strict';

            $('#myDropify').dropify();
        });
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const dropdownToggle = document.getElementById("userDropdown");
            const dropdownMenu = document.getElementById("dropdownMenu");

            dropdownToggle.addEventListener("click", function(event) {
                event.preventDefault(); // Mencegah reload halaman
                dropdownMenu.classList.toggle("show"); // Toggle class untuk menampilkan dropdown
            });

            // Tutup dropdown jika klik di luar area dropdown
            document.addEventListener("click", function(event) {
                if (!dropdownToggle.contains(event.target) && !dropdownMenu.contains(event.target)) {
                    dropdownMenu.classList.remove("show");
                }
            });
        });
    </script>

</body>

</html>