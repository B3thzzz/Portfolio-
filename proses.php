<?php
include 'db.php';

if (isset($_POST['simpan'])) {
    // Ambil data dari form
    $keterangan = mysqli_real_escape_string($conn, $_POST['keterangan']);
    $amaun = $_POST['amaun'];
    $jenis = $_POST['jenis']; // 'masuk' atau 'keluar'

    // Logik automatik: Jika jenis masuk, simpan di kolum masuk. Jika keluar, simpan di kolum keluar.
    if ($jenis == 'masuk') {
        $sql = "INSERT INTO transaksi (keterangan, masuk, keluar) VALUES ('$keterangan', '$amaun', '0.00')";
    } else {
        $sql = "INSERT INTO transaksi (keterangan, masuk, keluar) VALUES ('$keterangan', '0.00', '$amaun')";
    }

    if (mysqli_query($conn, $sql)) {
        // Kembali ke halaman utama
        header("Location: index.php");
    } else {
        echo "Ralat: " . mysqli_error($conn);
    }
}
?>