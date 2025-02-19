<?php
include '../config.php';

// Bangun query berdasarkan level
if ($level === "admin") {
    // Jika level admin, tidak ada WHERE id_toko
    $sql = "SELECT sepatu.*, users.nama_toko 
            FROM sepatu 
            JOIN users ON sepatu.id_toko = users.id";
} else {
    // Jika level bukan admin, tambahkan klausa WHERE
    $sql = "SELECT sepatu.*, users.nama_toko 
            FROM sepatu 
            JOIN users ON sepatu.id_toko = users.id
            WHERE id_toko = $user_id";
}
$result = $conn->query($sql);

if (isset($_GET['success']) && $_GET['success'] === 'added') {
    echo "<div class='alert alert-success' id='alertMessage'>Data berhasil ditambah!</div>";
}

if (isset($_GET['success']) && $_GET['success'] === 'updated') {
    echo "<div class='alert alert-success' id='alertMessage'>Data berhasil diperbarui!</div>";
}

if (isset($_GET['success']) && $_GET['success'] === 'deleted') {
    echo "<div class='alert alert-danger' id='alertMessage'>Data berhasil dihapus!</div>";
}
?>

<h1 class="h3 mb-3 text-gray-800">Produk</h1>
<!-- DataTales Example -->
<div class="card shadow mb-4">
    <div class="card-header py-3 d-flex justify-content-between align-items-center">
        <h6 class="m-0 font-weight-bold text-primary">Data Sepatu</h6>
        <!-- Tombol Tambah position yang Membuka Modal -->
        <?php if ($level === 'seller'): ?>
            <a href="index.php?page=tambah-produk" class="btn btn-primary btn-icon-split">
                <span class="icon text-white-50">
                    <i class="fa fa-plus"></i>
                </span>
                <span class="text">Tambah Produk</span>
            </a>
        <?php endif; ?>

        <!-- Modal Tambah position -->
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Kode</th>
                        <th style="max-width:150px">Nama</th>
                        <th>Stok</th>
                        <th>Harga</th>
                        <th>Toko</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?= $row['kode_produk'] ?></td>
                            <td><?= $row['shoes_name'] ?></td>
                            <td><?= $row['stok'] ?></td>
                            <td><?= $row['price'] ?></td>
                            <td><?= $row['nama_toko'] ?></td>
                            <td>
                                <a href="index.php?page=detail-produk&id=<?= $row['shoes_id'] ?>" class="btn btn-sm btn-primary">
                                    Detail
                                </a>
                                <?php if ($level === 'seller'): ?>
                                    <a href="index.php?page=edit-produk&id=<?= $row['shoes_id'] ?>" class="btn btn-sm btn-warning">
                                        <i class="fas fa-pen"></i>
                                    </a>
                                    <button type="button" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#confirmDeleteModal" onclick="setDeleteId(<?= $row['shoes_id'] ?>)">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
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
                Apakah Anda yakin ingin menghapus data ini?
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
        // Set href pada tombol hapus di modal dengan ID yang sesuai
        document.getElementById('confirmDeleteButton').href = 'aksi/hapus.php?page=produk&delete_id=' + id + '&produk=true';
    }

    window.addEventListener('load', function() {
        var url = new URL(window.location.href);
        if (url.searchParams.has('success')) {
            url.searchParams.delete('success');
            window.history.replaceState(null, null, url); // Memperbarui URL tanpa reload halaman
        }
    });
</script>