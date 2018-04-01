<?php
require("configuration.php");
class Database {
    private static $dsn = 'mysql:host='.DB_HOST.';dbname='.DB_DATABASE;
    private static $userName = DB_USER;
    private static $password = DB_PASSWORD;
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