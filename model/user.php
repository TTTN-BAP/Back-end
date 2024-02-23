<?php
class User{
    private $conn;
    //properties
    public $email;
    public $username;
    public $password;
    public $role;

    //connect to database
    public function __construct($db){
        $this->conn = $db;
    }
    //read data from database
    public function login($username,$password){
        $query = "SELECT * FROM auth WHERE username = ? and password = ?";
        $stmt = $this->conn->prepare($query);
        // Gán giá trị cho tham số
        $stmt->bind_param("ss", $username,$password);
        $stmt->execute();
        $res = $stmt->get_result();
        $row = $res->fetch_assoc();
        if ($row) {
            // Đăng nhập thành công
            echo json_encode(array("message" => "Đăng nhập thành công"));
            return $row;
        }
        else {
             // Đăng nhập thất bại
            echo json_encode(array("message" => "Đăng nhập thất bại"));
        }
    }

    public function register($email,$username,$password){
        // Kiểm tra xem username và email đã tồn tại trong cơ sở dữ liệu chưa
        $query = "SELECT * FROM auth WHERE username=? OR email=?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("ss", $username,$email);
        $stmt->execute();
        $res = $stmt->get_result();
        $row = $res->fetch_assoc();

        if ($row) {
            // Tài khoản đã tồn tại
            echo json_encode(array("message" => "Tài khoản đã tồn tại"));
        }
        else {
            // Thêm người dùng mới vào cơ sở dữ liệu
            $insert_query = "INSERT INTO auth (email, username, password, role) VALUES (?, ?, ?, 2)";
            $insert_stmt = $this->conn->prepare($insert_query);
            $insert_stmt->bind_param("sss", $email,$username, $password);

            if($insert_stmt->execute()) {
                // Đăng ký thành công
                echo json_encode(array("message" => "Đăng ký thành công"));
            }
            else {
                 // Đăng ký thất bại
                echo json_encode(array("message" => "Đăng ký thất bại"));
            }
        }
    }
}

?>