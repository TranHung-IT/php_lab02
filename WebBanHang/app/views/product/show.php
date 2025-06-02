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
    max-width: 500px;
    background: #ffffff;
    border: 1px solid #e0e0e0;
    border-radius: 5px;
    padding: 20px;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    margin: 0 auto;
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
.card h3 {
    font-size: 20px;
    margin-bottom: 15px;
    display: flex;
    align-items: center;
    gap: 8px;
}
.card p {
    color: #333333;
    margin-bottom: 12px;
    display: flex;
    align-items: center;
    gap: 8px;
}
.card img {
    max-width: 100%;
    border-radius: 5px;
    margin-bottom: 15px;
}
.form-group {
    margin-bottom: 15px;
    display: flex;
    align-items: center;
    gap: 8px;
}
.form-group label {
    display: flex;
    align-items: center;
    font-size: 14px;
    color: #333333;
    margin-bottom: 0;
    gap: 8px;
    white-space: nowrap;
}
.form-group input {
    width: 70px;
    padding: 8px;
    border: 1px solid #e0e0e0;
    border-radius: 5px;
}
.form-group input:focus {
    outline: none;
    border-color: #555555;
}
button {
    padding: 8px 16px;
    background: #ffffff;
    border: 1px solid #e0e0e0;
    border-radius: 5px;
    color: #000000;
    cursor: pointer;
    transition: background 0.2s ease, color 0.2s ease;
    display: flex;
    align-items: center;
    gap: 8px;
}
button:hover {
    background: #555555;
    color: #ffffff;
}
.actions {
    display: flex;
    gap: 10px;
    flex-wrap: wrap;
    margin-top: 15px;
}
.actions a {
    padding: 8px 16px;
    border-radius: 5px;
    text-decoration: none;
    transition: background 0.2s ease, color 0.2s ease;
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 14px;
}
.actions a.secondary {
    background: #ffffff;
    border: 1px solid #e0e0e0;
    color: #000000;
}
.actions a.secondary:hover {
    background: #555555;
    color: #ffffff;
}
.actions a.edit {
    background: #ffffff;
    border: 1px solid #e0e0e0;
    color: #000000;
}
.actions a.edit:hover {
    background: #555555;
    color: #ffffff;
}
.actions a.delete {
    background: #ffffff;
    border: 1px solid #e0e0e0;
    color: #000000;
}
.actions a.delete:hover {
    background: #555555;
    color: #ffffff;
}
.text-danger {
    color: #721c24;
    display: flex;
    align-items: center;
    gap: 8px;
}
.bi {
    font-size: 1.1em;
    color: #333333;
}
button:hover .bi,
.actions a:hover .bi {
    color: #ffffff;
}
</style>

<div class="container">
    <h1><i class="bi bi-box"></i> Chi Tiết Sản Phẩm</h1>
    <div class="card">
        <h3><i class="bi bi-tag"></i> <?php echo htmlspecialchars($product->name, ENT_QUOTES, 'UTF-8'); ?></h3>
        <?php if ($product->image): ?>
            <img src="/webbanhang/public/<?php echo htmlspecialchars($product->image, ENT_QUOTES, 'UTF-8'); ?>" 
                 alt="<?php echo htmlspecialchars($product->name, ENT_QUOTES, 'UTF-8'); ?>">
        <?php endif; ?>
        <p><i class="bi bi-text-paragraph"></i> <strong>Mô tả:</strong> <?php echo htmlspecialchars($product->description, ENT_QUOTES, 'UTF-8'); ?></p>
        <p><i class="bi bi-currency-dollar"></i> <strong>Giá:</strong> <?php echo number_format($product->price, 0, ',', '.'); ?> ₫</p>
        <p><i class="bi bi-boxes"></i> <strong>Danh mục:</strong> <?php echo htmlspecialchars($product->category_name ?? 'Không có danh mục', ENT_QUOTES, 'UTF-8'); ?></p>
        <?php if (isset($product->stock)): ?>
            <p><i class="bi bi-box"></i> <strong>Tồn kho:</strong> <?php echo htmlspecialchars($product->stock, ENT_QUOTES, 'UTF-8'); ?></p>
        <?php endif; ?>
        
        <?php if (!isset($product->stock) || $product->stock > 0): ?>
            <form method="POST" action="/webbanhang/Product/addToCart/<?php echo $product->id; ?>">
                <div class="form-group">
                    <label for="quantity"><i class="bi bi-box"></i> Số lượng:</label>
                    <input type="number" id="quantity" name="quantity" value="1" min="1" 
                           <?php echo isset($product->stock) ? "max=\"{$product->stock}\"" : ''; ?> required>
                    <button type="submit"><i class="bi bi-cart-plus"></i> Thêm vào giỏ</button>
                </div>
            </form>
        <?php else: ?>
            <p class="text-danger"><i class="bi bi-exclamation-circle"></i> Sản phẩm đã hết hàng</p>
        <?php endif; ?>
        
        <div class="actions">
            <a href="/webbanhang/Product" class="secondary"><i class="bi bi-arrow-left"></i> Quay lại</a>
            <?php if (SessionHelper::isAdmin()): ?>
                <a href="/webbanhang/Product/edit/<?php echo $product->id; ?>" class="edit"><i class="bi bi-pencil"></i> Sửa</a>
                <a href="/webbanhang/Product/delete/<?php echo $product->id; ?>" 
                   class="delete"
                   onclick="return confirm('Bạn có chắc chắn muốn xóa sản phẩm này?');"><i class="bi bi-trash"></i> Xóa</a>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php
include 'app/views/shares/footer.php';
ob_end_flush();
?>