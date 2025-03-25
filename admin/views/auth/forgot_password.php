<div class="auth-form">
    <div class="auth-header">
        <h1>Quên mật khẩu</h1>
        <p>Nhập email của bạn để khôi phục mật khẩu</p>
    </div>

    <form method="post" action="<?php echo BASE_URL; ?>auth/forgotPassword" class="login-form">
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" required>
        </div>

        <button type="submit" class="btn btn-primary btn-block">Gửi yêu cầu</button>
    </form>

    <div class="auth-links">
        <a href="<?php echo BASE_URL; ?>auth/login">Quay lại đăng nhập</a>
        <a href="/DP/">Quay lại trang chính</a>
    </div>
</div>