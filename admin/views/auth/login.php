<div class="auth-form">
    <div class="auth-header">
        <h1>Comovie Admin</h1>
        <p>Đăng nhập để tiếp tục</p>
    </div>

    <form method="post" action="<?php echo BASE_URL; ?>auth/login" class="login-form">
        <div class="form-group">
            <label for="username">Tên đăng nhập</label>
            <input type="text" id="username" name="username" required>
        </div>

        <div class="form-group">
            <label for="password">Mật khẩu</label>
            <input type="password" id="password" name="password" required>
        </div>

        <div class="form-group remember-me">
            <input type="checkbox" id="remember" name="remember">
            <label for="remember">Ghi nhớ đăng nhập</label>
        </div>

        <button type="submit" class="btn btn-primary btn-block">Đăng nhập</button>
    </form>

    <div class="auth-links">
        <a href="<?php echo BASE_URL; ?>auth/forgotPassword">Quên mật khẩu?</a>
        <a href="/DP/">Quay lại trang chính</a>
    </div>
</div>