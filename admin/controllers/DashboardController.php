<?php

/**
 * Class DashboardController
 * 
 * Controller quản lý trang tổng quan
 */
class DashboardController extends Controller
{
    /**
     * Khởi tạo controller
     */
    public function __construct()
    {
        parent::__construct();
        $this->loadModel('Dashboard');
    }

    /**
     * Hiển thị trang tổng quan
     * 
     * @return void
     */
    public function index()
    {
        // Lấy thống kê
        $stats = [
            'total_movies' => $this->model->countMovies(),
            'total_users' => $this->model->countUsers(),
            'total_categories' => $this->model->countCategories(),
            'total_comments' => $this->model->countComments()
        ];

        // Lấy danh sách phim mới nhất
        $latestMovies = $this->model->getLatestMovies(5);

        // Lấy danh sách người dùng mới nhất
        $latestUsers = $this->model->getLatestUsers(5);

        // Truyền dữ liệu cho view
        $data = [
            'title' => 'Tổng quan',
            'stats' => $stats,
            'latest_movies' => $latestMovies,
            'latest_users' => $latestUsers,
            'flash' => Session::getFlash()
        ];

        // Hiển thị view
        $this->render('dashboard/index', $data);
    }

    /**
     * Xử lý tìm kiếm
     * 
     * @return void
     */
    public function search()
    {
        // Lấy từ khóa tìm kiếm
        $keyword = isset($_GET['q']) ? trim($_GET['q']) : '';

        if (empty($keyword)) {
            $this->redirect('dashboard');
            return;
        }

        // Tìm kiếm phim
        $movies = $this->model->searchMovies($keyword, 10);

        // Tìm kiếm người dùng
        $users = $this->model->searchUsers($keyword, 10);

        // Tìm kiếm thể loại
        $categories = $this->model->searchCategories($keyword, 10);

        // Truyền dữ liệu cho view
        $data = [
            'title' => 'Kết quả tìm kiếm: ' . $keyword,
            'keyword' => $keyword,
            'movies' => $movies,
            'users' => $users,
            'categories' => $categories,
            'flash' => Session::getFlash()
        ];

        // Hiển thị view
        $this->render('dashboard/search', $data);
    }

    /**
     * Xóa dữ liệu
     * 
     * @param string $type Loại dữ liệu (movie, user, category)
     * @param int $id ID
     * @return void
     */
    public function delete($type = null, $id = null)
    {
        // Kiểm tra tham số
        if (!$type || !$id) {
            Session::setFlash('error', 'Tham số không hợp lệ.');
            $this->redirect('dashboard');
            return;
        }

        // Xử lý xóa dữ liệu theo loại
        $result = false;
        $message = '';

        switch ($type) {
            case 'movie':
                $result = $this->model->deleteMovie($id);
                $message = 'phim';
                break;
            case 'user':
                $result = $this->model->deleteUser($id);
                $message = 'người dùng';
                break;
            case 'category':
                $result = $this->model->deleteCategory($id);
                $message = 'thể loại';
                break;
            default:
                Session::setFlash('error', 'Loại dữ liệu không hợp lệ.');
                $this->redirect('dashboard');
                return;
        }

        // Hiển thị thông báo
        if ($result) {
            Session::setFlash('success', 'Đã xóa ' . $message . ' thành công.');
        } else {
            Session::setFlash('error', 'Có lỗi xảy ra khi xóa ' . $message . '.');
        }

        // Chuyển hướng về trang trước
        $this->redirect($_SERVER['HTTP_REFERER'] ?? 'dashboard');
    }

    /**
     * Xử lý chuyển hướng từ admin_panel.php cũ
     * 
     * @return void
     */
    public function legacyRedirect()
    {
        // Lấy action từ URL
        $legacyAction = isset($_GET['action']) ? $_GET['action'] : 'dashboard';

        // Chuyển hướng đến trang tương ứng
        switch ($legacyAction) {
            case 'movies':
                $this->redirect('movies');
                break;
            case 'users':
                $this->redirect('users');
                break;
            case 'categories':
                $this->redirect('categories');
                break;
            case 'settings':
                $this->redirect('settings');
                break;
            case 'edit_movie':
                $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
                if ($id > 0) {
                    $this->redirect('movies/edit/' . $id);
                } else {
                    $this->redirect('movies');
                }
                break;
            default:
                $this->redirect('dashboard');
                break;
        }
    }
}
