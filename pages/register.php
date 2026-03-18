<?php
include '../includes/functions.php';

$message = get_flash_message();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Choose Registration - Car Rental</title>
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
                                <span class="stat-chip">Choose your registration path</span>
                                <h3 class="mt-3">Get started in minutes</h3>
                                <p>Use separate registration pages for customers and agencies so each user type has a clear flow from the start.</p>
                            </div>
                        </div>
                        <div class="col-lg-7">
                            <div class="auth-form">
                                <h3>Create Your Account</h3>
                                <p class="muted-note mb-4">Pick the registration page that matches how you will use the system.</p>
                                <?php if ($message): ?>
                                    <div class="alert alert-<?php echo $message['type']; ?>">
                                        <?php echo $message['message']; ?>
                                    </div>
                                <?php endif; ?>
                                <div class="quick-link-grid">
                                    <div class="card dashboard-card">
                                        <div class="card-body">
                                            <h5 class="card-title">Customer Registration</h5>
                                            <p class="card-text">Create a customer account to browse available cars and rent them by date and duration.</p>
                                            <a href="register_customer.php" class="btn btn-primary w-100">Register as Customer</a>
                                        </div>
                                    </div>
                                    <div class="card dashboard-card">
                                        <div class="card-body">
                                            <h5 class="card-title">Agency Registration</h5>
                                            <p class="card-text">Create an agency account to add vehicles, edit listings, and review bookings for your cars.</p>
                                            <a href="register_agency.php" class="btn btn-outline-primary w-100">Register as Agency</a>
                                        </div>
                                    </div>
                                </div>
                                <p class="muted-note mt-4 mb-0">Already registered? <a href="login.php">Login here</a>.</p>
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
