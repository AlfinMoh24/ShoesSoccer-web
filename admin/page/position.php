<?php
include '../config.php';

// Query untuk mendapatkan semua data position
$sql = "SELECT * FROM positions";
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
        <h6 class="m-0 font-weight-bold text-primary">Position</h6>
        <!-- Tombol Tambah position yang Membuka Modal -->
        <a href="#" class="btn btn-primary btn-icon-split" data-toggle="modal"
            data-target="#tambahModal">
            <span class="icon text-white-50">
                <i class="fa fa-plus"></i>
            </span>
            <span class="text">Tambah Position</span>
        </a>

        <!-- Modal Tambah position -->
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Position</th>
                        <th>Deskripsi</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?= $row['position'] ?></td>
                            <td><?= $row['description'] ?></td>
                            <td>
                                <button type="button" class="btn btn-sm btn-warning" data-toggle="modal" data-target="#editModal" onclick="setEditData('<?= $row['position_id'] ?>', '<?= $row['position'] ?>', '<?= $row['description'] ?>')">
                                    Edit
                                </button>
                                <button type="button" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#confirmDeleteModal" onclick="setDeleteId(<?= $row['position_id'] ?>)">
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

<div class="modal fade" id="tambahModal" tabindex="-1" aria-labelledby="tambahLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="tambahLabel">Tambah Position</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <form action="aksi/tambah.php" method="POST" id="tambahForm">
                <input type="hidden" name="action" value="add_position">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="position" class="form-label">Position</label>
                        <input type="text" class="form-control" id="position" name="position" placeholder="Masukan Position" required>
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Deskripsi</label>
                        <textarea class="form-control" id="description" name="description"></textarea>
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

<!-- modal edit -->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Edit Position</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <form action="aksi/edit.php?page=position&position=true" method="POST">
                <div class="modal-body">
                    <input type="hidden" name="edit_id" id="edit_id">
                    <div class="mb-3">
                        <label for="edit_position" class="form-label">Position</label>
                        <input type="text" class="form-control" id="edit_position" name="edit_position">
                    </div>
                    <div class="mb-3">
                        <label for="edit_description" class="form-label">Deskripsi</label>
                        <textarea class="form-control" id="edit_description" name="edit_description"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary" name="update_position">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    function setDeleteId(id) {
        // Set href pada tombol hapus di modal dengan ID yang sesuai
        document.getElementById('confirmDeleteButton').href = 'aksi/hapus.php?page=position&delete_id=' + id + '&position=true';
    }

    function setEditData(id, position, description) {
        document.getElementById('edit_id').value = id;
        document.getElementById('edit_position').value = position;
        document.getElementById('edit_description').value = description;
    }

    window.addEventListener('load', function() {
        var url = new URL(window.location.href);
        if (url.searchParams.has('success')) {
            url.searchParams.delete('success');
            window.history.replaceState(null, null, url); // Memperbarui URL tanpa reload halaman
        }
    });
</script>