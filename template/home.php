<?php
$sql1 = "SELECT *FROM sepatu WHERE sepatu.stok > 0";
$all = $conn->query($sql1);

?>
<section id="hero" class="hero">
    <div class="container h-100">
        <div class="d-flex flex-column flex-md-row h-100">
            <div class="col d-flex align-items-center">
                <div class="col">
                    <div class="navbar-brand fs-1 fw-bold mb-3" href="#">SHOES<span
                            class="text-second">SOCCER</span>
                    </div>
                    <span class="fw-medium text-justify">ShoesSoccer adalah website e-commerce yang menyediakan berbagai pilihan sepatu sepak bola berkualitas. Website ini memberikan pengalaman belanja yang mudah dan nyaman, dengan pilihan sepatu yang dapat disortir berdasarkan preferensi pengguna.</span>
                    <br>
                    <button class="btn-second shadow mt-4 py-2 px-4 rounded-pill" onclick=" window.location.href='#produk'">Buy Now</button>
                </div>
            </div>
            <!-- slide gambar -->
            <div class="col swiper mySwiper">
                <div class="swiper-wrapper">
                    <div class="swiper-slide">
                        <img src="assets/img/img1.png" alt="" srcset="">
                    </div>
                    <div class="swiper-slide">
                        <img src="assets/img/img2.png" alt="" srcset="">
                    </div>
                    <div class="swiper-slide">
                        <img src="assets/img/img3.png" alt="" srcset="">
                    </div>
                </div>
                <div class="swiper-pagination"></div>
            </div>
        </div>
</section>

<!-- section produk -->
<section id="produk" class="produk mt-4">
    <div class="container">
        <div class="most-populer flex-column gap-3 mb-4">
            <div class="w-100 bg-prime rounded-pill px-5 py-3 mb-4 fw-semibold fs-5 text-center">All Produk</div>
            <?php if ($all->num_rows > 0): ?>
                <div class="row grid-5 gap-3 px-2">
                    <?php
                    $data = $all->fetch_all(MYSQLI_ASSOC);
                    $data = array_slice($data, 0, 10); // Ambil maksimal 10 item

                    foreach ($data as $row): ?>
                        <?php if ($row['stok'] > 0): // Tambahkan kondisi stok > 0 
                        ?>
                            <div class="produk-item p-3"
                                onclick="window.location.href='index.php?page=produk&id=<?= htmlspecialchars($row['shoes_id']) ?>'">
                                <div class="d-flex flex-column justify-content-between h-100">
                                    <div>
                                        <img src="<?= htmlspecialchars($row['image_url']) ?>" width="100%" alt="" srcset="">
                                        <div class="fw-bold mt-3 fs-7 "><?= htmlspecialchars($row['shoes_name']) ?></div>
                                        <div class="fs-8 py-2">Rp. <?= number_format($row['price'], 0, ',', '.') ?></div>
                                    </div>
                                    <div class="fs-7 fw-medium mt-3 me-4 d-flex justify-content-between">

                                        <div>Terjual : <?= htmlspecialchars($row['terjual']) ?></div>
                                        Stok: <?= htmlspecialchars($row['stok']) ?>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <div class="col-12 text-center py-5">
                    <p class="fs-4 text-muted">Tidak ada produk</p>
                </div>
            <?php endif; ?>
            <?php if ($all->num_rows > 10): ?>
                <div class="w-100 d-flex justify-content-center">
                    <a href="index.php?page=all-produk" class="btn-second shadow mt-5 py-2 px-3 fs-7 rounded-pill">Tampilkan Semua &nbsp; <i class="fa-solid fa-chevron-down"></i></a>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>

<!-- contact -->
<section id="kontak" class="bg-prime mt-5" style="padding-top: 30px;">
    <div class="container p-3">
        <div class="d-flex flex-column flex-md-row h-100">
            <div class="col d-flex justify-content-center mb-4">
                <img src="assets/img/contact.png" width="50%" alt="" srcset="">
            </div>
            <div class="col d-flex align-items-center">
                <div class="col">
                    <div class="navbar-brand fs-5 fw-bold mb-3 text-center text-md-start" href="#">
                        Hubungi Kami
                    </div>
                    <div class="fw-bold fs-1 text-center text-md-start">Dukungan Pelanggan Siap Membantu</div>
                    <br>
                    <div class="d-flex justify-content-center justify-content-md-start">
                        <button class="btn-second shadow mt-4 py-3 px-4 rounded-pill"><i
                                class="fa-brands fa-whatsapp"></i> &nbsp;Whatsapp Sekarang</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- faq -->
