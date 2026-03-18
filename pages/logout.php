<?php
include '../includes/functions.php';

session_destroy();
set_flash_message('Logged out successfully.', 'success');
header('Location: login.php');
exit;
?>