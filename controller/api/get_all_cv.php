<?php
    header('Access-Control-Allow-Origin:*');
    header('Content-Type: application/json');
    header("Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, X-Requested-With, Authorization");

    include_once('../../config/db_connect.php');
    include_once('../../model/cv.php');

    $db = new db();
    $connect = $db->connect();

    $data_cv = new Cv($connect);
    $method = $_SERVER['REQUEST_METHOD'];
    
    //$data = json_decode(file_get_contents("php://input"), true);
    $page = $_GET['page'];
    $limit   = $_GET['limit'];
    // Tính toán offset để xác định bắt đầu lấy dữ liệu từ bảng
    $offset = ($page - 1) * $limit;

    if ($method=='GET') {
        $read = $data_cv->get_all_cv($page, $offset);
        echo json_encode($read,JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    }
    else {
        echo json_encode(['message' => 'Invalid method']);
    }
?>