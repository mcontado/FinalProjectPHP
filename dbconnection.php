<?php

class Database {
    private static $dsn = 'mysql:host=localhost;dbname=moviedb';
    private static $userName = 'root';
    private static $password = 'root';
    private static $db;

    private function __construct() {}

    public static function getDB() {
        if (!isset(self::$db)) {
            try {
                self::$db = new PDO(self::$dsn,
                                    self::$userName,
                                    self::$password);
            } catch (PDOException $e) {
                $error_message = $e->getMessage();
                include('database_error.php');
            }
        }

        return self::$db;
    }
}
?>