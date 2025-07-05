<?php
require_once UTILS_PATH . '/envSetter.util.php';

try {
    $connectionString = "mongodb://{$databases['mongoHost']}:{$databases['mongoPort']}";
    $mongo = new MongoDB\Driver\Manager($connectionString);

    $command = new MongoDB\Driver\Command(["ping" => 1]);
    $mongo->executeCommand("admin", $command);

    echo "✅ Connected to MongoDB successfully.<br>";
} catch (MongoDB\Driver\Exception\Exception $e) {
    echo "❌ MongoDB connection failed: " . $e->getMessage() . "<br>";
} catch (Exception $e) {
    echo "❌ MongoDB error: " . $e->getMessage() . "<br>";
}
