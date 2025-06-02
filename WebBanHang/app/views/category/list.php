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
.card p {
    color: #333333;
    margin-bottom: 15px;
}
.card .actions {
    display: flex;
    gap: 10px;
}
.card .actions a {
    padding: 8px 15px;
    border-radius: 5px;
    text-decoration: none;
    transition: background 0.2s ease, color 0.2s ease;
    display: flex;
    align-items: center;
    gap: 8px;
}
.card .actions a.edit {
    background: #ffffff;
    border: 1px solid #e0e0e0;
    color: #000000;
}
.card .actions a.edit:hover {
    background: #555555;
    color: #ffffff;
}
.card .actions a.delete {
    background: #ffffff;
    border: 1px solid #e0e0e0;
    color: #000000;
}
.card .actions a.delete:hover {
    background: #555555;
    color: #ffffff;
}
.bi {
    font-size: 1.1em;
    color: #333333;
}
.add-button:hover .bi, 
.card .actions a:hover .bi {
    color: #ffffff;
}
</style>

<div class="container">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
        <h1><i class="bi bi-boxes"></i> Danh Sách Danh Mục</h1>
        <a href="/webbanhang/Category/add" class="add-button"><i class="bi bi-plus-circle"></i> Thêm Danh Mục</a>
    </div>

    <div class="grid">
        <?php foreach ($categories as $category): ?>
            <div class="card">
                <h2><i class="bi bi-tag"></i> <?php echo htmlspecialchars($category->name, ENT_QUOTES, 'UTF-8'); ?></h2>
                <p><?php echo htmlspecialchars($category->description, ENT_QUOTES, 'UTF-8'); ?></p>
                <div class="actions">
                    <a href="/webbanhang/Category/edit/<?php echo $category->id; ?>" class="edit"><i class="bi bi-pencil"></i> Sửa</a>
                    <a href="/webbanhang/Category/delete/<?php echo $category->id; ?>" class="delete" onclick="return confirm('Bạn có chắc chắn muốn xóa danh mục này?');"><i class="bi bi-trash"></i> Xóa</a>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<?php
include 'app/views/shares/footer.php';
ob_end_flush();
?>