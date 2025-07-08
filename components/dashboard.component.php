<?php
function renderDashboard($user, $isHandler = false)
{
    ob_start();
    ?>

    <div class="user-info">
        <h2>Welcome, <?php echo htmlspecialchars($user['first_name'] . ' ' . $user['last_name']); ?>!</h2>
        <p><strong>Role:</strong> <?php echo htmlspecialchars($user['role']); ?></p>
    </div>

    <div class="navigation">
        <?php
        $logoutUrl = $isHandler ? 'logout.handler.php' : 'handlers/logout.handler.php';
        ?>
        <button onclick="window.location.href='<?php echo $logoutUrl; ?>'">Logout</button>
    </div>

    <?php
    return ob_get_clean();
}
?>