<?php include 'app/views/shares/header.php'; ?>

<div class="container">
    <div class="card">
        <div class="card-body">
            <?php if (isset($errors) && !empty($errors)) : ?>
                <ul>
                    <?php foreach ($errors as $err) : ?>
                        <li class="text-danger"><?= htmlspecialchars($err) ?></li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>
            <form action="/webbanhang/account/save" method="post">
                <div class="form-group">
                    <label class="form-label" for="username">Tên Đăng Nhập</label>
                    <input type="text" class="form-control" id="username" name="username" placeholder="Tên Đăng Nhập">
                </div>
                <div class="form-group">
                    <label class="form-label" for="fullname">Họ Và Tên</label>
                    <input type="text" class="form-control" id="fullname" name="fullname" placeholder="Họ Và Tên">
                </div>
                <div class="form-group">
                    <label class="form-label" for="password">Mật Khẩu</label>
                    <input type="password" class="form-control" id="password" name="password" placeholder="Mật Khẩu">
                </div>
                <div class="form-group">
                    <label class="form-label" for="confirmpassword">Xác Nhận Mật Khẩu</label>
                    <input type="password" class="form-control" id="confirmpassword" name="confirmpassword" placeholder="Xác Nhận Mật Khẩu">
                </div>
                <div class="form-group">
                    <button class="btn" type="submit">Đăng Ký</button>
                </div>
            </form>
        </div>
    </div>
</div>

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
        padding: 20px;
    }
    .container {
        max-width: 1200px;
        margin: 0 auto;
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: 20vh;
        padding: 20px;
    }
    .card {
        background: #ffffff;
        border: 1px solid #e0e0e0;
        border-radius: 5px;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        width: 100%;
        max-width: 500px;
    }
    .card-body {
        padding: 30px;
        text-align: center;
    }
    .form-group {
        margin-bottom: 15px;
    }
    .form-control {
        width: 100%;
        padding: 10px;
        font-size: 14px;
        border: 1px solid #e0e0e0;
        border-radius: 5px;
        outline: none;
        transition: border-color 0.2s ease;
    }
    .form-control:focus {
        border-color: #555555;
    }
    .form-label {
        font-size: 12px;
        color: #333333;
        display: block;
        margin-bottom: 5px;
    }
    .btn {
        background: #ffffff;
        color: #000000;
        border: 1px solid #e0e0e0;
        padding: 12px 20px;
        font-size: 14px;
        border-radius: 5px;
        cursor: pointer;
        width: 100%;
        transition: background 0.2s ease, color 0.2s ease;
    }
    .btn:hover {
        background: #555555;
        color: #ffffff;
    }
    .text-danger {
        color: #721c24;
        font-size: 12px;
        margin: 10px 0;
    }
    @media (max-width: 768px) {
        .card {
            max-width: 90%;
            padding: 20px;
        }
        .card-body {
            padding: 20px;
        }
        .btn {
            padding: 10px 15px;
        }
    }
</style>

<?php include 'app/views/shares/footer.php'; ?>