<?php
include "connection.php";
$id = "";
$name = "";
$email = "";
$phone = "";

$error = "";
$success = "";

if ($_SERVER["REQUEST_METHOD"] == 'GET') {
    if (!isset($_GET['id'])) {
        header("location:crud100/index.php");
        exit;
    }
    $id = $_GET['id'];
    $sql = "SELECT * FROM club WHERE id=?";
    // Menggunakan prepared statement
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("i", $id); // Mengasumsikan id berupa integer
        $stmt->execute();
        $result = $stmt->get_result();
        // Periksa apakah query berhasil
        if ($result) {
            $row = $result->fetch_assoc();
            // Periksa apakah baris ada
            if ($row) {
                $name = $row["name"];
                $email = $row["email"];
                $phone = $row["phone"];
                $nama_club = $row["nama_club"]; // Populate the club name
            } else {
                header("location:crud100/index.php");
                exit;
            }
        } else {
            echo "Terjadi kesalahan saat menjalankan query: " . $stmt->error;
            exit;
        }
        $stmt->close();
    } else {
        echo "Terjadi kesalahan saat menyiapkan pernyataan: " . $conn->error;
        exit;
    }
}

if ($_SERVER["REQUEST_METHOD"] == 'POST') {
    $id = $_POST["id"];
    $name = $_POST["name"];
    $email = $_POST["email"];
    $phone = $_POST["phone"];
    
    // Pindahkan pengambilan nilai nama_club ke dalam kondisi ini
    $nama_club = isset($_POST["nama_club"]) ? $_POST["nama_club"] : '';

    $sql = "UPDATE club SET name=?, email=?, phone=?, nama_club=? WHERE id=?";
    // Menggunakan prepared statement
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("ssssi", $name, $email, $phone, $nama_club, $id); // Mengasumsikan name, email, dan phone berupa string, dan id berupa integer
        if ($stmt->execute()) {
            $success = "Anggota berhasil diperbarui.";
            // Redirect to index.php after successful update
            header("location: index.php");
            exit;
        } else {
            $error = "Terjadi kesalahan saat memperbarui anggota: " . $stmt->error;
        }
        $stmt->close();
    } else {
        $error = "Terjadi kesalahan saat menyiapkan pernyataan: " . $conn->error;
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
        <input type="hidden" name="id" value="<?php echo $id; ?>">
        <br><br><div class="card">
            <div class="card-header bg-primary">
                <h1 class="text-white text-center">  Edit Member </h1>
            </div><br>

            <label> NAME: </label>
            <input type="text" name="name" class="form-control" value="<?php echo $name; ?>"> <br>

            <label> EMAIL: </label>
            <input type="text" name="email" class="form-control" value="<?php echo $email; ?>"> <br>

            <label> PHONE: </label>
            <input type="text" name="phone" class="form-control" value="<?php echo $phone; ?>"> <br>

            <label> CLUB: </label>
            <input type="text" name="nama_club" class="form-control" value="<?php echo $nama_club; ?>"> <br>

            <button class="btn btn-success" type="submit" name="submit"> Submit </button><br>
            <a class="btn btn-info" type="submit" name="cancel" href="index.php"> Cancel </a><br>

        </div>
    </form>
</div>
</body>
</html>
