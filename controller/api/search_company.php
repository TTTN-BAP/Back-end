<?php
    header('Access-Control-Allow-Origin:*');
    header('Content-Type: application/json');
    header("Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, X-Requested-With, Authorization");
    
    include_once('../../config/db_connect.php');
    include_once('../../model/company.php');

    $db = new db();
    $connect = $db->connect();
    $data_company = new Company($connect);

    $method = $_SERVER['REQUEST_METHOD'];
    $company_info = $_GET['company_name'];
    $page = $_GET['page'];
    $limit   = $_GET['limit'];
    // Tính toán offset để xác định bắt đầu lấy dữ liệu từ bảng
    $offset = ($page - 1) * $limit;

    if ($method=='GET') {
        $data = $data_company->search_company($company_info, $limit, $offset);
        if($data){
            // Lấy tổng số dữ liệu
            $totalData = $data_company->get_total_search_company($company_info); 
            // Tính toán số lượng trang
            $totalPages = ceil($totalData / $limit);
            $response = array(
                'totalPages' => $totalPages,
                'data' => $data
            );
            echo json_encode($response,JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        }
        else {
            echo json_encode(array("message" => "Could not find company"));
        }
    }
?>