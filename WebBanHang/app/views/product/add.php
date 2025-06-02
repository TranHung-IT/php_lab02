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
.alert {
    background: #f8d7da;
    padding: 10px;
    border-radius: 5px;
    margin-bottom: 20px;
    color: #721c24;
}
.alert ul {
    list-style: disc;
    padding-left: 20px;
}
.alert li {
    display: flex;
    align-items: center;
    gap: 8px;
}
.form-group {
    margin-bottom: 15px;
}
.form-group label {
    display: flex;
    align-items: center;
    font-size: 14px;
    color: #333333;
    margin-bottom: 5px;
    gap: 8px;
}
.form-group input, 
.form-group textarea, 
.form-group select {
    width: 100%;
    padding: 10px;
    background: #ffffff;
    border: 1px solid #e0e0e0;
    border-radius: 5px;
    color: #000000;
    font-size: 14px;
}
.form-group input:focus, 
.form-group textarea:focus, 
.form-group select:focus {
    outline: none;
    border-color: #555555;
}
.form-group input[type="file"] {
    padding: 5px;
}
textarea {
    resize: vertical;
    min-height: 100px;
}
small {
    color: #777777;
    font-size: 12px;
}
button {
    width: 100%;
    padding: 12px;
    background: #ffffff;
    border: 1px solid #e0e0e0;
    border-radius: 5px;
    color: #000000;
    font-size: 14px;
    cursor: pointer;
    transition: background 0.2s ease, color 0.2s ease;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
}
button:hover {
    background: #555555;
    color: #ffffff;
}
a.back-link {
    display: flex;
    align-items: center;
    justify-content: center;
    margin-top: 15px;
    color: #000000;
    text-decoration: none;
    transition: color 0.2s ease;
    gap: 8px;
}
a.back-link:hover {
    color: #555555;
}
.bi {
    font-size: 1.1em;
    color: #333333;
}
button:hover .bi {
    color: #ffffff;
}
</style>

<?php if (SessionHelper::isAdmin()): ?>
    <div class="container">
        <h1><i class="bi bi-plus-circle"></i> Thêm Sản Phẩm Mới</h1>

        <?php if (!empty($errors)): ?>
            <div class="alert">
                <ul>
                    <?php foreach ($errors as $error): ?>
                        <li><i class="bi bi-exclamation-circle"></i> <?php echo htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <form method="POST" action="/webbanhang/Product/save" enctype="multipart/form-data" onsubmit="return validateForm();">
            <div class="form-group">
                <label for="name"><i class="bi bi-tag"></i> Tên Sản Phẩm:</label>
                <input type="text" id="name" name="name" placeholder="Nhập tên sản phẩm" required>
            </div>

            <div class="form-group">
                <label for="description"><i class="bi bi-text-paragraph"></i> Mô Tả:</label>
                <textarea id="description" name="description" placeholder="Nhập mô tả sản phẩm" required></textarea>
            </div>

            <div class="form-group">
                <label for="price"><i class="bi bi-currency-dollar"></i> Giá:</label>
                <input type="number" id="price" name="price" step="0.01" placeholder="Nhập giá sản phẩm" required>
            </div>

            <div class="form-group">
                <label for="category_id"><i class="bi bi-boxes"></i> Danh Mục:</label>
                <select id="category_id" name="category_id" required>
                    <?php foreach ($categories as $category): ?>
                        <option value="<?php echo $category->id; ?>">
                            <?php echo htmlspecialchars($category->name, ENT_QUOTES, 'UTF-8'); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-group">
                <label for="image"><i class="bi bi-image"></i> Hình Ảnh:</label>
                <input type="file" id="image" name="image">
                <small>Chỉ chấp nhận file ảnh JPG, PNG, GIF (tối đa 10MB)</small>
            </div>

            <button type="submit"><i class="bi bi-save"></i> Thêm Sản Phẩm</button>
            <a href="/webbanhang/Product/index" class="back-link"><i class="bi bi-arrow-left"></i> Quay Lại</a>
        </form>
    </div>
<?php endif; ?>

<script>
function validateForm() {
    const name = document.getElementById('name').value.trim();
    const description = document.getElementById('description').value.trim();
    const price = document.getElementById('price').value;
    const image = document.getElementById('image').files[0];
    
    if (name.length < 3) {
        alert('Tên sản phẩm phải có ít nhất 3 ký tự.');
        return false;
    }
    if (description.length < 10) {
        alert('Mô tả phải có ít nhất 10 ký tự.');
        return false;
    }
    if (price <= 0) {
        alert('Giá sản phẩm phải lớn hơn 0.');
        return false;
    }
    if (image && !['image/jpeg', 'image/png', 'image/gif'].includes(image.type)) {
        alert('Hình ảnh phải là định dạng JPG, PNG hoặc GIF.');
        return false;
    }
    if (image && image.size > 10 * 1024 * 1024) {
        alert('Hình ảnh không được vượt quá 10MB.');
        return false;
    }
    return true;
}
</script>

<?php
include 'app/views/shares/footer.php';
ob_end_flush();
?>