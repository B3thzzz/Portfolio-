<?php
include 'db.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    mysqli_query($conn, "DELETE FROM transaksi WHERE id = $id");
    header("Location: index.php");
}
?>