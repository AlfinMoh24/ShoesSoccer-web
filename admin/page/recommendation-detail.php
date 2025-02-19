<?php
include '../config.php';

$user_id = $_GET['user_id'];

$sql = "
SELECT user_recommendation.*, 
       users.username,
       sepatu.shoes_name
FROM user_recommendation 
LEFT JOIN users ON user_recommendation.user_id = users.id 
LEFT JOIN sepatu ON user_recommendation.shoes_id = sepatu.shoes_id
WHERE user_recommendation.user_id = $user_id";
$result = $conn->query($sql);

?>

<h1 class="h3 mb-3 text-gray-800">Data Master</h1>
<!-- DataTales Example -->
<div class="card shadow mb-4">
    <div class="card-header py-3 d-flex justify-content-between align-items-center">
        <h6 class="m-0 font-weight-bold text-primary">Model</h6>
        <!-- Tombol Tambah model yang Membuka Modal -->
        <a href="#" class="btn btn-primary btn-icon-split" data-toggle="modal"
            data-target="#tambahModal">
            <span class="icon text-white-50">
                <i class="fa fa-plus"></i>
            </span>
            <span class="text">Tambah Model</span>
        </a>

        <!-- Modal Tambah model -->
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>no</th>
                        <th>Sepatu</th>
                        <th>Brand Similarity</th>
                        <th>Material Similarity</th>
                        <th>Position Similarity</th>
                        <th>Series Similarity</th>
                        <th>Surface Similarity</th>
                        <th>Average Similarity</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?= $row['no'] ?></td>
                            <td><?= $row['shoes_name'] ?></td>
                            <td><?= $row['brand_similarity'] ?></td>
                            <td><?= $row['material_similarity'] ?></td>
                            <td><?= $row['position_similarity'] ?></td>
                            <td><?= $row['series_similarity'] ?></td>
                            <td><?= $row['surface_similarity'] ?></td>
                            <td><?= $row['average_similarity'] ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>