<?php
require_once UTILS_PATH . '/envSetter.util.php';

$host = $databases['pgHost'];
$port = $databases['pgPort'];
$username = $databases['pgUser'];
$password = $databases['pgPassword'];
$dbname = $databases['pgDB'];

$conn_string = "host=$host port=$port dbname=$dbname user=$username password=$password";

try {
    $dbconn = pg_connect($conn_string);

    if (!$dbconn) {
        echo "❌ Connection Failed: " . pg_last_error() . "<br>";
    } else {
        echo "✅ PostgreSQL Connection<br>";
        pg_close($dbconn);
    }
} catch (Exception $e) {
    echo "❌ PostgreSQL error: " . $e->getMessage() . "<br>";
}