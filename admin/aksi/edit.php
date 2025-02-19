<?php
include "../../config.php";

// Cek apakah ada parameter 'brand' dan data POST untuk pengeditan
if (!empty($_GET['brand'])) {

    $edit_id = $_POST['edit_id'];
    $edit_nama_brand = $_POST['edit_nama_brand'];

    // Query untuk memperbarui data brand berdasarkan ID
    $sql = "UPDATE brands SET brand_name = ? WHERE brand_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $edit_nama_brand, $edit_id);

    if ($stmt->execute()) {
        // Redirect setelah pembaruan berhasil
        header("Location: ../index.php?page=brand&success=updated");
        exit;
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}

if (!empty($_GET['surface'])) {

    $edit_id = $_POST['edit_id'];
    $edit_surface_type = $_POST['edit_surface_type'];
    $edit_description = $_POST['edit_description'];

    // Query untuk memperbarui data brand berdasarkan ID
    $sql = "UPDATE surfaces SET surface_type = ?, description = ? WHERE surface_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssi", $edit_surface_type, $edit_description, $edit_id);

    if ($stmt->execute()) {
        // Redirect setelah pembaruan berhasil
        header("Location: ../index.php?page=surface&success=updated");
        exit;
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}

if (!empty($_GET['position'])) {

    $edit_id = $_POST['edit_id'];
    $edit_position = $_POST['edit_position'];
    $edit_description = $_POST['edit_description'];

    // Query untuk memperbarui data brand berdasarkan ID
    $sql = "UPDATE positions SET position = ?, description = ? WHERE position_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssi", $edit_position, $edit_description, $edit_id);

    if ($stmt->execute()) {
        // Redirect setelah pembaruan berhasil
        header("Location: ../index.php?page=position&success=updated");
        exit;
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}

if (!empty($_GET['material'])) {

    $edit_id = $_POST['edit_id'];
    $edit_material = $_POST['edit_material'];
    $edit_description = $_POST['edit_description'];

    // Query untuk memperbarui data brand berdasarkan ID
    $sql = "UPDATE materials SET material = ?, description = ? WHERE material_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssi", $edit_material, $edit_description, $edit_id);

    if ($stmt->execute()) {
        // Redirect setelah pembaruan berhasil
        header("Location: ../index.php?page=material&success=updated");
        exit;
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}

if (!empty($_GET['series'])) {

    $edit_id = $_POST['edit_id'];
    $edit_series = $_POST['edit_series'];
    $edit_description = $_POST['edit_description'];
    $edit_fungsi = $_POST['edit_fungsi'];

    // Query untuk memperbarui data brand berdasarkan ID
    $sql = "UPDATE series SET series = ?, description = ?, fungsi =? WHERE series_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssi", $edit_series, $edit_description, $edit_fungsi, $edit_id);

    if ($stmt->execute()) {
        // Redirect setelah pembaruan berhasil
        header("Location: ../index.php?page=series&success=updated");
        exit;
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}

if (!empty($_GET['model'])) {

    $edit_id = $_POST['edit_id'];
    $edit_model = $_POST['edit_model'];

    // Query untuk memperbarui data brand berdasarkan ID
    $sql = "UPDATE models SET model = ? WHERE model_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $edit_model, $edit_id);

    if ($stmt->execute()) {
        // Redirect setelah pembaruan berhasil
        header("Location: ../index.php?page=model&success=updated");
        exit;
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}
if (!empty($_GET['produk'])) {
    $product_id = $_POST['product_id'];
    $kode_produk = $_POST['kode_produk'];
    $shoes_name = $_POST['shoes_name'];
    $brand_id = $_POST['brand_id'];
    $surface_id = $_POST['surface_id'];
    $material_id = $_POST['material_id'];
    $series_id = $_POST['series_id'];
    $model_id = $_POST['model_id'];
    $position_id = $_POST['position_id'];
    $color = $_POST['color'];
    $price = $_POST['price'];
    $size = $_POST['size'];
    $stok = $_POST['stok'];

    $brand = $_POST['brand_name'];
    $surface = $_POST['surface_type_name'];
    $material = $_POST['material_name'];
    $series = $_POST['series_fungsi'];
    $position = $_POST['position_name'];
    $data = [
        'brand' => $brand,
        'surface' => $surface,
        'position' => $position,
        'material' => $material,
        'series' => $series,
        'color' => $color
    ];

    $jsonData = json_encode($data);
    // Inisialisasi CURL untuk memanggil API Flask
    $ch = curl_init('https://shoes-soccer-production.up.railway.app/generate_vectors');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);
    $response = curl_exec($ch);
    curl_close($ch);

    // Parse JSON response dari API
    $vectors = json_decode($response, true);

    // Mendapatkan nilai vektor yang dihasilkan
    $brand_vector = json_encode($vectors['brand_vector']);
    $surface_vector = json_encode($vectors['surface_vector']);
    $position_vector = json_encode($vectors['position_vector']);
    $material_vector = json_encode($vectors['material_vector']);
    $series_vector = json_encode($vectors['series_vector']);
    $color_vector = json_encode($vectors['color_vector']);

    // Variabel untuk menyimpan query bagian gambar
    $image_query = "";

    // Proses unggah file jika ada
    if (!empty($_FILES['gambar']['name'])) {
        $target_dir = "../../img-produk/";
        $image_name = basename($_FILES["gambar"]["name"]); // Nama file
        $target_file = $target_dir . $image_name;
        $img_url = "img-produk/" . $image_name;

        // Memeriksa tipe file dan mengunggah file ke server
        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
        $fileType = $_FILES['gambar']['type'];

        if (in_array($fileType, $allowedTypes)) {
            if (move_uploaded_file($_FILES["gambar"]["tmp_name"], $target_file)) {
                // Jika file berhasil diunggah, tambahkan kolom image_url ke query
                $image_query = ", image_url = ?";
            } else {
                echo "Terjadi kesalahan saat mengunggah file.";
                exit;
            }
        } else {
            echo "Hanya file gambar (JPEG, PNG, GIF) yang diperbolehkan.";
            exit;
        }
    }

    // Query untuk memperbarui data produk
    $sql = "UPDATE sepatu SET 
                kode_produk = ?, 
                shoes_name = ?, 
                brand_id = ?, 
                surface_id = ?, 
                material_id = ?, 
                series_id = ?, 
                model_id = ?, 
                position_id = ?, 
                color = ?, 
                price = ?, 
                stok = ?,
                brand_vector = ?,
                surface_vector = ?,
                position_vector = ?,
                material_vector = ?,
                series_vector = ?,
                color_vector = ?,
                size = ?" . $image_query . " 
            WHERE shoes_id = ?";

    // Siapkan statement
    $stmt = $conn->prepare($sql);

    // Bind parameter berdasarkan apakah ada gambar atau tidak
    if (!empty($image_query)) {
        $stmt->bind_param("ssiiiiiisisssssssssi", $kode_produk, $shoes_name, $brand_id, $surface_id, $material_id, $series_id, $model_id, $position_id, $color, $price, $stok, $brand_vector, $surface_vector, $position_vector, $material_vector, $series_vector, $color_vector, $size, $img_url, $product_id);
    } else {
        $stmt->bind_param("ssiiiiiisissssssssi", $kode_produk, $shoes_name, $brand_id, $surface_id, $material_id, $series_id, $model_id, $position_id, $color, $price, $stok, $brand_vector, $surface_vector, $position_vector, $material_vector, $series_vector, $color_vector, $size, $product_id);
    }

    // Eksekusi statement
    if ($stmt->execute()) {
        // Redirect ke halaman produk dengan pesan sukses
        header("Location: ../index.php?page=produk&success=updated");
        exit;
    } else {
        echo "Error: " . $stmt->error;
    }

    // Tutup statement
    $stmt->close();
}


if (isset($_GET['action']) && $_GET['action'] == 'batalkan' && isset($_GET['id_transaksi'], $_GET['jumlah'], $_GET['shoes_id'])) {
    $id_transaksi = intval($_GET['id_transaksi']);
    $jumlah = intval($_GET['jumlah']);
    $shoes_id = intval($_GET['shoes_id']);

    $sql_sepatu = "UPDATE sepatu SET stok = stok + ? WHERE shoes_id = ?";
    $stmt_sepatu = $conn->prepare($sql_sepatu);
    $stmt_sepatu->bind_param("ii", $jumlah, $shoes_id);
    $stmt_sepatu->execute();

    $sql = "UPDATE transaksi SET status = 'Dibatalkan' WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id_transaksi);

    if ($stmt->execute()) {
        echo "<script>alert('Pesanan berhasil dibatalkan.'); window.location.href='../../user/index.php?page=transaksi-detail&id=$id_transaksi';</script>";
    } else {
        echo "<script>alert('Gagal membatalkan pesanan.'); window.location.href='../../user/index.php?page=transaksi-detail';</script>";
        $stmt->error;
    }

    $stmt->close();
    $conn->close();
}

if (!empty($_GET['profil'])) {
    $user_id = $_POST['user_id'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $nama_toko = $_POST['nama_toko'];
    $password = $_POST['password'];
    $konfirmasi_password = $_POST['konfirmasi_password'];

    // Cek apakah password dan konfirmasi password cocok
    if ($password != $konfirmasi_password) {
        die("Password dan konfirmasi password tidak cocok.");
    }

    // Hash password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Proses unggah file jika ada
    $image_query = ""; // Tambahan untuk kolom gambar
    $image_name = null; // Nilai default untuk nama gambar
    if (!empty($_FILES['icon_toko']['name'])) {
        $target_dir = "../../img-profil/";
        $image_name = $nama_toko ."." . pathinfo( $_FILES['icon_toko']['name'], PATHINFO_EXTENSION);
        $target_file = $target_dir . $image_name;
        $img_url = "img-profil/" . $image_name;

        // Memeriksa tipe file dan mengunggah file ke server
        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
        $fileType = $_FILES['icon_toko']['type'];

        if (in_array($fileType, $allowedTypes)) {
            if (move_uploaded_file($_FILES["icon_toko"]["tmp_name"], $target_file)) {
                // Tambahkan kolom image_url ke query
                $image_query = ", img_profil = ?";
            } else {
                echo "Terjadi kesalahan saat mengunggah file.";
                exit;
            }
        } else {
            echo "Hanya file gambar (JPEG, PNG, GIF) yang diperbolehkan.";
            exit;
        }
    }

    // Query untuk memperbarui data produk (dinamis sesuai gambar)
    $sql = "UPDATE users SET 
                username = ?, 
                email = ?, 
                nama_toko = ?, 
                password = ?";
    if (!empty($image_query)) {
        $sql .= $image_query;
    }
    $sql .= " WHERE id = ?";

    // Siapkan statement
    $stmt = $conn->prepare($sql);

    if (!empty($image_query)) {
        // Jika gambar diunggah
        $stmt->bind_param("sssssi", $username, $email, $nama_toko, $hashed_password, $image_name, $user_id);
    } else {
        // Jika gambar tidak diunggah
        $stmt->bind_param("ssssi", $username, $email, $nama_toko, $hashed_password, $user_id);
    }

    // Eksekusi statement
    if ($stmt->execute()) {
        // Redirect ke halaman profil dengan pesan sukses
        header("Location: ../index.php?page=profil&success=updated");
        exit;
    } else {
        echo "Error: " . $stmt->error;
    }

    // Tutup statement
    $stmt->close();
}


$conn->close();
