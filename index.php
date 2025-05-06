<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
include('dbconnection.php');

if (empty($_SESSION['uid'])) {
    header('location:logout.php');
    exit();
}

$uid = $_SESSION['uid'];
$ret = pg_query_params($conn, "SELECT FullName FROM tblemployees WHERE id = $1", array($uid));
$row = pg_fetch_assoc($ret);
$name = $row ? $row['fullname'] : 'User';

$query = "SELECT * FROM tblproduct ORDER BY id_product DESC";
$result = pg_query($conn, $query);

if (!$result) {
    die("Query produk gagal: " . pg_last_error());
}
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Welcome & Daftar Produk</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Custom styling -->
    <style>
        body {
            background-color: #f0f8ff;
        }

        .welcome-box {
            margin: 20px 0;
            text-align: center;
        }

        .card-img-top {
            height: 350px;
            object-fit: cover;
        }
    </style>
</head>

<body>
    <div class="container mt-5">
        <div class="d-flex justify-content-end">
            <a href="logout.php" class="btn btn-outline-danger mb-3">Keluar</a>
        </div>

        <div class="text-center mb-4">
            <h4 class="text-primary">Haloo ! Temanku, <?= htmlspecialchars($name) ?> !</h4>
        </div>

        <div class="d-flex justify-content-end mb-4">
            <a href="product/add_product.php" class="btn btn-success">Tambah Produk</a>
        </div>

        <!-- Product List Section -->
        <h2 class="mb-4 text-center">Daftar Produk</h2>
        <div class="row">
            <?php while ($produk = pg_fetch_assoc($result)): ?>
                <div class="col-md-4 mb-4">
                    <a href="product/detail_product.php?id_product= <?= urlencode($produk['id_product']) ?>">
                        <div class="card h-100">
                            <img src="<?= 'http://' . $_SERVER['HTTP_HOST'] . '/gn/product/uploads/' . $produk['image'] ?>"
                                class="card-img-top"
                                alt="<?= htmlspecialchars($produk['product_name']) ?>"
                                onerror="this.onerror=null;this.src='default-image.jpg';">
                            <div class="card-body d-flex justify-content-between align-items-center">
                                <div>
                                    <h5 class="card-title mb-1"><?= htmlspecialchars($produk['product_name']) ?></h5>
                                    <p class="card-text mb-2">Rp. <?= number_format($produk['price'], 0, ',', '.') ?></p>
                                </div>
                                <div class="d-flex gap-2">
                                    <a href="product/edit_product.php?id_product=<?= urlencode($produk['id_product']) ?>"
                                        class="btn btn-sm btn-outline-primary" title="Edit">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                    <a href="product/delete_product.php?id_product=<?= urlencode($produk['id_product']) ?>"
                                        class="btn btn-sm btn-outline-danger" title="Hapus"
                                        onclick="return confirm('Yakin ingin menghapus produk ini?')">
                                        <i class="bi bi-trash"></i>
                                    </a>
                                </div>
                            </div>

                    </a>
                </div>

        </div>
    <?php endwhile; ?>
    </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>