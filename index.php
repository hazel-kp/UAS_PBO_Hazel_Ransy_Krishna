<?php
// Include koneksi database dengan PBO
require_once 'koneksi.php';

// Include semua class
require_once 'Mahasiswa.php';
require_once 'MahasiswaMandiri.php';
require_once 'MahasiswaBidikmisi.php';
require_once 'MahasiswaPrestasi.php';

// Menggunakan koneksi dari object Database
$conn = $db->getConnection();

// Menentukan menu yang aktif
$menu = isset($_GET['menu']) ? $_GET['menu'] : 'semua';

// Function untuk mengambil data berdasarkan jenis
function getDataMahasiswa($db, $conn, $jenis = null) {
    if ($jenis === null) {
        $query = "SELECT * FROM tabel_mahasiswa ORDER BY id_mahasiswa";
        $result = $db->query($query);
    } else {
        $query = "SELECT * FROM tabel_mahasiswa WHERE jenis_pembayaran = ? ORDER BY id_mahasiswa";
        $stmt = $db->prepare($query);
        $stmt->bind_param("s", $jenis);
        $stmt->execute();
        $result = $stmt->get_result();
    }
    
    $data = [];
    if ($result) {
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
    }
    
    return $data;
}

// Function untuk membuat objek mahasiswa
function createMahasiswaObject($data, $conn) {
    $jenis = $data['jenis_pembayaran'];
    
    switch ($jenis) {
        case 'Mandiri':
            return new MahasiswaMandiri(
                $data['id_mahasiswa'],
                $data['nama_mahasiswa'],
                $data['nim'],
                $data['semester'],
                $data['tarif_ukt_nominal'],
                $data['golongan_ukt'],
                $data['nama_wali'],
                $conn
            );
        case 'Bidik Misi':
            return new MahasiswaBidikmisi(
                $data['id_mahasiswa'],
                $data['nama_mahasiswa'],
                $data['nim'],
                $data['semester'],
                $data['tarif_ukt_nominal'],
                $data['nomor_kip_kuliah'],
                $data['dana_saku_subsidi'],
                $conn
            );
        case 'Prestasi':
            return new MahasiswaPrestasi(
                $data['id_mahasiswa'],
                $data['nama_mahasiswa'],
                $data['nim'],
                $data['semester'],
                $data['tarif_ukt_nominal'],
                $data['nama_instansi_beasiswa'],
                $data['minimal_ukt_bersyarat'],
                $conn
            );
        default:
            return null;
    }
}

// Ambil data berdasarkan menu
if ($menu == 'mandiri') {
    $dataMahasiswa = getDataMahasiswa($db, $conn, 'Mandiri');
    $title = 'Mahasiswa Mandiri';
} elseif ($menu == 'bidikmisi') {
    $dataMahasiswa = getDataMahasiswa($db, $conn, 'Bidik Misi');
    $title = 'Mahasiswa Bidik Misi';
} elseif ($menu == 'prestasi') {
    $dataMahasiswa = getDataMahasiswa($db, $conn, 'Prestasi');
    $title = 'Mahasiswa Prestasi';
} else {
    $dataMahasiswa = getDataMahasiswa($db, $conn);
    $title = 'Semua Data Mahasiswa';
}

