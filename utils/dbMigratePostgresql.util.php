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

echo "Dropping old tables…\n";
foreach ([
    'meeting_users',
    'tasks',
    'meetings',
    'users',
] as $table) {
    // Use IF EXISTS so it won't error if the table is already gone
    $pdo->exec("DROP TABLE IF EXISTS {$table} CASCADE;");
}

echo "Applying schema from database/users.model.sql…\n";
$sql = file_get_contents('database/users.model.sql');
if ($sql === false) {
    throw new RuntimeException("Could not read database/users.model.sql");
} else {
    echo "Creation Success from the database/users.model.sql\n";
}
$pdo->exec($sql);

echo "Applying schema from database/meetings.model.sql…\n";
$sql = file_get_contents('database/meetings.model.sql');
if ($sql === false) {
    throw new RuntimeException("Could not read database/meetings.model.sql");
} else {
    echo "Creation Success from the database/meetings.model.sql\n";
}
$pdo->exec($sql);

echo "Applying schema from database/tasks.model.sql…\n";
$sql = file_get_contents('database/tasks.model.sql');
if ($sql === false) {
    throw new RuntimeException("Could not read database/tasks.model.sql");
} else {
    echo "Creation Success from the database/tasks.model.sql\n";
}
$pdo->exec($sql);

echo "Applying schema from database/meeting_users.model.sql…\n";
$sql = file_get_contents('database/meeting_users.model.sql');
if ($sql === false) {
    throw new RuntimeException("Could not read database/meeting_users.model.sql");
} else {
    echo "Creation Success from the database/meeting_users.model.sql\n";
}
$pdo->exec($sql);

echo "✅ PostgreSQL migration complete!\n";
