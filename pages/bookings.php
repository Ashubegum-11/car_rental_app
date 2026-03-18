<?php
include '../includes/functions.php';
include '../db.php';

require_login();
require_agency();

$message = get_flash_message();
$agency_id = get_user_id();
$selected_car_id = isset($_GET['car_id']) ? (int)$_GET['car_id'] : 0;

$car_stmt = $pdo->prepare("SELECT id, model, vehicle_number FROM cars WHERE agency_id = ? ORDER BY model ASC");
$car_stmt->execute([$agency_id]);
$agency_cars = $car_stmt->fetchAll(PDO::FETCH_ASSOC);

if ($selected_car_id > 0) {
    $stmt = $pdo->prepare("
        SELECT b.*, c.model, c.vehicle_number, u.name as customer_name, u.email as customer_email
        FROM bookings b
        JOIN cars c ON b.car_id = c.id
        JOIN users u ON b.customer_id = u.id
        WHERE c.agency_id = ? AND c.id = ?
        ORDER BY b.start_date DESC
    ");
    $stmt->execute([$agency_id, $selected_car_id]);
} else {
    $stmt = $pdo->prepare("
        SELECT b.*, c.model, c.vehicle_number, u.name as customer_name, u.email as customer_email
        FROM bookings b
        JOIN cars c ON b.car_id = c.id
        JOIN users u ON b.customer_id = u.id
        WHERE c.agency_id = ?
        ORDER BY b.start_date DESC
    ");
    $stmt->execute([$agency_id]);
}

$bookings = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bookings - Car Rental</title>
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

    <div class="container mt-5">
        <h2>My Car Bookings</h2>
        <?php if ($message): ?>
            <div class="alert alert-<?php echo $message['type']; ?>">
                <?php echo $message['message']; ?>
            </div>
        <?php endif; ?>

        <?php if (!empty($agency_cars)): ?>
            <form method="GET" class="mb-4">
                <div class="row g-3 align-items-end">
                    <div class="col-md-6">
                        <label class="form-label" for="car_id">View bookings for a particular car</label>
                        <select class="form-select" id="car_id" name="car_id">
                            <option value="0">All cars</option>
                            <?php foreach ($agency_cars as $agency_car): ?>
                                <option value="<?php echo $agency_car['id']; ?>" <?php echo $selected_car_id === (int)$agency_car['id'] ? 'selected' : ''; ?>>
                                    <?php echo $agency_car['model'] . ' (' . $agency_car['vehicle_number'] . ')'; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <button type="submit" class="btn btn-primary w-100">Filter Bookings</button>
                    </div>
                </div>
            </form>
        <?php endif; ?>

        <?php if (empty($bookings)): ?>
            <p>No bookings found for the selected car.</p>
        <?php else: ?>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Car Model</th>
                        <th>Vehicle Number</th>
                        <th>Customer Name</th>
                        <th>Customer Email</th>
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
                            <td><?php echo $booking['customer_name']; ?></td>
                            <td><?php echo $booking['customer_email']; ?></td>
                            <td><?php echo $booking['start_date']; ?></td>
                            <td><?php echo $booking['days']; ?></td>
                            <td>$<?php echo number_format($booking['total_amount'], 2); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