// Hitung total data per kategori
$totalMandiri = count(getDataMahasiswa($db, $conn, 'Mandiri'));
$totalBidikMisi = count(getDataMahasiswa($db, $conn, 'Bidik Misi'));
$totalPrestasi = count(getDataMahasiswa($db, $conn, 'Prestasi'));
$totalSemua = $totalMandiri + $totalBidikMisi + $totalPrestasi;
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Informasi Pembayaran UKT</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f4f6f9;
            display: flex;
            min-height: 100vh;
        }

        /* Sidebar */
        .sidebar {
            width: 260px;
            background: linear-gradient(180deg, #1a237e 0%, #0d47a1 100%);
            color: white;
            padding: 20px 0;
            position: fixed;
            height: 100vh;
            overflow-y: auto;
            box-shadow: 2px 0 10px rgba(0,0,0,0.1);
            z-index: 1000;
        }

        .sidebar-header {
            padding: 20px 25px;
            border-bottom: 1px solid rgba(255,255,255,0.1);
            margin-bottom: 20px;
        }

        .sidebar-header h2 {
            font-size: 18px;
            font-weight: 700;
            margin-bottom: 5px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .sidebar-header p {
            font-size: 12px;
            opacity: 0.8;
        }

        .sidebar-menu {
            list-style: none;
            padding: 0;
        }

        .sidebar-menu li {
            margin: 2px 15px;
        }

        .sidebar-menu li a {
            display: flex;
            align-items: center;
            padding: 12px 20px;
            color: rgba(255,255,255,0.8);
            text-decoration: none;
            border-radius: 10px;
            transition: all 0.3s;
            font-size: 14px;
            font-weight: 500;
        }

        .sidebar-menu li a:hover {
            background: rgba(255,255,255,0.15);
            color: white;
            transform: translateX(5px);
        }

        .sidebar-menu li a.active {
            background: rgba(255,255,255,0.2);
            color: white;
            box-shadow: 0 4px 15px rgba(0,0,0,0.2);
        }

        .sidebar-menu li a .icon {
            margin-right: 12px;
            font-size: 18px;
            width: 24px;
            text-align: center;
        }

        .sidebar-menu li a .badge {
            margin-left: auto;
            background: rgba(255,255,255,0.2);
            padding: 2px 10px;
            border-radius: 20px;
            font-size: 12px;
        }

        .sidebar-menu li a.active .badge {
            background: rgba(255,255,255,0.3);
        }

        /* Main Content */
        .main-content {
            margin-left: 260px;
            padding: 30px;
            width: 100%;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            background: white;
            padding: 20px 30px;
            border-radius: 15px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }

        .header h1 {
            font-size: 24px;
            color: #1a237e;
            font-weight: 700;
        }

        .header .info {
            color: #666;
            font-size: 14px;
        }

        .stats {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 20px;
            margin-bottom: 30px;
        }

        .stat-card {
            background: white;
            padding: 20px;
            border-radius: 15px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            transition: transform 0.3s;
        }

        .stat-card:hover {
            transform: translateY(-5px);
        }

        .stat-card .stat-title {
            font-size: 13px;
            color: #888;
            font-weight: 500;
            margin-bottom: 5px;
        }

        .stat-card .stat-number {
            font-size: 28px;
            font-weight: 700;
            color: #1a237e;
        }

        .stat-card .stat-number.mandiri {
            color: #e74c3c;
        }
        .stat-card .stat-number.bidikmisi {
            color: #2ecc71;
        }
        .stat-card .stat-number.prestasi {
            color: #3498db;
        }
        .stat-card .stat-number.semua {
            color: #1a237e;
        }

        /* Table */
        .table-container {
            background: white;
            border-radius: 15px;
            padding: 20px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table thead {
            background: #f8f9fa;
        }

        table th {
            padding: 12px 15px;
            text-align: left;
            font-size: 13px;
            font-weight: 600;
            color: #555;
            border-bottom: 2px solid #e9ecef;
            white-space: nowrap;
        }

        table td {
            padding: 12px 15px;
            border-bottom: 1px solid #e9ecef;
            font-size: 13px;
            color: #333;
        }

        table tbody tr:hover {
            background: #f8f9fa;
        }

        .badge-status {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 600;
            text-transform: uppercase;
        }

        .badge-mandiri {
            background: #fde8e8;
            color: #e74c3c;
        }

        .badge-bidikmisi {
            background: #e8f8ef;
            color: #2ecc71;
        }

        .badge-prestasi {
            background: #e8f4fd;
            color: #3498db;
        }

        .tagihan {
            font-weight: 700;
            color: #1a237e;
        }

        .tagihan-gratis {
            color: #2ecc71;
            font-weight: 700;
        }

        .no-data {
            text-align: center;
            padding: 40px;
            color: #999;
            font-size: 16px;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .sidebar {
                width: 200px;
            }
            .main-content {
                margin-left: 200px;
                padding: 20px;
            }
            .stats {
                grid-template-columns: repeat(2, 1fr);
            }
            .header {
                flex-direction: column;
                align-items: flex-start;
                gap: 10px;
            }
        }

        @media (max-width: 576px) {
            .sidebar {
                width: 100%;
                height: auto;
                position: relative;
            }
            .main-content {
                margin-left: 0;
            }
            .stats {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <div class="sidebar-header">
            <h2>📚 SIAKAD UKT</h2>
            <p>Sistem Informasi Pembayaran</p>
        </div>
        <ul class="sidebar-menu">
            <li>
                <a href="?menu=semua" class="<?= $menu == 'semua' ? 'active' : '' ?>">
                    <span class="icon">📊</span>
                    Semua Data
                    <span class="badge"><?= $totalSemua ?></span>
                </a>
            </li>
            <li>
                <a href="?menu=mandiri" class="<?= $menu == 'mandiri' ? 'active' : '' ?>">
                    <span class="icon">👤</span>
                    Mahasiswa Mandiri
                    <span class="badge"><?= $totalMandiri ?></span>
                </a>
            </li>
            <li>
                <a href="?menu=bidikmisi" class="<?= $menu == 'bidikmisi' ? 'active' : '' ?>">
                    <span class="icon">🎓</span>
                    Mahasiswa Bidik Misi
                    <span class="badge"><?= $totalBidikMisi ?></span>
                </a>
            </li>
            <li>
                <a href="?menu=prestasi" class="<?= $menu == 'prestasi' ? 'active' : '' ?>">
                    <span class="icon">🏆</span>
                    Mahasiswa Prestasi
                    <span class="badge"><?= $totalPrestasi ?></span>
                </a>
            </li>
        </ul>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <!-- Header -->
        <div class="header">
            <h1><?= $title ?></h1>
            <div class="info">
                Total Data: <strong><?= count($dataMahasiswa) ?></strong> Mahasiswa
            </div>
        </div>

        <!-- Stats -->
        <div class="stats">
            <div class="stat-card">
                <div class="stat-title">Total Mahasiswa</div>
                <div class="stat-number semua"><?= $totalSemua ?></div>
            </div>
            <div class="stat-card">
                <div class="stat-title">Mahasiswa Mandiri</div>
                <div class="stat-number mandiri"><?= $totalMandiri ?></div>
            </div>
            <div class="stat-card">
                <div class="stat-title">Mahasiswa Bidik Misi</div>
                <div class="stat-number bidikmisi"><?= $totalBidikMisi ?></div>
            </div>
            <div class="stat-card">
                <div class="stat-title">Mahasiswa Prestasi</div>
                <div class="stat-number prestasi"><?= $totalPrestasi ?></div>
            </div>
        </div>

        <!-- Table -->
        <div class="table-container">
            <?php if (count($dataMahasiswa) > 0): ?>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nama Mahasiswa</th>
                        <th>NIM</th>
                        <th>Semester</th>
                        <th>Jenis Pembayaran</th>
                        <th>Tarif UKT</th>
                        <th>Spesifikasi</th>
                        <th>Tagihan</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($dataMahasiswa as $data): 
                        $obj = createMahasiswaObject($data, $conn);
                        $tagihan = $obj ? $obj->hitungTagihanSemester() : 0;
                        
                        // Spesifikasi berdasarkan jenis
                        $spesifikasi = '-';
                        if ($data['jenis_pembayaran'] == 'Mandiri') {
                            $spesifikasi = 'Gol: ' . $data['golongan_ukt'] . ' | Wali: ' . $data['nama_wali'];
                        } elseif ($data['jenis_pembayaran'] == 'Bidik Misi') {
                            $spesifikasi = 'KIP: ' . $data['nomor_kip_kuliah'] . ' | Dana: Rp ' . number_format($data['dana_saku_subsidi'], 0, ',', '.');
                        } elseif ($data['jenis_pembayaran'] == 'Prestasi') {
                            $spesifikasi = $data['nama_instansi_beasiswa'] . ' | Minimal: Rp ' . number_format($data['minimal_ukt_bersyarat'], 0, ',', '.');
                        }
                        
                        // Badge class
                        $badgeClass = '';
                        if ($data['jenis_pembayaran'] == 'Mandiri') {
                            $badgeClass = 'badge-mandiri';
                        } elseif ($data['jenis_pembayaran'] == 'Bidik Misi') {
                            $badgeClass = 'badge-bidikmisi';
                        } elseif ($data['jenis_pembayaran'] == 'Prestasi') {
                            $badgeClass = 'badge-prestasi';
                        }
                    ?>
                    <tr>
                        <td><strong><?= $data['id_mahasiswa'] ?></strong></td>
                        <td><?= htmlspecialchars($data['nama_mahasiswa']) ?></td>
                        <td><?= htmlspecialchars($data['nim']) ?></td>
                        <td>Semester <?= $data['semester'] ?></td>
                        <td>
                            <span class="badge-status <?= $badgeClass ?>">
                                <?= $data['jenis_pembayaran'] ?>
                            </span>
                        </td>
                        <td>Rp <?= number_format($data['tarif_ukt_nominal'], 0, ',', '.') ?></td>
                        <td><?= htmlspecialchars($spesifikasi) ?></td>
                        <td>
                            <?php if ($tagihan == 0): ?>
                                <span class="tagihan-gratis">GRATIS</span>
                            <?php else: ?>
                                <span class="tagihan">Rp <?= number_format($tagihan, 0, ',', '.') ?></span>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <?php else: ?>
                <div class="no-data">
                    <p>📭 Belum ada data mahasiswa untuk kategori ini.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>