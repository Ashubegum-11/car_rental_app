<?php
include '../includes/functions.php';
include '../db.php';

$message = get_flash_message();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = sanitize($_POST['email']);
    $password = $_POST['password'];

    $stmt = $pdo->prepare("SELECT id, name, password, role FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_name'] = $user['name'];
        $_SESSION['role'] = $user['role'];
        set_flash_message('Login successful!', 'success');
        header('Location: dashboard.php');
        exit;
    } else {
        set_flash_message('Invalid email or password.', 'danger');
        header('Location: login.php');
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Car Rental</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/style.css?v=20260318-1">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="view_cars.php">Car Rental</a>
            <div class="navbar-nav ms-auto">
                <a class="nav-link" href="login.php">Login</a>
                <a class="nav-link" href="register.php">Register</a>
            </div>
        </div>
    </nav>

    <div class="container auth-wrapper">
        <div class="row justify-content-center w-100">
            <div class="col-lg-10">
                <div class="card auth-card">
                    <div class="row g-0">
                        <div class="col-lg-5">
                            <div class="auth-side">
                                <span class="stat-chip">Customer and agency access</span>
                                <h3 class="mt-3">Welcome back</h3>
                                <p>Login to browse available cars, manage bookings, or update your agency listings with a cleaner and faster experience.</p>
                                <div class="hero-stat-grid">
                                    <div class="stat-chip">Quick booking flow</div>
                                    <div class="stat-chip">Mobile-friendly layout</div>
                                    <div class="stat-chip">Simple dashboard access</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-7">
                            <div class="auth-form">
                                <h3>Login</h3>
                                <p class="muted-note mb-4">Enter your account details to continue.</p>
                        <?php if ($message): ?>
                            <div class="alert alert-<?php echo $message['type']; ?>">
                                <?php echo $message['message']; ?>
                            </div>
                        <?php endif; ?>
                        <form method="POST">
                            <div class="form-group">
                                <label class="form-label" for="email">Email</label>
                                <input type="email" class="form-control" id="email" name="email" required>
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="password">Password</label>
                                <input type="password" class="form-control" id="password" name="password" required>
                            </div>
                            <button type="submit" class="btn btn-primary w-100">Login</button>
                        </form>
                                <p class="muted-note mt-4 mb-0">New here? <a href="register.php">Create an account</a> to start booking cars.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../js/script.js"></script>
</body>
</html>
