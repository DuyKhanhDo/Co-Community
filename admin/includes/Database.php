<?php

/**
 * Class Database
 * 
 * Lớp xử lý kết nối và truy vấn cơ sở dữ liệu
 */
class Database
{
    private $host = DB_HOST;
    private $user = DB_USER;
    private $pass = DB_PASS;
    private $dbname = DB_NAME;

    private $conn;
    private $error;
    private $stmt;

    /**
     * Khởi tạo kết nối đến cơ sở dữ liệu
     */
    public function __construct()
    {
        // Thiết lập DSN
        $dsn = 'mysql:host=' . $this->host . ';dbname=' . $this->dbname . ';charset=utf8mb4';

        // Thiết lập các tùy chọn PDO
        $options = array(
            PDO::ATTR_PERSISTENT => true,
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false
        );

        // Tạo một instance PDO
        try {
            $this->conn = new PDO($dsn, $this->user, $this->pass, $options);
        } catch (PDOException $e) {
            $this->error = $e->getMessage();
            echo 'Lỗi kết nối: ' . $this->error;
        }
    }

    /**
     * Chuẩn bị câu truy vấn
     * 
     * @param string $query Câu truy vấn SQL
     * @return void
     */
    public function query($query)
    {
        $this->stmt = $this->conn->prepare($query);
    }

    /**
     * Bind các giá trị vào câu truy vấn
     * 
     * @param string $param Tên tham số
     * @param mixed $value Giá trị tham số
     * @param mixed $type Kiểu dữ liệu (tùy chọn)
     * @return void
     */
    public function bind($param, $value, $type = null)
    {
        if (is_null($type)) {
            switch (true) {
                case is_int($value):
                    $type = PDO::PARAM_INT;
                    break;
                case is_bool($value):
                    $type = PDO::PARAM_BOOL;
                    break;
                case is_null($value):
                    $type = PDO::PARAM_NULL;
                    break;
                default:
                    $type = PDO::PARAM_STR;
            }
        }
        $this->stmt->bindValue($param, $value, $type);
    }

    /**
     * Thực thi câu truy vấn
     * 
     * @return boolean
     */
    public function execute()
    {
        return $this->stmt->execute();
    }

    /**
     * Lấy tất cả các kết quả dưới dạng mảng liên kết
     * 
     * @return array
     */
    public function fetchAll()
    {
        $this->execute();
        return $this->stmt->fetchAll();
    }

    /**
     * Lấy một kết quả duy nhất dưới dạng mảng liên kết
     * 
     * @return array
     */
    public function fetch()
    {
        $this->execute();
        return $this->stmt->fetch();
    }

    /**
     * Đếm số hàng bị ảnh hưởng
     * 
     * @return int
     */
    public function rowCount()
    {
        return $this->stmt->rowCount();
    }

    /**
     * Lấy ID của bản ghi vừa được chèn
     * 
     * @return int
     */
    public function lastInsertId()
    {
        return $this->conn->lastInsertId();
    }

    /**
     * Bắt đầu một giao dịch
     * 
     * @return void
     */
    public function beginTransaction()
    {
        $this->conn->beginTransaction();
    }

    /**
     * Commit một giao dịch
     * 
     * @return void
     */
    public function commit()
    {
        $this->conn->commit();
    }

    /**
     * Rollback một giao dịch
     * 
     * @return void
     */
    public function rollBack()
    {
        $this->conn->rollBack();
    }
}
