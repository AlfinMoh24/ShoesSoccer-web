<?php
$product_id = $_GET['id'];

// Mengambil data dropdown dari tabel terkait
$brands = $conn->query("SELECT brand_id, brand_name FROM brands");
$surfaces = $conn->query("SELECT surface_id, surface_type FROM surfaces");
$materials = $conn->query("SELECT material_id, material FROM materials");
$series = $conn->query("SELECT series_id, series, fungsi FROM series");
$models = $conn->query("SELECT model_id, model FROM models");
$positions = $conn->query("SELECT position_id, position FROM positions");

// Ambil data produk dari database
$sql = "SELECT * FROM sepatu WHERE shoes_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $product_id);
$stmt->execute();
$result = $stmt->get_result();
$product = $result->fetch_assoc(); // Menggunakan variabel $product untuk data produk

// Tutup statement
$stmt->close();
?>

<h1 class="h3 mb-3 text-gray-800">Edit Data Sepatu</h1>
<div class="card shadow mb-4">
    <div class="container mt-4 mb-5">
        <form action="aksi/edit.php?page=produk&produk=true" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="product_id" value="<?php echo $product['shoes_id']; ?>">

            <!-- Kode Produk -->
            <div class="mb-3">
                <label for="kode_produk" class="form-label">Kode Produk</label>
                <input type="text" class="form-control" id="kode_produk" name="kode_produk" value="<?php echo $product['kode_produk']; ?>" readonly required>
            </div>

            <!-- Nama Sepatu -->
            <div class="mb-3">
                <label for="shoes_name" class="form-label">Nama Sepatu</label>
                <input type="text" class="form-control" id="shoes_name" name="shoes_name" required value="<?php echo $product['shoes_name']; ?>">
            </div>

            <!-- Warna -->
            <div class="mb-3">
                <label for="color" class="form-label">Warna</label>
                <input type="text" class="form-control" id="color" name="color" placeholder="contoh : White/Sand/Green Gecko" required value="<?php echo $product['color']; ?>">
            </div>

            <!-- Harga -->
            <div class="mb-3">
                <label for="price" class="form-label">Harga</label>
                <input type="number" class="form-control" id="price" name="price" value="<?php echo $product['price']; ?>" required>
            </div>

            <!-- Ukuran -->
            <div class="mb-3">
                <label for="size" class="form-label">Ukuran</label>
                <input type="text" class="form-control" id="size" name="size" placeholder="contoh : 39-42" value="<?php echo $product['size']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="stok" class="form-label">Stok</label>
                <input type="text" class="form-control" id="stok" name="stok" value="<?php echo $product['stok']; ?>" required>
            </div>
            <!-- Dropdown Brand -->
            <div class="mb-3">
                <label for="brand_id" class="form-label">Brand</label>
                <select class="form-control" id="brand_id" name="brand_id" required onchange="updateName(this, 'brand_name')">
                    <option value="">Pilih Brand</option>
                    <?php while ($brand = $brands->fetch_assoc()): ?>
                        <option value="<?= $brand['brand_id'] ?>" data-name="<?= $brand['brand_name'] ?>" <?= $product['brand_id'] == $brand['brand_id'] ? 'selected' : '' ?>><?= $brand['brand_name'] ?></option>
                    <?php endwhile; ?>
                </select>
            </div>
            <input type="hidden" id="brand_name" name="brand_name" value="">

            <!-- Dropdown Surface -->
            <div class="mb-3">
                <label for="surface_id" class="form-label">Surface</label>
                <select class="form-control" id="surface_id" name="surface_id" required onchange="updateName(this, 'surface_type_name')">
                    <option value="">Pilih Surface</option>
                    <?php while ($surface = $surfaces->fetch_assoc()): ?>
                        <option value="<?= $surface['surface_id'] ?>" data-name="<?= $surface['surface_type'] ?>" <?= $product['surface_id'] == $surface['surface_id'] ? 'selected' : '' ?>><?= $surface['surface_type'] ?></option>
                    <?php endwhile; ?>
                </select>
            </div>
            <input type="hidden" id="surface_type_name" name="surface_type_name" value="">

            <!-- Dropdown Material -->
            <div class="mb-3">
                <label for="material_id" class="form-label">Material</label>
                <select class="form-control" id="material_id" name="material_id" required onchange="updateName(this, 'material_name')">
                    <option value="">Pilih Material</option>
                    <?php while ($material = $materials->fetch_assoc()): ?>
                        <option value="<?= $material['material_id'] ?>" data-name="<?= $material['material'] ?>" <?= $product['material_id'] == $material['material_id'] ? 'selected' : '' ?>><?= $material['material'] ?></option>
                    <?php endwhile; ?>
                </select>
            </div>
            <input type="hidden" id="material_name" name="material_name" value="">

            <!-- Dropdown Series -->
            <!-- Dropdown Series -->
            <div class="mb-3">
                <label for="series_id" class="form-label">Series</label>
                <select class="form-control" id="series_id" name="series_id" required onchange="updateSeries(this)">
                    <option value="">Pilih Series</option>
                    <?php while ($serie = $series->fetch_assoc()): ?>
                        <option value="<?= $serie['series_id'] ?>"
                            data-name="<?= $serie['series'] ?>"
                            data-fungsi="<?= $serie['fungsi'] ?>"
                            <?= $product['series_id'] == $serie['series_id'] ? 'selected' : '' ?>>
                            <?= $serie['series'] ?>
                        </option>
                    <?php endwhile; ?>
                </select>
            </div>
            <input type="hidden" id="series_name" name="series_name" value="">
            <input type="hidden" id="series_fungsi" name="series_fungsi" value="">


            <!-- Dropdown Model -->
            <div class="mb-3">
                <label for="model_id" class="form-label">Model</label>
                <select class="form-control" id="model_id" name="model_id" required onchange="updateName(this, 'model_name')">
                    <option value="">Pilih Model</option>
                    <?php while ($model = $models->fetch_assoc()): ?>
                        <option value="<?= $model['model_id'] ?>" data-name="<?= $model['model'] ?>" <?= $product['model_id'] == $model['model_id'] ? 'selected' : '' ?>><?= $model['model'] ?></option>
                    <?php endwhile; ?>
                </select>
            </div>
            <input type="hidden" id="model_name" name="model_name" value="">

            <!-- Dropdown Position -->
            <div class="mb-3">
                <label for="position_id" class="form-label">Position</label>
                <select class="form-control" id="position_id" name="position_id" required onchange="updateName(this, 'position_name')">
                    <option value="">Pilih Posisi</option>
                    <?php while ($position = $positions->fetch_assoc()): ?>
                        <option value="<?= $position['position_id'] ?>" data-name="<?= $position['position'] ?>" <?= $product['position_id'] == $position['position_id'] ? 'selected' : '' ?>><?= $position['position'] ?></option>
                    <?php endwhile; ?>
                </select>
            </div>
            <input type="hidden" id="position_name" name="position_name" value="">



            <!-- Gambar -->
            <div class="mb-3">
                <label for="gambar" class="form-label">Gambar</label>
                <input type="file" id="myDropify" name="gambar" accept="image/*"/>
            </div>
            <button type="submit" class="btn btn-primary">Update Sepatu</button>
        </form>
    </div>
