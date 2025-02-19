<div class="mb-5 container" style="padding-top:90px">
    <div class="shadow-sm p-3 mb-5 bg-body-tertiary rounded">
        <?php
        $sql1 = "SELECT * FROM transaksi WHERE user_id = $user_id ORDER BY CASE WHEN status = 'Belum Dibayar' THEN 0 ELSE 1 END, id ASC";
        $result = $conn->query($sql1);
        while ($row = $result->fetch_assoc()): ?>
            <div class="border p-3 mb-3 bg-body-tertiary rounded" style="position:relative">
                <div class="d-flex">
                    <img src="../<?= htmlspecialchars($row['image_url']) ?>" width="120" height="120" alt="" srcset="">
                    <div class="flex-column w-100">
                        <div class="d-flex flex-column justify-content-start w-100 align-items-start flex-md-row justify-content-md-between align-items-md-center">
                            <div class="mb-2 ms-3 ms-md-5 d-flex flex-column ">
                                <div class="fs-6 fw-semi-bold">
                                    <?= htmlspecialchars($row['shoes_name']) ?>
                                </div>
                                <div class="mt-2 text-prime fs-7">
                                    Variasi: <?= htmlspecialchars($row['color']) ?>, Size: <?= htmlspecialchars($row['size']) ?>
                                </div>
                                <div class="mt-1 text-prime fs-7">
                                    Qty : <?= htmlspecialchars($row['jumlah']) ?>
                                </div>
                            </div>
                            <div class="mt-md-3 mt-1  ms-md-5 ms-3 fs-7">
                                Total Pesanan : &nbsp;&nbsp; <span class="text-second fs-5 fw-bold">Rp.<?= number_format($row['total'], 0, ',', '.') ?></span>
                            </div>
                        </div>
                        <?php if ($row['status'] == "Sudah Dibayar" || $row['status'] == "Dibatalkan"): ?>
                            <div class="d-flex justify-content-end mt-3 mt-md-0">
                                <a href="index.php?page=transaksi-detail&id=<?= $row['id'] ?>" class="btn btn-outline-second px-4 ms-2">Detail Pesanan</a>
                            </div>
                        <?php else : ?>
                            <div class="d-flex justify-content-end mt-3 mt-md-0">
                                <a href="index.php?page=transaksi-detail&id=<?php echo $row['id'] ?>" class="btn btn-second px-4">Bayar Sekarang</a>
                            </div>
                        <?php endif ?>
                    </div>
                </div>
            </div>
        <?php endwhile; ?>
        <?php if ($result->num_rows < 1): ?>
            <div class="w100 text-prime d-flex justify-content-center">
                <?php echo "Belum ada Pesanan" ?>
            </div>
        <?php endif ?>
    </div>
</div>