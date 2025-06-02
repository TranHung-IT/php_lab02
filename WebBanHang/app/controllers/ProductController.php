<?php

// Require necessary files
require_once 'app/config/database.php';
require_once 'app/models/ProductModel.php';
require_once 'app/models/CategoryModel.php';
require_once 'app/helpers/SessionHelper.php';

class ProductController {
    // private PDO $db;
    // private ProductModel $productModel;
    private $productModel; 
    private $db;

    public function __construct() {
        $this->db = (new Database())->getConnection();
        $this->productModel = new ProductModel($this->db);
    }

    // Kiểm tra quyền Admin 
    private function isAdmin() { 
        return SessionHelper::isAdmin(); 
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
        if (!$this->isAdmin()) { 
            echo "Bạn không có quyền truy cập chức năng này!"; 
            exit; 
        }
        $categories = (new CategoryModel($this->db))->getCategories();
        include 'app/views/product/add.php';
    }

    public function save(): void { 
        if (!$this->isAdmin()) { 
            echo "Bạn không có quyền truy cập chức năng này!"; 
            exit; 
        }
        if ($_SERVER['REQUEST_METHOD'] == 'POST') { 
            $name = $_POST['name'] ?? ''; 
            $description = $_POST['description'] ?? ''; 
            $price = $_POST['price'] ?? ''; 
            $category_id = $_POST['category_id'] ?? null; 

            if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) { 
                $image = $this->uploadImage($_FILES['image']); 
            } else { 
                $image = ""; 
            } 
            
            $result = $this->productModel->addProduct($name, $description, $price, $category_id, $image); 
            if (is_array($result)) { 
                $errors = $result; 
                $categories = (new CategoryModel($this->db))->getCategories(); 
                include 'app/views/product/add.php'; 
            } else {
                header('Location: /webbanhang/Product'); 
            } 
        } 
    }

    public function edit(int $id): void {
        if (!$this->isAdmin()) { 
            echo "Bạn không có quyền truy cập chức năng này!"; 
            exit; 
        }
        $product = $this->productModel->getProductById($id);
        $categories = (new CategoryModel($this->db))->getCategories();

        if ($product) {
            include 'app/views/product/edit.php';
        } else {
            echo "Không thấy sản phẩm.";
        }
    }

    public function update(): void {
        if (!$this->isAdmin()) { 
            echo "Bạn không có quyền truy cập chức năng này!"; 
            exit; 
        }
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'];
            $name = $_POST['name'];
            $description = $_POST['description'];
            $price = $_POST['price'];
            $category_id = $_POST['category_id'];

            if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) 
            { 
                $image = $this->uploadImage($_FILES['image']); 
            } else { 
                $image = $_POST['existing_image']; 
            }

            $edit = $this->productModel->updateProduct($id, $name, $description, $price, $category_id, $image);

            if ($edit) { 
                header('Location: /webbanhang/Product'); 
            } else { 
                echo "Đã xảy ra lỗi khi lưu sản phẩm."; 
            }
        }
    }

    public function delete(int $id): void {
        if (!$this->isAdmin()) { 
            echo "Bạn không có quyền truy cập chức năng này!"; 
            exit; 
        }
        if ($this->productModel->deleteProduct($id)) {
            header('Location: /webbanhang/Product');
            exit();
        } else {
            echo "Đã xảy ra lỗi khi xóa sản phẩm.";
        }
    }

    private function uploadImage($file) {
        if (!$this->isAdmin()) { 
            echo "Bạn không có quyền truy cập chức năng này!"; 
            exit; 
        }
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

    public function addToCart(int $id): void {
        // Khởi tạo session nếu chưa có
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Kiểm tra ID hợp lệ
        if ($id <= 0) {
            $this->setFlashMessage('error', 'ID sản phẩm không hợp lệ.');
            header('Location: /webbanhang/Product');
            exit();
        }

        // Lấy thông tin sản phẩm
        $product = $this->productModel->getProductById($id);
        if (!$product) {
            $this->setFlashMessage('error', 'Không tìm thấy sản phẩm.');
            header('Location: /webbanhang/Product');
            exit();
        }

        // Kiểm tra số lượng tồn kho (nếu có)
        if (isset($product->stock) && $product->stock <= 0) {
            $this->setFlashMessage('error', 'Sản phẩm hiện đã hết hàng.');
            header('Location: /webbanhang/Product');
            exit();
        }

        // Khởi tạo giỏ hàng nếu chưa tồn tại
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }

        // Lấy số lượng từ POST (nếu có) hoặc mặc định là 1
        $quantity = isset($_POST['quantity']) ? (int)$_POST['quantity'] : 1;
        if ($quantity <= 0) {
            $quantity = 1; // Đảm bảo số lượng ít nhất là 1
        }

        // Kiểm tra số lượng tồn kho (nếu có)
        if (isset($product->stock) && $quantity > $product->stock) {
            $this->setFlashMessage('error', "Số lượng yêu cầu vượt quá tồn kho. Chỉ còn {$product->stock} sản phẩm.");
            header('Location: /webbanhang/Product');
            exit();
        }

        // Cập nhật giỏ hàng
        if (isset($_SESSION['cart'][$id])) {
            // Nếu sản phẩm đã có trong giỏ, tăng số lượng
            $_SESSION['cart'][$id]['quantity'] += $quantity;
        } else {
            // Thêm sản phẩm mới vào giỏ
            $_SESSION['cart'][$id] = [
                'name' => htmlspecialchars($product->name, ENT_QUOTES, 'UTF-8'),
                'price' => (float)$product->price,
                'quantity' => $quantity,
                'image' => htmlspecialchars($product->image, ENT_QUOTES, 'UTF-8')
            ];
        }

        // Lưu thông báo thành công
        $this->setFlashMessage('success', 'Đã thêm sản phẩm vào giỏ hàng thành công!');

        // Chuyển hướng về trang trước hoặc giỏ hàng
        $redirect = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '/webbanhang/Product/cart';
        header("Location: $redirect");
        exit();
    }

    // Hàm hỗ trợ để lưu thông báo flash
    private function setFlashMessage(string $type, string $message): void {
        if (!isset($_SESSION['flash_messages'])) {
            $_SESSION['flash_messages'] = [];
        }
        $_SESSION['flash_messages'][] = [
            'type' => $type, // 'success', 'error', 'warning', v.v.
            'message' => $message
        ];
    }

    public function cart() {
        $cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];
        include 'app/views/product/cart.php';
    }

    public function checkout() {
        include 'app/views/product/checkout.php';
    }

    public function processCheckout() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $name = $_POST['name'];
            $phone = $_POST['phone'];
            $address = $_POST['address'];

            // Kiểm tra giỏ hàng
            if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
                echo "Giỏ hàng trống.";
                return;
            }

            // Bắt đầu giao dịch
            $this->db->beginTransaction();

            try {
                // Lưu thông tin đơn hàng vào bảng orders
                $query = "INSERT INTO orders (name, phone, address) VALUES (:name, :phone, :address)";
                $stmt = $this->db->prepare($query);
                $stmt->bindParam(':name', $name);
                $stmt->bindParam(':phone', $phone);
                $stmt->bindParam(':address', $address);
                $stmt->execute();
                $order_id = $this->db->lastInsertId();

                // Lưu chi tiết đơn hàng vào bảng order_details
                $cart = $_SESSION['cart'];
                foreach ($cart as $product_id => $item) {
                    $query = "INSERT INTO order_details (order_id, product_id, quantity, price) 
                            VALUES (:order_id, :product_id, :quantity, :price)";
                    $stmt = $this->db->prepare($query);
                    $stmt->bindParam(':order_id', $order_id);
                    $stmt->bindParam(':product_id', $product_id);
                    $stmt->bindParam(':quantity', $item['quantity']);
                    $stmt->bindParam(':price', $item['price']);
                    $stmt->execute();
                }

                // Xóa giỏ hàng sau khi đặt hàng thành công
                unset($_SESSION['cart']);

                // Commit giao dịch
                $this->db->commit();

                // Chuyển hướng đến trang xác nhận đơn hàng
                header('Location: /webbanhang/Product/orderConfirmation');
            } catch (Exception $e) {
                // Rollback giao dịch nếu có lỗi
                $this->db->rollBack();
                echo "Đã xảy ra lỗi khi xử lý đơn hàng: " . $e->getMessage();
            }
        }
    }

    public function orderConfirmation() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Lấy đơn hàng mới nhất
        $query = "SELECT id, name, phone, address, created_at 
                  FROM orders 
                  ORDER BY created_at DESC 
                  LIMIT 1";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        $order = $stmt->fetch(PDO::FETCH_OBJ);

        $order_details = [];
        if ($order) {
            // Lấy chi tiết đơn hàng
            $query = "SELECT od.product_id, od.quantity, od.price, p.name, p.image 
                      FROM order_details od 
                      LEFT JOIN product p ON od.product_id = p.id 
                      WHERE od.order_id = :order_id";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':order_id', $order->id, PDO::PARAM_INT);
            $stmt->execute();
            $order_details = $stmt->fetchAll(PDO::FETCH_OBJ);
        }

        include 'app/views/product/orderConfirmation.php';
    }
}