<?php
$product_id = $_GET['id'] ?? null;

if ($product_id === null) {
    echo "ID sepatu tidak ditemukan.";
    exit;
}

// Siapkan dan eksekusi query
$sql = "
    SELECT sepatu.*, 
           brands.brand_name, 
           surfaces.description as surface_description, 
           materials.material, 
           series.description as series_description,
           materials.description as material_description,
           series.series, 
           models.model, 
           positions.position,
           users.nama_toko,
           users.img_profil
    FROM sepatu
    LEFT JOIN brands ON sepatu.brand_id = brands.brand_id
    LEFT JOIN surfaces ON sepatu.surface_id = surfaces.surface_id
    LEFT JOIN materials ON sepatu.material_id = materials.material_id
    LEFT JOIN series ON sepatu.series_id = series.series_id
    LEFT JOIN models ON sepatu.model_id = models.model_id
    LEFT JOIN positions ON sepatu.position_id = positions.position_id
    LEFT JOIN users ON sepatu.id_toko = users.id
    WHERE sepatu.shoes_id = ? AND sepatu.stok > 0";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $product_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    echo "<script>
            alert('Produk sudah tidak tersedia');
            window.location.href = 'index.php?page=home';
          </script>";
} else {
    $product = $result->fetch_assoc();
}

$size_range = $product['size'];
list($start_size, $end_size) = explode("-", $size_range); // Pisahkan awal dan akhir rentang

// Buat array ukuran dari awal hingga akhir rentang
$sizes = range((int)$start_size, (int)$end_size);

// Tutup statement
$stmt->close();
?>

