<?php
// Nonaktifkan error agar tampilan tetap rapi jika database belum diimport
error_reporting(0);

$db_connected = false;
$lkp_data = [];

// Coba koneksi ke database MySQL
if (file_exists('config/database.php')) {
    include 'config/database.php';
    if (isset($conn) && is_object($conn) && !$conn->connect_error) {
        $db_connected = true;

        // Ambil data LKP dari tabel MySQL
        $sql = "SELECT * FROM lkp_institutions WHERE status = 'Aktif' ORDER BY name ASC";
        $result = $conn->query($sql);

        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                // Ambil daftar program untuk LKP ini
                $prog_sql = "SELECT program_name FROM lkp_programs WHERE lkp_id = " . $row['id'];
                $prog_result = $conn->query($prog_sql);
                $programs = [];
                if ($prog_result && $prog_result->num_rows > 0) {
                    while ($prow = $prog_result->fetch_assoc()) {
                        $programs[] = $prow['program_name'];
                    }
                }
                $row['programs'] = $programs;
                $lkp_data[] = $row;
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portal Direktori LKP Kota - Himpunan Lembaga Kursus dan Pelatihan</title>
    <meta name="description" content="Portal Direktori Lembaga Kursus dan Pelatihan (LKP) Kota. Temukan berbagai lembaga pendidikan non-formal terbaik di kota Anda.">
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

    <!-- Header / Navigation -->
    <header class="header blur-navbar" id="header">
        <div class="container nav-container">
            <div class="logo">
                <a href="index.php">
                    <span class="logo-text">Portal<span class="text-primary">LKP</span></span>
                </a>
            </div>
            <nav class="navbar" id="navbar">
                <ul class="nav-list">
                    <li class="nav-item"><a href="#home" class="nav-link active">Beranda</a></li>
                    <li class="nav-item"><a href="#direktori" class="nav-link">Direktori LKP</a></li>
                    <li class="nav-item"><a href="#tentang" class="nav-link">Tentang Portal</a></li>
                    <li class="nav-item"><a href="#berita" class="nav-link">Informasi</a></li>
                    <li class="nav-item"><a href="#kontak" class="nav-link">Kontak</a></li>
                </ul>
            </nav>
            <div class="nav-actions">
                <button class="menu-toggle" id="menu-toggle" aria-label="Toggle Menu">
                    <i class="fas fa-bars"></i>
                </button>
            </div>
        </div>
    </header>

    <!-- Hero Section -->
    <section class="hero" id="home">
        <div class="hero-bg-shapes">
            <div class="shape shape-1"></div>
            <div class="shape shape-2"></div>
            <div class="shape shape-3"></div>
        </div>
        <div class="container hero-container text-center mx-auto" style="grid-template-columns: 1fr;">
            <div class="hero-content mx-auto" style="max-width: 800px;">
                <div class="badge-tag glass-tag fade-in-up">🌟 <?php echo $db_connected ? '<span class="text-success"><i class="fas fa-check-circle"></i> Database Online</span>' : '<span class="text-warning"><i class="fas fa-exclamation-triangle"></i> Data Demo (DB Offline)</span>'; ?></div>
                <h1 class="hero-title fade-in-up delay-1">Direktori Resmi <span class="gradient-text">Lembaga Kursus & Pelatihan</span> (LKP) Kota</h1>
                <p class="hero-subtitle fade-in-up delay-2">Temukan pusat pendidikan non material, kurus, dan pelatihan yang kredibel, terdaftar resmi dan bersertifikat untuk meningkatkan keterampilan Anda di wilayah Kota.</p>
                
                <!-- Search Box -->
                <div class="search-box glassmorphism fade-in-up delay-3 mx-auto mt-4" style="max-width: 600px; border-radius: 50px; padding: 0.5rem; display: flex;">
                    <input type="text" placeholder="Cari nama LKP atau program keahlian..." style="flex:1; border:none; background:transparent; padding: 1rem 1.5rem; outline:none; font-family:var(--font-family);">
                    <button class="btn btn-primary rounded-pill"><i class="fas fa-search mr-2"></i> Cari</button>
                </div>

                <div class="stats-row mx-auto justify-content-center fade-in-up delay-4" style="justify-content: center; margin-top: 3rem; border-top: none;">
                    <div class="stat-item mx-3">
                        <span class="stat-number"><?php echo count($lkp_data); ?>+</span>
                        <span class="stat-label">LKP Terdaftar</span>
                    </div>
                    <div class="stat-item mx-3">
                        <span class="stat-number">100+</span>
                        <span class="stat-label">Program Kurikulum</span>
                    </div>
                    <div class="stat-item mx-3">
                        <span class="stat-number">Ribuan</span>
                        <span class="stat-label">Alumni Tersalurkan</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Direktori Section (Dynamic from Database) -->
    <section class="section bg-light programs-section" id="direktori">
        <div class="container">
            <div class="section-header text-center mx-auto mb-5" style="max-width: 600px;">
                <span class="subtitle text-primary fw-600">Daftar Lembaga</span>
                <h2 class="title">Direktori LKP Seluruh Kota</h2>
                <p class="text-muted">Profil lembaga kursus dan ketrampilan terdaftar dan tersertifikasi resmi dalam jaringan asosiasi kami.</p>
                <?php if (!$db_connected): ?>
                <div class="mt-3 p-3 bg-white shadow-sm rounded border-left border-warning" style="border-left-width: 4px !important;">
                    <small class="text-warning fw-600"><i class="fas fa-info-circle mr-1"></i> Mode Preview: Menampilkan data dummy karena database belum dikonfigurasi. Silakan import `database/schema.sql` ke MySQL Anda.</small>
                </div>
                <?php
endif; ?>
            </div>

            <div class="grid-3-col">
                <?php foreach ($lkp_data as $index => $lkp): ?>
                <!-- LKP Card -->
                <div class="program-card card-hover-fx fade-in-up delay-<?php echo($index % 4) + 1; ?>">
                    <div class="card-img-top placeholder-img <?php echo $index % 2 == 0 ? 'bg-gradient' : 'bg-gradient-alt'; ?>" style="height: 120px;">
                        <i class="fas fa-building main-icon" style="font-size: 3rem;"></i>
                        <div class="category-tag"><i class="fas fa-certificate text-warning mr-1"></i> NILEK: <?php echo htmlspecialchars($lkp['nilek']); ?></div>
                    </div>
                    <div class="card-body">
                        <h3 class="card-title h4 mb-2"><?php echo htmlspecialchars($lkp['name']); ?></h3>
                        
                        <div class="meta text-sm text-muted mb-4 pb-3 border-bottom border-gray-dark">
                            <div class="mb-1"><i class="fas fa-user-tie text-primary mr-2" style="width: 15px;"></i> Pimpinan: <?php echo htmlspecialchars($lkp['leader_name']); ?></div>
                            <div class="mb-1"><i class="fas fa-map-marker-alt text-primary mr-2" style="width: 15px;"></i> <?php echo htmlspecialchars($lkp['address']); ?></div>
                            <div><i class="fas fa-phone-alt text-primary mr-2" style="width: 15px;"></i> <?php echo htmlspecialchars($lkp['phone']); ?></div>
                        </div>
                        
                        <h4 class="text-sm fw-600 mb-2">Program Unggulan:</h4>
                        <div class="program-tags mb-4">
                            <?php
    if (!empty($lkp['programs'])):
        foreach ($lkp['programs'] as $prog):
?>
                                <span class="badge text-xs bg-soft text-main px-2 py-1 rounded d-inline-block mb-1" style="background-color: var(--bg-soft); color: var(--text-main);"><?php echo htmlspecialchars($prog); ?></span>
                            <?php
        endforeach;
    else:
?>
                                <span class="text-muted text-xs italic">Belum ada program diinput</span>
                            <?php
    endif; ?>
                        </div>
                        
                        <div class="card-footer-flex pt-2">
                            <a href="#" class="btn btn-sm btn-outline-primary rounded-pill w-100 mx-auto text-center" style="display: block;">Kunjungi Profil</a>
                        </div>
                    </div>
                </div>
                <?php
endforeach; ?>
            </div>
            
            <div class="text-center mt-5">
                <a href="#" class="btn btn-primary btn-lg rounded-pill hover-lift shadow-md">Muat Lebih Banyak LKP <i class="fas fa-chevron-down ml-2"></i></a>
            </div>
        </div>
    </section>

    <!-- About Portal Section -->
    <section class="section about-section" id="tentang">
        <div class="container">
            <div class="grid-2-col align-center">
                <div class="about-content">
                    <div class="section-heading">
                        <span class="subtitle text-primary fw-600">Tentang Portal</span>
                        <h2 class="title">Wadah Sentralisasi Informasi LKP Terpercaya</h2>
                    </div>
                    <p class="mb-4 text-muted">Portal ini didedikasikan untuk mempermudah masyarakat dalam menemukan lembaga kursus dan ketrampilan yang paling tepat demi mendukung karir mereka. Kami berkolaborasi dengan Dinas Pendidikan untuk memastikan seluruh LKP terdaftar secara legal.</p>
                    
                    <ul class="feature-list">
                        <li>
                            <div class="feature-icon"><i class="fas fa-shield-alt"></i></div>
                            <div>
                                <h4 class="fw-600">Telah Terverifikasi</h4>
                                <p class="text-sm text-muted">LKP yang terdaftar telah melewati tahap verifikasi legalitas operasi (NILEK/NPSN).</p>
                            </div>
                        </li>
                        <li>
                            <div class="feature-icon"><i class="fas fa-sync"></i></div>
                            <div>
                                <h4 class="fw-600">Data Terpusat & Terukur</h4>
                                <p class="text-sm text-muted">Akses informasi LKP, program studi, profil instruktur dalam satu pintu.</p>
                            </div>
                        </li>
                    </ul>
                </div>
                <div class="about-images">
                    <div class="img-box bg-dark placeholder-img rounded-xl shadow-lg" style="height: 400px; background: url('https://images.unsplash.com/photo-1524178232363-1fb2b075b655?q=80&w=2070&auto=format&fit=crop') center/cover;">
                        <div style="background: rgba(15, 23, 42, 0.7); width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; flex-direction: column; color: white;">
                             <i class="fas fa-network-wired mb-3" style="font-size: 4rem; color: var(--primary-color);"></i>
                             <h3 class="text-white">Ekosistem<br>Pendidikan Formal</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer bg-dark-footer text-white pt-5 pb-3">
        <div class="container pt-4">
            <div class="row">
                <div class="col-lg-4 col-md-6 mb-4 mb-lg-0">
                    <div class="logo mb-4">
                        <span class="logo-text text-white h3">Portal<span class="text-primary">LKP</span></span>
                    </div>
                    <p class="text-gray mb-4">Portal himpunan Lembaga Kursus dan Pelatihan tingkat kota. Meningkatkan sinergi antar instansi penyedia pendidikan non-formal dan vokasi masyarakat.</p>
                </div>
                
                <div class="col-lg-4 col-md-6 mb-4 mb-lg-0">
                    <h4 class="footer-title mb-4 h5">Tautan Cepat</h4>
                    <ul class="footer-links" style="display: grid; grid-template-columns: 1fr 1fr;">
                        <li><a href="#home">Beranda</a></li>
                        <li><a href="#direktori">Direktori LKP</a></li>
                        <li><a href="#tentang">Tentang Portal</a></li>
                        <li><a href="#berita">Informasi Publik</a></li>
                    </ul>
                </div>

                <div class="col-lg-4 col-md-6">
                    <h4 class="footer-title mb-4 h5">Sekretariat</h4>
                    <ul class="contact-info">
                        <li class="mb-3 d-flex">
                            <i class="fas fa-map-marker-alt text-primary mt-1 mr-3"></i>
                            <span class="text-gray">Gedung Dinas Pendidikan Lt. 2<br>Jl. Pendidikan No. 123, Pusat Kota</span>
                        </li>
                        <li class="mb-3 d-flex">
                            <i class="fas fa-envelope text-primary mt-1 mr-3"></i>
                            <span class="text-gray">admin@portal-lkpkota.id</span>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="footer-bottom border-top border-gray-dark mt-5 pt-4 text-center">
                <p class="text-gray mb-0">&copy; <?php echo date('Y'); ?> Portal Direktori LKP Kota. Hak Cipta Dilindungi.</p>
            </div>
        </div>
    </footer>

    <script src="assets/js/main.js"></script>
</body>
</html>
