<?php include 'app/views/shares/header.php'; ?>

<section>
    <div class="container">
        <div class="card">
            <div class="card-body">
                <h2>Đăng Nhập</h2>
                <p>Vui lòng nhập tên đăng nhập và mật khẩu!</p>
                <?php if (isset($errors) && !empty($errors)) : ?>
                    <ul>
                        <?php foreach ($errors as $err) : ?>
                            <li class="text-danger"><?= htmlspecialchars($err) ?></li>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>
                <form action="/webbanhang/account/checklogin" method="post">
                    <div class="form-group">
                        <label class="form-label" for="username">Tên Đăng Nhập</label>
                        <input type="text" name="username" class="form-control" placeholder="Tên Đăng Nhập" value="<?= isset($_POST['username']) ? htmlspecialchars($_POST['username']) : '' ?>" />
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="password">Mật Khẩu</label>
                        <input type="password" name="password" class="form-control" placeholder="Mật Khẩu" />
                    </div>
                    <p class="link">
                        <a class="text-link" href="#!">Quên Mật Khẩu?</a>
                    </p>
                    <button class="btn" type="submit">Đăng Nhập</button>
                    <div class="social-links">
                        <a href="https://www.facebook.com/WheelOfShare?locale=vi_VN" class="social-icon"><i class="bi bi-facebook"></i></a>
                        <a href="#!" class="social-icon"><i class="bi bi-twitter"></i></a>
                        <a href="#!" class="social-icon"><i class="bi bi-google"></i></a>
                    </div>
                    <p class="link">Chưa có tài khoản? 
                        <a class="text-link" href="/webbanhang/account/register">Đăng Ký</a>
                    </p>
                </form>
            </div>
        </div>
    </div>
</section>

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
        min-height: 10vh;
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
    h2 {
        font-size: 24px;
        font-weight: 600;
        margin-bottom: 10px;
    }
    p {
        font-size: 14px;
        color: #333333;
        margin-bottom: 20px;
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
    .link {
        font-size: 12px;
        margin: 20px 0;
    }
    .text-link {
        color: #000000;
        text-decoration: none;
        transition: color 0.2s ease;
    }
    .text-link:hover {
        color: #555555;
    }
    .social-links {
        display: flex;
        justify-content: center;
        gap: 20px;
        margin: 20px 0;
    }
    .social-icon {
        color: #000000;
        font-size: 20px;
        transition: color 0.2s ease;
    }
    .social-icon:hover {
        color: #555555;
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