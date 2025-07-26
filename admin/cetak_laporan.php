<?php
require_once '../auth.php';
require_once '../config/koneksi.php';

// Set header untuk PDF
header('Content-Type: application/pdf');
header('Content-Disposition: attachment; filename="Laporan_Transaksi_Delicia_by_Dilla_' . date('Y-m-d') . '.pdf"');

// Get transaction data
$laporan = mysqli_query($conn, "
    SELECT transaksi.*, users.nama_lengkap 
    FROM transaksi 
    JOIN users ON transaksi.id_user = users.id 
    ORDER BY tanggal DESC
");

// Calculate statistics
$total_pendapatan = mysqli_fetch_assoc(mysqli_query($conn, "SELECT SUM(total) as total FROM transaksi WHERE status = 'selesai'"))['total'];
$stats = [
    'total_transaksi' => mysqli_num_rows($laporan),
    'total_pending' => mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as count FROM transaksi WHERE status = 'pending'"))['count'],
    'total_diproses' => mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as count FROM transaksi WHERE status = 'diproses'"))['count'],
    'total_selesai' => mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as count FROM transaksi WHERE status = 'selesai'"))['count'],
    'total_dibatalkan' => mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as count FROM transaksi WHERE status = 'dibatalkan'"))['count']
];

// Start output buffering
ob_start();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Transaksi - Delicia by Dilla</title>
    <style>
        @page {
            margin: 20mm;
            size: A4;
        }
        
        body {
            font-family: 'Times New Roman', serif;
            font-size: 12px;
            line-height: 1.4;
            color: #333;
            margin: 0;
            padding: 0;
        }
        
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 3px solid #ff69b4;
            padding-bottom: 20px;
        }
        
        .header h1 {
            font-size: 24px;
            color: #d63384;
            margin: 0;
            font-weight: bold;
        }
        
        .header .subtitle {
            font-size: 16px;
            color: #ff69b4;
            margin: 5px 0;
        }
        
        .header .info {
            font-size: 11px;
            color: #666;
            margin-top: 10px;
        }
        
        .stats-section {
            margin: 20px 0;
            background: #fff0f5;
            padding: 15px;
            border-left: 5px solid #ff69b4;
        }
        
        .stats-section h3 {
            margin: 0 0 15px 0;
            color: #d63384;
            font-size: 14px;
        }
        
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(5, 1fr);
            gap: 10px;
            text-align: center;
        }
        
        .stat-item {
            background: white;
            padding: 10px;
            border: 1px solid #ffc0cb;
            border-radius: 5px;
        }
        
        .stat-number {
            font-size: 18px;
            font-weight: bold;
            color: #ff69b4;
            display: block;
        }
        
        .stat-label {
            font-size: 10px;
            color: #666;
            margin-top: 5px;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
            background: white;
        }
        
        th, td {
            padding: 8px;
            border: 1px solid #ffc0cb;
            text-align: center;
            font-size: 11px;
        }
        
        th {
            background: #ff69b4;
            color: white;
            font-weight: bold;
        }
        
        tr:nth-child(even) {
            background: #fff9fc;
        }
        
        .status-badge {
            padding: 3px 8px;
            border-radius: 12px;
            font-size: 9px;
            font-weight: bold;
            text-transform: uppercase;
            display: inline-block;
        }
        
        .status-pending {
            background: #fff3cd;
            color: #856404;
            border: 1px solid #ffeaa7;
        }
        
        .status-diproses {
            background: #cce5ff;
            color: #004085;
            border: 1px solid #74b9ff;
        }
        
        .status-selesai {
            background: #d4edda;
            color: #155724;
            border: 1px solid #00b894;
        }
        
        .status-dibatalkan {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #e17055;
        }
        
        .summary {
            margin-top: 20px;
            text-align: right;
            font-weight: bold;
            color: #d63384;
            font-size: 14px;
            background: #fff0f5;
            padding: 15px;
            border-radius: 5px;
        }
        
        .footer {
            margin-top: 40px;
            text-align: center;
            font-size: 10px;
            color: #666;
            border-top: 1px solid #ffc0cb;
            padding-top: 15px;
        }
        
        .footer .signature {
            margin-top: 30px;
            text-align: right;
        }
        
        .footer .signature-line {
            border-top: 1px solid #333;
            width: 200px;
            margin: 40px 0 5px auto;
        }
        
        .cupcake-icon {
            color: #ff69b4;
            font-size: 20px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>🧁 DELICIA BY DILLA</h1>
        <div class="subtitle">Laporan Transaksi</div>
        <div class="info">
            Periode: <?= date('d F Y') ?><br>
            Dicetak pada: <?= date('d/m/Y H:i') ?> WIB<br>
            Toko Kue Premium & Handmade
        </div>
    </div>
    
    <div class="stats-section">
        <h3>📊 Ringkasan Statistik</h3>
        <div class="stats-grid">
            <div class="stat-item">
                <span class="stat-number"><?= $stats['total_transaksi']; ?></span>
                <div class="stat-label">Total Transaksi</div>
            </div>
            <div class="stat-item">
                <span class="stat-number"><?= $stats['total_pending']; ?></span>
                <div class="stat-label">Pending</div>
            </div>
            <div class="stat-item">
                <span class="stat-number"><?= $stats['total_diproses']; ?></span>
                <div class="stat-label">Diproses</div>
            </div>
            <div class="stat-item">
                <span class="stat-number"><?= $stats['total_selesai']; ?></span>
                <div class="stat-label">Selesai</div>
            </div>
            <div class="stat-item">
                <span class="stat-number"><?= $stats['total_dibatalkan']; ?></span>
                <div class="stat-label">Dibatalkan</div>
            </div>
        </div>
    </div>
    
    <table>
        <thead>
            <tr>
                <th width="5%">No</th>
                <th width="25%">Nama Pembeli</th>
                <th width="15%">Tanggal</th>
                <th width="20%">Total</th>
                <th width="15%">Status</th>
                <th width="20%">Keterangan</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            mysqli_data_seek($laporan, 0); // Reset pointer
            $no = 1; 
            while ($row = mysqli_fetch_assoc($laporan)) : 
                $status_class = 'status-' . strtolower($row['status']);
                $status_text = ucfirst($row['status']);
            ?>
            <tr>
                <td><?= $no++; ?></td>
                <td><?= htmlspecialchars($row['nama_lengkap']); ?></td>
                <td><?= date('d/m/Y', strtotime($row['tanggal'])); ?></td>
                <td>Rp <?= number_format($row['total'], 0, ',', '.'); ?></td>
                <td>
                    <span class="status-badge <?= $status_class; ?>">
                        <?= $status_text; ?>
                    </span>
                </td>
                <td><?= $row['status'] == 'selesai' ? 'Transaksi berhasil' : ($row['status'] == 'dibatalkan' ? 'Dibatalkan' : 'Dalam proses'); ?></td>
            </tr>
            <?php endwhile; ?>
            
            <?php if (mysqli_num_rows($laporan) == 0): ?>
            <tr>
                <td colspan="6" style="text-align: center; font-style: italic; color: #999;">
                    Belum ada transaksi pada periode ini
                </td>
            </tr>
            <?php endif; ?>
        </tbody>
    </table>
    
    <div class="summary">
        💰 Total Pendapatan (Status: Selesai): Rp <?= number_format($total_pendapatan ?? 0, 0, ',', '.'); ?>
    </div>
    
    <div class="footer">
        <div style="margin-bottom: 20px;">
            <strong>DELICIA BY DILLA</strong><br>
            Toko Kue Premium & Handmade<br>
            📞 0812-3456-7890 | 📧 dillasardilla387@gmail.com<br>
            🌐 Sekolah Tinggi Teknologi Bontang
        </div>
        
        <div class="signature">
            <div>Mengetahui,</div>
            <div class="signature-line"></div>
            <div><strong>Admin Delicia by Dilla</strong></div>
        </div>
        
        <div style="margin-top: 20px; font-style: italic;">
            "Made with ❤️ for sweet memories"
        </div>
    </div>
</body>
</html>

<?php
$html = ob_get_contents();
ob_end_clean();

// Simple HTML to PDF conversion using DomPDF-like approach
// For better results, you should install a proper PDF library like TCPDF or DomPDF
// This is a simple implementation for demo purposes

// If you want to use a proper PDF library, uncomment and install DomPDF:
/*
require_once '../vendor/autoload.php'; // If using Composer
use Dompdf\Dompdf;
use Dompdf\Options;

$options = new Options();
$options->set('defaultFont', 'DejaVu Sans');
$options->set('isRemoteEnabled', true);

$dompdf = new Dompdf($options);
$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();

$dompdf->stream('Laporan_Transaksi_Delicia_by_Dilla_' . date('Y-m-d') . '.pdf', array('Attachment' => 1));
*/

// For now, we'll output the HTML that can be printed as PDF using browser's print function
header('Content-Type: text/html; charset=utf-8');
echo $html;
?>
