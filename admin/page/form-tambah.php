<?php

$brands = $conn->query("SELECT brand_id, brand_name FROM brands");
$surfaces = $conn->query("SELECT surface_id, surface_type FROM surfaces");
$materials = $conn->query("SELECT material_id, material FROM materials");
$series = $conn->query("SELECT series_id,series, fungsi FROM series");
$models = $conn->query("SELECT model_id, model FROM models");
$positions = $conn->query("SELECT position_id, position FROM positions");



// Mengambil kode brand terbaru
$newCode = '';
$sql = "SELECT kode_produk FROM sepatu ORDER BY kode_produk DESC LIMIT 1";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $lastCode = $row['kode_produk'];
    $number = (int)substr($lastCode, 4); // Mengambil angka setelah "SPT-"
    $newNumber = $number + 1;
    $newCode = 'SPT-' . str_pad($newNumber, 3, '0', STR_PAD_LEFT);
} else {
    // Jika belum ada data produk, mulai dari SPT-001
    $newCode = 'SPT-001';
}

?>


<h1 class="h3 mb-3 text-gray-800">Tambah Produk</h1>
<!-- DataTales Example -->
<div class="card shadow mb-4">
    <div class="container mt-4 mb-5">
        <form action="aksi/tambah.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="action" value="add_produk">
            <div class="mb-3">
                <label for="kode_produk" class="form-label">Kode Produk</label>
                <input type="text" class="form-control" id="kode_produk" name="kode_produk" value="<?php echo $newCode; ?>" readonly required>
            </div>

            <input type="hidden" id="user_id" name="user_id" value="<?php echo $user_id?>">
            <div class="mb-3">
                <label for="shoes_name" class="form-label">Nama Sepatu</label>
                <input type="text" class="form-control" id="shoes_name" name="shoes_name" required>
            </div>
            <div class="mb-3">
                <label for="color" class="form-label">Warna</label>
                <input type="text" class="form-control" id="color" name="color" placeholder="contoh : White/Sand/Green Gecko" required>
            </div>
            <div class="mb-3">
                <label for="price" class="form-label">Harga</label>
                <input type="number" class="form-control" id="price" name="price" required>
            </div>
            <div class="mb-3">
                <label for="size" class="form-label">Ukuran</label>
                <input type="text" class="form-control" id="size" name="size" required
                    pattern="^\d{2}-\d{2}$" title="contoh: 38-43" placeholder="contoh: 38-43">
            </div>
            <div class="mb-3">
                <label for="stok" class="form-label">Stok</label>
                <input type="text" class="form-control" id="stok" name="stok" required>
            </div>
            <div class="mb-3">
                <label for="brand_id" class="form-label">Brand</label>
                <select class="form-control" id="brand_id" name="brand_id" required onchange="updateName(this, 'brand_name')">
                    <option value="">Pilih Brand</option>
                    <?php while ($row = $brands->fetch_assoc()): ?>
                        <option value="<?= $row['brand_id'] ?>" data-name="<?= $row['brand_name'] ?>"><?= $row['brand_name'] ?></option>
                    <?php endwhile; ?>
                </select>
            </div>
            <input type="hidden" id="brand_name" name="brand_name" value="">

            <div class="mb-3">
                <label for="surface_id" class="form-label">Surface</label>
                <select class="form-control" id="surface_id" name="surface_id" required onchange="updateName(this, 'surface_type_name')">
                    <option value="">Pilih Surface</option>
                    <?php while ($row = $surfaces->fetch_assoc()): ?>
                        <option value="<?= $row['surface_id'] ?>" data-name="<?= $row['surface_type'] ?>"><?= $row['surface_type'] ?></option>
                    <?php endwhile; ?>
                </select>
            </div>
            <input type="hidden" id="surface_type_name" name="surface_type_name" value="">

            <div class="mb-3">
                <label for="material_id" class="form-label">Material</label>
                <select class="form-control" id="material_id" name="material_id" required onchange="updateName(this, 'material_name')">
                    <option value="">Pilih Material</option>
                    <?php while ($row = $materials->fetch_assoc()): ?>
                        <option value="<?= $row['material_id'] ?>" data-name="<?= $row['material'] ?>"><?= $row['material'] ?></option>
                    <?php endwhile; ?>
                </select>
            </div>
            <input type="hidden" id="material_name" name="material_name" value="">

            <div class="mb-3">
                <label for="series_id" class="form-label">Series</label>
                <select class="form-control" id="series_id" name="series_id" required onchange="updateSeries(this)">
                    <option value="">Pilih Series</option>
                    <?php while ($row = $series->fetch_assoc()): ?>
                        <option value="<?= $row['series_id'] ?>" data-name="<?= $row['series'] ?>" data-fungsi="<?= $row['fungsi'] ?>">
                            <?= $row['series'] ?>
                        </option>
                    <?php endwhile; ?>
                </select>
            </div>
            <input type="hidden" id="series_fungsi" name="series_fungsi" value="">

            <div class="mb-3">
                <label for="position_id" class="form-label">Position</label>
                <select class="form-control" id="position_id" name="position_id" required onchange="updateName(this, 'position_name')">
                    <option value="">Pilih Position</option>
                    <?php while ($row = $positions->fetch_assoc()): ?>
                        <option value="<?= $row['position_id'] ?>" data-name="<?= $row['position'] ?>"><?= $row['position'] ?></option>
                    <?php endwhile; ?>
                </select>
            </div>
            <input type="hidden" id="position_name" name="position_name" value="">

            <div class="mb-3">
                <label for="model_id" class="form-label">Model</label>
                <select class="form-control" id="model_id" name="model_id" required>
                    <option value="">Pilih Model</option>
                    <?php while ($row = $models->fetch_assoc()): ?>
                        <option value="<?= $row['model_id'] ?>"><?= $row['model'] ?></option>
                    <?php endwhile; ?>
                </select>
            </div>


            <div class="mb-3">
                <label for="gambar" class="form-label">Gambar</label>
                <input type="file" id="myDropify" name="gambar" multiple accept="image/*" required />
            </div>
            <button type="submit" class="btn btn-primary">Tambah Sepatu</button>
        </form>
    </div>
