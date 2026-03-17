<?php
session_start();
// Hardcoded admin for template purposes
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    // Dummy admin check: admin / password
    if ($username === 'admin' && $password === 'password') {
        $_SESSION['admin_logged_in'] = true;
        header('Location: index.php');
        exit;
    }
    else {
        $error = 'Username atau Password salah!';
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin - Portal LKP Kota</title>
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Admin CSS -->
    <link rel="stylesheet" href="assets/css/admin.css">
</head>
<body class="login-body">

    <div class="login-card">
        <div class="login-header">
            <span class="sidebar-brand text-dark h4" style="color:var(--dark-color) !important;">Portal<span class="text-primary">LKP</span></span>
            <p class="text-muted mt-2">Login untuk mengelola direktori</p>
        </div>

        <?php if ($error): ?>
            <div style="background: rgba(239, 68, 68, 0.1); color: var(--danger); padding: 0.75rem; border-radius: 0.5rem; margin-bottom: 1.5rem; text-align: center; font-size: 0.875rem;">
                <i class="fas fa-exclamation-circle mr-2"></i> <?php echo $error; ?>
            </div>
        <?php
endif; ?>

        <form action="" method="POST">
            <div class="form-group mb-4">
                <label class="form-label">Username</label>
                <div style="position: relative;">
                    <i class="fas fa-user text-muted" style="position: absolute; left: 1rem; top: 50%; transform: translateY(-50%);"></i>
                    <input type="text" name="username" class="form-control" style="padding-left: 2.5rem;" required placeholder="Masukkan username">
                </div>
            </div>
            
            <div class="form-group mb-4">
                <label class="form-label">Password</label>
                <div style="position: relative;">
                    <i class="fas fa-lock text-muted" style="position: absolute; left: 1rem; top: 50%; transform: translateY(-50%);"></i>
                    <input type="password" name="password" class="form-control" style="padding-left: 2.5rem;" required placeholder="Masukkan password">
                </div>
            </div>

            <button type="submit" class="btn btn-primary btn-lg w-100 mt-2">Login Ke Dashboard <i class="fas fa-arrow-right ml-2" style="margin-left:0.5rem"></i></button>
        </form>
        
        <div class="text-center mt-4 pt-3" style="border-top: 1px solid #eee; font-size: 0.8rem;">
            <p class="text-muted mb-0">Note: Use <b>admin</b> / <b>password</b> to login</p>
        </div>
    </div>

</body>
</html>
