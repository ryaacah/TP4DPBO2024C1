<?php
include "connection.php";

$error = "";
$success = "";

if(isset($_POST['submit'])){
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $nama_club = $_POST['nama_club'];
    // Query untuk menyisipkan data baru ke dalam tabel
    $q = "INSERT INTO `club`(`name`, `email`, `phone`, `nama_club`) VALUES ('$name', '$email', '$phone', '$nama_club')";

    // Melakukan eksekusi query
    $query = mysqli_query($conn, $q);

    // Periksa apakah query berhasil dieksekusi
    if($query) {
        $success = "Anggota berhasil ditambahkan.";
        // Arahkan pengguna kembali ke halaman index.php
        header("Location: index.php");
        exit; // Pastikan untuk keluar dari skrip setelah menggunakan header
    } else {
        $error = "Terjadi kesalahan saat menambahkan anggota: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>CRUD</title>

    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="bootstrap.min.css">
    <script src="jquery.min.js"></script>
    <script src="popper.min.js"></script>
    <script src="bootstrap.min.js"></script>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="index.php">CRUD Operation</a>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="index.php">Home</a>
                </li>
            </ul>
        </div>
    </div>
</nav>
<div class="col-lg-6 m-auto">

    <form method="post">

        <br><br><div class="card">

        <div class="card-header bg-primary">
            <h1 class="text-white text-center">  Create New Member </h1>
        </div><br>

        <label> NAME: </label>
        <input type="text" name="name" class="form-control"> <br>

        <label> EMAIL: </label>
        <input type="text" name="email" class="form-control"> <br>

        <label> PHONE: </label>
        <input type="text" name="phone" class="form-control"> <br>

        <label> CLUB: </label>
        <input type="text" name="nama_club" class="form-control"> <br>

        <button class="btn btn-success" type="submit" name="submit"> Submit </button><br>
        <a class="btn btn-info" type="submit" name="cancel" href="index.php"> Cancel </a><br>

        </div>
    </form>
</div>
</body>
</html>
