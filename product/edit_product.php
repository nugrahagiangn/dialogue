<?php
session_start();
include('../dbconnection.php');


if (empty($_SESSION['uid'])) {
    header('location:../signin.php?session=expired');
    exit();
}

$id = urldecode($_GET['id_product']);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['product_name'];
    $price = $_POST['price'];
    $description = $_POST['description'];

    if (!empty($_FILES['image']['name'])) {
        $image_original = $_FILES['image']['name'];
        $image_extension = pathinfo($image_original, PATHINFO_EXTENSION);
        $image_new = time() . '_' . $image_original;

        $target = "uploads/" . $image_new;
        move_uploaded_file($_FILES['image']['tmp_name'], $target);

        $query = "UPDATE tblproduct SET product_name=$1, price=$2, image=$3, description=$4 WHERE id_product=$5";
        $params = array($name, $price, $image_new, $description, $id);
    } else {
        $query = "UPDATE tblproduct SET product_name=$1, price=$2, description=$3 WHERE id_product=$4";
        $params = array($name, $price, $description, $id);
    }

    $result = pg_query_params($conn, $query, $params);
    if ($result) {
        header('Location: ../index.php');
        exit();
    } else {
        echo "Gagal mengedit produk: " . pg_last_error();
    }
} else {
    $result = pg_query_params($conn, "SELECT * FROM tblproduct WHERE id_product=$1", array($id));
    $product = pg_fetch_assoc($result);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Edit Produk</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">
    <div class="container mt-5">
        <div class="card shadow">
            <div class="card-header bg-primary text-white">
                <h4 class="mb-0">Edit Produk</h4>
            </div>
            <div class="card-body">
                <form method="POST" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label class="form-label">Nama Produk</label>
                        <input type="text" name="product_name" class="form-control" value="<?= htmlspecialchars($product['product_name']) ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Harga</label>
                        <input type="number" name="price" class="form-control" value="<?= $product['price'] ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Gambar Baru (Opsional)</label>
                        <input type="file" name="image" class="form-control">
                        <div class="mt-2">
                            <img src="<?= 'http://' . $_SERVER['HTTP_HOST'] . '/gn/product/uploads/' . $product['image'] ?>" width="150" alt="Current Image">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Deskripsi Produk</label>
                        <textarea class="form-control" id="description" name="description" rows="4"><?= $product['description'] ?></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Update</button>
                    <a href="index.php" class="btn btn-secondary">Kembali</a>
                </form>
            </div>
        </div>
    </div>
</body>

</html>