<?php
require_once 'bootstrap.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once COMPONENTS_PATH . '/error.component.php';
require_once COMPONENTS_PATH . '/loginForm.component.php';
require_once COMPONENTS_PATH . '/dashboard.component.php';
require_once COMPONENTS_PATH . '/dbStatus.component.php';

ob_start();

echo renderDatabaseStatus();

if (file_exists(UTILS_PATH . '/auth.util.php')) {
    require_once UTILS_PATH . '/auth.util.php';

    if (Auth::check()) {
        $user = Auth::user();
        echo renderDashboard($user, false);
    } else {
        $error = isset($_GET['error']) && $_GET['error'] === 'invalid' ? 'Invalid username or password' : null;
        echo renderLoginForm($error);
    }
} else {
    echo renderError('Auth system not available. File missing: ' . UTILS_PATH . '/auth.util.php');
}

$content = ob_get_clean();


$title = 'AD Task Meeting Calendar';

include LAYOUTS_PATH . '/main.layout.php';
?>