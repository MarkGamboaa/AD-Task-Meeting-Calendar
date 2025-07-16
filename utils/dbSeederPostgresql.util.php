<?php
declare(strict_types=1);

require_once 'vendor/autoload.php';

require_once 'bootstrap.php';

require_once UTILS_PATH . '/envSetter.util.php';

$users = require_once DUMMIES_PATH . '/users.staticData.php';

$host = $_ENV['PG_HOST'] ?? 'localhost';
$port = $_ENV['PG_PORT'] ?? '5432';
$username = $_ENV['PG_USER'] ?? 'user';
$password = $_ENV['PG_PASSWORD'] ?? 'password';
$dbname = $_ENV['PG_DB'] ?? 'taskmeeting';

$dsn = "pgsql:host={$host};port={$port};dbname={$dbname}";
$pdo = new PDO($dsn, $username, $password, [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
]);

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

echo "Truncating tables…\n";
foreach (['meeting_users', 'tasks', 'meetings', 'users'] as $table) {
    $pdo->exec("TRUNCATE TABLE {$table} RESTART IDENTITY CASCADE;");
}

echo "Seeding users…\n";

$stmt = $pdo->prepare("
    INSERT INTO users (username, role, first_name, last_name, password)
    VALUES (:username, :role, :fn, :ln, :pw)
");

foreach ($users as $u) {
    $stmt->execute([
        ':username' => $u['username'],
        ':role' => $u['role'],
        ':fn' => $u['first_name'],
        ':ln' => $u['last_name'],
        ':pw' => password_hash($u['password'], PASSWORD_DEFAULT),
    ]);
}

$meetings = require_once DUMMIES_PATH . '/meetings.staticData.php';
echo "Seeding meetings…\n";
$stmt = $pdo->prepare("
    INSERT INTO meetings (title, description, scheduled_at)
    VALUES (:title, :description, :scheduled_at)
");
foreach ($meetings as $m) {
    $stmt->execute([
        ':title' => $m['title'],
        ':description' => $m['description'],
        ':scheduled_at' => $m['scheduled_at'],
    ]);
}

$tasks = require_once DUMMIES_PATH . '/tasks.staticData.php';
echo "Seeding tasks…\n";
$stmt = $pdo->prepare("
    INSERT INTO tasks (title, description, status)
    VALUES (:title, :description, :status)
");
foreach ($tasks as $t) {
    $stmt->execute([
        ':title' => $t['title'],
        ':description' => $t['description'],
        ':status' => $t['status'],
    ]);
}

$meetingUsers = require_once DUMMIES_PATH . '/meeting_users.staticData.php';
echo "Seeding meeting_users…\n";
$stmt = $pdo->prepare("
    INSERT INTO meeting_users (meeting_id, user_id)
    VALUES (:meeting_id, :user_id)
");
foreach ($meetingUsers as $mu) {
    $stmt->execute([
        ':meeting_id' => $mu['meeting_id'],
        ':user_id' => $mu['user_id'],
    ]);
}

echo "✅ PostgreSQL seeding complete!\n";
