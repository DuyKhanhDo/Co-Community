<?php

/**
 * Class Dashboard
 * 
 * Model xử lý dữ liệu cho trang tổng quan
 */
class Dashboard extends Model
{
    /**
     * Đếm số lượng phim
     * 
     * @return int Số lượng phim
     */
    public function countMovies()
    {
        $this->db->query("SELECT COUNT(*) as count FROM movies");
        $result = $this->db->fetch();
        return (int) $result['count'];
    }

    /**
     * Đếm số lượng người dùng
     * 
     * @return int Số lượng người dùng
     */
    public function countUsers()
    {
        $this->db->query("SELECT COUNT(*) as count FROM users");
        $result = $this->db->fetch();
        return (int) $result['count'];
    }

    /**
     * Đếm số lượng thể loại
     * 
     * @return int Số lượng thể loại
     */
    public function countCategories()
    {
        $this->db->query("SELECT COUNT(*) as count FROM categories");
        $result = $this->db->fetch();
        return (int) $result['count'];
    }

    /**
     * Đếm số lượng bình luận
     * 
     * @return int Số lượng bình luận
     */
    public function countComments()
    {
        $this->db->query("SELECT COUNT(*) as count FROM comments");
        $result = $this->db->fetch();
        return (int) $result['count'];
    }

    /**
     * Lấy danh sách phim mới nhất
     * 
     * @param int $limit Giới hạn số lượng
     * @return array Danh sách phim
     */
    public function getLatestMovies($limit = 5)
    {
        $this->db->query("SELECT * FROM movies ORDER BY created_at DESC LIMIT :limit");
        $this->db->bind(':limit', $limit);
        return $this->db->fetchAll();
    }

    /**
     * Lấy danh sách người dùng mới nhất
     * 
     * @param int $limit Giới hạn số lượng
     * @return array Danh sách người dùng
     */
    public function getLatestUsers($limit = 5)
    {
        $this->db->query("SELECT * FROM users ORDER BY created_at DESC LIMIT :limit");
        $this->db->bind(':limit', $limit);
        return $this->db->fetchAll();
    }

    /**
     * Tìm kiếm phim
     * 
     * @param string $keyword Từ khóa tìm kiếm
     * @param int $limit Giới hạn số lượng
     * @return array Danh sách phim
     */
    public function searchMovies($keyword, $limit = 10)
    {
        $keyword = '%' . $keyword . '%';

        $this->db->query("
            SELECT * FROM movies
            WHERE title LIKE :keyword
            OR original_title LIKE :keyword
            OR description LIKE :keyword
            ORDER BY created_at DESC
            LIMIT :limit
        ");

        $this->db->bind(':keyword', $keyword);
        $this->db->bind(':limit', $limit);
        return $this->db->fetchAll();
    }

    /**
     * Tìm kiếm người dùng
     * 
     * @param string $keyword Từ khóa tìm kiếm
     * @param int $limit Giới hạn số lượng
     * @return array Danh sách người dùng
     */
    public function searchUsers($keyword, $limit = 10)
    {
        $keyword = '%' . $keyword . '%';

        $this->db->query("
            SELECT * FROM users
            WHERE username LIKE :keyword
            OR email LIKE :keyword
            ORDER BY created_at DESC
            LIMIT :limit
        ");

        $this->db->bind(':keyword', $keyword);
        $this->db->bind(':limit', $limit);
        return $this->db->fetchAll();
    }

    /**
     * Tìm kiếm thể loại
     * 
     * @param string $keyword Từ khóa tìm kiếm
     * @param int $limit Giới hạn số lượng
     * @return array Danh sách thể loại
     */
    public function searchCategories($keyword, $limit = 10)
    {
        $keyword = '%' . $keyword . '%';

        $this->db->query("
            SELECT * FROM categories
            WHERE name LIKE :keyword
            OR description LIKE :keyword
            ORDER BY name ASC
            LIMIT :limit
        ");

        $this->db->bind(':keyword', $keyword);
        $this->db->bind(':limit', $limit);
        return $this->db->fetchAll();
    }

    /**
     * Xóa phim
     * 
     * @param int $id ID phim
     * @return boolean Kết quả
     */
    public function deleteMovie($id)
    {
        $this->db->query("DELETE FROM movies WHERE id = :id");
        $this->db->bind(':id', $id);
        return $this->db->execute();
    }

    /**
     * Xóa người dùng
     * 
     * @param int $id ID người dùng
     * @return boolean Kết quả
     */
    public function deleteUser($id)
    {
        $this->db->query("DELETE FROM users WHERE id = :id");
        $this->db->bind(':id', $id);
        return $this->db->execute();
    }

    /**
     * Xóa thể loại
     * 
     * @param int $id ID thể loại
     * @return boolean Kết quả
     */
    public function deleteCategory($id)
    {
        $this->db->query("DELETE FROM categories WHERE id = :id");
        $this->db->bind(':id', $id);
        return $this->db->execute();
    }
}
