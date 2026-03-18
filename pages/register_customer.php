<?php
include '../includes/functions.php';
include '../db.php';

$message = get_flash_message();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = sanitize($_POST['name']);
    $email = sanitize($_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    try {
        $stmt = $pdo->prepare("INSERT INTO users (name, email, password, role) VALUES (?, ?, ?, 'customer')");
        $stmt->execute([$name, $email, $password]);
        set_flash_message('Customer registration successful! Please login.', 'success');
        header('Location: login.php');
        exit;
    } catch (PDOException $e) {
        if ($e->getCode() == 23000) {
            set_flash_message('Email already exists.', 'danger');
        } else {
            set_flash_message('Registration failed.', 'danger');
        }
        header('Location: register_customer.php');
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Registration - Car Rental</title>
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
                                <span class="stat-chip">Customer registration</span>
                                <h3 class="mt-3">Start booking trips</h3>
                                <p>Create a customer account to browse cars, choose rental dates, and manage your bookings.</p>
                            </div>
                        </div>
                        <div class="col-lg-7">
                            <div class="auth-form">
                                <h3>Register as Customer</h3>
                                <p class="muted-note mb-4">Enter your details to create a customer account.</p>
                                <?php if ($message): ?>
                                    <div class="alert alert-<?php echo $message['type']; ?>">
                                        <?php echo $message['message']; ?>
                                    </div>
                                <?php endif; ?>
                                <form method="POST">
                                    <div class="form-group">
                                        <label class="form-label" for="name">Name</label>
                                        <input type="text" class="form-control" id="name" name="name" required>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label" for="email">Email</label>
                                        <input type="email" class="form-control" id="email" name="email" required>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label" for="password">Password</label>
                                        <input type="password" class="form-control" id="password" name="password" required>
                                    </div>
                                    <button type="submit" class="btn btn-primary w-100">Create Customer Account</button>
                                </form>
                                <p class="muted-note mt-4 mb-0">Need an agency account instead? <a href="register_agency.php">Register as agency</a>.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
