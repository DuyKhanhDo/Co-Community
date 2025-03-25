<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($title) ? $title . ' - ' : ''; ?>Comovie Admin</title>
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/css/admin.css">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/css/auth.css">
</head>

<body class="auth-body">
    <div class="auth-container">
        <?php if (isset($flash) && $flash): ?>
            <div class="alert alert-<?php echo $flash['type']; ?>">
                <?php echo $flash['message']; ?>
            </div>
        <?php endif; ?>

        <!-- Auth Content Area -->
        <?php echo $content; ?>

        <div class="auth-footer">
            <p>&copy; <?php echo date('Y'); ?> Comovie. Tất cả quyền được bảo lưu.</p>
        </div>
    </div>

    <script src="<?php echo BASE_URL; ?>assets/js/admin.js"></script>
</body>

</html>