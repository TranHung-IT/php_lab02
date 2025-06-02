<?php

// Require necessary files
require_once 'app/config/database.php';     //Nhúng file cấu hình database
require_once 'app/models/CategoryModel.php';       //Nhúng file model danh mục

class CategoryController {
    private PDO $db;
    private CategoryModel $categoryModel;

    public function __construct() {     //Hàm hởi tạo
        $this->db = (new Database())->getConnection();
        $this->categoryModel = new CategoryModel($this->db);
    }

    public function list(): void {
        $categories = $this->categoryModel->getCategories();
        include 'app/views/category/list.php';
    }

    public function add(): void {
        include 'app/views/category/add.php';   //Hiển thị form thêm danh mục
    }

    public function save(): void {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'] ?? '';       //Nếu có post thì lấy giá trị name else gán là rỗng
            $description = $_POST['description'] ?? '';

            $result = $this->categoryModel->addCategory($name, $description);

            if (is_array($result)) {
                $errors = $result;
                include 'app/views/category/add.php';
            } else {
                header('Location: /webbanhang/Category/list');
                exit();
            }
        }
    }

    public function edit(int $id): void {
        $category = $this->categoryModel->getCategoryById($id);

        if ($category) {
            include 'app/views/category/edit.php';
        } else {
            echo "Không thấy danh mục.";
        }
    }

    public function update(): void {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = (int)$_POST['id'];
            $name = $_POST['name'] ?? '';
            $description = $_POST['description'] ?? '';

            if ($this->categoryModel->updateCategory($id, $name, $description)) {
                header('Location: /webbanhang/Category/list');
                exit();
            } else {
                echo "Đã xảy ra lỗi khi lưu danh mục.";
            }
        }
    }

    public function delete(int $id): void {
        if ($this->categoryModel->deleteCategory($id)) {
            header('Location: /webbanhang/Category/list');
            exit();
        } else {
            echo "Đã xảy ra lỗi khi xóa danh mục.";
        }
    }
}