</div>
<script>
    function updateName(selectElement, hiddenInputId) {
        // Ambil nama dari atribut `data-name` di option yang dipilih
        var selectedName = selectElement.options[selectElement.selectedIndex].getAttribute("data-name");
        // Simpan nama yang dipilih di input hidden yang sesuai
        document.getElementById(hiddenInputId).value = selectedName || '';
    }

    function updateSeries(selectElement) {
        // Ambil nama dan fungsi dari atribut di option yang dipilih
        var selectedName = selectElement.options[selectElement.selectedIndex].getAttribute("data-name");
        var selectedFungsi = selectElement.options[selectElement.selectedIndex].getAttribute("data-fungsi");

        // Simpan nilai ke input hidden
        document.getElementById('series_fungsi').value = selectedFungsi || '';
    }

    // Saat halaman dimuat, isi nilai hidden input berdasarkan opsi yang sudah dipilih
    document.addEventListener("DOMContentLoaded", function() {
        // Perbarui nilai input hidden untuk Series
        const seriesSelect = document.getElementById('series_id');
        if (seriesSelect.value) {
            updateSeries(seriesSelect);
        }

        // Perbarui nilai input hidden lainnya
        document.querySelectorAll('select').forEach(select => {
            const onchangeAttr = select.getAttribute('onchange');
            if (onchangeAttr) {
                const hiddenInputIdMatch = onchangeAttr.match(/'([^']+)'/);
                if (hiddenInputIdMatch) {
                    const hiddenInputId = hiddenInputIdMatch[1];
                    if (hiddenInputId !== 'series_fungsi') {
                        updateName(select, hiddenInputId);
                    }
                }
            }
        });
    });
</script>