<?php
include '../config.php';

// Query untuk mendapatkan semua data brand
$sql = "SELECT * FROM brands";
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

<h1 class="h3 mb-3 text-gray-800">Data Master</h1>
<!-- DataTales Example -->
<div class="card shadow mb-4">
    <div class="card-header py-3 d-flex justify-content-between align-items-center">
        <h6 class="m-0 font-weight-bold text-primary">Brand</h6>
        <!-- Tombol Tambah Brand yang Membuka Modal -->
        <a href="#" class="btn btn-primary btn-icon-split" data-toggle="modal"
            data-target="#tambahBrandModal">
            <span class="icon text-white-50">
                <i class="fa fa-plus"></i>
            </span>
            <span class="text">Tambah Brand</span>
        </a>

        <!-- Modal Tambah Brand -->
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Kode</th>
                        <th>Brand</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?= $row['kode_brand'] ?></td>
                            <td><?= $row['brand_name'] ?></td>
                            <td>

                                <button type="button" class="btn btn-sm btn-warning" data-toggle="modal" data-target="#editModal" onclick="setEditData('<?= $row['brand_id'] ?>', '<?= $row['kode_brand'] ?>', '<?= $row['brand_name'] ?>')">
                                    Edit
                                </button>
                                <button type="button" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#confirmDeleteModal" onclick="setDeleteId(<?= $row['brand_id'] ?>)">
                                    Hapus
                                </button>

                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>



<?php

// Mengambil kode brand terbaru
$newCode = '';
$sql = "SELECT kode_brand FROM brands ORDER BY kode_brand DESC LIMIT 1";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $lastCode = $row['kode_brand'];
    $number = (int)substr($lastCode, 2); // Mengambil angka setelah "B-"
    $newNumber = $number + 1;
    $newCode = 'B-' . str_pad($newNumber, 3, '0', STR_PAD_LEFT);
} else {
    // Jika belum ada data brand, mulai dari B-001
    $newCode = 'B-001';
}
?>
<div class="modal fade" id="tambahBrandModal" tabindex="-1" aria-labelledby="tambahBrandLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="tambahBrandLabel">Tambah Brand</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <form action="aksi/tambah.php" method="POST" id="tambahBrandForm">
                <input type="hidden" name="action" value="add_brand">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="kode_brand" class="form-label">Kode Brand</label>
                        <input type="text" class="form-control" id="kode_brand" name="kode_brand" value="<?php echo $newCode; ?>" readonly required>
                    </div>
                    <div class="mb-3">
                        <label for="nama_brand" class="form-label">Nama Brand</label>
                        <input type="text" class="form-control" id="nama_brand" name="nama_brand" placeholder="Masukkan Nama Brand" required>
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
                Apakah Anda yakin ingin menghapus data ini?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                <a href="#" id="confirmDeleteButton" class="btn btn-danger">Hapus</a>
            </div>
        </div>
    </div>
</div>
<!-- Modal Edit -->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Edit Brand</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <form action="aksi/edit.php?page=brand&brand=true" method="POST">
                <div class="modal-body">
                    <input type="hidden" name="edit_id" id="edit_id">
                    <div class="mb-3">
                        <label for="edit_kode_brand" class="form-label">Kode Brand</label>
                        <input type="text" class="form-control" id="edit_kode_brand" name="edit_kode_brand" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="edit_nama_brand" class="form-label">Nama Brand</label>
                        <input type="text" class="form-control" id="edit_nama_brand" name="edit_nama_brand" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary" name="update_brand">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function setDeleteId(id) {
        // Set href pada tombol hapus di modal dengan ID yang sesuai
        document.getElementById('confirmDeleteButton').href = 'aksi/hapus.php?page=brand&delete_id=' + id + '&brand=true';
    }

    function setEditData(id, kodeBrand, namaBrand) {
        document.getElementById('edit_id').value = id;
        document.getElementById('edit_kode_brand').value = kodeBrand;
        document.getElementById('edit_nama_brand').value = namaBrand;
    }

    window.addEventListener('load', function() {
        var url = new URL(window.location.href);
        if (url.searchParams.has('success')) {
            url.searchParams.delete('success');
            window.history.replaceState(null, null, url); // Memperbarui URL tanpa reload halaman
        }
    });
</script>