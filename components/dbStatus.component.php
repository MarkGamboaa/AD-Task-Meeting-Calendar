<?php
function renderDatabaseStatus()
{
    ob_start();
    ?>

    <div class="db-status">
        <h2>Database Connection Status</h2>

        <?php
        ob_start();
        include HANDLERS_PATH . '/postgreChecker.handler.php';
        $pgStatus = ob_get_clean();

        ob_start();
        include HANDLERS_PATH . '/mongodbChecker.handler.php';
        $mongoStatus = ob_get_clean();
        ?>

        <div class="status-item">
            <span class="status-success"><?php echo $pgStatus; ?></span>
        </div>
        <div class="status-item">
            <span class="status-success"><?php echo $mongoStatus; ?></span>
        </div>
    </div>

    <?php
    return ob_get_clean();
}
?>