<section id="produk-shop" class="produk-shop" style="padding-top: 90px;">
    <div class="container">
        <div class="produk-name fs-8 text-prime">
            <a href="index.php?page=home">Home</a><i class="fa-solid fa-chevron-right"></i> shoes <i
                class="fa-solid fa-chevron-right"></i> <span class="text-second"><?= htmlspecialchars($product['shoes_name']) ?></span>
        </div>
        <div class="d-flex flex-column  flex-md-row mt-3 gap-3">
            <div class="img-produk">
                <img src="<?= htmlspecialchars($product['image_url']) ?>" alt="" srcset="">
            </div>
            <div class="produk-detail">
                <div class="fw-bold fs-1"><?= htmlspecialchars($product['shoes_name']) ?></div>
                <div class="fs-6 mt-3 text-secondary">
                    <?= htmlspecialchars($product['color']) ?>
                </div>
                <div class="text-second my-4 fs-3 fw-bold">Rp. <?= number_format($product['price'], 0, ',', '.') ?></div>
                <span>Select a size</span>
                <div class="d-flex gap-1 mt-1">
                    <?php foreach ($sizes as $size): ?>
                        <input type="radio" class="btn-check" name="size" id="size-<?= $size ?>" value="<?= $size ?>" autocomplete="off">
                        <label class="btn btn-outline-dark fs-8" for="size-<?= $size ?>"><?= $size ?></label>
                    <?php endforeach; ?>
                </div>
                <div class="d-flex mt-4 align-items-center gap-2">
                    <div class="counter me-3">
                        <i class="fa-solid fa-minus" id="decrement"></i>
                        <span id="counterValue">1</span>
                        <i class="fa-solid fa-plus" id="increment"></i>
                    </div>
                    <a href="index.php?page=login" type="submit" class="btn-outline-second fs-8 px-3 py-2 rounded-pill">+ Add to cart</a>
                    <a href="index.php?page=login" class="btn-second fs-8 px-4 py-2 rounded-pill" id="openModalButton">Buy Now</a>
                </div>
                <br>
                <span>
                    stok : <?= htmlspecialchars($product['stok']) ?>
                </span>
                <spanc class="ms-5">
                    terjual : <?= htmlspecialchars($product['terjual']) ?>
                    </span>
            </div>
        </div>
    </div>
    <div class="detail-store container mt-4 px-3">
        <img src="img-profil/<?php echo $product['img_profil']?>" alt="" srcset="">
        <?= htmlspecialchars($product['nama_toko']) ?>
    </div>
    <div class="container mt-3 px-3">
        <!-- Tab Navigation -->
        <ul class="nav nav-pills bg-prime rounded-pill px-2 py-2" id="myTab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-links active me-3" id="detail-tab" data-bs-toggle="tab" data-bs-target="#detail"
                    type="button" role="tab" aria-controls="detail" aria-selected="true">
                    Detail
                </button>
            </li>
        </ul>
        <!-- detail -->
        <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade show active fs-7" id="detail" role="tabpanel" aria-labelledby="detail-tab">
                <h3 class="mt-4"><?= htmlspecialchars($product['shoes_name']) ?></h3>
                <p class="fs-8">
                    Brand : <?= htmlspecialchars($product['brand_name']) ?>
                </p>

                <p><strong>Perawatan & Bahan: <br></strong> <?= htmlspecialchars($product['material']) ?> (<?= htmlspecialchars($product['material_description']) ?>)</p>
                <p><strong>Warna: <br></strong> <?= htmlspecialchars($product['color']) ?></p>
                <p><strong>Ukuran: <br></strong> <?= htmlspecialchars($product['size']) ?></p>
                <p><strong>Series: <br></strong> <?= htmlspecialchars($product['series']) ?> (<?= htmlspecialchars($product['series_description']) ?>)</p>
                <p><strong>Surface: <br></strong> <?= htmlspecialchars($product['surface_description']) ?></p>
                <p><strong>Position: <br></strong> <?= htmlspecialchars($product['position']) ?></p>
            </div>
        </div>
        <div class="most-populer flex-column gap-3 my-4">
            <div class="w-100 bg-prime rounded-pill px-5 py-3 mb-4 fw-semibold fs-5">Anda Mungkin Juga Suka</div>
            <div class="row gap-3">
                <?php
                $sql1 = "SELECT *FROM sepatu LIMIT 4";
                $result1 = $conn->query($sql1);
                while ($row1 = $result1->fetch_assoc()): ?>
                    <?php if ($row1['stok'] > 0): ?>
                        <div class="produk-item col-6 col-md-3 p-3 flex-column"
                            onclick="window.location.href='index.php?page=produk&id=<?= $row1['shoes_id'] ?>'">
                            <div class="d-flex flex-column justify-content-between h-100">
                                <div>
                                    <img src="<?= htmlspecialchars($row1['image_url']) ?>" width="100%" alt="" srcset="">
                                    <div class="fw-bold mt-3 fs-7 "><?= htmlspecialchars($row1['shoes_name']) ?></div>
                                    <div class="fs-8 py-2">Rp. <?= number_format($row1['price'], 0, ',', '.') ?></div>
                                </div>
                                <div class="fs-7 fw-medium mt-3 me-4 d-flex justify-content-between">
                                    <div>Terjual : <?= htmlspecialchars($row1['terjual']) ?></div>
                                    Stok: <?= htmlspecialchars($row1['stok']) ?>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                <?php endwhile; ?>
            </div>
        </div>
    </div>
