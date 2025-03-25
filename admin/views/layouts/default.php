<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($title) ? $title . ' - ' : ''; ?>Comovie Admin</title>
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/css/admin.css">
</head>

<body>
    <div class="admin-container">
        <!-- Sidebar -->
        <div class="sidebar">
            <div class="logo">
                <h1>Comovie Admin</h1>
            </div>
            <ul class="nav-links">
                <li><a href="<?php echo BASE_URL; ?>dashboard" class="<?php echo isset($active_menu) && $active_menu == 'dashboard' ? 'active' : ''; ?>">
                        <i class="icon-dashboard"></i> Tổng quan
                    </a></li>
                <li><a href="<?php echo BASE_URL; ?>movies" class="<?php echo isset($active_menu) && $active_menu == 'movies' ? 'active' : ''; ?>">
                        <i class="icon-movie"></i> Quản lý phim
                    </a></li>
                <li><a href="<?php echo BASE_URL; ?>users" class="<?php echo isset($active_menu) && $active_menu == 'users' ? 'active' : ''; ?>">
                        <i class="icon-users"></i> Quản lý người dùng
                    </a></li>
                <li><a href="<?php echo BASE_URL; ?>categories" class="<?php echo isset($active_menu) && $active_menu == 'categories' ? 'active' : ''; ?>">
                        <i class="icon-category"></i> Thể loại
                    </a></li>
                <li><a href="<?php echo BASE_URL; ?>settings" class="<?php echo isset($active_menu) && $active_menu == 'settings' ? 'active' : ''; ?>">
                        <i class="icon-settings"></i> Cài đặt
                    </a></li>
            </ul>
            <div class="logout">
                <a href="<?php echo BASE_URL; ?>auth/logout"><i class="icon-logout"></i> Đăng xuất</a>
            </div>
        </div>

        <!-- Main Content -->
        <div class="main-content">
            <!-- Header -->
            <div class="header">
                <form action="<?php echo BASE_URL; ?>dashboard/search" method="get" class="search-bar">
                    <input type="text" name="q" placeholder="Tìm kiếm..." value="<?php echo isset($keyword) ? htmlspecialchars($keyword) : ''; ?>">
                    <button type="submit"><i class="icon-search"></i></button>
                </form>
                <div class="user-info">
                    <span>Xin chào, <?php echo htmlspecialchars(Session::get('admin_username') ?? 'Admin'); ?></span>
                    <img src="https://via.placeholder.com/40" alt="Admin Avatar">
                </div>
            </div>

            <?php if (isset($flash) && $flash): ?>
                <div class="alert alert-<?php echo $flash['type']; ?>">
                    <?php echo $flash['message']; ?>
                </div>
            <?php endif; ?>

            <!-- Main Content Area -->
            <?php echo $content; ?>
        </div>
    </div>

    <script src="<?php echo BASE_URL; ?>assets/js/admin.js"></script>
</body>

</html>