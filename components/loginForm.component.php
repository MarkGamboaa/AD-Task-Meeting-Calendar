<?php
function renderLoginForm($error = null)
{
    ob_start();
    ?>

    <?php if ($error): ?>
        <div class="error">❌ <?php echo htmlspecialchars($error); ?></div>
    <?php endif; ?>

    <form action="handlers/auth.handler.php" method="POST">
        <div class="form-group">
            <label for="username">Username:</label>
            <input id="username" name="username" type="text" required>
        </div>
        <div class="form-group">
            <label for="password">Password:</label>
            <input id="password" name="password" type="password" required>
        </div>
        <div class="form-group">
            <button type="submit">Login</button>
        </div>
    </form>

    <div class="test-users">
        <h3>Test Users:</h3>
        <ul>
            <li>Username: john.smith, Password: p@ssW0rd1234 (designer)</li>
            <li>Username: jane.doe, Password: SecurePass123 (admin)</li>
            <li>Username: mike.wilson, Password: MyPassword456 (developer)</li>
            <li>Username: sarah.connor, Password: StrongPass789 (manager)</li>
        </ul>
    </div>

    <?php
    return ob_get_clean();
}
?>