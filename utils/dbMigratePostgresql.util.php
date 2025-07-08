<?php
declare(strict_types=1);

require_once 'vendor/autoload.php';

require_once 'bootstrap.php';

require_once UTILS_PATH . '/envSetter.util.php';

$host = $_ENV['PG_HOST'] ?? 'localhost';
$port = $_ENV['PG_PORT'] ?? '5432';
$username = $_ENV['PG_USER'] ?? 'user';
$password = $_ENV['PG_PASSWORD'] ?? 'password';
$dbname = $_ENV['PG_DB'] ?? 'taskmeeting';

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
