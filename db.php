<?php
// Tetapan pangkalan data
$host = "localhost";
$user = "root";
$pass = "";
$db_name = "db_kewangan_kelas";

// Proses sambungan menggunakan mysqli
$conn = mysqli_connect($host, $user, $pass, $db_name);

// Semak jika sambungan gagal
if (!$conn) {
    // Paparkan ralat yang lebih spesifik jika sambungan gagal
    die("Sambungan ke pangkalan data gagal: " . mysqli_connect_error());
}

// Setkan karakter set kepada utf8 (penting untuk simbol RM atau aksen)
mysqli_set_charset($conn, "utf8");
?>