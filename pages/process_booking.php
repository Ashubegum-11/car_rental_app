<?php
include '../includes/functions.php';
include '../db.php';

require_login();
require_customer();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $car_id = (int)$_POST['car_id'];
    $start_date = $_POST['start_date'];
    $days = (int)$_POST['days'];
    $customer_id = get_user_id();

    // Validate date
    $start = new DateTime($start_date);
    $today = new DateTime();
    if ($start < $today) {
        set_flash_message('Start date cannot be in the past.', 'danger');
        header('Location: view_cars.php');
        exit;
    }

    // Get car rent
    $stmt = $pdo->prepare("SELECT rent_per_day FROM cars WHERE id = ?");
    $stmt->execute([$car_id]);
    $car = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$car) {
        set_flash_message('Car not found.', 'danger');
        header('Location: view_cars.php');
        exit;
    }

    $total_amount = $car['rent_per_day'] * $days;

    try {
        $stmt = $pdo->prepare("INSERT INTO bookings (car_id, customer_id, start_date, days, total_amount) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$car_id, $customer_id, $start_date, $days, $total_amount]);
        set_flash_message('Booking successful! Total: $' . number_format($total_amount, 2), 'success');
        header('Location: view_cars.php');
        exit;
    } catch (PDOException $e) {
        set_flash_message('Booking failed.', 'danger');
        header('Location: view_cars.php');
        exit;
    }
} else {
    header('Location: view_cars.php');
    exit;
}
?>