<?php
include '../includes/functions.php';
include '../db.php';

require_login();
require_agency();

$message = get_flash_message();
$agency_id = get_user_id();

$stmt = $pdo->prepare("SELECT * FROM cars WHERE agency_id = ? ORDER BY id DESC");
$stmt->execute([$agency_id]);
$cars = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Cars - Car Rental</title>
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
        <h2>My Cars</h2>
        <a href="add_car.php" class="btn btn-primary mb-3">Add New Car</a>
        <?php if ($message): ?>
            <div class="alert alert-<?php echo $message['type']; ?>">
                <?php echo $message['message']; ?>
            </div>
        <?php endif; ?>

        <?php if (empty($cars)): ?>
            <p>No cars added yet.</p>
        <?php else: ?>
            <div class="row">
                <?php foreach ($cars as $car): ?>
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title"><?php echo $car['model']; ?></h5>
                                <p class="card-text">
                                    Vehicle Number: <?php echo $car['vehicle_number']; ?><br>
                                    Seating Capacity: <?php echo $car['seating_capacity']; ?><br>
                                    Rent per Day: $<?php echo $car['rent_per_day']; ?>
                                </p>
                                <a href="edit_car.php?id=<?php echo $car['id']; ?>" class="btn btn-secondary">Edit</a>
                                <a href="bookings.php?car_id=<?php echo $car['id']; ?>" class="btn btn-primary">View Bookings</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
