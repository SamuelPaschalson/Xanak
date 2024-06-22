<?php

namespace Xanak\Database;

use PDO;

class Connection
{
    private static $instance = null;
    private $pdo;

    private function __construct()
    {
        $dsn = $_ENV['DB_DSN'];
        $username = $_ENV['DB_USERNAME'];
        $password = $_ENV['DB_PASSWORD'];

        $this->pdo = new PDO($dsn, $username, $password, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
    }

    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    public function getPdo()
    {
        return $this->pdo;
    }
}
