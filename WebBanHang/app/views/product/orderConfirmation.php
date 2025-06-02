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
    background: #ffffff;
    border: 1px solid #e0e0e0;
    border-radius: 5px;
    padding: 20px;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
}
h1 {
    font-size: 24px;
    text-align: center;
    margin-bottom: 20px;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
}
h2 {
    font-size: 20px;
    margin-bottom: 15px;
    display: flex;
    align-items: center;
    gap: 8px;
}
.customer-info, 
.order-summary {
    margin-bottom: 20px;
}
.customer-info p, 
.order-summary p {
    color: #333333;
    font-size: 14px;
    margin-bottom: 8px;
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
.total {
    text-align: right;
    font-size: 16px;
    font-weight: bold;
    margin-top: 15px;
    display: flex;
    justify-content: flex-end;
    align-items: center;
    gap: 8px;
}
.btn {
    display: inline-flex;
    align-items: center;
    padding: 10px 20px;
    background: #ffffff;
    border: 1px solid #e0e0e0;
    color: #000000;
    text-decoration: none;
    border-radius: 5px;
    transition: background 0.2s ease, color 0.2s ease;
    gap: 8px;
}
.btn:hover {
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
    <h1><i class="bi bi-receipt"></i> Xác Nhận Đơn Hàng</h1>

    <?php if ($order && !empty($order_details)): ?>
        <div class="customer-info">
            <h2><i class="bi bi-person"></i> Thông Tin Khách Hàng</h2>
            <p><i class="bi bi-person"></i> <strong>Họ tên:</strong> <?php echo htmlspecialchars($order->name, ENT_QUOTES, 'UTF-8'); ?></p>
            <p><i class="bi bi-telephone"></i> <strong>Số điện thoại:</strong> <?php echo htmlspecialchars($order->phone, ENT_QUOTES, 'UTF-8'); ?></p>
            <p><i class="bi bi-geo-alt"></i> <strong>Địa chỉ:</strong> <?php echo htmlspecialchars($order->address, ENT_QUOTES, 'UTF-8'); ?></p>
            <p><i class="bi bi-calendar"></i> <strong>Ngày đặt:</strong> <?php echo date('d/m/Y H:i', strtotime($order->created_at)); ?></p>
        </div>

        <div class="order-summary">
            <h2><i class="bi bi-list"></i> Chi Tiết Đơn Hàng</h2>
            <table>
                <thead>
                    <tr>
                        <th><i class="bi bi-image"></i> Hình Ảnh</th>
                        <th><i class="bi bi-tag"></i> Tên Sản Phẩm</th>
                        <th><i class="bi bi-box"></i> Số Lượng</th>
                        <th><i class="bi bi-currency-dollar"></i> Đơn Giá</th>
                        <th><i class="bi bi-cash"></i> Thành Tiền</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $subtotal = 0;
                    foreach ($order_details as $item): 
                        $item_total = $item->quantity * $item->price;
                        $subtotal += $item_total;
                    ?>
                        <tr>
                            <td>
                                <?php if (!empty($item->image)): ?>
                                    <img src="/webbanhang/public/<?php echo htmlspecialchars($item->image, ENT_QUOTES, 'UTF-8'); ?>" 
                                         alt="<?php echo htmlspecialchars($item->name, ENT_QUOTES, 'UTF-8'); ?>">
                                <?php endif; ?>
                            </td>
                            <td><?php echo htmlspecialchars($item->name, ENT_QUOTES, 'UTF-8'); ?></td>
                            <td><?php echo htmlspecialchars($item->quantity, ENT_QUOTES, 'UTF-8'); ?></td>
                            <td><?php echo number_format($item->price, 0, ',', '.'); ?> ₫</td>
                            <td><?php echo number_format($item_total, 0, ',', '.'); ?> ₫</td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <p class="total"><i class="bi bi-cash-stack"></i> Tổng cộng: <?php echo number_format($subtotal, 0, ',', '.'); ?> ₫</p>
        </div>
    <?php else: ?>
        <p><i class="bi bi-exclamation-circle"></i> Không tìm thấy thông tin đơn hàng.</p>
    <?php endif; ?>

    <a href="/webbanhang/Product" class="btn"><i class="bi bi-shop"></i> Tiếp Tục Mua Sắm</a>
</div>

<?php
include 'app/views/shares/footer.php';
ob_end_flush();
?>