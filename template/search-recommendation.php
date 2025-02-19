<?php
include "../config.php";
$input_user = $_POST['search-oi'];
$query = "SELECT * FROM sepatu";
$result = $conn->query($query);
$hasil = $result->fetch_all(MYSQLI_ASSOC);

// Encode data menjadi JSON
$jsonData = json_encode(['search_input' => $input_user,'database'=>$hasil]);

// Konfigurasi cURL untuk mengirim data ke Python
$ch = curl_init('https://shoes-soccer-production.up.railway.app/get_search_recommendation');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);

// Kirim request ke Flask API dan tangkap respons
$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

$recommendations = json_decode($response, true);
$sql = "DELETE FROM search_recommendation";
$stmt = $conn->prepare($sql);
$stmt->execute();
$stmt->close();

$no = 1;

foreach ($recommendations as $recommendation) {
    $sql = "INSERT INTO search_recommendation (no, shoes_id, brand_similarity, material_similarity, position_similarity, series_similarity,  surface_similarity, color_similarity, average_similarity) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $data = [
        $no,  // Nomor urut manual
        $recommendation['shoes_id'],
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
    $stmt->bind_param("iiddddddd", ...$data);
    if (!$stmt->execute()) {
        echo "Error: " . $stmt->error;
    }
    $no++;

    $stmt->close();
}
header("Location: ../index.php?page=search&q=$input_user");
?>