<section id="faq" class="bg-prime">
    <div class="container pt-2 pb-5 d-flex flex-column align-items-center gap-4">
        <br>
        <div class="fs-2 fw-bold">
            Faq's
        </div>
        <div class="container-faq">
            <div class="question">
                Apa saja metode pembayaran yang tersedia?
            </div>
            <div class="answercont">
                <div class="answer">
                    Untuk memudahkan transaksi, kami menyediakan berbagai metode pembayaran yang aman dan nyaman. diantaranya: Transfer Bank, E-Wallet (Qris, Ovo, Dana, Shopeepay), Virtual account, payLater, Alfa Group, Indomaret
                </div>
            </div>
        </div>
        <div class="container-faq">
            <div class="question">
                Bagaimana saya mendapatkan rekomendasi sepatu?
            </div>
            <div class="answercont">
                <div class="answer">
                    Untuk mendapatkan rekomedasi sepatu sesuai keinginan, anda bisa pilih menu prefrenece, kemudian jawab pertanyaan chtabot dan anda akan mendapatkan rekomendasi sepatu sesuai pilihan anda
                </div>
            </div>
        </div>
        <div class="container-faq">
            <div class="question">
                Bagaimana cara memperbarui alamat pengiriman?
            </div>
            <div class="answercont">
                <div class="answer">
                    Setelah melakukan checkout anda tidak bisa mengubah alamat pebgiriman, pastikan alamat sudah benar sebelum melakukan checkout. jika sudah terlanjur checkout maka anda bisa melakukan pembatalan transaksi terlebih dahulu kemudian chekout kembali dan mengisi alamat pengiriman yang benar
                </div>
            </div>
        </div>
        <div class="container-faq">
            <div class="question">
                Bagaimana cara menggunakan website SHOESSOCCER?
            </div>
            <div class="answercont">
                <div class="answer">
                    Untuk panduan penggunaan website bisa di unduh <span style="cursor:pointer; color:blueviolet" onclick="downloadFile()">disini</span>
                </div>
            </div>
        </div>
    </div>

</section>
<div class="modal fade" id="iklanModal" tabindex="-1" aria-labelledby="iklanModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <img src="assets/img/iklan.png" width="100%" alt="" srcset="">
            </div>
            <div class="modal-footer" style="justify-content:center">
                <button type="button" class="btn btn-second" data-bs-dismiss="modal">Order Now</button>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Deteksi halaman awal berdasarkan parameter URL
        const urlParams = new URLSearchParams(window.location.search);
        const currentPage = urlParams.get('page');
        const isHomePage = currentPage === 'home' || window.location.pathname.includes('index.php'); // Menambahkan pengecekan untuk index.php
        const logoutParam = urlParams.get('logout'); // Mengambil parameter logout

        const hasVisited = sessionStorage.getItem('iklanDilihat');
        const isRefreshed = performance.navigation.type === 1; // 1 indicates refresh

        if ((isHomePage && (!hasVisited || isRefreshed))) {
            var iklanModal = new bootstrap.Modal(document.getElementById('iklanModal'));
            iklanModal.show();
            sessionStorage.setItem('iklanDilihat', 'true');
        }

        // Menampilkan modal iklan jika logout terjadi
        if (logoutParam === 'true') {
            // Menampilkan modal iklan
            var iklanModal = new bootstrap.Modal(document.getElementById('iklanModal'));
            iklanModal.show();

            // Hapus parameter ?logout=true dari URL tanpa me-reload halaman
            const currentUrl = window.location.href.split('?')[0]; // URL tanpa parameter query
            history.pushState({}, '', currentUrl); // Memperbarui URL di browser
        }
    });
</script>
<script>
    function downloadFile() {
    window.open('MANUAL BOOK APK.pdf', '_blank');
}
</script>