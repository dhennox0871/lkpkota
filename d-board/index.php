<?php
session_start();
// Aktifkan error reporting untuk debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Validasi session
if (!isset($_SESSION['admin_logged_in'])) {
    // Redirect ke login.php dengan path absolut agar aman di semua kondisi
    header('Location: login.php');
    exit;
}

// Koneksi ke db untuk stat
include '../config/database.php';
$total_lkp = 0;
$total_program = 0;

if (isset($conn) && is_object($conn) && !$conn->connect_error) {
    $res_lkp = $conn->query("SELECT COUNT(id) as total FROM lkp_institutions");
    if ($res_lkp)
        $total_lkp = $res_lkp->fetch_assoc()['total'];

    $res_prog = $conn->query("SELECT COUNT(id) as total FROM lkp_programs");
    if ($res_prog)
        $total_program = $res_prog->fetch_assoc()['total'];
}
else {
    $total_program = 0;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - Portal LKP</title>
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Admin CSS -->
    <link rel="stylesheet" href="assets/css/admin.css">
</head>
<body>

<div class="admin-wrapper">
    
    <!-- Sidebar -->
    <aside class="sidebar">
        <div class="sidebar-header">
            <div class="sidebar-brand">Portal<span class="text-primary">Admin</span></div>
        </div>
        
        <div class="sidebar-menu">
            <div class="menu-label">Menu Utama</div>
            <ul class="menu-list">
                <li class="menu-item"><a href="index.php" class="menu-link active"><i class="fas fa-tachometer-alt"></i> Dashboard</a></li>
                <li class="menu-item"><a href="lkp.php" class="menu-link"><i class="fas fa-building"></i> Kelola LKP</a></li>
                <li class="menu-item"><a href="#" class="menu-link"><i class="fas fa-book"></i> Program Kursus</a></li>
            </ul>
            
            <div class="menu-label" style="margin-top: 1.5rem;">Sistem</div>
            <ul class="menu-list">
                <li class="menu-item"><a href="#" class="menu-link"><i class="fas fa-users-cog"></i> Pengguna Admin</a></li>
                <li class="menu-item"><a href="#" class="menu-link"><i class="fas fa-cog"></i> Pengaturan Portal</a></li>
                <li class="menu-item"><a href="logout.php" class="menu-link" style="color: #F87171;"><i class="fas fa-sign-out-alt"></i> Keluar</a></li>
            </ul>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="main-content">
        
        <!-- Header -->
        <header class="top-navbar">
            <button class="nav-toggle-btn"><i class="fas fa-bars"></i></button>
            <div class="top-nav-menu">
                <a href="../index.php" target="_blank" class="btn btn-outline btn-sm me-2"><i class="fas fa-external-link-alt" style="margin-right:5px"></i> Lihat Web</a>
                <div class="nav-profile">
                    <img src="https://ui-avatars.com/api/?name=Admin&background=4F46E5&color=fff" alt="Admin">
                    <span class="fw-500 text-sm">Administrator</span>
                </div>
            </div>
        </header>

        <!-- Body -->
        <div class="content-body">
            <div class="page-header">
                <div>
                    <h1 class="h4">Dashboard Ringkasan</h1>
                    <p class="text-muted text-sm mt-1">Selamat datang kembali! Berikut ringkasan data direktori saat ini.</p>
                </div>
                <button class="btn btn-primary"><i class="fas fa-plus" style="margin-right: 5px;"></i> Tambah LKP Baru</button>
            </div>

            <!-- Stats -->
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-icon icon-blue"><i class="fas fa-building"></i></div>
                    <div class="stat-details">
                        <h3><?php echo $total_lkp; ?></h3>
                        <p>Total LKP Terdaftar</p>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon icon-indigo"><i class="fas fa-book-open"></i></div>
                    <div class="stat-details">
                        <h3><?php echo $total_program; ?></h3>
                        <p>Total Program Studi</p>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon icon-green"><i class="fas fa-check-circle"></i></div>
                    <div class="stat-details">
                        <h3>Aktif</h3>
                        <p>Status Database MySQL</p>
                    </div>
                </div>
            </div>

            <!-- Recent Data -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Lembaga Terdaftar Terbaru</h3>
                    <a href="lkp.php" class="text-primary text-sm fw-600">Lihat Semua</a>
                </div>
                <div class="card-body" style="padding: 0;">
                    <div class="table-responsive">
                        <table>
                            <thead>
                                <tr>
                                    <th>NILEK</th>
                                    <th>NAMA LEMBAGA</th>
                                    <th>PIMPINAN</th>
                                    <th>STATUS</th>
                                    <th>AKSI</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
if (isset($conn) && is_object($conn) && !$conn->connect_error) {
    $result = $conn->query("SELECT * FROM lkp_institutions ORDER BY created_at DESC LIMIT 5");
    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $statusBadge = $row['status'] == 'Aktif' ? 'bg-success-light' : 'bg-danger-light';
            echo "<tr>";
            echo "<td><b>{$row['nilek']}</b></td>";
            echo "<td>{$row['name']}</td>";
            echo "<td>{$row['leader_name']}</td>";
            echo "<td><span class='badge {$statusBadge}'>{$row['status']}</span></td>";
            echo "<td>
                                                    <button class='btn btn-outline btn-sm me-2' title='Edit'><i class='fas fa-edit'></i></button>
                                                </td>";
            echo "</tr>";
        }
    }
    else {
        echo "<tr><td colspan='5' class='text-center text-muted py-4'>Belum ada data di database</td></tr>";
    }
}
?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </main>

</div>

</body>
</html>