</div>
<script>
    console.log(document.getElementById('myDropify').value)
</script>
<script>
    function updateName(selectElement, hiddenInputId) {
        // Ambil nama dari atribut `data-name` di option yang dipilih
        var selectedName = selectElement.options[selectElement.selectedIndex].getAttribute("data-name");
        // Simpan nama yang dipilih di input hidden yang sesuai
        document.getElementById(hiddenInputId).value = selectedName || '';
    }

    function updateSeries(selectElement) {
        // Ambil nama dari atribut `data-name` di option yang dipilih
        var selectedName = selectElement.options[selectElement.selectedIndex].getAttribute("data-name");
        // Ambil fungsi dari atribut `data-fungsi` di option yang dipilih
        var selectedFungsi = selectElement.options[selectElement.selectedIndex].getAttribute("data-fungsi");
        
        // Simpan nilai ke input hidden
        document.getElementById('series_name').value = selectedName || '';
        document.getElementById('series_fungsi').value = selectedFungsi || '';
    }

    // Isi hidden input saat halaman pertama kali dimuat
    document.addEventListener("DOMContentLoaded", function () {
        // Dropdown Series
        const seriesSelect = document.getElementById('series_id');
        if (seriesSelect.value) {
            updateSeries(seriesSelect);
        }

        // Dropdown lain (opsional)
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
