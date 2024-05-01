<?php
include "connection.php";

$error = "";
$success = "";

if(isset($_GET['id'])){
    $id = $_GET['id'];

    // Menggunakan prepared statement untuk menghindari SQL Injection
    $sql = "DELETE FROM club WHERE id=?";
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("i", $id);
        if ($stmt->execute()) {
            $success = "Data berhasil dihapus.";
        } else {
            $error = "Terjadi kesalahan saat menghapus data: " . $stmt->error;
        }
        $stmt->close();
    } else {
        $error = "Terjadi kesalahan saat menyiapkan pernyataan: " . $conn->error;
        exit;
    }
}

header('location:/crud100/index.php?success='.$success.'&error='.$error);
exit;
?>
