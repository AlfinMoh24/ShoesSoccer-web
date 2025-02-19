<?php
$product_id = $_GET['id'];

$sql = "
    SELECT sepatu.*, 
           brands.brand_name, 
           surfaces.description as surface_description, 
           materials.material, 
           series.description as series_description,
           materials.description as material_description,
           series.series, 
           models.model, 
           positions.position 
    FROM sepatu
    LEFT JOIN brands ON sepatu.brand_id = brands.brand_id
    LEFT JOIN surfaces ON sepatu.surface_id = surfaces.surface_id
    LEFT JOIN materials ON sepatu.material_id = materials.material_id
    LEFT JOIN series ON sepatu.series_id = series.series_id
    LEFT JOIN models ON sepatu.model_id = models.model_id
    LEFT JOIN positions ON sepatu.position_id = positions.position_id
    WHERE sepatu.shoes_id = ? ";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $product_id);
$stmt->execute();
$result = $stmt->get_result();
$product = $result->fetch_assoc()
?>

<h1 class="h3 mb-3 text-gray-800">Detail</h1>
<div class="card shadow mb-4">
    <div class="container mt-4 mb-3">
        <!-- Kode Produk -->
        <div class="mb-3">
            <label for="kode_produk" class="form-label">Kode Produk</label>
            <input type="text" class="form-control" id="kode_produk" name="kode_produk" value="<?php echo $product['kode_produk']; ?>" readonly required readonly>
        </div>

        <!-- Nama Sepatu -->
        <div class="mb-3">
            <label for="shoes_name" class="form-label">Nama Sepatu</label>
            <input type="text" class="form-control" id="shoes_name" name="shoes_name" required readonly value="<?php echo $product['shoes_name']; ?>">
        </div>

        <!-- Warna -->
        <div class="mb-3">
            <label for="color" class="form-label">Warna</label>
            <input type="text" class="form-control" id="color" name="color" placeholder="contoh : White/Sand/Green Gecko" required readonly value="<?php echo $product['color']; ?>">
        </div>

        <!-- Harga -->
        <div class="mb-3">
            <label for="price" class="form-label">Harga</label>
            <input type="number" class="form-control" id="price" name="price" value="<?php echo $product['price']; ?>" required readonly>
        </div>

        <!-- Ukuran -->
        <div class="mb-3">
            <label for="size" class="form-label">Ukuran</label>
            <input type="text" class="form-control" id="size" name="size" value="<?php echo $product['size']; ?>" required readonly>
        </div>

        <!-- Dropdown Brand -->
        <div class="mb-3">
            <label for="brand_id" class="form-label">Brand</label>
            <input type="text" class="form-control" id="size" name="size" value="<?php echo $product['brand_name']; ?>" required readonly>
        </div>

        <!-- Dropdown Surface -->
        <div class="mb-3">
            <label for="surface_id" class="form-label">Surface</label>
            <input type="text" class="form-control" id="size" name="size" value="<?php echo $product['surface_description']; ?>" required readonly>
        </div>

        <!-- Dropdown Material -->
        <div class="mb-3">
            <label for="material_id" class="form-label">Material</label>
            <input type="text" class="form-control" id="size" name="size" value="<?php echo $product['material']; ?> (<?php echo $product['material_description']; ?>)" required readonly>
        </div>

        <!-- Dropdown Series -->
        <div class="mb-3">
            <label for="series_id" class="form-label">Series</label>
            <input type="text" class="form-control" value="<?php echo $product['series']; ?> (<?php echo $product['series_description']; ?>)" required readonly>
        </div>


        <!-- Dropdown Position -->
        <div class="mb-3">
            <label for="position_id" class="form-label">Position</label>
            <input type="text" class="form-control" value="<?php echo $product['position']; ?>" required readonly>
        </div>

        <!-- Gambar -->
        <div class="mb-3">
            <label for="gambar" class="form-label">Gambar</label><br>

            <img src="../<?php echo $product['image_url']; ?>" style="border:1px solid grey; border-radius:20px; width:200px ;margin-bottom:20px" alt="" srcset="">
            <input type="text" class="form-control" value="<?php echo $product['image_url']; ?>" readonly />
        </div>
    </div>
    <div class="px-3">
        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
            <thead>
                <tr>
                    <th>brand_vector</th>
                    <th>surface_vector</th>
                    <th>material_vector</th>
                    <th>series_vector</th>
                    <th>position_vector</th>
                    <th>color_vector</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="text-break"><?= $product['brand_vector'] ?></td>
                    <td class="text-break"><?= $product['surface_vector'] ?></td>
                    <td class="text-break"><?= $product['material_vector'] ?></td>
                    <td class="text-break"><?= $product['series_vector'] ?></td>
                    <td class="text-break"><?= $product['position_vector'] ?></td>
                    <td class="text-break"><?= $product['color_vector'] ?></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
<script>
        $(document).ready(function() {
            $('#dataTable').DataTable({
                paging: false,     // Menonaktifkan Pagination
                searching: false,  // Menonaktifkan Pencarian
                info: false        // Menonaktifkan Info (jumlah data yang ditampilkan)
            });
        });