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
.form-group textarea {
    width: 100%;
    padding: 10px;
    background: #ffffff;
    border: 1px solid #e0e0e0;
    border-radius: 5px;
    color: #000000;
    font-size: 14px;
}
.form-group input:focus, 
.form-group textarea:focus {
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

<div class="container">
    <h1><i class="bi bi-credit-card"></i> Thanh Toán</h1>

    <form method="POST" action="/webbanhang/Product/processCheckout" onsubmit="return validateForm();">
        <div class="form-group">
            <label for="name"><i class="bi bi-person"></i> Họ Tên:</label>
            <input type="text" id="name" name="name" placeholder="Nhập họ tên" required>
        </div>

        <div class="form-group">
            <label for="phone"><i class="bi bi-telephone"></i> Số Điện Thoại:</label>
            <input type="text" id="phone" name="phone" placeholder="Nhập số điện thoại" required>
        </div>

        <div class="form-group">
            <label for="address"><i class="bi bi-geo-alt"></i> Địa Chỉ:</label>
            <textarea id="address" name="address" placeholder="Nhập địa chỉ giao hàng" required></textarea>
        </div>

        <button type="submit"><i class="bi bi-credit-card"></i> Thanh Toán</button>
        <a href="/webbanhang/Product/cart" class="back-link"><i class="bi bi-arrow-left"></i> Quay Lại Giỏ Hàng</a>
    </form>
</div>

<script>
function validateForm() {
    const name = document.getElementById('name').value.trim();
    const phone = document.getElementById('phone').value.trim();
    const address = document.getElementById('address').value.trim();
    
    if (name.length < 3) {
        alert('Họ tên phải có ít nhất 3 ký tự.');
        return false;
    }
    if (!/^\d{10,11}$/.test(phone)) {
        alert('Số điện thoại phải có 10 hoặc 11 chữ số.');
        return false;
    }
    if (address.length < 10) {
        alert('Địa chỉ phải có ít nhất 10 ký tự.');
        return false;
    }
    return true;
}
</script>

<?php
include 'app/views/shares/footer.php';
ob_end_flush();
?>