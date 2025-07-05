<?php
require_once 'bootstrap.php';

// Start session before any output
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Include and run MongoDB checker
include HANDLERS_PATH . '/mongodbChecker.handler.php';

// Include and run PostgreSQL checker
include HANDLERS_PATH . '/postgreChecker.handler.php';

// Check if auth utility exists before including
if (file_exists(UTILS_PATH . '/auth.util.php')) {
    require_once UTILS_PATH . '/auth.util.php';

    // Check if user is already logged in
    if (Auth::check()) {
        $user = Auth::user();
        echo "Already logged in as: " . $user['first_name'] . " " . $user['last_name'] . " (" . $user['role'] . ")<br>";
        echo '<a href="handlers/logout.handler.php">Logout</a>';
    } else {
        ?>

        <form action="handlers/auth.handler.php" method="POST">
            <?php if (isset($_GET['error']) && $_GET['error'] === 'invalid'): ?>
                <p style="color: red;">❌ Invalid username or password</p>
            <?php endif; ?>
            <div>
                <label for="username">Username:</label>
                <input id="username" name="username" type="text" required>
            </div>
            <div>
                <label for="password">Password:</label>
                <input id="password" name="password" type="password" required>
            </div>
            <div>
                <button type="submit">Login</button>
            </div>
        </form>

        <h3>Test Users:</h3>
        <ul>
            <li>Username: john.smith, Password: p@ssW0rd1234 (designer)</li>
            <li>Username: jane.doe, Password: SecurePass123 (admin)</li>
            <li>Username: mike.wilson, Password: MyPassword456 (developer)</li>
            <li>Username: sarah.connor, Password: StrongPass789 (manager)</li>
        </ul>

        <?php
    }
} else {
    echo "Auth system not available. File missing: " . UTILS_PATH . '/auth.util.php';
}
?>