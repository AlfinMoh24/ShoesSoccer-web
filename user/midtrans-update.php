<?php
// Ambil data dari request body
$data = json_decode(file_get_contents("php://input"), true);
$id = $data['id'] ?? null;
$jumlah = $data['jumlah'] ?? null; // Jumlah item yang terjual
$shoes_id = $data['shoes_id'] ?? null; // Shoes ID langsung dari input

if ($id !== null && $jumlah !== null && $shoes_id !== null) {
    $mysqli = new mysqli("localhost", "root", "", "shoes-soccer");

    if ($mysqli->connect_error) {
        http_response_code(500);
        echo json_encode(["success" => false, "message" => "Database connection failed"]);
        exit;
    }
    $stmt_update_sepatu = $mysqli->prepare("UPDATE sepatu SET terjual = terjual + ? WHERE shoes_id = ?");
        $stmt_update_sepatu->bind_param("ii", $jumlah, $shoes_id);
        $stmt_update_sepatu->execute();

    $status = "Sudah Dibayar";

    $stmt = $mysqli->prepare("UPDATE transaksi SET status = ? WHERE id = ?");
    $stmt->bind_param("ss", $status, $id);
    
    if ($stmt->execute()) {
        // Jika update berhasil
        echo json_encode(["success" => true, "message" => "Update successful"]);
    } else {
        // Jika update gagal
        http_response_code(500);
        echo json_encode(["success" => false, "message" => "Failed to update record"]);
    }

    $stmt->close();
    $mysqli->close();
} else {
    // Jika 'id' tidak diberikan
    http_response_code(400);
    echo json_encode(["success" => false, "message" => "Invalid request, 'id' is required"]);
}
?>
