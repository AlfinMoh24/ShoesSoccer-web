<?php
$sql = "
SELECT cart.*, 
       sepatu.image_url,
       sepatu.shoes_name,
       sepatu.color,
       sepatu.stok,
       sepatu.size,
       sepatu.price
FROM cart LEFT JOIN sepatu ON cart.shoes_id = sepatu.shoes_id WHERE cart.user_id = $user_id";

$stmt = $conn->query($sql);
// Mengambil semua data sekaligus
$rows = $stmt->fetch_all(MYSQLI_ASSOC);

// Loop pertama untuk tampilan desktop

?>
<div class="mb-5 container" style="padding-top:90px">
    <div class="shadow-sm p-3 mb-5 bg-body-tertiary rounded">
        <div class="border p-3 mb-5 bg-body-tertiary rounded">
            <?php if ($stmt->num_rows > 0): ?>
                <!-- tampilan desktop -->
                <table class="table-cart fs-7">
                    <tr>
                        <th></th>
                        <th>Produk</th>
                        <th></th>
                        <th>Harga</th>
                        <th>Ukuran</th>
                        <th>Stok</th>
                        <th>Jumlah</th>
                        <th></th>
                    </tr>

                    <?php foreach ($rows as $row): ?>
                        <tr>
                            <td>
                                <button type="button" class="btn btn-sm btn-danger " data-bs-toggle="modal" data-bs-target="#confirmDeleteModal" onclick="setDeleteId(<?= $row['id'] ?>)">
                                    <i class="fas fa-close"></i>
                                </button>
                            </td>
                            <td>
                                <img src="../<?= htmlspecialchars($row['image_url']) ?>" width="120" alt="" srcset="">
                            </td>
                            <td>
                                <div class="mb-2 d-flex flex-column ">
                                    <div class="fs-6 fw-semi-bold">
                                        <?= htmlspecialchars($row['shoes_name']) ?>
                                    </div>
                                    <div class="mt-2 text-prime">
                                        Variasi: <?= htmlspecialchars($row['color']) ?>
                                    </div>
                                </div>
                            </td>
                            <td>Rp. <?= number_format($row['price'], 0, ',', '.') ?></td>
                            <td>
                                <div class="d-flex justify-content-center">
                                    <select class="form-select fs-7" style="width:auto;" name="" id="ukuran-<?= $row['id'] ?>">
                                        <?php
                                        $size_range = $row['size'];
                                        list($start_size, $end_size) = explode("-", $size_range); // Pisahkan awal dan akhir rentang
                                        $sizes = range((int)$start_size, (int)$end_size);
                                        ?>
                                        <?php foreach ($sizes as $size): ?>
                                            <option value="<?= $size ?>"><?= $size ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </td>
                            <td id="stok-<?= $row['id'] ?>">
                                <?= $row['stok'] == 0 ? 'Stok Habis' : htmlspecialchars($row['stok']) ?>
                            </td>
                            <td>
                                <div class="counter d-flex justify-content-center">
                                    <i class="fa-solid fa-minus" id="decrement-<?= $row['id'] ?>"></i>
                                    <span id="counterValue-<?= $row['id'] ?>"><?= $row['jumlah'] ?></span>
                                    <i class="fa-solid fa-plus" id="increment-<?= $row['id'] ?>"></i>
                                </div>
                            </td>
                            <td>
                                <button
                                    class="btn btn-second rounded-pill fs-7 px-4"
                                    data-bs-toggle="modal"
                                    data-bs-target="#exampleModal"
                                    onclick="isiForm('<?= $row['id'] ?>', '<?= $row['shoes_id'] ?>', '<?= $row['image_url'] ?>', '<?= $row['shoes_name'] ?>', '<?= $row['price'] ?>',  '<?= $row['color'] ?>', '<?= $row['stok'] ?>')"
                                    <?= $row['stok'] == 0 ? 'disabled' : '' ?>>
                                    Checkout
                                </button>

                            </td>
                        </tr>
                    <?php endforeach; ?>
                </table>
                <!-- tampilan mobile -->
                <div class="tampilan-mobile">
                    <?php foreach ($rows as $row): ?>
                        <div class="row product-detail mb-5">
                            
                            <div class="d-flex align-items-center ">
                            
                                <img src="../<?= htmlspecialchars($row['image_url']) ?>" style="width:30%; height:fit-content" alt="" srcset="">
                                <div class="ms-4 fs-8 d-flex flex-column w-100 justify-content-center">
                                    <div class="product-name "><?= htmlspecialchars($row['shoes_name']) ?></div>
                                    <div class="mt-2 text-prime">
                                        Variasi: <?= htmlspecialchars($row['color']) ?>
                                    </div>
                                    <div class="d-flex justify-content-between mt-2">
                                        <div class="product-price text-prime">Harga: Rp. <?= number_format($row['price'], 0, ',', '.') ?></div>
                                        <div class="product-stock">Stok: <?= $row['stok'] == 0 ? 'Stok Habis' : htmlspecialchars($row['stok']) ?></div>
                                    </div>
                                    <div class="d-flex justify-content-between  mt-2">
                                        <div class="">
                                            <select class="form-select" style="width:auto;" name="" id="ukuranM-<?= $row['id'] ?>">
                                                <?php
                                                $size_range = $row['size'];
                                                list($start_size, $end_size) = explode("-", $size_range);
                                                $sizes = range((int)$start_size, (int)$end_size);
                                                ?>
                                                <?php foreach ($sizes as $size): ?>
                                                    <option value="<?= $size ?>"><?= $size ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                        <div class="counter">
                                            <i class="fa-solid fa-minus" id="decrementM-<?= $row['id'] ?>"></i>
                                            <span id="counterValueM-<?= $row['id'] ?>"><?= $row['jumlah'] ?></span>
                                            <i class="fa-solid fa-plus" id="incrementM-<?= $row['id'] ?>"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex justify-content-end mt-4">
                            <button type="button" class="btn btn-sm rounded-pill btn-danger me-2 px-4" data-bs-toggle="modal" data-bs-target="#confirmDeleteModal" onclick="setDeleteId(<?= $row['id'] ?>)">
                               Hapus dari Keranjang
                            </button>
                                <button
                                    class="btn btn-second rounded-pill fs-8 px-4 "
                                    data-bs-toggle="modal"
                                    data-bs-target="#exampleModal"
                                    onclick="isiFormM('<?= $row['id'] ?>', '<?= $row['shoes_id'] ?>', '<?= $row['image_url'] ?>', '<?= $row['shoes_name'] ?>', '<?= $row['price'] ?>',  '<?= $row['color'] ?>', '<?= $row['stok'] ?>')"
                                    <?= $row['stok'] == 0 ? 'disabled' : '' ?>>
                                    Checkout
                                </button>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else : ?>
                <div class="w-100 d-flex justify-content-center text-prime">
                    <?php echo 'Tidak ada produk' ?>
                </div>
            <?php endif ?>
        </div>
    </div>
