<?php
require_once UTILS_PATH . '/envSetter.util.php';

$host = $_ENV['PG_HOST'] ?? 'localhost';
$port = $_ENV['PG_PORT'] ?? '5432';
$username = $_ENV['PG_USER'] ?? 'user';
$password = $_ENV['PG_PASSWORD'] ?? 'password';
$dbname = $_ENV['PG_DB'] ?? 'taskmeeting';

$conn_string = "host=$host port=$port dbname=$dbname user=$username password=$password";

try {
    $dbconn = pg_connect($conn_string);

    if (!$dbconn) {
        echo "❌ Connection Failed: " . pg_last_error();
    } else {
        echo "✅ PostgreSQL Connection";
        pg_close($dbconn);
    }
} catch (Exception $e) {
    echo "❌ PostgreSQL Error: " . $e->getMessage();
}