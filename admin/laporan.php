<?php
include '../auth.php';
include '../config/koneksi.php';

$laporan = mysqli_query($conn, "
    SELECT transaksi.*, users.nama_lengkap 
    FROM transaksi 
    JOIN users ON transaksi.id_user = users.id 
    ORDER BY tanggal DESC
");

// Hitung total pendapatan selesai
$total_pendapatan = mysqli_fetch_assoc(mysqli_query($conn, "SELECT SUM(total) as total FROM transaksi WHERE status = 'selesai'"))['total'];

// Hitung statistik laporan
$stats = [
    'total_transaksi' => mysqli_num_rows($laporan),
    'total_pending' => mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as count FROM transaksi WHERE status = 'pending'"))['count'],
    'total_diproses' => mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as count FROM transaksi WHERE status = 'diproses'"))['count'],
    'total_selesai' => mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as count FROM transaksi WHERE status = 'selesai'"))['count'],
    'total_dibatalkan' => mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as count FROM transaksi WHERE status = 'dibatalkan'"))['count']
];

// Function untuk menentukan class CSS status
function getStatusClass($status) {
    switch(strtolower($status)) {
        case 'pending':
            return 'status-pending';
        case 'diproses':
            return 'status-diproses';
        case 'selesai':
            return 'status-selesai';
        case 'dibatalkan':
            return 'status-dibatalkan';
        default:
            return 'status-pending';
    }
}

// Function untuk menampilkan status dengan handling null/empty
function displayStatus($status) {
    if (empty($status) || is_null($status)) {
        return 'Pending';
    }
    return ucfirst($status);
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan - Delicia by Dilla</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #fff0f5;
            padding: 40px;
            color: #333;
        }

        h2 {
            text-align: center;
            color: #cc0066;
            margin-bottom: 20px;
            font-weight: 600;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background-color: #fff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 0 10px rgba(255, 105, 180, 0.2);
        }

        th, td {
            padding: 12px;
            border-bottom: 1px solid #ffe6f0;
            text-align: center;
        }

        th {
            background-color: #ff69b4;
            color: white;
        }

        tr:nth-child(even) {
            background-color: #fdf0f5;
        }

        tr:hover {
            background-color: #ffe6f0;
        }

        .summary {
            margin-top: 25px;
            text-align: right;
            font-weight: bold;
            color: #d6006c;
        }

        .back-btn {
            margin-top: 30px;
            display: inline-block;
            background: #ff69b4;
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 6px;
            font-weight: 500;
        }

        .back-btn:hover {
            background: #cc0066;
        }
        
        .status {
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: bold;
            text-transform: uppercase;
        }
        .status-pending {
            background-color: #fff3cd;
            color: #856404;
            border: 1px solid #ffeaa7;
        }
        .status-diproses {
            background-color: #cce5ff;
            color: #004085;
            border: 1px solid #74b9ff;
        }
        .status-selesai {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #00b894;
        }
        .status-dibatalkan {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #e17055;
        }
        
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }
        
        .stat-card {
            background: white;
            padding: 20px;
            border-radius: 12px;
            text-align: center;
            box-shadow: 0 4px 15px rgba(255, 105, 180, 0.1);
        }
        
        .stat-card h3 {
            margin: 0 0 10px 0;
            font-size: 24px;
            color: #ff69b4;
        }
        
        .stat-card p {
            margin: 0;
            color: #666;
            font-size: 14px;
        }
        
        .action-buttons {
            text-align: center;
            margin: 30px 0;
        }
        
        .print-btn {
            display: inline-block;
            background: linear-gradient(135deg, #ff69b4, #d63384);
            color: white;
            padding: 12px 25px;
            text-decoration: none;
            border-radius: 8px;
            font-weight: 600;
            margin: 0 10px;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(255, 105, 180, 0.3);
        }
        
        .print-btn:hover {
            background: linear-gradient(135deg, #d63384, #cc0066);
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(255, 105, 180, 0.4);
        }
        
        .print-btn i {
            margin-right: 8px;
        }
    </style>
</head>
<body>

    <h2>📊 Laporan Transaksi</h2>
    
    <!-- Statistics Grid -->
    <div class="stats-grid">
        <div class="stat-card">
            <h3><?= $stats['total_transaksi']; ?></h3>
            <p>Total Transaksi</p>
        </div>
        <div class="stat-card">
            <h3><?= $stats['total_pending']; ?></h3>
            <p>Pending</p>
        </div>
        <div class="stat-card">
            <h3><?= $stats['total_diproses']; ?></h3>
            <p>Diproses</p>
        </div>
        <div class="stat-card">
            <h3><?= $stats['total_selesai']; ?></h3>
            <p>Selesai</p>
        </div>
        <div class="stat-card">
            <h3><?= $stats['total_dibatalkan']; ?></h3>
            <p>Dibatalkan</p>
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Pembeli</th>
                <th>Tanggal</th>
                <th>Total</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php $no = 1; while ($row = mysqli_fetch_assoc($laporan)) : ?>
            <tr>
                <td><?= $no++; ?></td>
                <td><?= htmlspecialchars($row['nama_lengkap']); ?></td>
                <td><?= $row['tanggal']; ?></td>
                <td>Rp<?= number_format($row['total'], 0, ',', '.'); ?></td>
                <td><span class="status <?= getStatusClass($row['status']); ?>"><?= displayStatus($row['status']); ?></span></td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>

    <div class="summary">
        Total Pendapatan (Status: Selesai): Rp<?= number_format($total_pendapatan ?? 0, 0, ',', '.'); ?>
    </div>
    
    <!-- Action Buttons -->
    <div class="action-buttons">
        <a href="cetak_laporan.php" target="_blank" class="print-btn">
            <i class="fas fa-file-pdf"></i> Cetak PDF
        </a>
        <button onclick="printPage()" class="print-btn" style="border: none; cursor: pointer;">
            <i class="fas fa-print"></i> Print Halaman
        </button>
    </div>

    <a href="dashboard.php" class="back-btn">← Kembali ke Dashboard</a>
    
    <script>
        function printPage() {
            // Hide buttons before printing
            document.querySelector('.action-buttons').style.display = 'none';
            document.querySelector('.back-btn').style.display = 'none';
            
            // Print the page
            window.print();
            
            // Show buttons after printing
            setTimeout(() => {
                document.querySelector('.action-buttons').style.display = 'block';
                document.querySelector('.back-btn').style.display = 'inline-block';
            }, 1000);
        }
        
        // Add print media queries for better printing
        const style = document.createElement('style');
        style.textContent = `
            @media print {
                body {
                    background: white !important;
                    padding: 20px !important;
                }
                .action-buttons, .back-btn {
                    display: none !important;
                }
                table {
                    box-shadow: none !important;
                }
                .stat-card {
                    box-shadow: none !important;
                    border: 1px solid #ddd;
                }
            }
        `;
        document.head.appendChild(style);
    </script>

</body>
</html>
