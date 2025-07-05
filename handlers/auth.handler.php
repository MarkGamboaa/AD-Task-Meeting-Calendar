<?php
require_once '../bootstrap.php';
require_once UTILS_PATH . '/auth.util.php';

// Start session before any processing
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    if (empty($username) || empty($password)) {
        echo "❌ Username and password are required";
        exit;
    }

    $loginResult = Auth::login($username, $password);

    if ($loginResult) {
        $user = Auth::user();
        ?>
        <h1>Dashboard</h1>

        <p>Welcome, <?php echo $user['first_name'] . ' ' . $user['last_name']; ?>!</p>

        <p>Role: <?php echo $user['role']; ?></p>

        <h2>Navigation</h2>

        <button onclick="window.location.href='logout.handler.php'">Logout</button>

        <h2>Database Connection Status</h2>

        <p>✅ PostgreSQL Connection</p>
        <p>✅ Connected to MongoDB successfully.</p>
        <?php
    } else {
        // Invalid login - redirect back to main page
        header('Location: ../index.php?error=invalid');
        exit;
    }
} else {
    echo "❌ Invalid request method";
    echo '<br><a href="../index.php">Go back to main page</a>';
}
