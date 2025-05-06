<?php
session_start();
include('../dbconnection.php');

if (empty($_SESSION['uid'])) {
    header('location:../signin.php?session=expired');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['product_name'];
    $price = $_POST['price'];
    $description = $_POST['description'];
    $image_original = $_FILES['image']['name'];
    $image_extension = pathinfo($image_original, PATHINFO_EXTENSION);
    // $image_new = time() . '_' . uniqid() . '.' . $image_extension;
    $image_new = time() . '_' . $image_original;

    $target = "uploads/" . $image_new;
    move_uploaded_file($_FILES['image']['tmp_name'], $target);

    $query = "INSERT INTO tblproduct (product_name, price, image, description) VALUES ($1, $2, $3, $4)";
    $result = pg_query_params($conn, $query, array($name, $price, $image_new, $description));

    if ($result) {
        header('Location: ../index.php');
        exit();
    } else {
        echo "Gagal menambahkan produk: " . pg_last_error();
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Tambah Produk</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">
    <div class="container mt-5">
        <div class="card shadow">
            <div class="card-header bg-success text-white">
                <h4 class="mb-0">Tambah Produk</h4>
            </div>
            <div class="card-body">
                <form method="POST" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label class="form-label">Nama Produk</label>
                        <input type="text" name="product_name" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Harga</label>
                        <input type="number" name="price" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Gambar</label>
                        <input type="file" name="image" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Deskripsi Produk</label>
                        <textarea class="form-control" id="description" name="description" rows="4"></textarea>
                    </div>
                    <button type="submit" class="btn btn-success">Simpan</button>
                    <a href="../index.php" class="btn btn-secondary">Kembali</a>
                </form>
            </div>
        </div>
    </div>
</body>

</html>