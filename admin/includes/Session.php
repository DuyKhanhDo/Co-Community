<?php

/**
 * Class Session
 * 
 * Lớp xử lý phiên làm việc và xác thực người dùng
 */
class Session
{
    /**
     * Bắt đầu phiên làm việc
     */
    public static function init()
    {
        // Bắt đầu phiên làm việc nếu chưa có
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        // Kiểm tra thời gian timeout
        self::checkSessionTimeout();
    }

    /**
     * Thiết lập một giá trị vào phiên
     * 
     * @param string $key Khóa
     * @param mixed $value Giá trị
     * @return void
     */
    public static function set($key, $value)
    {
        $_SESSION[$key] = $value;
    }

    /**
     * Lấy một giá trị từ phiên
     * 
     * @param string $key Khóa
     * @return mixed Giá trị hoặc null nếu không tồn tại
     */
    public static function get($key)
    {
        return isset($_SESSION[$key]) ? $_SESSION[$key] : null;
    }

    /**
     * Xóa một giá trị từ phiên
     * 
     * @param string $key Khóa
     * @return void
     */
    public static function remove($key)
    {
        if (isset($_SESSION[$key])) {
            unset($_SESSION[$key]);
        }
    }

    /**
     * Xóa toàn bộ phiên và hủy phiên
     * 
     * @return void
     */
    public static function destroy()
    {
        // Xóa tất cả dữ liệu phiên
        $_SESSION = array();

        // Xóa cookie phiên
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(
                session_name(),
                '',
                time() - 42000,
                $params["path"],
                $params["domain"],
                $params["secure"],
                $params["httponly"]
            );
        }

        // Hủy phiên
        session_destroy();
    }

    /**
     * Kiểm tra nếu người dùng đã đăng nhập
     * 
     * @return boolean
     */
    public static function isLoggedIn()
    {
        return isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true;
    }

    /**
     * Kiểm tra quyền admin của người dùng
     * 
     * @return boolean
     */
    public static function isAdmin()
    {
        return self::isLoggedIn() && isset($_SESSION['admin_role']) && $_SESSION['admin_role'] === 'admin';
    }

    /**
     * Cập nhật thời gian hoạt động cuối cùng
     * 
     * @return void
     */
    public static function updateLastActivity()
    {
        $_SESSION['admin_last_activity'] = time();
    }

    /**
     * Kiểm tra thời gian timeout của phiên
     * 
     * @return void
     */
    private static function checkSessionTimeout()
    {
        if (self::isLoggedIn()) {
            if (isset($_SESSION['admin_last_activity'])) {
                // Nếu phiên đã hết hạn
                if (time() - $_SESSION['admin_last_activity'] > SESSION_TIME) {
                    self::destroy();
                    header("Location: " . BASE_URL . "auth/login");
                    exit;
                }
            }
            // Cập nhật thời gian hoạt động
            self::updateLastActivity();
        }
    }

    /**
     * Thiết lập thông báo flash
     * 
     * @param string $type Loại thông báo (success, error, warning, info)
     * @param string $message Nội dung thông báo
     * @return void
     */
    public static function setFlash($type, $message)
    {
        $_SESSION['flash_message'] = [
            'type' => $type,
            'message' => $message
        ];
    }

    /**
     * Lấy thông báo flash và xóa nó
     * 
     * @return array|null Thông báo flash hoặc null nếu không có
     */
    public static function getFlash()
    {
        if (isset($_SESSION['flash_message'])) {
            $flash = $_SESSION['flash_message'];
            unset($_SESSION['flash_message']);
            return $flash;
        }
        return null;
    }
}
