<?php

class Auth
{
    public static function init()
    {
        // Session is already started in index.php, no need to start it here
    }

    public static function login($username, $password)
    {
        self::init();

        require_once UTILS_PATH . '/envSetter.util.php';

        $host = $databases['pgHost'];
        $port = $databases['pgPort'];
        $dbUsername = $databases['pgUser'];
        $dbPassword = $databases['pgPassword'];
        $dbname = $databases['pgDB'];

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
