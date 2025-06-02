<?php
ob_start();
include 'app/views/shares/header.php';
?>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

<style>
body {
    background: #ffffff;
    min-height: 100vh;
    padding: 20px;
    font-family: Arial, sans-serif;
    color: #000000;
}
.container {
    max-width: 900px;
    margin: 0 auto;
}
h1 {
    font-size: 24px;
    margin-bottom: 20px;
    display: flex;
    align-items: center;
    gap: 8px;
}
table {
    width: 100%;
    border-collapse: collapse;
    margin-bottom: 20px;
    border: 1px solid #e0e0e0;
}
th, td {
    padding: 12px;
    border-bottom: 1px solid #e0e0e0;
    text-align: left;
}
th {
    background: #f5f5f5;
    font-weight: bold;
}
td img {
    max-width: 80px;
    display: block;
}
.empty-cart {
    text-align: center;
    padding: 40px 0;
    font-size: 16px;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
}
.btn {
    display: inline-flex;
    align-items: center;
    padding: 10px 20px;
    border-radius: 5px;
    text-decoration: none;
    transition: background 0.2s ease, color 0.2s ease;
    margin-top: 15px;
    margin-right: 10px;
    gap: 8px;
}
.btn-primary {
    background: #ffffff;
    border: 1px solid #e0e0e0;
    color: #000000;
}
.btn-primary:hover {
    background: #555555;
    color: #ffffff;
}
.btn-secondary {
    background: #ffffff;
    border: 1px solid #e0e0e0;
    color: #000000;
}
.btn-secondary:hover {
    background: #555555;
    color: #ffffff;
}
.bi {
    font-size: 1.1em;
    color: #333333;
}
.btn:hover .bi {
    color: #ffffff;
}
</style>

<div class="container">
    <h1><i class="bi bi-cart"></i> Giỏ Hàng</h1>

    <?php if (!empty($cart)): ?>
        <table>
            <thead>
                <tr>
                    <th><i class="bi bi-image"></i> Hình Ảnh</th>
                    <th><i class="bi bi-tag"></i> Tên Sản Phẩm</th>
                    <th><i class="bi bi-currency-dollar"></i> Giá</th>
                    <th><i class="bi bi-box"></i> Số Lượng</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($cart as $id => $item): ?>
                    <tr>
                        <td>
                            <?php if (!empty($item['image'])): ?>
                                <img src="/webbanhang/public/<?php echo htmlspecialchars($item['image'], ENT_QUOTES, 'UTF-8'); ?>" 
                                     alt="<?php echo htmlspecialchars($item['name'], ENT_QUOTES, 'UTF-8'); ?>">
                            <?php endif; ?>
                        </td>
                        <td><?php echo htmlspecialchars($item['name'], ENT_QUOTES, 'UTF-8'); ?></td>
                        <td><?php echo number_format($item['price'], 0, ',', '.'); ?> ₫</td>
                        <td><?php echo htmlspecialchars($item['quantity'], ENT_QUOTES, 'UTF-8'); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p class="empty-cart"><i class="bi bi-cart-x"></i> Giỏ hàng của bạn đang trống.</p>
    <?php endif; ?>
    
    <a href="/webbanhang/Product" class="btn btn-secondary"><i class="bi bi-shop"></i> Tiếp Tục Mua Sắm</a>
    <a href="/webbanhang/Product/checkout" class="btn btn-primary"><i class="bi bi-credit-card"></i> Thanh Toán</a>
</div>

<?php
include 'app/views/shares/footer.php';
ob_end_flush();
?>