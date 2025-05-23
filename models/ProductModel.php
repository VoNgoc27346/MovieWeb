<?php
class ProductModel {
    private $conn;

    public function __construct() {
        $host = 'localhost';
        $dbname = 'movie_online';
        $username = 'root';
        $password = '';

        try {
            $this->conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Kết nối thất bại: " . $e->getMessage());
        }
    }

    public function getAllProducts() {
        $stmt = $this->conn->query("SELECT p.*, c.name AS category, b.name AS brand FROM products p 
                                    LEFT JOIN categories c ON p.category_id = c.id 
                                    LEFT JOIN brands b ON p.brand_id = b.id 
                                    ORDER BY p.created_at DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getProductBySlug($slug) {
        $stmt = $this->conn->prepare("SELECT p.*, c.name AS category, b.name AS brand FROM products p 
                                      LEFT JOIN categories c ON p.category_id = c.id 
                                      LEFT JOIN brands b ON p.brand_id = b.id 
                                      WHERE p.slug = :slug LIMIT 1");
        $stmt->execute(['slug' => $slug]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getCategories() {
        $stmt = $this->conn->query("SELECT * FROM categories");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getBrands() {
        $stmt = $this->conn->query("SELECT * FROM brands");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function filterProducts($filters) {
        $query = "SELECT p.*, c.name AS category, b.name AS brand FROM products p 
                  LEFT JOIN categories c ON p.category_id = c.id 
                  LEFT JOIN brands b ON p.brand_id = b.id WHERE 1=1";
        $params = [];

        // Lọc theo danh mục
        if (!empty($filters['category'])) {
            $query .= " AND p.category_id = :category";
            $params['category'] = $this->getCategoryId($filters['category']);
        }

        // Lọc theo thương hiệu
        if (!empty($filters['brand'])) {
            $query .= " AND p.brand_id = :brand";
            $params['brand'] = $this->getBrandId($filters['brand']);
        }

        // Lọc theo giá
        if (!empty($filters['price_min']) || !empty($filters['price_max'])) {
            $priceMin = $filters['price_min'] ?? 0;
            $priceMax = $filters['price_max'] ?? PHP_INT_MAX;
            $query .= " AND p.price BETWEEN :price_min AND :price_max";
            $params['price_min'] = $priceMin;
            $params['price_max'] = $priceMax;
        }

        // Tìm kiếm theo tên
        if (!empty($filters['search'])) {
            $query .= " AND p.name LIKE :search";
            $params['search'] = "%" . $filters['search'] . "%";
        }

        $query .= " ORDER BY p.created_at DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute($params);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    private function getCategoryId($categoryName) {
        $stmt = $this->conn->prepare("SELECT id FROM categories WHERE name = :name LIMIT 1");
        $stmt->execute(['name' => $categoryName]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ? $result['id'] : null;
    }

    private function getBrandId($brandName) {
        $stmt = $this->conn->prepare("SELECT id FROM brands WHERE name = :name LIMIT 1");
        $stmt->execute(['name' => $brandName]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ? $result['id'] : null;
    }
}
?>