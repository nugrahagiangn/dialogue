<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

include(__DIR__ . '/dbconnection.php');

if (isset($_POST['login'])) {
    $emailcon = $_POST['emailcont'];
    $password = md5($_POST['password']);

    $query = pg_query($conn, "SELECT id FROM tblemployees WHERE (email='$emailcon' OR mobilenumber='$emailcon') AND password='$password'");

    if (!$query) {
        die("Query error: " . pg_last_error($conn));
    }

    $ret = pg_fetch_assoc($query);

    if ($ret) {
        $_SESSION['uid'] = $ret['id'];
        header("Location: index.php");
        exit();
    } else {
        echo "<script>alert('Invalid Details');</script>";
    }
}
?>
<?php
if (isset($_GET['session']) && $_GET['session'] === 'expired') {
    echo "<script>alert('Sesi Anda telah habis. Silakan login kembali.');</script>";
}
?>




<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #e9f2f9;
        }

        .login-container {
            max-width: 400px;
            margin: 100px auto;
            padding: 30px;
            background-color: white;
            border-radius: 10px;
            box-shadow: 0px 0px 15px rgba(0, 0, 0, 0.1);
        }

        .login-title {
            margin-bottom: 25px;
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
    <div class="login-container">
        <h3 class="login-title">Sign In</h3>
        <form method="POST">
            <div class="mb-3">
                <label class="form-label">Email / Nomor Kontak</label>
                <input type="text" class="form-control" name="emailcont" placeholder="Masukkan Email atau Nomor HP" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Kata Sandi</label>
                <input type="password" class="form-control" name="password" placeholder="Masukkan Kata Sandi Anda" required>
            </div>

            <div class="d-grid mb-3">
                <button class="btn btn-green" type="submit" name="login">Masuk</button>
            </div>

            <div class="text-center">
                <a href="register.php">Belum Punya Akun? <strong>Buatkan Segera !</strong></a>
            </div>
        </form>
    </div>
</body>

</html>