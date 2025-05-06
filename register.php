<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include(__DIR__ . '/dbconnection.php');

if (isset($_POST['submit'])) {
    $fname = $_POST['fname'];
    $contno = $_POST['contactno'];
    $email = $_POST['email'];
    $password = md5($_POST['password']);

    $ret = pg_query($conn, "SELECT Email FROM tblemployees WHERE Email='$email' OR MobileNumber='$contno'");
    $result = pg_num_rows($ret);

    if ($result > 0) {
        echo "<script>alert('This email or Contact Number already associated with another account');</script>";
    } else {
        $query = pg_query($conn, "INSERT INTO tblemployees (FullName, MobileNumber, Email, Password) VALUES ('$fname', '$contno', '$email', '$password')");
        if ($query) {
            echo "<script>alert('You have successfully registered');</script>";
            echo "<script>window.location.href='signin.php';</script>";
        } else {
            echo "<script>alert('Something went wrong. Please try again');</script>";
            echo "<script>window.location.href='index.php';</script>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Register</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #eef2f7;
        }

        .register-container {
            max-width: 500px;
            margin: 80px auto;
            background-color: #fff;
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
        }

        .form-title {
            margin-bottom: 30px;
            text-align: center;
            color: #007bff;
        }

        .btn-green {
            background-color: #28a745;
            color: white;
        }

        .btn-green:hover {
            background-color: #218838;
        }
    </style>
</head>

<body>
    <div class="register-container">
        <h3 class="form-title">Form Registrasi</h3>
        <form method="POST">
            <div class="mb-3">
                <label for="fname" class="form-label">Nama Lengkap</label>
                <input type="text" name="fname" class="form-control" id="fname" required>
            </div>

            <div class="mb-3">
                <label for="contactno" class="form-label">Nomor Kontak</label>
                <input type="text" name="contactno" class="form-control" id="contactno" maxlength="13" pattern="[0-9]+" required>
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Alamat Email</label>
                <input type="email" name="email" class="form-control" id="email" required>
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Kata Sandi</label>
                <input type="password" name="password" class="form-control" id="password" required>
            </div>

            <div class="d-grid mb-3">
                <button type="submit" name="submit" class="btn btn-green">Daftar</button>
            </div>

            <div class="text-center">
                <a href="signin.php" class="text-danger">Sudah Memiliki Akun? Masuk</a>
            </div>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>