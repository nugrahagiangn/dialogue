<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
include('../dbconnection.php');

if (empty($_SESSION['uid'])) {
    header('location:../signin.php?session=expired');
    exit();
}

$id_product = urldecode($_GET['id_product']);

if (!isset($_GET['id_product']) || !is_numeric($id_product)) {
    die("ID produk tidak valid.");
}

// Ambil data produk
$query = "SELECT * FROM tblproduct WHERE id_product = $1";
$result = pg_query_params($conn, $query, array($id_product));

if (!$result || pg_num_rows($result) == 0) {
    die("Produk tidak ditemukan.");
}
$product = pg_fetch_assoc($result);

// Ambil data review
$review_query = "SELECT r.*, e.fullname FROM tblreview r 
                 JOIN tblemployees e ON r.employee_id = e.id 
                 WHERE r.product_id = $1 ORDER BY r.id DESC";
$review_result = pg_query_params($conn, $review_query, array($id_product));
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Detail Produk - <?= htmlspecialchars($product['product_name']) ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }

        .product-detail {
            margin-top: 50px;
            margin-bottom: 30px;
        }

        .product-image {
            max-height: 400px;
            object-fit: cover;
        }

        .back-button {
            margin-top: 20px;
        }

        .review-section {
            margin-top: 50px;
        }

        .review-item {
            border-bottom: 1px solid #dee2e6;
            padding-bottom: 15px;
            margin-bottom: 15px;
        }
    </style>
</head>

<body>
    <!-- Modal -->
    <div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content bg-transparent border-0">
                <div class="modal-body p-0 text-center">
                    <img src="<?= 'http://' . $_SERVER['HTTP_HOST'] . '/gn/product/uploads/' . $product['image'] ?>"
                        class="img-fluid rounded"
                        alt="<?= htmlspecialchars($product['product_name']) ?>"
                        onerror="this.onerror=null;this.src='default-image.jpg';">
                </div>
            </div>
        </div>
    </div>

    <div class="container product-detail">
        <div class="row">
            <div class="col-md-6">
                <img src="<?= 'http://' . $_SERVER['HTTP_HOST'] . '/gn/product/uploads/' . $product['image'] ?>"
                    class="img-fluid product-image rounded"
                    alt="<?= htmlspecialchars($product['product_name']) ?>"
                    data-bs-toggle="modal" data-bs-target="#imageModal"
                    style="cursor: pointer;"
                    onerror="this.onerror=null;this.src='default-image.jpg';">

            </div>
            <div class="col-md-6">
                <h2><?= htmlspecialchars($product['product_name']) ?></h2>
                <h4 class="text-success mb-3">Rp. <?= number_format($product['price'], 0, ',', '.') ?></h4>
                <p><strong>Deskripsi:</strong></p>
                <p><?= nl2br(htmlspecialchars($product['description'])) ?></p>

                <a href="../index.php" class="btn btn-secondary back-button">Kembali</a>
                <a href="../product/edit_product.php?id_product=<?= urlencode($product['id_product']) ?>" class="btn btn-primary back-button">Edit Produk</a>
            </div>
        </div>

        <!-- Section Review -->
        <div class="review-section mt-5">
            <h4>Ulasan Produk</h4>
            <?php if (pg_num_rows($review_result) > 0): ?>
                <?php while ($review = pg_fetch_assoc($review_result)): ?>
                    <div class="review-item">
                        <strong><?= htmlspecialchars($review['fullname']) ?></strong><br />
                        <span class="text-warning">Rating: <?= str_repeat('⭐', $review['rate']) ?> (<?= $review['rate'] ?>)</span>
                        <p><?= htmlspecialchars($review['coment']) ?></p>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <p class="text-muted">Belum ada ulasan untuk produk ini.</p>
            <?php endif; ?>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>