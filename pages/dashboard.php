<?php
include '../includes/functions.php';
include '../db.php';

require_login();

$message = get_flash_message();
$role = get_user_role();
$user_name = $_SESSION['user_name'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Car Rental</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/style.css?v=20260318-1">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="view_cars.php">Car Rental</a>
            <div class="navbar-nav ms-auto">
                <span class="navbar-text me-3">Welcome, <?php echo $user_name; ?> (<?php echo ucfirst($role); ?>)</span>
                <a class="nav-link" href="logout.php">Logout</a>
            </div>
        </div>
    </nav>

    <div class="container page-shell">
        <?php if ($message): ?>
            <div class="alert alert-<?php echo $message['type']; ?>">
                <?php echo $message['message']; ?>
            </div>
        <?php endif; ?>

        <section class="hero-panel mb-4">
            <span class="stat-chip"><?php echo ucfirst($role); ?> account</span>
            <h2>Welcome back, <?php echo htmlspecialchars($user_name); ?></h2>
            <?php if ($role === 'agency'): ?>
                <p>Manage your vehicle inventory, keep pricing updated, and review upcoming bookings from one place.</p>
            <?php else: ?>
                <p>Pick a car, review your past bookings, and get back on the road with a simpler customer experience.</p>
            <?php endif; ?>
        </section>

        <?php if ($role === 'agency'): ?>
            <div class="section-heading">
                <div>
                    <h3>Agency Tools</h3>
                    <p>Everything you need to manage listings and incoming rentals.</p>
                </div>
            </div>
            <div class="quick-link-grid">
                <div class="card dashboard-card">
                    <div class="card-body">
                        <h5 class="card-title">Manage Cars</h5>
                        <p class="card-text">Add new vehicles, refresh details, and keep your listings customer-ready.</p>
                        <a href="add_car.php" class="btn btn-primary">Add Car</a>
                        <a href="view_my_cars.php" class="btn btn-outline-secondary ms-2">View My Cars</a>
                    </div>
                </div>
                <div class="card dashboard-card">
                    <div class="card-body">
                        <h5 class="card-title">View Bookings</h5>
                        <p class="card-text">Stay on top of reservations for all cars listed by your agency account.</p>
                        <a href="bookings.php" class="btn btn-primary">View Bookings</a>
                    </div>
                </div>
                <div class="card dashboard-card">
                    <div class="card-body">
                        <h5 class="card-title">Public Listings</h5>
                        <p class="card-text">Preview the customer-facing car catalog exactly as renters will see it.</p>
                        <a href="view_cars.php" class="btn btn-primary">Browse Public Cars</a>
                    </div>
                </div>
            </div>
        <?php elseif ($role === 'customer'): ?>
            <div class="section-heading">
                <div>
                    <h3>Customer Shortcuts</h3>
                    <p>Start a new trip or review your recent rental activity.</p>
                </div>
            </div>
            <div class="quick-link-grid">
                <div class="card dashboard-card">
                    <div class="card-body">
                        <h5 class="card-title">Browse Cars</h5>
                        <p class="card-text">Explore available vehicles with clearer pricing and quick booking forms.</p>
                        <a href="view_cars.php" class="btn btn-primary">View Cars</a>
                    </div>
                </div>
                <div class="card dashboard-card">
                    <div class="card-body">
                        <h5 class="card-title">My Bookings</h5>
                        <p class="card-text">Track your reservations, agencies, and total trip costs in one place.</p>
                        <a href="my_bookings.php" class="btn btn-primary">View My Bookings</a>
                    </div>
                </div>
                <div class="card dashboard-card">
                    <div class="card-body">
                        <h5 class="card-title">Start Fast</h5>
                        <p class="card-text">Need a quick option? Open the listings page and reserve from the first card that fits.</p>
                        <a href="view_cars.php" class="btn btn-outline-primary">Book a Car Now</a>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
