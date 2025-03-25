<?php

/**
 * Cấu hình cơ sở dữ liệu và các thiết lập chính
 */

// Thông tin kết nối cơ sở dữ liệu
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'comovie_db');

// Đường dẫn cơ sở
define('BASE_URL', '/DP/admin/');
define('ROOT_PATH', realpath(dirname(__FILE__) . '/../'));
define('ADMIN_URL', '/DP/admin/');

// Thiết lập mặc định
define('DEFAULT_CONTROLLER', 'Dashboard');
define('DEFAULT_ACTION', 'index');

// Thiết lập phiên làm việc
define('SESSION_TIME', 1800); // 30 phút

// Hiển thị lỗi
ini_set('display_errors', 1);
error_reporting(E_ALL);
