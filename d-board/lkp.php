<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    // Redirect ke login.php dengan path absolut dari root domain demi keamanan
    header('Location: login.php');
    exit;
}

include '../config/database.php';
$lkp_data = [];

// Fetch real data
if (isset($conn) && is_object($conn) && !$conn->connect_error) {
    $sql = "SELECT * FROM lkp_institutions ORDER BY name ASC";
    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $lkp_data[] = $row;
        }
    }
}
else {
    // Kosongkan jika koneksi gagal
    $lkp_data = [];
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola LKP - Admin Portal</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
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
                <li class="menu-item"><a href="index.php" class="menu-link"><i class="fas fa-tachometer-alt"></i> Dashboard</a></li>
                <li class="menu-item"><a href="lkp.php" class="menu-link active"><i class="fas fa-building"></i> Kelola LKP</a></li>
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

        <div class="content-body">
            <div class="page-header">
                <div>
                    <h1 class="h4">Data Lembaga Kursus & Pelatihan</h1>
                    <p class="text-muted text-sm mt-1">Kelola data profil, alamat, dan status LKP yang terdaftar.</p>
                </div>
                <button class="btn btn-primary"><i class="fas fa-plus" style="margin-right: 5px;"></i> Tambah LKP Baru</button>
            </div>

            <div class="card">
                <div class="card-header" style="justify-content: flex-start; gap: 1rem;">
                    <div style="position: relative; width: 300px;">
                        <i class="fas fa-search text-muted" style="position: absolute; left: 1rem; top: 50%; transform: translateY(-50%);"></i>
                        <input type="text" class="form-control" style="padding-left: 2.5rem;" placeholder="Cari nama LKP atau NILEK...">
                    </div>
                    <button class="btn btn-outline"><i class="fas fa-filter"></i> Filter</button>
                </div>
                <div class="card-body" style="padding: 0;">
                    <div class="table-responsive">
                        <table>
                            <thead>
                                <tr>
                                    <th>NILEK</th>
                                    <th>NAMA LEMBAGA</th>
                                    <th>PIMPINAN</th>
                                    <th>NO. TELP</th>
                                    <th>STATUS</th>
                                    <th>AKSI</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($lkp_data as $lkp): ?>
                                    <?php
    $statusClass = isset($lkp['status']) && $lkp['status'] == 'Aktif' ? 'bg-success-light' : 'bg-danger-light';
    $statusText = isset($lkp['status']) ? $lkp['status'] : 'Aktif';
?>
                                <tr>
                                    <td><b><?php echo htmlspecialchars($lkp['nilek'] ?? '-'); ?></b></td>
                                    <td><?php echo htmlspecialchars($lkp['name']); ?></td>
                                    <td><?php echo htmlspecialchars($lkp['leader_name'] ?? '-'); ?></td>
                                    <td><?php echo htmlspecialchars($lkp['phone'] ?? '-'); ?></td>
                                    <td><span class='badge <?php echo $statusClass; ?>'><?php echo htmlspecialchars($statusText); ?></span></td>
                                    <td>
                                        <button class='btn btn-outline btn-sm me-2' title='Edit'><i class='fas fa-edit'></i></button>
                                        <button class='btn btn-danger btn-sm' title='Hapus'><i class='fas fa-trash'></i></button>
                                    </td>
                                </tr>
                                <?php
endforeach; ?>
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
