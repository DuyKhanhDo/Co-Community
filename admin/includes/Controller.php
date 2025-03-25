<?php

/**
 * Class Controller
 * 
 * Lớp cơ sở cho tất cả các controller
 */
abstract class Controller
{
    protected $db;
    protected $view;
    protected $model;
    protected $params = [];

    /**
     * Khởi tạo controller
     */
    public function __construct()
    {
        // Khởi tạo kết nối database
        $this->db = new Database();

        // Xác thực phiên làm việc
        Session::init();

        // Kiểm tra đăng nhập cho tất cả các controller trừ AuthController
        if (get_class($this) !== 'AuthController' && !Session::isLoggedIn()) {
            header("Location: " . BASE_URL . "auth/login");
            exit;
        }
    }

    /**
     * Tải model
     * 
     * @param string $model Tên model
     * @return object Model
     */
    public function loadModel($model)
    {
        // Kiểm tra file model tồn tại
        $modelFile = ROOT_PATH . '/models/' . $model . '.php';

        if (file_exists($modelFile)) {
            require_once $modelFile;

            // Khởi tạo model
            $this->model = new $model($this->db);
            return $this->model;
        } else {
            // Báo lỗi nếu model không tồn tại
            die("Model không tồn tại: " . $model);
        }
    }

    /**
     * Hiển thị view
     * 
     * @param string $view Đường dẫn đến view
     * @param array $data Dữ liệu truyền cho view
     * @param boolean $returnAsString Trả về dưới dạng chuỗi thay vì xuất ra
     * @return mixed View rendering
     */
    public function view($view, $data = [], $returnAsString = false)
    {
        // Nếu trả về dưới dạng chuỗi, bật output buffering
        if ($returnAsString) {
            ob_start();
        }

        // Giải nén dữ liệu để sử dụng trong view
        extract($data);

        // Tải các view
        $viewPath = ROOT_PATH . '/views/' . $view . '.php';

        if (file_exists($viewPath)) {
            require_once $viewPath;
        } else {
            // Báo lỗi nếu view không tồn tại
            die("View không tồn tại: " . $view);
        }

        // Trả về nội dung buffer nếu cần
        if ($returnAsString) {
            return ob_get_clean();
        }
    }

    /**
     * Hiển thị layout với nội dung
     * 
     * @param string $content Nội dung cần hiển thị
     * @param array $data Dữ liệu truyền cho layout
     * @param string $layout Tên layout (mặc định là 'default')
     * @return void
     */
    public function renderLayout($content, $data = [], $layout = 'default')
    {
        // Thêm nội dung vào dữ liệu
        $data['content'] = $content;

        // Tải layout
        $this->view('layouts/' . $layout, $data);
    }

    /**
     * Hiển thị view bên trong layout
     * 
     * @param string $view Đường dẫn đến view
     * @param array $data Dữ liệu truyền cho view
     * @param string $layout Tên layout (mặc định là 'default')
     * @return void
     */
    public function render($view, $data = [], $layout = 'default')
    {
        // Tạo nội dung view
        $content = $this->view($view, $data, true);

        // Hiển thị layout với nội dung
        $this->renderLayout($content, $data, $layout);
    }

    /**
     * Chuyển hướng đến một URL
     * 
     * @param string $url URL đích
     * @return void
     */
    public function redirect($url)
    {
        header("Location: " . BASE_URL . $url);
        exit;
    }

    /**
     * Thiết lập tham số
     * 
     * @param array $params Tham số
     * @return void
     */
    public function setParams($params)
    {
        $this->params = $params;
    }
}
