<?php

/**
 * Class AuthController
 * 
 * Controller xử lý xác thực người dùng
 */
class AuthController extends Controller
{
    /**
     * Khởi tạo controller
     */
    public function __construct()
    {
        parent::__construct();
        $this->loadModel('User');
    }

    /**
     * Hiển thị trang đăng nhập
     * 
     * @return void
     */
    public function login()
    {
        // Kiểm tra nếu đã đăng nhập, chuyển hướng đến dashboard
        if (Session::isLoggedIn()) {
            $this->redirect('dashboard');
            return;
        }

        // Xử lý form đăng nhập nếu có yêu cầu POST
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = trim($_POST['username']);
            $password = $_POST['password'];
            $remember = isset($_POST['remember']) ? true : false;

            // Xác thực người dùng
            $user = $this->model->getUserByUsername($username);

            if ($user && password_verify($password, $user['password']) && $user['role'] === 'admin') {
                // Đăng nhập thành công
                Session::set('admin_logged_in', true);
                Session::set('admin_id', $user['id']);
                Session::set('admin_username', $user['username']);
                Session::set('admin_role', $user['role']);
                Session::updateLastActivity();

                // Thiết lập cookie nếu remember me được chọn
                if ($remember) {
                    $token = bin2hex(random_bytes(32));
                    $expires = time() + 30 * 24 * 60 * 60; // 30 ngày

                    // Lưu token vào database
                    $this->model->saveRememberToken($user['id'], $token, $expires);

                    // Thiết lập cookie
                    setcookie('admin_remember', $token, $expires, '/');
                }

                // Chuyển hướng đến dashboard
                $this->redirect('dashboard');
            } else {
                // Đăng nhập thất bại
                Session::setFlash('error', 'Tên đăng nhập hoặc mật khẩu không đúng, hoặc bạn không có quyền truy cập!');
            }
        }

        // Hiển thị form đăng nhập
        $data = [
            'title' => 'Đăng nhập',
            'flash' => Session::getFlash()
        ];

        $this->view('auth/login', $data);
    }

    /**
     * Xử lý đăng xuất
     * 
     * @return void
     */
    public function logout()
    {
        // Xóa cookie remember
        if (isset($_COOKIE['admin_remember'])) {
            setcookie('admin_remember', '', time() - 3600, '/');
        }

        // Hủy phiên
        Session::destroy();

        // Chuyển hướng đến trang đăng nhập
        $this->redirect('auth/login');
    }

    /**
     * Xử lý quên mật khẩu
     * 
     * @return void
     */
    public function forgotPassword()
    {
        // Kiểm tra nếu đã đăng nhập, chuyển hướng đến dashboard
        if (Session::isLoggedIn()) {
            $this->redirect('dashboard');
            return;
        }

        // Xử lý form quên mật khẩu nếu có yêu cầu POST
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = trim($_POST['email']);

            // Kiểm tra email tồn tại
            $user = $this->model->getUserByEmail($email);

            if ($user) {
                // Tạo token khôi phục mật khẩu
                $token = bin2hex(random_bytes(32));
                $expires = time() + 1 * 60 * 60; // 1 giờ

                // Lưu token vào database
                $this->model->saveResetToken($user['id'], $token, $expires);

                // Gửi email khôi phục mật khẩu (đoạn code giả định)
                $resetLink = BASE_URL . 'auth/resetPassword/' . $token;
                // mail($email, 'Khôi phục mật khẩu', "Hãy nhấp vào đường dẫn sau để khôi phục mật khẩu: $resetLink");

                // Hiển thị thông báo email đã được gửi
                Session::setFlash('success', 'Đường dẫn khôi phục mật khẩu đã được gửi đến email của bạn. Vui lòng kiểm tra hộp thư.');
            } else {
                // Email không tồn tại
                Session::setFlash('error', 'Không tìm thấy tài khoản với email này.');
            }
        }

        // Hiển thị form quên mật khẩu
        $data = [
            'title' => 'Quên mật khẩu',
            'flash' => Session::getFlash()
        ];

        $this->view('auth/forgot_password', $data);
    }

    /**
     * Xử lý đặt lại mật khẩu
     * 
     * @param string $token Token đặt lại mật khẩu
     * @return void
     */
    public function resetPassword($token = null)
    {
        // Kiểm tra nếu đã đăng nhập, chuyển hướng đến dashboard
        if (Session::isLoggedIn()) {
            $this->redirect('dashboard');
            return;
        }

        // Kiểm tra token
        if (!$token) {
            Session::setFlash('error', 'Token không hợp lệ.');
            $this->redirect('auth/forgotPassword');
            return;
        }

        // Kiểm tra token tồn tại và còn hiệu lực
        $user = $this->model->getUserByResetToken($token);

        if (!$user) {
            Session::setFlash('error', 'Token không hợp lệ hoặc đã hết hạn.');
            $this->redirect('auth/forgotPassword');
            return;
        }

        // Xử lý form đặt lại mật khẩu nếu có yêu cầu POST
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $password = $_POST['password'];
            $confirmPassword = $_POST['confirm_password'];

            // Kiểm tra mật khẩu khớp nhau
            if ($password !== $confirmPassword) {
                Session::setFlash('error', 'Mật khẩu không khớp.');
            } else {
                // Mã hóa mật khẩu mới
                $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

                // Cập nhật mật khẩu và xóa token
                $this->model->updatePassword($user['id'], $hashedPassword);
                $this->model->clearResetToken($user['id']);

                // Hiển thị thông báo thành công
                Session::setFlash('success', 'Mật khẩu đã được đặt lại thành công. Vui lòng đăng nhập với mật khẩu mới.');
                $this->redirect('auth/login');
                return;
            }
        }

        // Hiển thị form đặt lại mật khẩu
        $data = [
            'title' => 'Đặt lại mật khẩu',
            'token' => $token,
            'flash' => Session::getFlash()
        ];

        $this->view('auth/reset_password', $data);
    }

    /**
     * Xử lý chuyển hướng từ tệp cũ sang mới
     * 
     * @return void
     */
    public function legacyRedirect()
    {
        // Kiểm tra nếu đã đăng nhập, chuyển hướng đến dashboard
        if (Session::isLoggedIn()) {
            $this->redirect('dashboard');
            return;
        }

        // Chuyển hướng đến trang đăng nhập mới
        $this->redirect('auth/login');
    }
}
