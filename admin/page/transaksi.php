<?php
include '../config.php';

if ($level === "admin") {
    $sql = "SELECT transaksi.*, transaksi.shoes_id, sepatu.id_toko, users.nama_toko
            FROM transaksi
            JOIN sepatu ON transaksi.shoes_id = sepatu.shoes_id
            JOIN users ON sepatu.id_toko = users.id;";
} else {
    $sql = "SELECT transaksi.*, transaksi.shoes_id, sepatu.id_toko, users.nama_toko
            FROM transaksi
            JOIN sepatu ON transaksi.shoes_id = sepatu.shoes_id
            JOIN users ON sepatu.id_toko = users.id
            WHERE id_toko = $user_id";
}



$result = $conn->query($sql);

if (isset($_GET['success']) && $_GET['success'] === 'deleted') {
    echo "<div class='alert alert-danger' id='alertMessage'>Data berhasil dihapus!</div>";
}
?>

<!-- DataTales Example -->
<div class="card shadow mb-4">
    <div class="card-header py-3 d-flex justify-content-between align-items-center">
        <h6 class="m-0 font-weight-bold text-primary">Transaksi</h6>


        <!-- Modal Tambah position -->
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Produk</th>
                        <th>Toko</th>
                        <th>Jumlah</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?= $row['nama'] ?></td>
                            <td><?= $row['email'] ?></td>
                            <td><?= $row['shoes_name'] ?></td>
                            <td><?= $row['nama_toko'] ?></td>
                            <td><?= $row['jumlah'] ?></td>
                            <td>Rp. <?= number_format($row['total'], 0, ',', '.') ?></td>
                            <td><?= $row['status'] ?></td>
                            <td>
                                <button type="button" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#confirmDeleteModal" onclick="setDeleteId(<?= $row['id'] ?>)">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="modal fade" id="tambahModal" tabindex="-1" aria-labelledby="tambahLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="tambahLabel">Tambah Admin</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <form action="aksi/tambah.php" method="POST" id="tambahForm">
                <input type="hidden" name="action" value="add_admin">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="username" class="form-label">Username</label>
                        <input type="text" class="form-control" id="username" name="username" placeholder="Masukan username" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="text" class="form-control" id="email" name="email" placeholder="Masukan email" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Password</label>
                        <input type="password" class="form-control" name="password" placeholder="Password" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Konfirmasi Password</label>
                        <input type="password" class="form-control" name="confirm_password" placeholder="Konfirmasi Password" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-labelledby="confirmDeleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmDeleteModalLabel">Konfirmasi Hapus</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                Apakah Anda yakin ingin menghapus transaksi ini?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                <a href="#" id="confirmDeleteButton" class="btn btn-danger">Hapus</a>
            </div>
        </div>
    </div>
</div>
<script>
    function setDeleteId(id) {
        document.getElementById('confirmDeleteButton').href = 'aksi/hapus.php?page=transaksi&delete_id=' + id + '&transaksi=true';
    }
    window.addEventListener('load', function() {
        var url = new URL(window.location.href);
        if (url.searchParams.has('success')) {
            url.searchParams.delete('success');
            window.history.replaceState(null, null, url); // Memperbarui URL tanpa reload halaman
        }
    });
</script>