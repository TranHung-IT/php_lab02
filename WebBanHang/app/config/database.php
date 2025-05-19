<?php
class Database {
    private string $host = "localhost";
    private string $db_name = "my_store";
    private string $username = "root";
    private string $password = "Tranviethung2k4";
    public ?PDO $conn = null;

    public function getConnection(): ?PDO {
        try {
            if ($this->conn === null) {
                $this->conn = new PDO(
                    "mysql:host={$this->host};dbname={$this->db_name}",
                    $this->username,
                    $this->password,
                    [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]   //xử lý lỗi
                );
                $this->conn->exec("SET NAMES utf8");   
            }
            return $this->conn;
        } catch (PDOException $exception) {
            error_log("Lỗi kết nối database: " . $exception->getMessage());
            throw new PDOException("Không thể kết nối đến cơ sở dữ liệu. Vui lòng kiểm tra lại cấu hình.");
        }
    }
}