</section>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Modal title</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="../admin/aksi/tambah.php" method="post">
                <input type="hidden" name="action" value="add_transaksi">
                <div class="modal-body">
                    <div class="d-flex flex-column-reverse flex-md-row g-3">
                        <div class="flex-column fs-7 checkout-modal" style="width: 100%; max-width: 40%;;">
                            <div class="fs-6 mb-4">
                                Alamat Pengiriman
                            </div>
                            <div class="mb-3">
                                <input type="text" class="form-control fs-7" name="nama" id="nama" required placeholder="Nama">
                            </div>
                            <div class="mb-3">
                                <input type="number" class="form-control fs-7" name="nomor" id="nomor" required placeholder="+62XXXXXXXXXX">
                            </div>
                            <div class="mb-3">
                                <input type="email" class="form-control fs-7" name="email" id="email" required placeholder="name@example.com">
                            </div>
                            <div class="mb-3">
                                <textarea class="form-control fs-7" name="alamat" id="alamat" rows="3" required placeholder="Alamat"></textarea>
                            </div>
                            <input type="hidden" name="user_id" value="<?php echo $user_id ?>">
                            <input type="hidden" name="shoes_id" value="<?php echo $product['shoes_id'] ?>">
                            <input type="hidden" name="status" value="Belum Dibayar">
                            <input type="hidden" name="image_url" value="<?php echo $product['image_url'] ?>">
                            <input type="hidden" name="shoes_name" value="<?php echo $product['shoes_name'] ?>">
                            <input type="hidden" name="size" value="<?php echo $product['size'] ?>">
                            <input type="hidden" name="price" value="<?php echo $product['price'] ?>">
                            <input type="hidden" name="jumlah" id="jumlah">
                            <input type="hidden" name="total" id="total">
                            <input type="hidden" name="color" value="<?php echo $product['color'] ?>">
                            <input type="hidden" name="stok" value="<?php echo $product['stok'] ?>">
                        </div>
                        <div style="border-left:1px solid #dee2e6; margin:0 20px"></div>
                        <div class="flex-column checkout-modal" style="width: 100%; max-width: 50%;">
                            <div class="fs-6 mb-4">
                                Detail Pesanan
                            </div>
                            <div class="d-flex">
                                <img src="<?= htmlspecialchars($product['image_url']) ?>" width="100" height="100" alt="" srcset="">
                                <div class="flex-column w-100">
                                    <div class="mt-3 ms-3">
                                        <div class="fs-6 fw-semi-bold">
                                            <?= htmlspecialchars($product['shoes_name']) ?>
                                        </div>
                                        <div class="mt-2 text-prime fs-7">
                                            Variasi: <?= htmlspecialchars($product['color']) ?>, Size: <span id="selectedSize"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-5 ">
                                <table class="table-transaksi w-100">
                                    <tr>
                                        <td>Harga</td>
                                        <td>:</td>
                                        <td>Rp. <?= number_format($product['price'], 0, ',', '.') ?></td>
                                    </tr>
                                    <tr>
                                        <td>Quantity</td>
                                        <td>:</td>
                                        <td id="jumlah2"></td>
                                    </tr>
                                    <tr>
                                        <td>Total Pesanan</td>
                                        <td>:</td>
                                        <td id="total1"></td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-second">Checkout</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    const openModalButton = document.getElementById('openModalButton');
    const harga = <?= $product['price'] ?>;

    // Add click event listener
    openModalButton.addEventListener('click', function(event) {


        // Update selected size in modal
        const selectedSize = document.querySelector('input[name="size"]:checked').value;
        document.getElementById('selectedSize').textContent = selectedSize;

        // Trigger modal manually
        const modal = new bootstrap.Modal(document.getElementById('exampleModal'));
        modal.show();
        isiForm();
    });

    // Function to check if a size is selected
    function isSizeSelected() {
        const selectedSize = document.querySelector('input[name="size"]:checked');
        return selectedSize !== null;
    }

    function isiForm() {
        document.getElementById('jumlah').value = document.getElementById('counterValue').textContent;
        document.getElementById('jumlah2').textContent = document.getElementById('counterValue').textContent;
        document.getElementById('total').value = document.getElementById('counterValue').textContent * harga;
        document.getElementById('total1').textContent = "Rp. " + Intl.NumberFormat('id-ID').format(document.getElementById('counterValue').textContent * harga);
    }
    // Initial value for the counter
    let counter = 1;

    // Get references to the HTML elements
    const counterValueElement = document.getElementById('counterValue');
    const incrementButton = document.getElementById('increment');
    const decrementButton = document.getElementById('decrement');
    const maxStock = <?= $product['stok'] ?>;


    // Event listeners for increment and decrement buttons
    incrementButton.addEventListener('click', () => {
        if (counter < maxStock) { // Prevent increment above 10
            counter++;
        }
        updateCounterDisplay();
    });

    decrementButton.addEventListener('click', () => {
        if (counter > 1) { // Prevent decrement below 1
            counter--;
        }
        updateCounterDisplay();
    });

    // Function to update the displayed counter value
    function updateCounterDisplay() {
        counterValueElement.textContent = counter;
        document.getElementById('jumlah-cart').value = counter;
    }
</script>