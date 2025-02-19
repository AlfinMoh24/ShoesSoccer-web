<?php
include '../config.php';

// Query untuk mendapatkan semua data model
$sql = "SELECT * FROM users WHERE id = $user_id";
$stmt = $conn->prepare($sql);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc(); // Menggunakan variabel $product untuk data profil

// Tutup statement
$stmt->close();

if (isset($_GET['success']) && $_GET['success'] === 'updated') {
    echo "<div class='alert alert-success' id='alertMessage'>Data berhasil diperbarui!</div>";
}
?>
<style>
    .img-profil {
        width: 30%;
        display: flex;
        justify-content: center;
    }

    .img-profil img {
        width: 80%;
        height: fit-content;
        aspect-ratio: 1 / 1;
        object-fit: cover;
        background-color: #d5d5d5;
        border-radius: 15px;
    }

    .form-profil {
        margin-left: 50px;
        width: 50%;
    }

    @media (max-width: 768px) {
        .img-profil {
            width: 100%
        }

        .img-profil img {
            width: 60%;
            margin-bottom: 30px;
        }

        .form-profil {
            width: 100%;
            margin-left: 0;
        }
    }
</style>

<h1 class="h3 mb-3 text-gray-800">Profil</h1>
<!-- DataTales Example -->
<div class="card shadow mb-4">
    <div class="card-body">
        <div class="d-flex flex-column flex-md-row mt-4 mb-4">
            <div class="img-profil">
                <img src="../img-profil/<?php echo $user['img_profil'] ?>" alt="" srcset="">
            </div>
            <div class="form-profil">
                <form action="aksi/edit.php?page=profil&profil=true" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="user_id" value="<?php echo $user['id']; ?>">
                    <div class="mb-3">
                        <label for="name" class="form-label">Username</label>
                        <input type="text" class="form-control" name="username" required placeholder="username" value="<?php echo $user['username'] ?>">
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" name="email" required placeholder="email" value="<?php echo $user['email'] ?>">
                    </div>
                    <?php if ($level === 'seller'): ?>
                        <div class="mb-3">
                            <label for="nama_toko" class="form-label">Nama Toko</label>
                            <input type="text" class="form-control" name="nama_toko" required placeholder="nama toko" value="<?php echo $user['nama_toko'] ?>">
                        </div>
                    <?php endif; ?>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" name="password" required placeholder="password">
                    </div>
                    <div class="mb-3">
                        <label for="konfirmasi_password" class="form-label">Konfirmasi Password</label>
                        <input type="password" class="form-control" name="konfirmasi_password" required placeholder="konfirmasi password">
                    </div>
                    <div class="mb-3">
                        <?php if ($level === 'seller'): ?>
                            <label for="icon_toko" class="form-label">Icon Toko</label>
                        <?php else: ?>
                            <label for="icon_toko" class="form-label">Foto profil</label>
                        <?php endif; ?>
                        <input class="form-control" type="file" name="icon_toko">
                    </div>
                    <button type="submit" class="btn btn-primary">Edit Profil</button>
                </form>
            </div>
        </div>
    </div>
</div>


<script>
    window.addEventListener('load', function() {
        var url = new URL(window.location.href);
        if (url.searchParams.has('success')) {
            url.searchParams.delete('success');
            window.history.replaceState(null, null, url); // Memperbarui URL tanpa reload halaman
        }
    });
</script>