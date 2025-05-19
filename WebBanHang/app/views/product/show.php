<?php include 'app/views/shares/header.php'; ?>

<h1>Chi tiết sản phẩm</h1>

<div class="card">
    <div class="card-header">
        <h3><?php echo htmlspecialchars($product->name, ENT_QUOTES, 'UTF-8'); ?></h3>
    </div>
    <div class="card-body">
        <?php if ($product->image): ?>
            <p><strong>Hình ảnh:</strong></p>
            <img src="/webbanhang/public/<?php echo htmlspecialchars($product->image, ENT_QUOTES, 'UTF-8'); ?>" 
            alt="<?php echo htmlspecialchars($product->name, ENT_QUOTES, 'UTF-8'); ?>" 
            class="img-thumbnail" 
            style="max-width: 200px;">
        <?php endif; ?>
        <p><strong>Mô tả:</strong> <?php echo htmlspecialchars($product->description, ENT_QUOTES, 'UTF-8'); ?></p>
        <p><strong>Giá:</strong> <?php echo htmlspecialchars(number_format($product->price, 2), ENT_QUOTES, 'UTF-8'); ?> VND</p>
        <p><strong>Danh mục:</strong> <?php echo htmlspecialchars($product->category_name ?? 'Không có danh mục', ENT_QUOTES, 'UTF-8'); ?></p>
    </div>
    <div class="card-footer">
        <a href="/webbanhang/Product" class="btn btn-secondary">Quay lại danh sách</a>
        <a href="/webbanhang/Product/edit/<?php echo $product->id; ?>" class="btn btn-warning">Sửa</a>
        <a href="/webbanhang/Product/delete/<?php echo $product->id; ?>" class="btn btn-danger"
           onclick="return confirm('Bạn có chắc chắn muốn xóa sản phẩm này?');">Xóa</a>
    </div>
</div>

<?php include 'app/views/shares/footer.php'; ?>