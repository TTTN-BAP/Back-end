<?php
    header('Access-Control-Allow-Origin:*');
    header('Content-Type: application/json');
    header("Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, X-Requested-With, Authorization");

    include_once('../../config/db_connect.php');
    include_once('../../model/data.php');

    $db = new db();
    $connect = $db->connect();
    $data_job = new Data($connect);
    $method = $_SERVER['REQUEST_METHOD'];
    //$data = json_decode(file_get_contents("php://input"), true);
    $page = $_GET['page'];
    $limit   = $_GET['limit'];
    // Tính toán offset để xác định bắt đầu lấy dữ liệu từ bảng
    $offset = ($page - 1) * $limit;
    if ($method=='GET') {
        $read = $data_job->get_all_job($limit, $offset);
        // Lấy tổng số dữ liệu
        $totalData = $data_job->get_total_data(); 
        // Tính toán số lượng trang
        $totalPages = ceil($totalData / $limit);
        $response = array(
            'totalPages' => $totalPages,
            'data' => $read
        );
        echo json_encode($response, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    }
    else {
        echo json_encode(['message' => 'Invalid method']);
    }
?>