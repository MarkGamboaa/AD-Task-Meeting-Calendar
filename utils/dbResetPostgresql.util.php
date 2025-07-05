<?php
declare(strict_types=1);

// 1) Composer autoload
require_once 'vendor/autoload.php';

// 2) Composer bootstrap
require_once 'bootstrap.php';

// 3) envSetter
require_once UTILS_PATH . '/envSetter.util.php';

$host = $databases['pgHost'];
$port = $databases['pgPort'];
$username = $databases['pgUser'];
$password = $databases['pgPassword'];
$dbname = $databases['pgDB'];

// ——— Connect to PostgreSQL ———
$dsn = "pgsql:host={$host};port={$port};dbname={$dbname}";
$pdo = new PDO($dsn, $username, $password, [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
]);

// Apply users schema
echo "Applying schema from database/users.model.sql…\n";
$sql = file_get_contents('database/users.model.sql');
if ($sql === false) {
    throw new RuntimeException("Could not read database/users.model.sql");
} else {
    echo "Creation Success from the database/users.model.sql\n";
}
$pdo->exec($sql);

// Apply meetings schema
echo "Applying schema from database/meetings.model.sql…\n";
$sql = file_get_contents('database/meetings.model.sql');
if ($sql === false) {
    throw new RuntimeException("Could not read database/meetings.model.sql");
} else {
    echo "Creation Success from the database/meetings.model.sql\n";
}
$pdo->exec($sql);

// Apply tasks schema
echo "Applying schema from database/tasks.model.sql…\n";
$sql = file_get_contents('database/tasks.model.sql');
if ($sql === false) {
    throw new RuntimeException("Could not read database/tasks.model.sql");
} else {
    echo "Creation Success from the database/tasks.model.sql\n";
}
$pdo->exec($sql);

// Apply meeting_users schema
echo "Applying schema from database/meeting_users.model.sql…\n";
$sql = file_get_contents('database/meeting_users.model.sql');
if ($sql === false) {
    throw new RuntimeException("Could not read database/meeting_users.model.sql");
} else {
    echo "Creation Success from the database/meeting_users.model.sql\n";
}
$pdo->exec($sql);

// Clean tables
echo "Truncating tables…\n";
foreach (['meeting_users', 'tasks', 'meetings', 'users'] as $table) {
    $pdo->exec("TRUNCATE TABLE {$table} RESTART IDENTITY CASCADE;");
}

echo "✅ PostgreSQL reset complete!\n";
