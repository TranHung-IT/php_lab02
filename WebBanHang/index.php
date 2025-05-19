<?php

// Bật hiển thị lỗi trong quá trình phát triển (xóa khi triển khai)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Định nghĩa hằng số cho đường dẫn
define('BASE_PATH', __DIR__);

// Nạp các tệp cần thiết
require_once BASE_PATH . '/app/config/database.php';
require_once BASE_PATH . '/app/models/ProductModel.php';
require_once BASE_PATH . '/app/models/CategoryModel.php';
require_once BASE_PATH . '/app/controllers/ProductController.php';
require_once BASE_PATH . '/app/controllers/CategoryController.php';

// Lấy URL từ query string hoặc REQUEST_URI
$url = isset($_GET['url']) ? $_GET['url'] : 'Product/index';
$url = rtrim($url, '/');
$url = filter_var($url, FILTER_SANITIZE_URL);
$url = explode('/', $url);

// Xác định controller, action, và tham số
// $controllerName = isset($url[0]) ? ucfirst($url[0]) . 'Controller' : 'ProductController';
$controllerName = isset($url[0]) ? ucfirst($url[0]) . 'Controller' : 'CategoryController';
$action = isset($url[1]) ? $url[1] : 'index';
$param = isset($url[2]) ? $url[2] : null;

// Kiểm tra controller tồn tại
$controllerFile = BASE_PATH . "/app/controllers/$controllerName.php";
if (file_exists($controllerFile)) {
    $controller = new $controllerName();

    // Kiểm tra action tồn tại
    if (method_exists($controller, $action)) {
        // Gọi action với tham số (nếu có)
        if ($param !== null) {
            $controller->$action($param);
        } else {
            $controller->$action();
        }
    } else {
        // Xử lý lỗi: action không tồn tại
        header('HTTP/1.0 404 Not Found');
        echo "<h1>404 - Hành động '$action' không tồn tại trong '$controllerName'</h1>";
        exit;
    }
} else {
    // Xử lý lỗi: controller không tồn tại
    header('HTTP/1.0 404 Not Found');
    echo "<h1>404 - Controller '$controllerName' không tồn tại</h1>";
    exit;
}
