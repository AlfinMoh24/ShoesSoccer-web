<?php
$search = $_GET['q'] ?? null;

$sql = "
 SELECT search_recommendation.*, 
        sepatu.shoes_name, 
        sepatu.price, 
        sepatu.stok,
        sepatu.terjual,
        sepatu.image_url 
 FROM search_recommendation
 LEFT JOIN sepatu ON search_recommendation.shoes_id = sepatu.shoes_id
 AND sepatu.stok > 0 ORDER BY search_recommendation.no ASC";

$rec = $conn->query($sql);

?>


<div class="container" style="padding-top:90px">
    <div class="most-populer flex-column gap-3 mb-4 ">
        <div class="w-100 bg-prime ps-4 py-3 mb-4 fw-semibold fs-6">Hasil Pencarian dari : <span class="fs-7 fs-normal"><?php echo $search ?></span></div>
        <?php if ($rec->num_rows > 0): ?>
            <div class="grid-5 gap-3 px-2">
                <?php while ($row = $rec->fetch_assoc()): ?>
                    <?php if ($row['stok'] > 0): ?>
                        <div class="produk-item p-3"
                            onclick="window.location.href='index.php?page=produk&id=<?= $row['shoes_id'] ?>'">
                            <div class="d-flex flex-column justify-content-between h-100">
                                <div>
                                    <img src="../<?= htmlspecialchars($row['image_url']) ?>" width="100%" alt="" srcset="">
                                    <div class="fw-bold mt-3 fs-7 "><?= htmlspecialchars($row['shoes_name']) ?></div>
                                    <div class="fs-8 py-2">Rp. <?= number_format($row['price'], 0, ',', '.') ?></div>
                                </div>
                                <div style="font-size:12px;">Average Similarity : &nbsp;&nbsp;<?= htmlspecialchars($row['average_similarity']) ?></div>
                                <div class="fs-7 fw-medium mt-3 me-4 d-flex justify-content-between">
                                    <div>Terjual : <?= htmlspecialchars($row['terjual']) ?></div>
                                    Stok: <?= htmlspecialchars($row['stok']) ?>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                <?php endwhile; ?>
            </div>
        <?php else: ?>
            <div class="col-12 text-center py-5">
                <p class="fs-5 text-muted">Tidak ada produk</p>
            </div>
        <?php endif; ?>
    </div>
</div>