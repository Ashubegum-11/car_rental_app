<?php
include '../includes/functions.php';
include '../db.php';

require_login();
require_customer();

$message = get_flash_message();
$customer_id = get_user_id();

$stmt = $pdo->prepare("
    SELECT b.*, c.model, c.vehicle_number, u.name as agency_name
    FROM bookings b
    JOIN cars c ON b.car_id = c.id
    JOIN users u ON c.agency_id = u.id
    WHERE b.customer_id = ?
    ORDER BY b.start_date DESC
");
$stmt->execute([$customer_id]);
$bookings = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Bookings - Car Rental</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/style.css?v=20260318-1">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="view_cars.php">Car Rental</a>
            <div class="navbar-nav ms-auto">
                <a class="nav-link" href="dashboard.php">Dashboard</a>
                <a class="nav-link" href="logout.php">Logout</a>
            </div>
        </div>
    </nav>

    <div class="container page-shell">
        <section class="hero-panel mb-4">
            <span class="stat-chip">Customer booking history</span>
            <h2>My Bookings</h2>
            <p>Keep track of your reserved cars, start dates, trip lengths, and total rental costs in one clear view.</p>
        </section>

        <?php if ($message): ?>
            <div class="alert alert-<?php echo $message['type']; ?>">
                <?php echo $message['message']; ?>
            </div>
        <?php endif; ?>

        <?php if (empty($bookings)): ?>
            <div class="surface-card empty-state">
                <h3>No bookings yet</h3>
                <p class="muted-note mb-4">Once you reserve a car, the trip details will appear here.</p>
                <a href="view_cars.php" class="btn btn-primary">Browse Available Cars</a>
            </div>
        <?php else: ?>
            <div class="surface-card table-wrap">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Car Model</th>
                            <th>Vehicle Number</th>
                            <th>Agency</th>
                            <th>Start Date</th>
                            <th>Days</th>
                            <th>Total Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($bookings as $booking): ?>
                            <tr>
                                <td><?php echo $booking['model']; ?></td>
                                <td><?php echo $booking['vehicle_number']; ?></td>
                                <td><?php echo $booking['agency_name']; ?></td>
                                <td><?php echo $booking['start_date']; ?></td>
                                <td><?php echo $booking['days']; ?></td>
                                <td>$<?php echo number_format($booking['total_amount'], 2); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
