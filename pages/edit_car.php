<?php
include '../includes/functions.php';
include '../db.php';

require_login();
require_agency();

$message = get_flash_message();
$car_id = $_GET['id'] ?? null;

if (!$car_id) {
    header('Location: dashboard.php');
    exit;
}

// Check if car belongs to agency
$stmt = $pdo->prepare("SELECT * FROM cars WHERE id = ? AND agency_id = ?");
$stmt->execute([$car_id, get_user_id()]);
$car = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$car) {
    set_flash_message('Car not found or access denied.', 'danger');
    header('Location: dashboard.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $model = sanitize($_POST['model']);
    $vehicle_number = sanitize($_POST['vehicle_number']);
    $seating_capacity = (int)$_POST['seating_capacity'];
    $rent_per_day = (float)$_POST['rent_per_day'];

    try {
        $stmt = $pdo->prepare("UPDATE cars SET model = ?, vehicle_number = ?, seating_capacity = ?, rent_per_day = ? WHERE id = ? AND agency_id = ?");
        $stmt->execute([$model, $vehicle_number, $seating_capacity, $rent_per_day, $car_id, get_user_id()]);
        set_flash_message('Car updated successfully!', 'success');
        header('Location: edit_car.php?id=' . $car_id);
        exit;
    } catch (PDOException $e) {
        if ($e->getCode() == 23000) {
            set_flash_message('Vehicle number already exists.', 'danger');
        } else {
            set_flash_message('Failed to update car.', 'danger');
        }
        header('Location: edit_car.php?id=' . $car_id);
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Car - Car Rental</title>
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
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h3>Edit Car</h3>
                    </div>
                    <div class="card-body">
                        <?php if ($message): ?>
                            <div class="alert alert-<?php echo $message['type']; ?>">
                                <?php echo $message['message']; ?>
                            </div>
                        <?php endif; ?>
                        <form method="POST">
                            <div class="form-group">
                                <label for="model">Model</label>
                                <input type="text" class="form-control" id="model" name="model" value="<?php echo $car['model']; ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="vehicle_number">Vehicle Number</label>
                                <input type="text" class="form-control" id="vehicle_number" name="vehicle_number" value="<?php echo $car['vehicle_number']; ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="seating_capacity">Seating Capacity</label>
                                <input type="number" class="form-control" id="seating_capacity" name="seating_capacity" value="<?php echo $car['seating_capacity']; ?>" min="1" required>
                            </div>
                            <div class="form-group">
                                <label for="rent_per_day">Rent per Day ($)</label>
                                <input type="number" class="form-control" id="rent_per_day" name="rent_per_day" value="<?php echo $car['rent_per_day']; ?>" step="0.01" min="0" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Update Car</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../js/script.js"></script>
</body>
</html>
