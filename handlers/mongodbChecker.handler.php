<?php
require_once UTILS_PATH . '/envSetter.util.php';

try {
    $host = $_ENV['MONGO_HOST'] ?? 'localhost';
    $port = $_ENV['MONGO_PORT'] ?? '27017';
    $connectionString = "mongodb://{$host}:{$port}";

    $connection = @stream_socket_client("tcp://{$host}:{$port}", $errno, $errstr, 1);

    if ($connection) {
        echo "✅ Connected to MongoDB successfully";
        fclose($connection);
    } else {
        echo "❌ MongoDB connection failed: {$errstr}";
    }
} catch (Exception $e) {
    echo "❌ MongoDB error: " . $e->getMessage();
}
