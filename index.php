<?php 
include 'db.php'; 

// 1. KIRA TOTAL DARI DATABASE
$query_total = mysqli_query($conn, "SELECT SUM(masuk) as total_masuk, SUM(keluar) as total_keluar FROM transaksi");
$data_total = mysqli_fetch_assoc($query_total);

$total_masuk = $data_total['total_masuk'] ?? 0;
$total_keluar = $data_total['total_keluar'] ?? 0;
$baki_semasa = $total_masuk - $total_keluar;
?>

<!DOCTYPE html>
<html>
<head>
    <title>Sistem Kewangan Kelas</title>
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; margin: 30px; background-color: #f0f2f5; }
        .container { max-width: 1000px; margin: auto; background: white; padding: 25px; border-radius: 12px; box-shadow: 0px 4px 15px rgba(0,0,0,0.1); }
        h2 { text-align: center; color: #333; }
        
        /* Kad Ringkasan */
        .summary-box { display: flex; gap: 20px; margin-bottom: 30px; }
        .card { flex: 1; padding: 20px; border-radius: 10px; color: white; text-align: center; }
        .bg-success { background: linear-gradient(135deg, #28a745, #218838); }
        .bg-danger { background: linear-gradient(135deg, #dc3545, #c82333); }
        .bg-primary { background: linear-gradient(135deg, #007bff, #0069d9); }
        
        /* UI Borang Dua Bahagian */
        .flex-forms { display: flex; gap: 20px; margin-bottom: 30px; }
        .form-section { flex: 1; padding: 20px; border-radius: 10px; border: 1px solid #ddd; }
        .form-masuk { border-left: 5px solid #28a745; background-color: #fafffa; }
        .form-keluar { border-left: 5px solid #dc3545; background-color: #fffafb; }
        
        input { width: 100%; padding: 10px; margin: 8px 0; border: 1px solid #ccc; border-radius: 5px; box-sizing: border-box; }
        button { width: 100%; padding: 12px; color: white; border: none; border-radius: 5px; cursor: pointer; font-weight: bold; }
        .btn-masuk { background-color: #28a745; }
        .btn-keluar { background-color: #dc3545; }
        
        /* Jadual */
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border-bottom: 1px solid #eee; padding: 15px; text-align: left; }
        th { background-color: #f8f9fa; color: #555; }
        .badge-masuk { color: #28a745; font-weight: bold; }
        .badge-keluar { color: #dc3545; font-weight: bold; }
        .btn-delete { color: #ff4d4d; text-decoration: none; font-size: 0.9em; }
    </style>
</head>
<body>

<div class="container">
    <h2>Sistem Kewangan Kelas</h2>

    <div class="summary-box">
        <div class="card bg-success">
            <small>Jumlah Masuk</small>
            <h3>RM <?php echo number_format($total_masuk, 2); ?></h3>
        </div>
        <div class="card bg-danger">
            <small>Jumlah Keluar</small>
            <h3>RM <?php echo number_format($total_keluar, 2); ?></h3>
        </div>
        <div class="card bg-primary">
            <small>Baki Terkini</small>
            <h3>RM <?php echo number_format($baki_semasa, 2); ?></h3>
        </div>
    </div>

    <div class="flex-forms">
        <div class="form-section form-masuk">
            <h4>+ Terima Wang</h4>
            <form action="proses.php" method="POST">
                <input type="hidden" name="jenis" value="masuk">
                <input type="text" name="keterangan" placeholder="Sumber (cth: Sumbangan Pn. Haslila)" required>
                <input type="number" step="0.01" name="amaun" placeholder="RM" required>
                <button type="submit" name="simpan" class="btn-masuk">Simpan Masuk</button>
            </form>
        </div>

        <div class="form-section form-keluar">
            <h4>- Guna Wang</h4>
            <form action="proses.php" method="POST">
                <input type="hidden" name="jenis" value="keluar">
                <input type="text" name="keterangan" placeholder="Tujuan (cth: Beli Marker Pen)" required>
                <input type="number" step="0.01" name="amaun" placeholder="RM" required>
                <button type="submit" name="simpan" class="btn-keluar">Simpan Keluar</button>
            </form>
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th>Waktu & Tarikh</th>
                <th>Keterangan / Remarks</th>
                <th>Masuk (RM)</th>
                <th>Keluar (RM)</th>
                <th>Tindakan</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $ambil_data = mysqli_query($conn, "SELECT * FROM transaksi ORDER BY tarikh DESC");
            if(mysqli_num_rows($ambil_data) > 0) {
                while($row = mysqli_fetch_array($ambil_data)) {
                    echo "<tr>
                            <td><small>".date('d/m/Y h:i A', strtotime($row['tarikh']))."</small></td>
                            <td>{$row['keterangan']}</td>
                            <td class='badge-masuk'>".($row['masuk'] > 0 ? '+ '.number_format($row['masuk'], 2) : '-')."</td>
                            <td class='badge-keluar'>".($row['keluar'] > 0 ? '- '.number_format($row['keluar'], 2) : '-')."</td>
                            <td>
                                <a href='padam.php?id={$row['id']}' class='btn-delete' onclick=\"return confirm('Padam rekod ini?')\">🗑️ Padam</a>
                            </td>
                          </tr>";
                }
            } else {
                echo "<tr><td colspan='5' style='text-align:center'>Tiada rekod kewangan buat masa ini.</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>

</body>
</html>