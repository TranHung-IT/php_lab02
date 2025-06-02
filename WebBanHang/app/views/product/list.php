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
    max-width: 1000px;
    margin: 0 auto;
}
h1 {
    font-size: 24px;
    margin-bottom: 20px;
    display: flex;
    align-items: center;
    gap: 8px;
}
.add-button {
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
.add-button:hover {
    background: #555555;
    color: #ffffff;
}
.grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 20px;
}
.card {
    background: #ffffff;
    border: 1px solid #e0e0e0;
    border-radius: 5px;
    padding: 20px;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
}
.card h2 {
    font-size: 18px;
    margin-bottom: 15px;
    display: flex;
    align-items: center;
    gap: 8px;
}
.card h2 a {
    color: #000000;
    text-decoration: none;
}
.card h2 a:hover {
    color: #555555;
}
.card p {
    color: #333333;
    margin-bottom: 15px;
    display: flex;
    align-items: center;
    gap: 8px;
}
.card img {
    max-width: 100%;
    border-radius: 5px;
    margin-bottom: 15px;
}
.actions {
    display: flex;
    gap: 10px;
    flex-wrap: wrap;
}
.actions a, 
.actions button {
    padding: 8px 15px;
    border-radius: 5px;
    text-decoration: none;
    transition: background 0.2s ease, color 0.2s ease;
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 14px;
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
.actions form {
    display: inline-flex;
    align-items: center;
}
.actions input[type="number"] {
    width: 40px; /* nhỏ hơn nhưng vẫn đủ cho 2-3 chữ số */
    padding: 6.2px 8px; /* giảm padding để tiết kiệm không gian */
    border: 1px solid #e0e0e0;
    border-radius: 0 5px 5px 0; /* chỉnh lại bo góc để dính liền với button */
    margin: 0;
    gap: 0;
    text-align: center; /* căn giữa số để dễ nhìn */
    font-size: 14px;
}
.actions button {
    background: #ffffff;
    padding: 6px 10px;
    border: 1px solid #e0e0e0;
    border-left: none;
    border-radius: 5px 0 0 5px;
    color: #000000;
    cursor: pointer;
}
.actions button:hover {
    background: #555555;
    color: #ffffff;
}
.badge {
    display: inline-flex;
    align-items: center;
    padding: 8px 12px;
    background: #ffffff;
    border: 1px solid #e0e0e0;
    border-radius: 5px;
    gap: 8px;
}
.bi {
    font-size: 1.1em;
    color: #333333;
}
.add-button:hover .bi,
.actions a:hover .bi,
.actions button:hover .bi {
    color: #ffffff;
}
</style>

<div class="container">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
        <h1><i class="bi bi-shop"></i> Danh Sách Sản Phẩm</h1>
        <a href="/webbanhang/Product/add" class="add-button"><i class="bi bi-plus-circle"></i> Thêm Sản Phẩm</a>
    </div>

    <div class="grid">
        <?php foreach ($products as $product): ?>
            <div class="card">
                <h2>
                    <a href="/webbanhang/Product/show/<?php echo $product->id; ?>">
                        <i class="bi bi-tag"></i> <?php echo htmlspecialchars($product->name, ENT_QUOTES, 'UTF-8'); ?>
                    </a>
                </h2>
                <p><i class="bi bi-text-paragraph"></i> <?php echo htmlspecialchars($product->description, ENT_QUOTES, 'UTF-8'); ?></p>
                <p><i class="bi bi-currency-dollar"></i> Giá: <?php echo number_format($product->price, 0, ',', '.'); ?> ₫</p>
                <?php if (isset($product->stock)): ?>
                    <p><i class="bi bi-box"></i> Tồn kho: <?php echo htmlspecialchars($product->stock, ENT_QUOTES, 'UTF-8'); ?></p>
                <?php endif; ?>
                <?php if ($product->image): ?>
                    <img src="/webbanhang/public/<?php echo htmlspecialchars($product->image, ENT_QUOTES, 'UTF-8'); ?>" 
                         alt="<?php echo htmlspecialchars($product->name, ENT_QUOTES, 'UTF-8'); ?>">
                <?php endif; ?>
                <div class="actions">
                    <?php if (SessionHelper::isAdmin()): ?>
                        <a href="/webbanhang/Product/edit/<?php echo $product->id; ?>" class="edit"><i class="bi bi-pencil"></i> Sửa</a>
                        <a href="/webbanhang/Product/delete/<?php echo $product->id; ?>" class="delete" 
                           onclick="return confirm('Bạn có chắc chắn muốn xóa sản phẩm này?');"><i class="bi bi-trash"></i> Xóa</a>
                    <?php endif; ?>
                    <?php if (!isset($product->stock) || $product->stock > 0): ?>
                        <form method="POST" action="/webbanhang/Product/addToCart/<?php echo $product->id; ?>">
                            <button type="submit"><i class="bi bi-cart-plus"></i></button>
                            <input type="number" name="quantity" value="1" min="1" 
                                   <?php echo isset($product->stock) ? "max=\"{$product->stock}\"" : ''; ?> required>
                        </form>
                    <?php else: ?>
                        <span class="badge"><i class="bi bi-exclamation-circle"></i> Hết hàng</span>
                    <?php endif; ?>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<?php
include 'app/views/shares/footer.php';
ob_end_flush();
?>