</div>

<div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-labelledby="confirmDeleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Konfirmasi Hapus</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-secondary">
                Apakah Anda yakin ingin menghapus dari keranjang?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <a href="#" id="confirmDeleteButton" class="btn btn-danger">Hapus</a>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Modal title</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="../admin/aksi/tambah.php" method="post">
                <input type="hidden" name="action" value="add_transaksi_cart">
                <div class="modal-body">
                    <div class="d-flex flex-column-reverse flex-md-row g-3">
                        <div class="flex-column fs-7 checkout-modal" style="width: 100%; max-width: 40%;">
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
                            <input type="hidden" name="cart_id">
                            <input type="hidden" name="shoes_id">
                            <input type="hidden" name="status" value="Belum Dibayar">
                            <input type="hidden" name="image_url">
                            <input type="hidden" name="shoes_name">
                            <input type="hidden" name="size">
                            <input type="hidden" name="price">
                            <input type="hidden" name="jumlah">
                            <input type="hidden" name="total">
                            <input type="hidden" name="color">
                            <input type="hidden" name="stok">
                        </div>
                        <div style="border-left:1px solid #dee2e6; margin:0 20px"></div>
                        <div class="flex-column checkout-modal" style="width: 100%; max-width: 50%;">
                            <div class="fs-6 mb-4">
                                Detail Pesanan
                            </div>
                            <div class="d-flex">
                                <img id="img-src" src="" width="100" height="100" alt="" srcset="">
                                <div class="flex-column w-100">
                                    <div class="mt-3 ms-3">
                                        <div class="fs-6 fw-semi-bold" id="shoes_name"></div>
                                        <div class="mt-2 text-prime fs-7">
                                            Variasi: <span id="color"></span>, Size: <span id="selectedSize"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-5 ">
                                <table class="table-transaksi w-100">
                                    <tr>
                                        <td>Harga</td>
                                        <td>:</td>
                                        <td id="harga"></td>
                                    </tr>
                                    <tr>
                                        <td>Quantity</td>
                                        <td>:</td>
                                        <td id="jumlah"></td>
                                    </tr>
                                    <tr>
                                        <td>Total Pesanan</td>
                                        <td>:</td>
                                        <td id="total"></td>
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
    function setDeleteId(id) {
        // Set href pada tombol hapus di modal dengan ID yang sesuai
        document.getElementById('confirmDeleteButton').href = '../admin/aksi/hapus.php?page=cart&delete_id=' + id + '&cart=true';
    }


    // console.log()

    function isiForm(cart_id, shoes_id, image_url, shoes_name, price, color, stok) {
        ukuran = document.querySelector('#ukuran-' + cart_id).value;
        total = document.getElementById('counterValue-' + cart_id).textContent * price;
        jumlah = document.getElementById('counterValue-' + cart_id).textContent;
        document.getElementById('img-src').src = '../' + image_url;
        document.getElementById('shoes_name').textContent = shoes_name;
        document.getElementById('color').textContent = color;
        document.getElementById('selectedSize').innerHTML = ukuran;
        document.getElementById('harga').textContent = "Rp. " + Intl.NumberFormat('id-ID').format(price);
        document.getElementById('jumlah').textContent = jumlah;
        document.getElementById('total').textContent = "Rp. " + Intl.NumberFormat('id-ID').format(total);
        document.getElementsByName('cart_id')[0].value = cart_id;
        document.getElementsByName('shoes_id')[0].value = shoes_id;
        document.getElementsByName('image_url')[0].value = image_url;
        document.getElementsByName('shoes_name')[0].value = shoes_name;
        document.getElementsByName('jumlah')[0].value = jumlah;
        document.getElementsByName('size')[0].value = ukuran;
        document.getElementsByName('price')[0].value = price;
        document.getElementsByName('total')[0].value = total;
        document.getElementsByName('color')[0].value = color;
        document.getElementsByName('stok')[0].value = stok;
    }

    function isiFormM(cart_id, shoes_id, image_url, shoes_name, price, color, stok) {
        ukuran = document.querySelector('#ukuranM-' + cart_id).value;
        total = document.getElementById('counterValueM-' + cart_id).textContent * price;
        jumlah = document.getElementById('counterValueM-' + cart_id).textContent;
        document.getElementById('img-src').src = '../' + image_url;
        document.getElementById('shoes_name').textContent = shoes_name;
        document.getElementById('color').textContent = color;
        document.getElementById('selectedSize').innerHTML = ukuran;
        document.getElementById('harga').textContent = "Rp. " + Intl.NumberFormat('id-ID').format(price);
        document.getElementById('jumlah').textContent = jumlah;
        document.getElementById('total').textContent = "Rp. " + Intl.NumberFormat('id-ID').format(total);
        document.getElementsByName('cart_id')[0].value = cart_id;
        document.getElementsByName('shoes_id')[0].value = shoes_id;
        document.getElementsByName('image_url')[0].value = image_url;
        document.getElementsByName('shoes_name')[0].value = shoes_name;
        document.getElementsByName('jumlah')[0].value = jumlah;
        document.getElementsByName('size')[0].value = ukuran;
        document.getElementsByName('price')[0].value = price;
        document.getElementsByName('total')[0].value = total;
        document.getElementsByName('color')[0].value = color;
        document.getElementsByName('stok')[0].value = stok;
    }

    // Pilih semua elemen yang memiliki ID dengan pola "counterValue-"
    document.querySelectorAll('[id^="counterValue-"]').forEach(counterElement => {
    // Ambil ID unik dari elemen
    const id = counterElement.id.split('-')[1]; // Ekstrak ID unik dari format "counterValue-<id>"

    // Dapatkan elemen increment dan decrement yang terkait
    const incrementButton = document.getElementById(`increment-${id}`);
    const decrementButton = document.getElementById(`decrement-${id}`);
    let counter = parseInt(counterElement.textContent, 10);

    // Dapatkan elemen stok yang sesuai dengan ID unik
    const stokElement = document.getElementById(`stok-${id}`);
    const maxStock = parseInt(stokElement.textContent, 10) || 0; // Ambil stok sebagai angka

    // Event listener untuk tombol increment
    incrementButton.addEventListener('click', () => {
        if (counter < maxStock) {
            counter++;
        }
        updateCounterDisplay(counterElement, counter);
    });

    // Event listener untuk tombol decrement
    decrementButton.addEventListener('click', () => {
        if (counter > 1) {
            counter--;
        }
        updateCounterDisplay(counterElement, counter);
    });

    function updateCounterDisplay(element, value) {
        element.textContent = value;
    }
});


document.querySelectorAll('[id^="counterValueM-"]').forEach(counterElement => {
    // Ambil ID unik dari elemen
    const id = counterElement.id.split('-')[1]; // Ekstrak ID unik dari format "counterValue-<id>"

    // Dapatkan elemen increment dan decrement yang terkait
    const incrementButton = document.getElementById(`incrementM-${id}`);
    const decrementButton = document.getElementById(`decrementM-${id}`);
    let counter = parseInt(counterElement.textContent, 10);

    // Dapatkan elemen stok yang sesuai dengan ID unik
    const stokElement = document.getElementById(`stok-${id}`);
    const maxStock = parseInt(stokElement.textContent, 10) || 0; // Ambil stok sebagai angka

    // Event listener untuk tombol increment
    incrementButton.addEventListener('click', () => {
        if (counter < maxStock) {
            counter++;
        }
        updateCounterDisplay(counterElement, counter);
    });

    // Event listener untuk tombol decrement
    decrementButton.addEventListener('click', () => {
        if (counter > 1) {
            counter--;
        }
        updateCounterDisplay(counterElement, counter);
    });

    function updateCounterDisplay(element, value) {
        element.textContent = value;
    }
});

</script>