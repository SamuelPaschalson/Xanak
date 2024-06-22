<?php

namespace Xanak\Database;

use PDO;
use Xanak\Config\Config;

class DB
{
    protected static $connection;

    public static function connect()
    {
        if (!self::$connection) {
            $config = Config::get('mysql');
            $host = $config['host'];
            $port = $config['port'];
            $database = $config['database'];
            $username = $config['username'];
            $password = $config['password'];

            $dsn = "mysql:host=$host;port=$port;dbname=$database";
            self::$connection = new PDO($dsn, $username, $password);
            self::$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }

        return self::$connection;
    }

    public static function select($query, $bindings = [])
    {
        $stmt = self::connect()->prepare($query);
        $stmt->execute($bindings);
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public static function insert($query, $bindings = [])
    {
        $stmt = self::connect()->prepare($query);
        return $stmt->execute($bindings);
    }

    public static function update($query, $bindings = [])
    {
        $stmt = self::connect()->prepare($query);
        return $stmt->execute($bindings);
    }

    public static function delete($query, $bindings = [])
    {
        $stmt = self::connect()->prepare($query);
        return $stmt->execute($bindings);
    }

    public static function statement($query, $bindings = [])
    {
        $stmt = self::connect()->prepare($query);
        return $stmt->execute($bindings);
    }

    public static function transaction(callable $callback)
    {
        try {
            self::connect()->beginTransaction();
            $callback();
            self::connect()->commit();
        } catch (\Exception $e) {
            self::connect()->rollBack();
            throw $e;
        }
    }
}
