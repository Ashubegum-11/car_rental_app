<?php
session_start();

// Function to check if user is logged in
function is_logged_in() {
    return isset($_SESSION['user_id']);
}

// Function to get current user role
function get_user_role() {
    return $_SESSION['role'] ?? null;
}

// Function to get current user id
function get_user_id() {
    return $_SESSION['user_id'] ?? null;
}

// Function to redirect if not logged in
function require_login() {
    if (!is_logged_in()) {
        header('Location: login.php');
        exit;
    }
}

// Function to redirect if not agency
function require_agency() {
    if (get_user_role() !== 'agency') {
        header('Location: dashboard.php');
        exit;
    }
}

// Function to redirect if not customer
function require_customer() {
    if (get_user_role() !== 'customer') {
        header('Location: dashboard.php');
        exit;
    }
}

// Function to set flash message
function set_flash_message($message, $type = 'success') {
    $_SESSION['flash_message'] = $message;
    $_SESSION['flash_type'] = $type;
}

// Function to get and clear flash message
function get_flash_message() {
    if (isset($_SESSION['flash_message'])) {
        $message = $_SESSION['flash_message'];
        $type = $_SESSION['flash_type'] ?? 'success';
        unset($_SESSION['flash_message'], $_SESSION['flash_type']);
        return ['message' => $message, 'type' => $type];
    }
    return null;
}

// Function to sanitize input
function sanitize($data) {
    return htmlspecialchars(strip_tags(trim($data)));
}
?>