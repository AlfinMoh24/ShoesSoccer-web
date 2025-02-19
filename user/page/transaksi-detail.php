<?php
$id_transaksi = $_GET['id'];

$sql = "SELECT * FROM transaksi WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id_transaksi);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc(); // Menggunakan variabel $product untuk data produk

// Tutup statement
$stmt->close();
?>

<div class="mb-5 container" style="padding-top:90px">
    <div class="shadow-sm p-3 mb-5 bg-body-tertiary rounded">
        <div class="border p-3 mb-5 bg-body-tertiary rounded">
            <div class="d-flex flex-column flex-md-row g-3">
                <div class="flex-column checkout-modal mb-5" style="width: 100%; max-width: 40%;">
                    <div class="fs-5 mb-4">
                        Alamat Pengiriman
                    </div>
                    <div class="fs-6 mb-2">
                        <?= htmlspecialchars($row['nama']) ?>
                    </div>
                    <div class="text-prime fs-7"><?= htmlspecialchars($row['email']) ?></div>
                    <div class="text-prime fs-7"><?= htmlspecialchars($row['nomor']) ?></div>
                    <div class="text-prime fs-7"><?= htmlspecialchars($row['alamat']) ?></div>
                </div>
                <div style="border-left:1px solid #dee2e6; margin:0 20px"></div>
                <div class="flex-column checkout-modal" style="width: 100%; max-width: 50%;">
                    <div class="fs-5 mb-4">
                        Detail Pesanan
                    </div>
                    <div class="d-flex">
                        <img src="../<?= htmlspecialchars($row['image_url']) ?>" width="100" height="100" alt="" srcset="">
                        <div class="flex-column w-100">
                            <div class="mt-3 ms-3">
                                <div class="fs-6 fw-semi-bold">
                                    <?= htmlspecialchars($row['shoes_name']) ?>
                                </div>
                                <div class="mt-2 text-prime fs-7">
                                    Variasi: <?= htmlspecialchars($row['color']) ?>, Size: <?= htmlspecialchars($row['size']) ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="mt-5 flex-column ">
                        <table class="table-transaksi w-100">
                            <tr>
                                <td>Harga</td>
                                <td>:</td>
                                <td>Rp. <?= number_format($row['price'], 0, ',', '.') ?></td>
                            </tr>
                            <tr>
                                <td>Quantity</td>
                                <td>:</td>
                                <td><?= htmlspecialchars($row['jumlah']) ?></td>
                            </tr>
                            <tr>
                                <td>Total Pesanan</td>
                                <td>:</td>
                                <td>Rp. <?= number_format($row['total'], 0, ',', '.') ?></td>
                            </tr>
                            <tr>
                                <td>Status Pesanan</td>
                                <td>:</td>
                                <td><?= htmlspecialchars($row['status']) ?></td>
                            </tr>
                            <tr>
                                <td>Waktu Pemesanan</td>
                                <td>:</td>
                                <td><?= htmlspecialchars($row['create_at']) ?></td>
                            </tr>
                        </table>
                        <?php if ($row['status'] == "Sudah Dibayar" || $row['status'] == "Dibatalkan"): ?>
                            <div class="d-flex justify-content-end">
                                <a href="index.php?page=produk&id=<?= $row['shoes_id'] ?>" class="btn btn-second px-4 ms-2">Beli Lagi</a>
                            </div>
                        <?php else : ?>
                            <div class="d-flex justify-content-end">
                                <form id="payment-form" action="midtrans.php" method="post">
                                    <input type="hidden" name="first_name" value="<?= $row['nama'] ?>">
                                    <input type="hidden" name="id_transaksi" value="<?= $row['id'] ?>">
                                    <input type="hidden" name="jumlah" value="<?= $row['jumlah'] ?>">
                                    <input type="hidden" name="shoes_id" value="<?= $row['shoes_id'] ?>">
                                    <input type="hidden" name="email" value="<?= $row['email'] ?>">
                                    <input type="hidden" name="phone" value="<?= $row['nomor'] ?>">
                                    <input type="hidden" name="order_id" value="<?php echo rand(); ?>">
                                    <input type="hidden" name="gross_amount" value="<?= $row['total'] ?>">
                                    <button type="submit" class="btn btn-second px-4">Bayar Sekarang</button>
                                </form>
                                <button type="button" class="btn btn-outline-second px-4 ms-2" data-bs-toggle="modal" data-bs-target="#confirmDeleteModal" onclick="setDeleteId(<?= $row['id'] ?>,<?= $row['jumlah'] ?>,<?= $row['shoes_id'] ?>)">
                                    Batalkan Pesanan
                                </button>
                            </div>
                        <?php endif ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-labelledby="confirmDeleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmDeleteModalLabel">Konfirmasi Pembatalan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </button>
            </div>
            <div class="modal-body">
                Apakah Anda yakin ingin membatalkan data ini?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tidak</button>
                <a href="#" id="confirmDeleteButton" class="btn btn-danger">Iya</a>
            </div>
        </div>
    </div>
</div>
<script>
    function setDeleteId(id, jumlah, shoes_id) {
        // Set href pada tombol hapus di modal dengan ID yang sesuai
        document.getElementById('confirmDeleteButton').href = '../admin/aksi/edit.php?action=batalkan&id_transaksi=' + id + '&jumlah=' + jumlah + '&shoes_id=' + shoes_id;
    }
</script>
<script type="text/javascript">
    jumlah = document.getElementsByName('jumlah')[0].value;
    document.getElementById("payment-form").onsubmit = function(event) {
        event.preventDefault();

        // Kirimkan form untuk mendapatkan token transaksi
        fetch('midtrans.php', {
                method: 'POST',
                body: new FormData(this)
            })
            .then(response => response.json())
            .then(data => {
                // Menggunakan Snap Token yang diterima untuk melanjutkan pembayaran
                if (data.token) {
                    window.snap.pay(data.token, {
                        onSuccess: function(result) {
                            id = document.getElementsByName('id_transaksi')[0].value;
                            shoes_id = document.getElementsByName('shoes_id')[0].value;
                            jumlah = document.getElementsByName('jumlah')[0].value;
                            /* You may add your own implementation here */
                            fetch('midtrans-update.php', {
                                    method: 'POST',
                                    headers: {
                                        'Content-Type': 'application/json',
                                    },
                                    body: JSON.stringify({
                                        id: id,
                                        shoes_id: shoes_id,
                                        jumlah: jumlah,
                                    })
                                })
                                .then(response => {
                                    if (!response.ok) {
                                        throw new Error('Network response was not ok');
                                    }
                                    return response.json();
                                })
                                .then(data => {
                                    if (data.success) {
                                        console.log('Success:', data.message);
                                        // Setelah sukses, pindah ke halaman lain
                                        alert('Pembayaran Berhasil');
                                        window.location.reload();
                                    } else {
                                        console.error('Error:', data.message);
                                        alert('Update failed: ' + data.message);
                                    }
                                })
                                .catch((error) => {
                                    console.error('Error:', error);
                                    alert('There was an error: ' + error.message);
                                });
                        },
                        onPending: function(result) {
                            alert("Belum dibayar!");
                            window.location.reload();
                        },
                        onError: function(result) {
                            /* You may add your own implementation here */
                            alert("payment failed!");
                            console.log(result);
                        },
                        onClose: function() {


                        }
                    });
                }
            })
            .catch(error => console.error('Error:', error));
    }
</script>