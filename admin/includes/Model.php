<?php

/**
 * Class Model
 * 
 * Lớp cơ sở cho tất cả các model
 */
abstract class Model
{
    protected $db;
    protected $table;
    protected $primaryKey = 'id';

    /**
     * Khởi tạo model
     * 
     * @param Database $db Đối tượng Database
     */
    public function __construct(Database $db)
    {
        $this->db = $db;

        // Nếu không có tên bảng, sử dụng tên class thường
        if (!$this->table) {
            $this->table = strtolower(str_replace('Model', '', get_class($this))) . 's';
        }
    }

    /**
     * Lấy tất cả các bản ghi
     * 
     * @param array $columns Các cột cần lấy
     * @param string $orderBy Sắp xếp theo
     * @param string $orderDir Hướng sắp xếp
     * @param int $limit Giới hạn số lượng
     * @param int $offset Offset
     * @return array Danh sách bản ghi
     */
    public function getAll($columns = ['*'], $orderBy = null, $orderDir = 'ASC', $limit = null, $offset = null)
    {
        // Xây dựng câu truy vấn
        $columnsStr = implode(', ', $columns);
        $query = "SELECT {$columnsStr} FROM {$this->table}";

        // Thêm ORDER BY nếu có
        if ($orderBy) {
            $query .= " ORDER BY {$orderBy} {$orderDir}";
        }

        // Thêm LIMIT nếu có
        if ($limit) {
            $query .= " LIMIT {$limit}";

            // Thêm OFFSET nếu có
            if ($offset) {
                $query .= " OFFSET {$offset}";
            }
        }

        // Thực thi truy vấn
        $this->db->query($query);
        return $this->db->fetchAll();
    }

    /**
     * Lấy một bản ghi theo ID
     * 
     * @param int $id ID của bản ghi
     * @param array $columns Các cột cần lấy
     * @return array|boolean Bản ghi hoặc false nếu không tìm thấy
     */
    public function getById($id, $columns = ['*'])
    {
        // Xây dựng câu truy vấn
        $columnsStr = implode(', ', $columns);
        $query = "SELECT {$columnsStr} FROM {$this->table} WHERE {$this->primaryKey} = :id";

        // Thực thi truy vấn
        $this->db->query($query);
        $this->db->bind(':id', $id);

        $result = $this->db->fetch();
        return $result ? $result : false;
    }

    /**
     * Lấy bản ghi theo điều kiện
     * 
     * @param array $conditions Điều kiện dưới dạng mảng key=>value
     * @param array $columns Các cột cần lấy
     * @param string $operator Toán tử (AND, OR)
     * @return array Danh sách bản ghi
     */
    public function getBy($conditions, $columns = ['*'], $operator = 'AND')
    {
        // Xây dựng câu truy vấn
        $columnsStr = implode(', ', $columns);
        $query = "SELECT {$columnsStr} FROM {$this->table} WHERE ";

        // Xây dựng phần WHERE
        $whereConditions = [];
        $params = [];

        foreach ($conditions as $key => $value) {
            $paramName = ':' . $key;
            $whereConditions[] = "{$key} = {$paramName}";
            $params[$paramName] = $value;
        }

        $query .= implode(" {$operator} ", $whereConditions);

        // Thực thi truy vấn
        $this->db->query($query);

        // Bind các tham số
        foreach ($params as $key => $value) {
            $this->db->bind($key, $value);
        }

        return $this->db->fetchAll();
    }

    /**
     * Lấy một bản ghi theo điều kiện
     * 
     * @param array $conditions Điều kiện dưới dạng mảng key=>value
     * @param array $columns Các cột cần lấy
     * @param string $operator Toán tử (AND, OR)
     * @return array|boolean Bản ghi hoặc false nếu không tìm thấy
     */
    public function getOneBy($conditions, $columns = ['*'], $operator = 'AND')
    {
        $results = $this->getBy($conditions, $columns, $operator);
        return !empty($results) ? $results[0] : false;
    }

