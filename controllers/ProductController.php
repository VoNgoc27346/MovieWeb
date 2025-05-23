<?php
require_once 'models/ProductModel.php';

class ProductController {
    private $productModel;

    public function __construct() {
        $this->productModel = new ProductModel();
    }

    public function list() {
        // Lấy dữ liệu lọc từ query string
        $filters = [
            'category' => $_GET['category'] ?? '',
            'brand' => $_GET['brand'] ?? '',
            'price_min' => $_GET['price_min'] ?? '',
            'price_max' => $_GET['price_max'] ?? '',
            'search' => $_GET['search'] ?? ''
        ];

        // Lấy danh sách sản phẩm đã lọc
        $products = $this->productModel->filterProducts($filters);

        // Lấy danh sách danh mục và thương hiệu
        $categories = $this->productModel->getCategories();
        $brands = $this->productModel->getBrands();

        // Gọi view để hiển thị
        include 'views/products/list.php';
    }

    public function detail($slug) {
        // Lấy thông tin sản phẩm theo slug
        $product = $this->productModel->getProductBySlug($slug);

        if (!$product) {
            // Xử lý lỗi nếu không tìm thấy sản phẩm
            echo "Sản phẩm không tồn tại!";
            return;
        }

        // Gọi view để hiển thị chi tiết
        include 'views/products/detail.php';
    }
}
?>