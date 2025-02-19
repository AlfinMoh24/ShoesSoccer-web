<?php
include '../../config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Mengambil jenis data dari input `action`
    $action = $_POST['action'];

    switch ($action) {
        case 'add_brand':
            if (isset($_POST['nama_brand']) && isset($_POST['kode_brand'])) {
                $kode_brand = $_POST['kode_brand'];
                $nama_brand = $_POST['nama_brand'];

                $sql = "INSERT INTO brands (kode_brand, brand_name) VALUES (?, ?)";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("ss", $kode_brand, $nama_brand);

                if ($stmt->execute()) {
                    header("Location: ../index.php?page=brand&success=added");
                    exit;
                } else {
                    echo "Error: " . $stmt->error;
                }
                $stmt->close();
            }
            break;

        case 'add_surface':
            if (isset($_POST['surface_type']) && isset($_POST['description'])) {
                $surface_type = $_POST['surface_type'];
                $description = $_POST['description'];

                $sql = "INSERT INTO surfaces (surface_type, description) VALUES (?, ?)";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("ss", $surface_type, $description);

                if ($stmt->execute()) {
                    header("Location: ../index.php?page=surface&success=added");
                    exit;
                } else {
                    echo "Error: " . $stmt->error;
                }
                $stmt->close();
            }
            break;

        case 'add_position':
            if (isset($_POST['position']) && isset($_POST['description'])) {
                $position = $_POST['position'];
                $description = $_POST['description'];

                $sql = "INSERT INTO positions (position, description) VALUES (?, ?)";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("ss", $position, $description);

                if ($stmt->execute()) {
                    header("Location: ../index.php?page=position&success=added");
                    exit;
                } else {
                    echo "Error: " . $stmt->error;
                }
                $stmt->close();
            }
            break;

        case 'add_material':
            if (isset($_POST['material']) && isset($_POST['description'])) {
                $material = $_POST['material'];
                $description = $_POST['description'];

                $sql = "INSERT INTO materials (material, description) VALUES (?, ?)";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("ss", $material, $description);

                if ($stmt->execute()) {
                    header("Location: ../index.php?page=material&success=added");
                    exit;
                } else {
                    echo "Error: " . $stmt->error;
                }
                $stmt->close();
            }
            break;
        case 'add_series':
            if (isset($_POST['series']) && isset($_POST['description'])) {
                $series = $_POST['series'];
                $fungsi = $_POST['fungsi'];
                $description = $_POST['description'];

                $sql = "INSERT INTO series (series, fungsi, description) VALUES (?, ?, ?)";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("sss", $series, $fungsi, $description);

                if ($stmt->execute()) {
                    header("Location: ../index.php?page=series&success=added");
                    exit;
                } else {
                    echo "Error: " . $stmt->error;
                }
                $stmt->close();
            }
            break;
        case 'add_model':
            if (isset($_POST['model'])) {
                $model = $_POST['model'];

                $sql = "INSERT INTO models (model) VALUES (?)";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("s", $model);

                if ($stmt->execute()) {
                    header("Location: ../index.php?page=model&success=added");
                    exit;
                } else {
                    echo "Error: " . $stmt->error;
                }
                $stmt->close();
            }
            break;
        case 'add_produk':
            if (isset($_POST['kode_produk'])) {
                $kode_produk = $_POST['kode_produk'];
                $user_id = $_POST['user_id'];
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
                // Proses unggah file
                $target_dir = "../../img-produk/"; // Folder penyimpanan file
                $image_name = basename($_FILES["gambar"]["name"]); // Nama file
                $target_file = $target_dir . $image_name;
                $img_url = "img-produk/" . $image_name;
                // Memeriksa tipe file dan mengunggah file ke server
                $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
                $fileType = $_FILES['gambar']['type'];

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

                if (in_array($fileType, $allowedTypes)) {
                    if (move_uploaded_file($_FILES["gambar"]["tmp_name"], $target_file)) {
                        // Jika file berhasil diunggah, simpan path ke database
                        $sql = "INSERT INTO sepatu (kode_produk, id_toko, shoes_name, brand_id, surface_id, material_id, series_id, model_id, position_id, color, price, size, stok, image_url, brand_vector, surface_vector, position_vector, material_vector, series_vector, color_vector) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
                        $stmt = $conn->prepare($sql);
                        $stmt->bind_param("sisiiiiiisisssssssss", $kode_produk,$user_id, $shoes_name, $brand_id, $surface_id, $material_id, $series_id, $model_id, $position_id, $color, $price, $size, $stok, $img_url, $brand_vector, $surface_vector, $position_vector, $material_vector, $series_vector, $color_vector);

                        if ($stmt->execute()) {
                            header("Location: ../index.php?page=produk&success=added");
                            exit;
                        } else {
                            echo "Error: " . $stmt->error;
                        }
                        $stmt->close();
                    } else {
                        echo "Terjadi kesalahan saat mengunggah file.";
                    }
                } else {
                    echo "Hanya file gambar (JPEG, PNG, GIF) yang diperbolehkan.";
                }
            }
        case 'add_admin':
            if (isset($_POST['username'])) {
                $username = $_POST['username'];
                $email = $_POST['email'];
                $password = $_POST['password'];
                $confirm_password = $_POST['confirm_password'];

                // Validasi password
                if ($password != $confirm_password) {
                    echo "<script>alert('Password dan konfirmasi password tidak cocok.'); window.history.back();</script>";
                    exit;
                }

                // Enkripsi password
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);

                try {
                    // Query untuk menyimpan data
                    $sql = "INSERT INTO users (username, email, password, level) VALUES (?, ?, ?, 'admin')";
                    $stmt = $conn->prepare($sql);
                    $stmt->bind_param("sss", $username, $email, $hashed_password);

                    if ($stmt->execute()) {
                        // Redirect jika berhasil
                        header("Location: ../index.php?page=user&success=added");
                        exit;
                    }
                } catch (mysqli_sql_exception $e) {
                    // Tangkap error duplicate entry
                    if ($e->getCode() == 1062) { // 1062 adalah kode error untuk duplicate entry di MySQL
                        echo "<script>alert('Username atau email sudah digunakan, silakan pilih yang lain.'); window.history.back();</script>";
                    } else {
                        // Tampilkan pesan error lain
                        echo "Error: " . $e->getMessage();
                    }
                }

                $stmt->close();
                $conn->close();
            }
            break;
        case 'add_user_recommendation':
            if (isset($_POST['position'])) {
                $user_id = $_POST['user_id'];
                $brand = $_POST['brand'];
                $surface = $_POST['surface'];
                $material = $_POST['material'];
                $color = $_POST['color'];
                $series = $_POST['series'];
                $position = $_POST['position'];
                $prioritas = $_POST['prioritas'];
                $price_range = $_POST['price'];
                $price_json_str = str_replace(["min", "max"], ['"min"', '"max"'], $price_range); // Tambahkan kutipan pada key
                $price_json_str = str_replace("'", '"', $price_json_str);  // Ubah kutipan tunggal ke ganda

                // Decode ke array PHP
                $query = "SELECT * FROM sepatu";
                $result = $conn->query($query);
                $hasil = $result->fetch_all(MYSQLI_ASSOC);

                $price_json = json_decode($price_json_str, true);
                $data = [
                    'brand' => $brand,
                    'surface' => $surface,
                    'position' => $position,
                    'material' => $material,
                    'color' => $color,
                    'series' => $series,
                    'prioritas' => $prioritas,
                    'price_range' => $price_json,
                    'database'=>$hasil
                ];
                $jsonData = json_encode($data);
                // Inisialisasi CURL untuk memanggil API Flask
                $ch = curl_init('https://shoes-soccer-production.up.railway.app/get_similarity');
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
                curl_setopt($ch, CURLOPT_POST, true);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);
                $response = curl_exec($ch);
                curl_close($ch);

                // Parse JSON response dari API
                $recommendations = json_decode($response, true);
                // var_dump($user_id);

                $sql = "DELETE FROM user_recommendation WHERE user_id = ?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("i", $user_id);
                $stmt->execute();
                $stmt->close();

                // Masukkan rekomendasi baru ke tabel user_recommendation
                // Membuat array untuk menyimpan nomor urut per user
                $user_recommendation_counter = [];

                // Loop untuk memasukkan setiap rekomendasi
                foreach ($recommendations as $recommendation) {
                    // Tentukan nomor urut untuk user ini (1-16)
                    if (!isset($user_recommendation_counter[$user_id])) {
                        $user_recommendation_counter[$user_id] = 1;
                    }
                    $no = $user_recommendation_counter[$user_id];

                    // Pastikan nomor urut tidak melebihi 16
                    if ($no > 16) {
                        continue;  // Jika sudah lebih dari 16, lewati
                    }

                    // SQL query untuk memasukkan data rekomendasi
                    $sql = "INSERT INTO user_recommendation 
                (user_id, no, shoes_id, material_id, brand_id, surface_id, position_id, series_id, brand_similarity, material_similarity, position_similarity, series_similarity,
                surface_similarity,color_similarity, average_similarity)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

                    // Ambil data yang diperlukan dari recommendation
                    $data = [
                        $user_id,
                        $no,  // Nomor urut manual
                        $recommendation['shoes_id'],
                        $recommendation['material_id'],
                        $recommendation['brand_id'],
                        $recommendation['surface_id'],
                        $recommendation['position_id'],
                        $recommendation['series_id'],
                        $recommendation['brand_similarity'],
                        $recommendation['material_similarity'],
                        $recommendation['position_similarity'],
                        $recommendation['series_similarity'],
                        $recommendation['surface_similarity'],
                        $recommendation['color_similarity'],
                        $recommendation['average_similarity']
                    ];

                    // Eksekusi query untuk memasukkan data
                    $stmt = $conn->prepare($sql);
                    $stmt->bind_param("iiiiiiiiddddddd", ...$data);
                    if (!$stmt->execute()) {
                        echo "Error: " . $stmt->error;
                    }
                    $stmt->close();

                    // Increment nomor urut untuk user ini
                    $user_recommendation_counter[$user_id]++;
                }
                header("Location: ../../user/index.php?page=home&id=$user_id");
                exit;
            }
            break;

        case 'add_transaksi':
            if (isset($_POST['nama'])) {
                $nama = $_POST['nama'];
                $nomor = $_POST['nomor'];
                $email = $_POST['email'];
                $alamat = $_POST['alamat'];
                $user_id = $_POST['user_id'];
                $shoes_id = $_POST['shoes_id'];
                $shoes_name = $_POST['shoes_name'];
                $image_url = $_POST['image_url'];
                $color = $_POST['color'];
                $size = $_POST['size'];
                $price = $_POST['price'];
                $jumlah = $_POST['jumlah'];
                $total = $_POST['total'];
                $status = $_POST['status'];
                $stok = $_POST['stok'];
                $sisa = (int)$stok - (int)$jumlah;

                $update = "UPDATE sepatu SET stok = ? WHERE shoes_id = ?";
                $stmt1 = $conn->prepare($update);
                $stmt1->bind_param("ii", $sisa, $shoes_id);
                $stmt1->execute();
                $stmt1->close();

                $sql = "INSERT INTO transaksi (nama, nomor, email, alamat, user_id, shoes_id, shoes_name, image_url, color, size, price, jumlah, total, status) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("ssssiisssiiiis", $nama, $nomor, $email, $alamat, $user_id, $shoes_id, $shoes_name, $image_url, $color, $size, $price, $jumlah, $total, $status);

                if ($stmt->execute()) {
                    $id = $conn->insert_id;
                    header("Location: ../../user/index.php?page=transaksi-detail&id=$id");
                    exit;
                } else {
                    echo "Error: " . $stmt->error;
                }
                $stmt->close();
            }
            break;
        case 'add_transaksi_cart':
            if (isset($_POST['nama'])) {
                $cart_id = $_POST['cart_id'];
                $nama = $_POST['nama'];
                $nomor = $_POST['nomor'];
                $email = $_POST['email'];
                $alamat = $_POST['alamat'];
                $user_id = $_POST['user_id'];
                $shoes_id = $_POST['shoes_id'];
                $shoes_name = $_POST['shoes_name'];
                $image_url = $_POST['image_url'];
                $color = $_POST['color'];
                $size = $_POST['size'];
                $price = $_POST['price'];
                $jumlah = $_POST['jumlah'];
                $total = $_POST['total'];
                $status = $_POST['status'];
                $stok = $_POST['stok'];
                $sisa = (int)$stok - (int)$jumlah;

                $update = "UPDATE sepatu SET stok = ? WHERE shoes_id = ?";
                $stmt1 = $conn->prepare($update);
                $stmt1->bind_param("ii", $sisa, $shoes_id);
                $stmt1->execute();
                $stmt1->close();

                $sql2 = "DELETE FROM cart WHERE id = ?";
                $stmt2 = $conn->prepare($sql2);
                $stmt2->bind_param("i", $cart_id);
                $stmt2->execute();
                $stmt2->close();

                $sql = "INSERT INTO transaksi (nama, nomor, email, alamat, user_id, shoes_id, shoes_name, image_url, color, size, price, jumlah, total, status) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("ssssiisssiiiis", $nama, $nomor, $email, $alamat, $user_id, $shoes_id, $shoes_name, $image_url, $color, $size, $price, $jumlah, $total, $status);

                if ($stmt->execute()) {
                    $id = $conn->insert_id;
                    header("Location: ../../user/index.php?page=transaksi-detail&id=$id");
                    exit;
                } else {
                    echo "Error: " . $stmt->error;
                }
                $stmt->close();
            }
            break;
        case 'add_cart':
            if (isset($_POST['user_id'])) {
                $user_id = $_POST['user_id'];
                $shoes_id = $_POST['shoes_id'];
                $jumlah = $_POST['jumlah'];

                $sql = "INSERT INTO cart (user_id, shoes_id, jumlah) VALUES (?,?,?)";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("iii", $user_id, $shoes_id, $jumlah);

                if ($stmt->execute()) {
                    echo "<script>alert('Berhasil Ditambahkan ke Keranjang!');
                    history.go(-1); // Refresh halaman
                    </script>";
                    exit;
                } else {
                    echo "Error: " . $stmt->error;
                }
                $stmt->close();
            }
            break;

        default:
            echo "Invalid action.";
            break;
    }

    $conn->close();
}
