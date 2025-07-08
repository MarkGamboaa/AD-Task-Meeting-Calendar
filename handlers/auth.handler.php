<?php
require_once '../bootstrap.php';
require_once UTILS_PATH . '/auth.util.php';
require_once COMPONENTS_PATH . '/error.component.php';
require_once COMPONENTS_PATH . '/dashboard.component.php';
require_once COMPONENTS_PATH . '/dbStatus.component.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    if (empty($username) || empty($password)) {
        $content = renderError('Username and password are required');
        $title = 'Login Error';
        $isHandler = true;
        include LAYOUTS_PATH . '/main.layout.php';
        exit;
    }

    $loginResult = Auth::login($username, $password);

    if ($loginResult) {
        $user = Auth::user();

        ob_start();

        echo renderDatabaseStatus();
        echo renderDashboard($user, true);

        $content = ob_get_clean();
        $title = 'Dashboard';
        $isHandler = true;
        include LAYOUTS_PATH . '/main.layout.php';
    } else {
        header('Location: ../index.php?error=invalid');
        exit;
    }
} else {
    $content = renderError('Invalid request method') . '<br><a href="../index.php">Go back to main page</a>';
    $title = 'Error';
    $isHandler = true;
    include LAYOUTS_PATH . '/main.layout.php';
}
