<?php
require_once '../bootstrap.php';
require_once UTILS_PATH . '/auth.util.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

Auth::logout();

header('Location: ../index.php');
exit;
