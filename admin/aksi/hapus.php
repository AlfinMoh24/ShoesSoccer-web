<?php
include "../../config.php";
function showAlert($message, $redirectPage)
{
    echo "<script>
            alert('$message');
            window.location.href = '../index.php?page=$redirectPage';
          </script>";
}
try {

    if (!empty($_GET['brand'])) {

        $delete_id = $_GET['delete_id'];
        $redirectPage = 'brand';

        $sql = "DELETE FROM brands WHERE brand_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $delete_id);

        if ($stmt->execute()) {
            header("Location: ../index.php?page=brand&success=deleted");
            exit;
        } else {
            // echo "Error: " . $stmt->error;
        }
    }

    if (!empty($_GET['surface'])) {

        $delete_id = $_GET['delete_id'];
        $redirectPage = 'surface';

        $sql = "DELETE FROM surfaces WHERE surface_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $delete_id);

        if ($stmt->execute()) {
            header("Location: ../index.php?page=surface&success=deleted");
            exit;
        } else {
            echo "Error: " . $stmt->error;
        }
    }

    if (!empty($_GET['position'])) {

        $delete_id = $_GET['delete_id'];
        $redirectPage = 'position';

        $sql = "DELETE FROM positions WHERE position_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $delete_id);

        if ($stmt->execute()) {
            header("Location: ../index.php?page=position&success=deleted");
            exit;
        } else {
            echo "Error: " . $stmt->error;
        }
    }

    if (!empty($_GET['material'])) {

        $delete_id = $_GET['delete_id'];
        $redirectPage = 'material';

        $sql = "DELETE FROM materials WHERE material_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $delete_id);

        if ($stmt->execute()) {
            header("Location: ../index.php?page=material&success=deleted");
            exit;
        } else {
            echo "Error: " . $stmt->error;
        }
    }

    if (!empty($_GET['series'])) {

        $delete_id = $_GET['delete_id'];
        $redirectPage = 'series';

        $sql = "DELETE FROM series WHERE series_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $delete_id);

        if ($stmt->execute()) {
            header("Location: ../index.php?page=series&success=deleted");
            exit;
        } else {
            echo "Error: " . $stmt->error;
        }
    }

    if (!empty($_GET['model'])) {
        $redirectPage = 'model';

        $delete_id = $_GET['delete_id'];

        $sql = "DELETE FROM models WHERE model_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $delete_id);

        if ($stmt->execute()) {
            header("Location: ../index.php?page=model&success=deleted");
            exit;
        } else {
            echo "Error: " . $stmt->error;
        }
    }

    if (!empty($_GET['produk'])) {

        $delete_id = $_GET['delete_id'];


        $sql1 = "DELETE FROM cart WHERE shoes_id = ?";
        $stmt1 = $conn->prepare($sql1);
        $stmt1->bind_param("i", $delete_id);
        $stmt1->execute();

        $sql2 = "DELETE FROM user_recommendation WHERE shoes_id = ?";
        $stmt2 = $conn->prepare($sql2);
        $stmt2->bind_param("i", $delete_id);
        $stmt2->execute();

        $sql3 = "DELETE FROM search_recommendation WHERE shoes_id = ?";
        $stmt3 = $conn->prepare($sql3);
        $stmt3->bind_param("i", $delete_id);
        $stmt3->execute();

        
        $sql = "DELETE FROM sepatu WHERE shoes_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $delete_id);

        if ($stmt->execute()) {
            header("Location: ../index.php?page=produk&success=deleted");
            exit;
        } else {
            echo "Error: " . $stmt->error;
        }
        
    }

    if (!empty($_GET['user'])) {

        $delete_id = $_GET['delete_id'];

        $sql = "DELETE FROM users WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $delete_id);

        if ($stmt->execute()) {
            header("Location: ../index.php?page=user&success=deleted");
            exit;
        } else {
            echo "Error: " . $stmt->error;
        }
    }
    if (!empty($_GET['transaksi'])) {

        $delete_id = $_GET['delete_id'];

        $sql = "DELETE FROM transaksi WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $delete_id);

        if ($stmt->execute()) {
            header("Location: ../index.php?page=transaksi&success=deleted");
            exit;
        } else {
            echo "Error: " . $stmt->error;
        }
    }
    if (!empty($_GET['cart'])) {

        $delete_id = $_GET['delete_id'];

        $sql = "DELETE FROM cart WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $delete_id);

        if ($stmt->execute()) {
            header("Location: ../../user/index.php?page=cart");
            exit;
        } else {
            echo "Error: " . $stmt->error;
        }
    }
} catch (mysqli_sql_exception $e) {
    showAlert("Error: Gagal menghapus data. Pastikan data tidak digunakan di tempat lain.",  $redirectPage);
} finally {
    $stmt->close();
    $conn->close();
}
