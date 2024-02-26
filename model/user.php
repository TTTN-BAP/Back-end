<?php
require '../../config/vendor/autoload.php'; // Đường dẫn đến autoload.php của thư viện JWT

use Firebase\JWT\JWT;
use \Firebase\JWT\Key;
class User{
    private $conn;
    //properties
    public $email;
    public $username;
    public $password;
    public $role;
    private $secretKey = "job_recommender";
    private $hash = "HS256";
    private $key;
    //connect to database
    public function __construct($db){
        $this->conn = $db;
        //$this->key = new Key($this->secretKey, $this->hash);
    }
    //read data from database
    private function generateToken($user_id) {
        $issuedAt = time();
        $expirationTime = $issuedAt + 60 * 60; // Token hết hạn sau 1 giờ

        $payload = array(
            "user_id" => $user_id,
            "iat" => $issuedAt,
            "exp" => $expirationTime
        );

        return JWT::encode($payload, $this->secretKey, $this->hash);
    }
    public function getUserIDFromToken($token) {
        try {
            $decoded = JWT::decode($token, new Key($this->secretKey, 'HS256'));
            return $decoded->user_id;
        } catch (Exception $e) {
            // Xử lý lỗi giải mã token nếu cần
            return null;
        }
    }
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
            $user_id = $row['id']; // Thay thế bằng ID của người dùng được đăng nhập
            // Tạo token
            $token = $this->generateToken($user_id);
            //echo json_encode(array("message" => "Đăng nhập thành công"));
            return json_encode(array("Role" => $row['role'], "token" => $token));
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
            $stmt->close();
        }
        else {
            // Thêm người dùng mới vào cơ sở dữ liệu
            $insert_query = "INSERT INTO auth (email, username, password, role) VALUES (?, ?, ?, 2)";
            $insert_stmt = $this->conn->prepare($insert_query);
            $insert_stmt->bind_param("sss", $email,$username, $password);

            if($insert_stmt->execute()) {
                // Đăng ký thành công
                $accountID = $insert_stmt->insert_id;
                $insert_stmt->close();
                $queryUserInfo = "INSERT INTO cv_info (id) VALUES (?)";
                $stmtUserInfo = $this->conn->prepare($queryUserInfo);
                $stmtUserInfo->bind_param("i", $accountID);
                $stmtUserInfo->execute();
                $stmtUserInfo->close();
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