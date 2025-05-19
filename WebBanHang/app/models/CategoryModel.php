<?php

class CategoryModel {
    private PDO $conn;
    private string $table_name = "category";

    public function __construct(PDO $db) {
        $this->conn = $db;
    }

    public function getCategories(): array {
        $query = "SELECT id, name, description FROM {$this->table_name}";

        $stmt = $this->conn->prepare($query);       // Prepare: tối ưu hóa truy vấn
        $stmt->execute();       //Thực thi truy vấn

        return $stmt->fetchAll(PDO::FETCH_OBJ);  //Lấy tất cả dữ liệu trả về một mảng các đối tượng
    }

    public function getCategoryById(int $id): ?object {
        $query = "SELECT * FROM {$this->table_name} WHERE id = :id";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);  //PDO::PARAM_INT chỉ định id là kiểu số nguyên
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_OBJ) ?: null;
    }

    public function addCategory(string $name, string $description): mixed {
        $errors = [];

        if (empty($name)) {
            $errors['name'] = 'Tên danh mục không được để trống';
        }
        if (empty($description)) {
            $errors['description'] = 'Mô tả không được để trống';
        }

        if (!empty($errors)) {
            return $errors;
        }

        $query = "INSERT INTO {$this->table_name} (name, description) 
                  VALUES (:name, :description)";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':name', htmlspecialchars(strip_tags($name)));
        $stmt->bindParam(':description', htmlspecialchars(strip_tags($description)));

        return $stmt->execute();
    }

    public function updateCategory(int $id, string $name, string $description): bool {
        $query = "UPDATE {$this->table_name} 
                  SET name = :name, description = :description 
                  WHERE id = :id";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':name', htmlspecialchars(strip_tags($name)));
        $stmt->bindParam(':description', htmlspecialchars(strip_tags($description)));

        return $stmt->execute();
    }

    public function deleteCategory(int $id): bool {
        $query = "DELETE FROM {$this->table_name} WHERE id = :id";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);

        return $stmt->execute();
    }
}