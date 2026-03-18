<?php
include '../includes/functions.php';
include '../db.php';

$message = get_flash_message();

$stmt = $pdo->prepare("SELECT c.*, u.name as agency_name FROM cars c JOIN users u ON c.agency_id = u.id ORDER BY c.id DESC");
$stmt->execute();
$cars = $stmt->fetchAll(PDO::FETCH_ASSOC);
$car_count = count($cars);
$lowest_price = $car_count ? min(array_column($cars, 'rent_per_day')) : null;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Cars - Car Rental</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/style.css?v=20260318-1">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="view_cars.php">Car Rental</a>
            <div class="navbar-nav ms-auto">
                <?php if (is_logged_in()): ?>
                    <a class="nav-link" href="dashboard.php">Dashboard</a>
                    <a class="nav-link" href="logout.php">Logout</a>
                <?php else: ?>
                    <a class="nav-link" href="login.php">Login</a>
                    <a class="nav-link" href="register.php">Register</a>
                <?php endif; ?>
            </div>
        </div>
    </nav>

    <div class="container page-shell">
        <section class="hero-panel">
            <div class="row align-items-center g-4">
                <div class="col-lg-8">
                    <span class="stat-chip">Easy city rides and family trips</span>
                    <h1>Book the right car in just a few clicks</h1>
                    <p>Browse verified vehicles, compare daily prices, and reserve the one that matches your plan without hunting through cluttered screens.</p>
                    <div class="hero-actions">
                        <?php if (!is_logged_in()): ?>
                            <a href="register.php" class="btn btn-light">Create Customer Account</a>
                            <a href="login.php" class="btn btn-outline-light">Login</a>
                        <?php elseif (get_user_role() === 'customer'): ?>
                            <a href="my_bookings.php" class="btn btn-light">View My Bookings</a>
                            <a href="dashboard.php" class="btn btn-outline-light">Open Dashboard</a>
                        <?php else: ?>
                            <a href="dashboard.php" class="btn btn-light">Open Agency Dashboard</a>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="hero-stat-grid">
                        <div class="stat-chip">Available cars: <?php echo $car_count; ?></div>
                        <div class="stat-chip">Starting from: <?php echo $lowest_price !== null ? '$' . number_format($lowest_price, 2) . '/day' : 'No pricing yet'; ?></div>
                        <div class="stat-chip">Quick booking form on every card</div>
                    </div>
                </div>
            </div>
        </section>

        <?php if ($message): ?>
            <div class="alert alert-<?php echo $message['type']; ?>">
                <?php echo $message['message']; ?>
            </div>
        <?php endif; ?>

        <div class="section-heading">
            <div>
                <h2>Available Cars</h2>
                <p>Compare daily rent, seating, and provider details at a glance.</p>
            </div>
            <span class="info-chip">Customer-friendly booking flow</span>
        </div>

        <?php if (empty($cars)): ?>
            <div class="surface-card empty-state">
                <h3>No cars are listed yet</h3>
                <p class="muted-note">Once agencies add vehicles, customers will be able to browse and book them here.</p>
            </div>
        <?php else: ?>
            <div class="row g-4">
                <?php foreach ($cars as $car): ?>
                    <div class="col-lg-4 col-md-6">
                        <div class="card booking-card">
                            <div class="card-body">
                                <div class="car-card-top">
                                    <div>
                                        <h5 class="car-card-title"><?php echo $car['model']; ?></h5>
                                        <p class="car-card-subtitle">Provided by <?php echo $car['agency_name']; ?></p>
                                    </div>
                                    <div class="price-badge">
                                        $<?php echo number_format($car['rent_per_day'], 2); ?>
                                        <small>per day</small>
                                    </div>
                                </div>

                                <div class="feature-list">
                                    <div class="feature-item">
                                        <span>Vehicle Number</span>
                                        <strong><?php echo $car['vehicle_number']; ?></strong>
                                    </div>
                                    <div class="feature-item">
                                        <span>Seats</span>
                                        <strong><?php echo $car['seating_capacity']; ?> passengers</strong>
                                    </div>
                                </div>

                                <?php if (is_logged_in() && get_user_role() === 'customer'): ?>
                                    <form method="POST" action="process_booking.php">
                                        <input type="hidden" name="car_id" value="<?php echo $car['id']; ?>">
                                        <div class="form-group">
                                            <label class="form-label" for="start_date_<?php echo $car['id']; ?>">Trip Start Date</label>
                                            <input type="date" class="form-control" id="start_date_<?php echo $car['id']; ?>" name="start_date" min="<?php echo date('Y-m-d'); ?>" required>
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label" for="days_<?php echo $car['id']; ?>">Rental Duration</label>
                                            <select class="form-select" id="days_<?php echo $car['id']; ?>" name="days" required>
                                                <?php for ($i = 1; $i <= 30; $i++): ?>
                                                    <option value="<?php echo $i; ?>"><?php echo $i; ?> day<?php echo $i > 1 ? 's' : ''; ?></option>
                                                <?php endfor; ?>
                                            </select>
                                        </div>
                                        <button type="submit" class="btn btn-primary w-100">Book This Car</button>
                                    </form>
                                <?php elseif (!is_logged_in()): ?>
                                    <p class="text-muted mb-3">Please login as a customer to continue with this booking.</p>
                                    <a href="login.php" class="btn btn-primary w-100">Rent Car</a>
                                <?php elseif (get_user_role() === 'agency'): ?>
                                    <p class="text-muted mb-0">Agencies can list and manage cars, but customer accounts are needed to make bookings.</p>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../js/script.js"></script>
</body>
</html>
