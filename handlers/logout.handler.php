<?php
require_once '../bootstrap.php';
require_once UTILS_PATH . '/auth.util.php';

// Start session before logout
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

Auth::logout();

// Redirect to main page
header('Location: ../index.php');
exit;
