<?php

class Database {
    private static $conn = null;

    public static function getConnection() {
        if (self::$conn === null) {
            self::$conn = new mysqli('localhost', 'root', '', 'movie_online');
            if (self::$conn->connect_error) {
                die("Connection failed: " . self::$conn->connect_error);
            }
            self::$conn->set_charset("utf8mb4");
        }
        return self::$conn;
    }
}
?>