<?php

/**
 * File index.php
 * 
 * Tập tin chính xử lý tất cả các yêu cầu đến admin panel
 */

// Bắt đầu output buffering
ob_start();

// Tải các file cấu hình và hỗ trợ
require_once 'config/config.php';
require_once 'includes/Database.php';
require_once 'includes/Session.php';
require_once 'includes/Model.php';
require_once 'includes/Controller.php';

// Bắt đầu phiên
Session::init();

// Lấy thành phần URL
$url = isset($_GET['url']) ? $_GET['url'] : DEFAULT_CONTROLLER . '/' . DEFAULT_ACTION;
$url = rtrim($url, '/');
$url = filter_var($url, FILTER_SANITIZE_URL);
$url = explode('/', $url);

// Xác định controller, action và tham số
$controllerName = isset($url[0]) && !empty($url[0]) ? ucfirst($url[0]) . 'Controller' : DEFAULT_CONTROLLER . 'Controller';
$actionName = isset($url[1]) && !empty($url[1]) ? $url[1] : DEFAULT_ACTION;
$params = array_slice($url, 2);

// Kiểm tra xem file controller có tồn tại không
$controllerFile = 'controllers/' . $controllerName . '.php';

if (file_exists($controllerFile)) {
    require_once $controllerFile;

    // Tạo đối tượng controller
    $controller = new $controllerName();

    // Kiểm tra xem phương thức action có tồn tại không
    if (method_exists($controller, $actionName)) {
        // Thiết lập tham số và gọi phương thức
        $controller->setParams($params);
        call_user_func_array([$controller, $actionName], $params);
    } else {
        // Phương thức không tồn tại - Hiển thị trang lỗi 404
        header("HTTP/1.0 404 Not Found");
        require_once 'views/errors/404.php';
    }
} else {
    // Controller không tồn tại - Hiển thị trang lỗi 404
    header("HTTP/1.0 404 Not Found");
    require_once 'views/errors/404.php';
}

// Kết thúc output buffering và gửi nội dung
ob_end_flush();
