<?php

// Require necessary files
require_once 'app/config/database.php';
require_once 'app/models/ProductModel.php';
require_once 'app/models/CategoryModel.php';

class ProductController {
    private PDO $db;
    private ProductModel $productModel;

    public function __construct() {
        $this->db = (new Database())->getConnection();
        $this->productModel = new ProductModel($this->db);
    }

    public function index(): void {
        $products = $this->productModel->getProducts();
        include 'app/views/product/list.php';
    }

    public function show(int $id): void {
        $product = $this->productModel->getProductById($id);

        if ($product) {
            include 'app/views/product/show.php';
        } else {
            echo "Không thấy sản phẩm.";
        }
    }

    public function add(): void {
        $categories = (new CategoryModel($this->db))->getCategories();
        include 'app/views/product/add.php';
    }

    public function save(): void {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'] ?? '';
            $description = $_POST['description'] ?? '';
            $price = $_POST['price'] ?? '';
            $category_id = $_POST['category_id'] ?? null;

            if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) 
            { 
                $image = $this->uploadImage($_FILES['image']); 
            } 
            else 
            {
                $image = ""; 
            }

            $result = $this->productModel->addProduct($name, $description, $price, $category_id, $image);

            if (is_array($result)) {
                $errors = $result;
                $categories = (new CategoryModel($this->db))->getCategories();
                include 'app/views/product/add.php';
            } else {
                header('Location: /webbanhang/Product');
                exit();
            }
        }
    }

    public function edit(int $id): void {
        $product = $this->productModel->getProductById($id);
        $categories = (new CategoryModel($this->db))->getCategories();

        if ($product) {
            include 'app/views/product/edit.php';
        } else {
            echo "Không thấy sản phẩm.";
        }
    }

    public function update(): void {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = (int)$_POST['id'];
            $name = $_POST['name'];
            $description = $_POST['description'];
            $price = $_POST['price'];
            $category_id = $_POST['category_id'];

            if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) 
            { 
                $image = $this->uploadImage($_FILES['image']); 
            } 
            else 
            { 
                $image = $_POST['existing_image']; 
            }

            if ($this->productModel->updateProduct($id, $name, $description, $price, $category_id, $image)) {
                header('Location: /webbanhang/Product');
                exit();
            } else {
                echo "Đã xảy ra lỗi khi lưu sản phẩm.";
            }
        }
    }

    public function delete(int $id): void {
        if ($this->productModel->deleteProduct($id)) {
            header('Location: /webbanhang/Product');
            exit();
        } else {
            echo "Đã xảy ra lỗi khi xóa sản phẩm.";
        }
    }

    private function uploadImage($file) {
        // Đường dẫn tuyệt đối đến thư mục uploads
        $target_dir = __DIR__ . "/../../public/uploads/";
        
        // Tạo thư mục nếu chưa tồn tại
        if (!file_exists($target_dir)) {
            mkdir($target_dir, 0777, true);
        }
        
        // Tạo tên file duy nhất
        $fileExtension = strtolower(pathinfo($file["name"], PATHINFO_EXTENSION));
        $newFilename = uniqid() . '.' . $fileExtension;
        $target_file = $target_dir . $newFilename;
        
        // Kiểm tra có phải là ảnh
        $check = getimagesize($file["tmp_name"]);
        if ($check === false) {
            throw new Exception("File không phải là ảnh.");
        }
        
        // Kiểm tra kích thước file (tối đa 10MB)
        if ($file["size"] > 10 * 1024 * 1024) {
            throw new Exception("Ảnh quá lớn, tối đa 10MB.");
        }
        
        // Chỉ cho phép định dạng ảnh nhất định
        $allowedTypes = ["jpg", "jpeg", "png", "gif"];
        if (!in_array($fileExtension, $allowedTypes)) {
            throw new Exception("Chỉ chấp nhận file JPG, JPEG, PNG & GIF.");
        }
        
        // Di chuyển file vào thư mục đích
        if (move_uploaded_file($file["tmp_name"], $target_file)) {
            // Trả về đường dẫn tương đối để lưu database
            return "uploads/" . $newFilename;
        } else {
            throw new Exception("Có lỗi khi upload ảnh.");
        }
    }

    public function addToCart($id) {
        $product = $this->productModel->getProductById($id);

        if (!$product) {
            echo "Không tìm thấy sản phẩm.";
            return;
        }

        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }

        if (isset($_SESSION['cart'][$id])) {
            $_SESSION['cart'][$id]['quantity']++;
        } else {
            $_SESSION['cart'][$id] = [
                'name' => $product->name,
                'price' => $product->price,
                'quantity' => 1,
                'image' => $product->image
            ];
        }

        header('Location: /webbanhang/Product/cart');
    }
}