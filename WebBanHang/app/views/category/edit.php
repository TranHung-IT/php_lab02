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
    max-width: 400px;
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
.form-group input, .form-group textarea {
    width: 100%;
    padding: 10px;
    background: #ffffff;
    border: 1px solid #e0e0e0;
    border-radius: 5px;
    color: #000000;
    font-size: 14px;
    transition: border-color 0.2s ease;
}
.form-group input:focus, .form-group textarea:focus {
    outline: none;
    border-color: #555555;
}
textarea {
    resize: vertical;
    min-height: 100px;
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
button:hover .bi {
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
</style>

<div class="container">
    <h1><i class="bi bi-pencil"></i> Sửa Danh Mục</h1>

    <?php if (!empty($errors)): ?>
        <div class="alert">
            <ul>
                <?php foreach ($errors as $error): ?>
                    <li><i class="bi bi-exclamation-circle"></i> <?php echo htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <form method="POST" action="/webbanhang/Category/update" onsubmit="return validateForm();">
        <input type="hidden" name="id" value="<?php echo $category->id; ?>">

        <div class="form-group">
            <label for="name"><i class="bi bi-tag"></i> Tên Danh Mục:</label>
            <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($category->name, ENT_QUOTES, 'UTF-8'); ?>" required>
        </div>

        <div class="form-group">
            <label for="description"><i class="bi bi-text-paragraph"></i> Mô Tả:</label>
            <textarea id="description" name="description" required><?php echo htmlspecialchars($category->description, ENT_QUOTES, 'UTF-8'); ?></textarea>
        </div>

        <button type="submit"><i class="bi bi-save"></i> Lưu Thay Đổi</button>
    </form>

    <a href="/webbanhang/Category/list" class="back-link"><i class="bi bi-arrow-left"></i> Quay Lại Danh Sách</a>
</div>

<script>
function validateForm() {
    const name = document.getElementById('name').value.trim();
    const description = document.getElementById('description').value.trim();
    
    if (name.length < 3) {
        alert('Tên danh mục phải có ít nhất 3 ký tự.');
        return false;
    }
    if (description.length < 10) {
        alert('Mô tả phải có ít nhất 10 ký tự.');
        return false;
    }
    return true;
}
</script>

<?php
include 'app/views/shares/footer.php';
ob_end_flush();
?>