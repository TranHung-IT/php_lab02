<?php
ob_start();
?>

<style>
    .container {
        padding-bottom: 40px;
    }
    footer {
        background: #ffffff;
        border-top: 1px solid #e0e0e0;
        padding: 10px 20px;
        text-align: center;
        color: #000000;
        position: fixed;
        bottom: 0;
        left: 0;
        width: 100%;
        z-index: 1000;
        box-shadow: 0 -2px 5px rgba(0, 0, 0, 0.1);
    }
    footer p {
        margin: 0;
        font-size: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
    }
    footer a {
        color: #000000;
        text-decoration: none;
        transition: color 0.2s ease;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    footer a:hover {
        color: #555555;
    }
    .bi {
        font-size: 1.1em;
        color: #000000;
    }
    footer a:hover .bi {
        color: #555555;
    }
</style>

    </div>
    <footer>
        <p>© <?php echo date('Y'); ?> Quản Lý Cửa Hàng. Mọi quyền được bảo lưu. 
        <a href="/webbanhang"><i class="bi bi-house"></i> Trang Chủ</a></p>
    </footer>

</body>
</html>

<?php
ob_end_flush();
?>