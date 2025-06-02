<?php
ob_start();
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản Lý Cửa Hàng</title>
    <!-- Bootstrap Icons CDN -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: Arial, sans-serif;
            background: #ffffff;
            min-height: 100vh;
            color: #000000;
            padding-top: 60px;
            padding-bottom: 60px;
        }
        .navbar {
            background: #ffffff;
            border-bottom: 1px solid #e0e0e0;
            padding: 10px 20px;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            z-index: 1000;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }
        .navbar-container {
            max-width: 1200px;
            margin: 0 auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .navbar-brand {
            font-size: 18px;
            font-weight: 600;
            color: #000000;
            text-decoration: none;
            transition: color 0.2s ease;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .navbar-brand:hover {
            color: #555555;
        }
        .navbar-brand:hover .bi {
            color: #555555;
        }
        .navbar-toggler {
            display: none;
            background: none;
            border: none;
            font-size: 18px;
            color: #000000;
            cursor: pointer;
        }
        .navbar-nav {
            display: flex;
            list-style: none;
        }
        .navbar-nav li {
            margin-left: 20px;
        }
        .navbar-nav a {
            color: #333333;
            text-decoration: none;
            font-size: 14px;
            transition: color 0.2s ease;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .navbar-nav a:hover {
            color: #000000;
            font-weight: 500;
        }
        .navbar-nav a:hover .bi {
            color: #000000;
        }
        .container {
            max-width: 1200px;
            margin: 20px auto;
            padding: 0 20px;
            min-height: calc(10vh - 20px);
        }
        .alert {
            position: fixed;
            top: 80px;
            right: 20px;
            min-width: 300px;
            padding: 15px;
            border-radius: 5px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
            z-index: 9999;
            display: flex;
            align-items: center;
            animation: slideIn 0.5s forwards;
            opacity: 0;
        }
        .alert-success {
            background: #d4edda;
            color: #155724;
            border-left: 4px solid #28a745;
        }
        .alert button {
            position: absolute;
            top: 5px;
            right: 10px;
            background: none;
            border: none;
            margin-left: 15px;
            color: inherit;
            font-size: 14px;
            cursor: pointer;
            transition: color 0.2s ease;
        }
        .alert-success button {
            color: #155724;
        }
        .alert button:hover {
            color: #000000;
        }
        .alert-error {
            background: #f8d7da;
            color: #721c24;
            border-left: 4px solid #dc3545;
        }
        .bi {
            font-size: 1.1em;
            color: #333333;
        }
        .navbar-brand .bi, .alert-success .bi {
            color: #000000;
        }
        @media (max-width: 768px) {
            body {
                padding-top: 50px;
                padding-bottom: 50px;
            }
            .navbar-container {
                flex-direction: column;
                align-items: flex-start;
            }
            .navbar-toggler {
                display: block;
            }
            .navbar-nav {
                display: none;
                flex-direction: column;
                width: 100%;
                margin-top: 10px;
            }
            .navbar-nav.active {
                display: flex;
            }
            .navbar-nav li {
                margin: 5px 0;
            }
            .container {
                min-height: calc(100vh - 100px);
            }
        }
        @keyframes slideIn {
            from {
                transform: translateX(100%);
                opacity: 0;
            }
            to {
                transform: translateX(0);
                opacity: 1;
            }
        }

        .alert .bi {
            margin-right: 10px;
            font-size: 1.5em;
        }
    </style>
</head>
<body>
    <nav class="navbar">
        <div class="navbar-container">
            <a class="navbar-brand" href="/webbanhang"><i class="bi bi-shop-window"></i> Quản Lý Cửa Hàng</a>
            <button class="navbar-toggler" onclick="toggleNavbar()">☰</button>
            <ul class="navbar-nav" id="navbarNav">
                <li class="nav-item">
                    <a class="nav-link" href="/webbanhang/Product/"><i class="bi bi-shop"></i> Danh Sách Sản Phẩm</a>
                </li>
                <?php if (SessionHelper::isAdmin()): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="/webbanhang/Category/list"><i class="bi bi-boxes"></i> Danh Sách Danh Mục</a>
                    </li>
                <?php endif; ?>
                <li class="nav-item">
                    <a class="nav-link" href="/webbanhang/Product/cart"><i class="bi bi-cart"></i> Giỏ Hàng</a>
                </li>
                <li class="nav-item">
                    <?php if (SessionHelper::isLoggedIn()): ?>
                        <a class="nav-link">
                            <?= htmlspecialchars($_SESSION['username']) . " (" . SessionHelper::getRole() . ")" ?>
                        </a>
                    <?php else: ?>
                        <a class="nav-link" href="/webbanhang/account/login"><i class="bi bi-person"></i> Đăng Nhập</a>
                    <?php endif; ?>
                </li>
                <li class="nav-item">
                    <?php if (SessionHelper::isLoggedIn()) : ?>
                        <a class="nav-link" href="/webbanhang/account/logout"><i class="bi bi-box-arrow-right"></i> Đăng Xuất</a>
                    <?php endif; ?>
                </li>
            </ul>
        </div>
    </nav>
    <div class="container">
        <?php if (isset($_SESSION['flash_messages']) && !empty($_SESSION['flash_messages'])): ?>
            <?php foreach ($_SESSION['flash_messages'] as $flash): ?>
                <div class="alert alert-<?php echo htmlspecialchars($flash['type'], ENT_QUOTES, 'UTF-8'); ?>">
                    <i class="bi <?php echo $flash['type'] === 'success' ? 'bi-check-circle' : 'bi-exclamation-circle'; ?>"></i>
                    <span><?php echo htmlspecialchars($flash['message'], ENT_QUOTES, 'UTF-8'); ?></span>
                    <button onclick="this.parentElement.remove()">×</button>
                </div>
            <?php endforeach; ?>
            <?php unset($_SESSION['flash_messages']); ?>
        <?php endif; ?>
    </div>
    <script>
        function toggleNavbar() {
            const navbar = document.getElementById('navbarNav');
            navbar.classList.toggle('active');
        }
        // Tự động ẩn thông báo sau 5 giây
        document.addEventListener('DOMContentLoaded', function() {
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(alert => {
                setTimeout(() => {
                    alert.style.opacity = '0';
                    setTimeout(() => alert.remove(), 300);
                }, 3000);
            });
        });
    </script>
</body>
</html>

<?php
ob_end_flush();
?>