    /**
     * Tạo bản ghi mới
     * 
     * @param array $data Dữ liệu cần chèn
     * @return int|boolean ID của bản ghi mới hoặc false nếu thất bại
     */
    public function create($data)
    {
        // Xây dựng câu truy vấn
        $columns = implode(', ', array_keys($data));
        $placeholders = ':' . implode(', :', array_keys($data));

        $query = "INSERT INTO {$this->table} ({$columns}) VALUES ({$placeholders})";

        // Thực thi truy vấn
        $this->db->query($query);

        // Bind các tham số
        foreach ($data as $key => $value) {
            $this->db->bind(':' . $key, $value);
        }

        // Thực thi và kiểm tra kết quả
        if ($this->db->execute()) {
            return $this->db->lastInsertId();
        }

        return false;
    }

    /**
     * Cập nhật bản ghi
     * 
     * @param int $id ID của bản ghi
     * @param array $data Dữ liệu cần cập nhật
     * @return boolean Kết quả cập nhật
     */
    public function update($id, $data)
    {
        // Xây dựng câu truy vấn
        $setParts = [];

        foreach (array_keys($data) as $key) {
            $setParts[] = "{$key} = :{$key}";
        }

        $setClause = implode(', ', $setParts);
        $query = "UPDATE {$this->table} SET {$setClause} WHERE {$this->primaryKey} = :id";

        // Thực thi truy vấn
        $this->db->query($query);

        // Bind các tham số
        foreach ($data as $key => $value) {
            $this->db->bind(':' . $key, $value);
        }
        $this->db->bind(':id', $id);

        // Thực thi và kiểm tra kết quả
        return $this->db->execute();
    }

    /**
     * Xóa bản ghi
     * 
     * @param int $id ID của bản ghi
     * @return boolean Kết quả xóa
     */
    public function delete($id)
    {
        // Xây dựng câu truy vấn
        $query = "DELETE FROM {$this->table} WHERE {$this->primaryKey} = :id";

        // Thực thi truy vấn
        $this->db->query($query);
        $this->db->bind(':id', $id);

        // Thực thi và kiểm tra kết quả
        return $this->db->execute();
    }

    /**
     * Đếm số lượng bản ghi
     * 
     * @param array $conditions Điều kiện dưới dạng mảng key=>value
     * @param string $operator Toán tử (AND, OR)
     * @return int Số lượng bản ghi
     */
    public function count($conditions = [], $operator = 'AND')
    {
        // Xây dựng câu truy vấn
        $query = "SELECT COUNT(*) as count FROM {$this->table}";

        // Thêm WHERE nếu có điều kiện
        if (!empty($conditions)) {
            $query .= " WHERE ";

            // Xây dựng phần WHERE
            $whereConditions = [];
            $params = [];

            foreach ($conditions as $key => $value) {
                $paramName = ':' . $key;
                $whereConditions[] = "{$key} = {$paramName}";
                $params[$paramName] = $value;
            }

            $query .= implode(" {$operator} ", $whereConditions);

            // Thực thi truy vấn
            $this->db->query($query);

            // Bind các tham số
            foreach ($params as $key => $value) {
                $this->db->bind($key, $value);
            }
        } else {
            // Thực thi truy vấn không có điều kiện
            $this->db->query($query);
        }

        $result = $this->db->fetch();
        return (int) $result['count'];
    }

    /**
     * Thực thi truy vấn tùy chỉnh
     * 
     * @param string $query Câu truy vấn SQL
     * @param array $params Các tham số cần bind
     * @return array Kết quả truy vấn
     */
    public function query($query, $params = [])
    {
        // Thực thi truy vấn
        $this->db->query($query);

        // Bind các tham số
        foreach ($params as $key => $value) {
            $this->db->bind($key, $value);
        }

        return $this->db->fetchAll();
    }
}
