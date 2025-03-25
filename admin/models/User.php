<?php

/**
 * Class User
 * 
 * Model xử lý dữ liệu người dùng
 */
class User extends Model
{
    protected $table = 'users';

    /**
     * Lấy người dùng theo tên đăng nhập
     * 
     * @param string $username Tên đăng nhập
     * @return array|boolean Thông tin người dùng hoặc false nếu không tìm thấy
     */
    public function getUserByUsername($username)
    {
        return $this->getOneBy(['username' => $username]);
    }

    /**
     * Lấy người dùng theo email
     * 
     * @param string $email Email
     * @return array|boolean Thông tin người dùng hoặc false nếu không tìm thấy
     */
    public function getUserByEmail($email)
    {
        return $this->getOneBy(['email' => $email]);
    }

    /**
     * Lưu token đăng nhập tự động
     * 
     * @param int $userId ID người dùng
     * @param string $token Token
     * @param int $expires Thời gian hết hạn
     * @return boolean Kết quả
     */
    public function saveRememberToken($userId, $token, $expires)
    {
        // Xóa token cũ nếu có
        $this->db->query("DELETE FROM user_tokens WHERE user_id = :user_id AND type = 'remember'");
        $this->db->bind(':user_id', $userId);
        $this->db->execute();

        // Lưu token mới
        $this->db->query("INSERT INTO user_tokens (user_id, token, expires, type) VALUES (:user_id, :token, FROM_UNIXTIME(:expires), 'remember')");
        $this->db->bind(':user_id', $userId);
        $this->db->bind(':token', $token);
        $this->db->bind(':expires', $expires);
        return $this->db->execute();
    }

    /**
     * Lấy người dùng từ token đăng nhập tự động
     * 
     * @param string $token Token
     * @return array|boolean Thông tin người dùng hoặc false nếu không tìm thấy
     */
    public function getUserByRememberToken($token)
    {
        $this->db->query("
            SELECT u.* 
            FROM users u 
            JOIN user_tokens t ON u.id = t.user_id 
            WHERE t.token = :token 
            AND t.type = 'remember' 
            AND t.expires > NOW()
        ");
        $this->db->bind(':token', $token);
        return $this->db->fetch();
    }

    /**
     * Lưu token đặt lại mật khẩu
     * 
     * @param int $userId ID người dùng
     * @param string $token Token
     * @param int $expires Thời gian hết hạn
     * @return boolean Kết quả
     */
    public function saveResetToken($userId, $token, $expires)
    {
        // Xóa token cũ nếu có
        $this->db->query("DELETE FROM user_tokens WHERE user_id = :user_id AND type = 'reset'");
        $this->db->bind(':user_id', $userId);
        $this->db->execute();

        // Lưu token mới
        $this->db->query("INSERT INTO user_tokens (user_id, token, expires, type) VALUES (:user_id, :token, FROM_UNIXTIME(:expires), 'reset')");
        $this->db->bind(':user_id', $userId);
        $this->db->bind(':token', $token);
        $this->db->bind(':expires', $expires);
        return $this->db->execute();
    }

    /**
     * Lấy người dùng từ token đặt lại mật khẩu
     * 
     * @param string $token Token
     * @return array|boolean Thông tin người dùng hoặc false nếu không tìm thấy
     */
    public function getUserByResetToken($token)
    {
        $this->db->query("
            SELECT u.* 
            FROM users u 
            JOIN user_tokens t ON u.id = t.user_id 
            WHERE t.token = :token 
            AND t.type = 'reset' 
            AND t.expires > NOW()
        ");
        $this->db->bind(':token', $token);
        return $this->db->fetch();
    }

    /**
     * Cập nhật mật khẩu
     * 
     * @param int $userId ID người dùng
     * @param string $password Mật khẩu đã được mã hóa
     * @return boolean Kết quả
     */
    public function updatePassword($userId, $password)
    {
        return $this->update($userId, ['password' => $password]);
    }

    /**
     * Xóa token đặt lại mật khẩu
     * 
     * @param int $userId ID người dùng
     * @return boolean Kết quả
     */
    public function clearResetToken($userId)
    {
        $this->db->query("DELETE FROM user_tokens WHERE user_id = :user_id AND type = 'reset'");
        $this->db->bind(':user_id', $userId);
        return $this->db->execute();
    }

    /**
     * Lấy danh sách người dùng theo vai trò
     * 
     * @param string $role Vai trò (admin, user, ...)
     * @param int $limit Giới hạn số lượng
     * @param int $offset Offset
     * @return array Danh sách người dùng
     */
    public function getUsersByRole($role, $limit = null, $offset = null)
    {
        return $this->getBy(['role' => $role], ['*'], 'AND', 'created_at', 'DESC', $limit, $offset);
    }

    /**
     * Tìm kiếm người dùng
     * 
     * @param string $keyword Từ khóa tìm kiếm
     * @param int $limit Giới hạn số lượng
     * @param int $offset Offset
     * @return array Danh sách người dùng
     */
    public function searchUsers($keyword, $limit = null, $offset = null)
    {
        $keyword = '%' . $keyword . '%';

        $this->db->query("
            SELECT * FROM {$this->table}
            WHERE username LIKE :keyword
            OR email LIKE :keyword
            ORDER BY created_at DESC
        " . ($limit ? " LIMIT {$limit}" : '') . ($offset ? " OFFSET {$offset}" : ''));

        $this->db->bind(':keyword', $keyword);
        return $this->db->fetchAll();
    }

    /**
     * Cập nhật trạng thái người dùng
     * 
     * @param int $userId ID người dùng
     * @param string $status Trạng thái (active, inactive)
     * @return boolean Kết quả
     */
    public function updateStatus($userId, $status)
    {
        return $this->update($userId, ['status' => $status]);
    }
}
