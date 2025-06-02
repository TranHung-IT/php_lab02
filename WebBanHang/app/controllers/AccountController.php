<?php
require_once 'app/config/database.php';
require_once 'app/models/AccountModel.php';
require_once 'app/helpers/SessionHelper.php'; // Thêm include SessionHelper

class AccountController {
    private $accountModel;
    private $db;

    public function __construct() {
        $this->db = (new Database())->getConnection();
        $this->accountModel = new AccountModel($this->db);
    }

    public function register() {
        include_once 'app/views/account/register.php';
    }

    public function login() {
        include_once 'app/views/account/login.php';
    }

    public function save() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'] ?? '';
            $fullName = $_POST['fullname'] ?? '';
            $password = $_POST['password'] ?? '';
            $confirmPassword = $_POST['confirmpassword'] ?? '';
            $errors = [];

            // Kiểm tra dữ liệu đầu vào
            if (empty($username)) {
                $errors['username'] = "Vui lòng nhập username!";
            } elseif (strlen($username) < 3 || strlen($username) > 50) {
                $errors['username'] = "Username phải từ 3 đến 50 ký tự!";
            }
            if (empty($fullName)) {
                $errors['fullname'] = "Vui lòng nhập fullname!";
            }
            if (empty($password)) {
                $errors['password'] = "Vui lòng nhập password!";
            } elseif (strlen($password) < 6) {
                $errors['password'] = "Mật khẩu phải ít nhất 6 ký tự!";
            }
            if ($password !== $confirmPassword) {
                $errors['confirmPass'] = "Mật khẩu và xác nhận chưa đúng!";
            }

            // Kiểm tra username đã đăng ký chưa
            $account = $this->accountModel->getAccountByUsername($username);
            if ($account) {
                $errors['account'] = "Tài khoản này đã có người đăng ký!";
            }

            if (!empty($errors)) {
                include_once 'app/views/account/register.php';
            } else {
                // Mã hóa mật khẩu trước khi lưu
                $hashedPassword = password_hash($password, PASSWORD_BCRYPT, ['cost' => 12]);
                $role = 'user'; // Gán vai trò mặc định là 'user'
                $result = $this->accountModel->save($username, $fullName, $hashedPassword, $role);

                if ($result) {
                    SessionHelper::start(); // Khởi tạo session
                    $_SESSION['flash_messages'] = [
                        ['type' => 'success', 'message' => 'Đăng ký thành công! Vui lòng đăng nhập.']
                    ];
                    header('Location: /webbanhang/account/login');
                    exit;
                } else {
                    $errors['save'] = "Lỗi khi đăng ký. Vui lòng thử lại!";
                    include_once 'app/views/account/register.php';
                }
            }
        }
    }

    public function logout() {
        SessionHelper::start(); // Sử dụng SessionHelper để khởi tạo session
        unset($_SESSION['username']);
        unset($_SESSION['role']);
        session_destroy(); // Hủy toàn bộ session
        header('Location: /webbanhang/product');
        exit;
    }

    public function checkLogin() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'] ?? '';
            $password = $_POST['password'] ?? '';
            $errors = [];

            $account = $this->accountModel->getAccountByUsername($username);
            if ($account) {
                $pwd_hashed = $account->password;

                // Kiểm tra mật khẩu
                if (password_verify($password, $pwd_hashed)) {
                    SessionHelper::start(); // Sử dụng SessionHelper để khởi tạo session
                    $_SESSION['username'] = $account->username;
                    $_SESSION['role'] = $account->role; // Lưu role vào session
                    header('Location: /webbanhang/product');
                    exit;
                } else {
                    $errors['password'] = "Password incorrect.";
                }
            } else {
                $errors['username'] = "Không tìm thấy tài khoản.";
            }

            // Hiển thị lại form đăng nhập với thông báo lỗi
            include_once 'app/views/account/login.php';
        }
    }
}