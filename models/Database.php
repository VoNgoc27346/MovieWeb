<?php

class Database {
    private static $instance = null;
    private $pdo;

    private function __construct() {
        $host = 'localhost';
        $dbname = 'movie_online2';
        $username = 'root';
        $password = '';
        
        try {
            $this->pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Kết nối CSDL thất bại: " . $e->getMessage());
        }
    }

    // Phương thức để lấy instance duy nhất
    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new Database();
        }
        return self::$instance;
    }

    public function querySingle($sql, $params = []) {
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function execute($sql, $params = []) {
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute($params);
    }

    public function getConnection() {
        return $this->pdo; // hoặc $this->conn nếu bạn đặt tên vậy
    }

    public function query($sql, $params = []) {
        $stmt = $this->pdo->prepare($sql); // giả sử bạn có $pdo là một PDO object
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC); // hoặc chỉ trả về $stmt nếu bạn muốn xử lý sau
    }


}

?>