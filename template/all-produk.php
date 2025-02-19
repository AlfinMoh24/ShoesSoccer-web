<?php
// Ambil halaman saat ini dari URL (default ke 1 jika tidak ada)
$page = isset($_GET['halaman']) ? (int)$_GET['halaman'] : 1;
$perPage = 12; // Jumlah data per halaman

// Hitung offset
$offset = ($page - 1) * $perPage;

// Query data sepatu dengan limit dan offset
$sql1 = "SELECT * FROM sepatu LIMIT $perPage OFFSET $offset";
$all = $conn->query($sql1);

// Ambil semua data
$data = $all->fetch_all(MYSQLI_ASSOC);

// Hitung total data
$sql2 = "SELECT COUNT(*) as total FROM sepatu WHERE sepatu.stok > 0";
$result = $conn->query($sql2);
$totalData = $result->fetch_assoc()['total'];

// Hitung total halaman
$totalPages = ceil($totalData / $perPage);
?>

<!-- Tampilkan Produk -->

<div class="container" style="padding-top:90px">
    <div class="most-populer flex-column gap-3 mb-4">
        <div class="w-100 rounded-pill px-5 py-3 mb-4 fw-semibold fs-5 text-center">All Produk</div>
        <div class="row gap-3 ">
            <?php foreach ($data as $row): ?>
                <?php if ($row['stok'] > 0): // Tambahkan kondisi stok > 0 
                ?>
                    <div class="produk-item col-6 col-md-3 p-3 flex-column"
                        onclick="window.location.href='index.php?page=produk&id=<?= htmlspecialchars($row['shoes_id']) ?>'">
                        <div class="d-flex flex-column justify-content-between h-100">
                            <div>
                                <img src="<?= htmlspecialchars($row['image_url']) ?>" width="100%" alt="" srcset="">
                                <div class="fw-bold mt-3 fs-7 "><?= htmlspecialchars($row['shoes_name']) ?></div>
                                <div class="fs-8 py-2">Rp. <?= number_format($row['price'], 0, ',', '.') ?></div>
                            </div>
                            <div class="fs-7 fw-medium mt-3 me-4 d-flex justify-content-between">
                                <div>Terjual : <?= htmlspecialchars($row['terjual']) ?></div>
                                Stok: <?= htmlspecialchars($row['stok']) ?>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            <?php endforeach; ?>
            <!-- Pagination Navigation -->
            <nav aria-label="Page navigation example" class="mt-3">
                <ul class="pagination justify-content-center ">
                    <?php if ($page > 1): ?>
                        <li class="page-item ">
                            <a href="index.php?page=all-produk&halaman=<?= $page - 1 ?>" class="page-link text-second fs-7">Previous</a>
                        </li>
                    <?php endif; ?>
                    <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                        <li class="page-item "><a href="index.php?page=all-produk&halaman=<?= $i ?>" class="page-link fs-7 <?= $i == $page ? 'active' : 'text-second' ?>">
                                <?= $i ?>
                            </a>
                        </li>
                    <?php endfor; ?>
                    <?php if ($page < $totalPages): ?>
                        <li class="page-item">
                            <a href="index.php?page=all-produk&halaman=<?= $page + 1 ?>" class="page-link text-second fs-7">Next</a>
                        </li>
                    <?php endif; ?>
                </ul>
            </nav>
        </div>
    </div>
</div>