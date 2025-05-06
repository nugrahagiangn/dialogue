<?php
session_start();
include('../dbconnection.php');

if (empty($_SESSION['uid'])) {
    header('location:../signin.php?session=expired');
    exit();
}

$id_product = urldecode($_GET['id_product']);

if (!isset($_GET['id_product']) || !is_numeric($id_product)) {
    die("ID produk tidak valid.");
}

$get_image_query = "SELECT image FROM tblproduct WHERE id_product = $1";
$image_result = pg_query_params($conn, $get_image_query, array($id_product));

if ($image_result && pg_num_rows($image_result) > 0) {
    $row = pg_fetch_assoc($image_result);
    $image_filename = $row['image'];

    // Hapus file gambar dari folder uploads/
    $image_path = __DIR__ . "/uploads/" . $image_filename;
    if (file_exists($image_path)) {
        unlink($image_path);
    }
}

$delete_query = "DELETE FROM tblproduct WHERE id_product = $1";
$delete_result = pg_query_params($conn, $delete_query, array($id_product));

if ($delete_result) {
    header('Location: ../index.php');
    exit();
} else {
    echo "Gagal menghapus produk: " . pg_last_error($conn);
}
