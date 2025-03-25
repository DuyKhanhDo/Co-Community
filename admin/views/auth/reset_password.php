<div class="auth-form">
    <div class="auth-header">
        <h1>Đặt lại mật khẩu</h1>
        <p>Tạo mật khẩu mới cho tài khoản của bạn</p>
    </div>

    <form method="post" action="<?php echo BASE_URL; ?>auth/resetPassword/<?php echo $token; ?>" class="login-form">
        <div class="form-group">
            <label for="password">Mật khẩu mới</label>
            <input type="password" id="password" name="password" required>
        </div>

        <div class="form-group">
            <label for="confirm_password">Xác nhận mật khẩu</label>
            <input type="password" id="confirm_password" name="confirm_password" required>
        </div>

        <button type="submit" class="btn btn-primary btn-block">Đặt lại mật khẩu</button>
    </form>

    <div class="auth-links">
        <a href="<?php echo BASE_URL; ?>auth/login">Quay lại đăng nhập</a>
    </div>
</div>