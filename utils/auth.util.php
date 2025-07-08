<?php

class Auth
{
    public static function init()
    {
    }

    public static function login($username, $password)
    {
        self::init();

        require_once UTILS_PATH . '/envSetter.util.php';

        $host = $_ENV['PG_HOST'] ?? 'localhost';
        $port = $_ENV['PG_PORT'] ?? '5432';
        $dbUsername = $_ENV['PG_USER'] ?? 'user';
        $dbPassword = $_ENV['PG_PASSWORD'] ?? 'password';
        $dbname = $_ENV['PG_DB'] ?? 'taskmeeting';

        try {
            $dsn = "pgsql:host={$host};port={$port};dbname={$dbname}";
            $pdo = new PDO($dsn, $dbUsername, $dbPassword, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            ]);

            $stmt = $pdo->prepare("SELECT id, username, first_name, last_name, password, role FROM users WHERE username = :username");
            $stmt->execute([':username' => $username]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user && password_verify($password, $user['password'])) {
                unset($user['password']);
                $_SESSION['user'] = $user;
                return true;
            }

            return false;
        } catch (Exception $e) {
            return false;
        }
    }

    public static function user()
    {
        self::init();
        return $_SESSION['user'] ?? null;
    }

    public static function check()
    {
        self::init();
        return isset($_SESSION['user']);
    }

    public static function logout()
    {
        self::init();
        session_destroy();
        if (isset($_COOKIE[session_name()])) {
            setcookie(session_name(), '', time() - 3600, '/');
        }
    }
}
