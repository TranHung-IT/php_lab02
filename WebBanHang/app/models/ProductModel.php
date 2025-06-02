<?php

class ProductModel {
    private PDO $conn;
    private string $table_name = "product";

    public function __construct(PDO $db) {
        $this->conn = $db;
    }

    public function getProducts(): array {
        $query = "SELECT p.id, p.name, p.description, p.price, p.image, c.name AS category_name 
                  FROM {$this->table_name} p 
                  LEFT JOIN category c ON p.category_id = c.id";

        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function getProductById(int $id): ?object {
        $query = "SELECT p.*, c.name AS category_name 
                FROM {$this->table_name} p 
                LEFT JOIN category c ON p.category_id = c.id 
                WHERE p.id = :id";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_OBJ) ?: null;
    }

    public function addProduct(string $name, string $description, float $price, int $category_id, $image): mixed {
        $errors = [];

        if (empty($name)) {
            $errors['name'] = 'Tên sản phẩm không được để trống';
        }
        if (empty($description)) {
            $errors['description'] = 'Mô tả không được để trống';
        }
        if ($price < 0) {
            $errors['price'] = 'Giá sản phẩm không hợp lệ';
        }
        if ($price > 999999999.99) {
            $errors['price'] = 'Giá sản phẩm quá lớn';
        }

        if (!empty($errors)) {
            return $errors;
        }

        $cleanedName = htmlspecialchars(strip_tags($name));
        $cleanedDescription = htmlspecialchars(strip_tags($description));

        $query = "INSERT INTO {$this->table_name} (name, description, price, category_id, image) 
                VALUES (:name, :description, :price, :category_id, :image)";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':name', $cleanedName);
        $stmt->bindParam(':description', $cleanedDescription);
        $stmt->bindParam(':price', $price, PDO::PARAM_STR);
        $stmt->bindParam(':category_id', $category_id, PDO::PARAM_INT);
        $stmt->bindParam(':image', $image, PDO::PARAM_STR);

        return $stmt->execute();
    }

    public function updateProduct(int $id, string $name, string $description, float $price, int $category_id, $image): mixed {
        $errors = [];

        if (empty($name)) {
            $errors['name'] = 'Tên sản phẩm không được để trống';
        }
        if (empty($description)) {
            $errors['description'] = 'Mô tả không được để trống';
        }
        if ($price < 0) {
            $errors['price'] = 'Giá sản phẩm không hợp lệ';
        }

        if (!empty($errors)) {
            return $errors;
        }

        $query = "UPDATE {$this->table_name} 
                SET name = :name, description = :description, price = :price, 
                    category_id = :category_id, image = :image 
                WHERE id = :id";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':name', htmlspecialchars(strip_tags($name)));
        $stmt->bindParam(':description', htmlspecialchars(strip_tags($description)));
        $stmt->bindParam(':price', $price, PDO::PARAM_STR);
        $stmt->bindParam(':category_id', $category_id, PDO::PARAM_INT);
        $stmt->bindParam(':image', $image, PDO::PARAM_STR);

        return $stmt->execute();
    }

    public function deleteProduct(int $id): bool {
        $query = "DELETE FROM {$this->table_name} WHERE id = :id";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);

        return $stmt->execute();
    }
}