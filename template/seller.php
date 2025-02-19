<style>
    .col-seller {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 40px;
        min-height: 100vh;
    }

    .seller-item {
        display: flex;
        justify-content: center;
        align-items: end;
        padding: 40px 0;
        animation-name: faderight;
        animation-duration: 1.5s;
    }

    .seller-item img {
        height: 80%;
        object-fit: cover;
    }

    .seller-item-left {
        display: flex;
        flex-direction: column;
        justify-content: center;
        gap: 0px;
    }
</style>

<section id="hero" class="hero" style="min-height:100vh">
    <div class="container">
        <div class="col-seller">
            <div class="seller-item">
                <img src="assets/img/aff.png" width="100%" alt="" srcset="">
            </div>
            <div class="seller-item-left">
                <h2><strong>Gabung Sebagai Seller di <span class="text-second">SHOESSOCCER</span> dan Maksimalkan Penjualan Produk Sepak Bola Anda!</strong></h1>
                <div>
                    <button class="btn-second shadow mt-4 py-2 px-4 rounded-pill" onclick=" window.location.href='index.php?page=daftar-seller'">Daftar Sekarang</button>
                </div>
            </div>
        </div>
</section>