<?php
    header('Access-Control-Allow-Origin:*');
    header('Content-Type: application/json');
    header("Access-Control-Allow-Methods: POST");
    header("Access-Control-Allow-Headers: Access-Control-Allow-Headers, Access-Control-Allow-Methods, Content-Type, X-Requested-With, Authorization");

    include_once('../../config/db_connect.php');
    include_once('../../model/company.php');

    $db = new db();
    $connect = $db->connect();
    $data_company = new Company($connect);

    $method = $_SERVER['REQUEST_METHOD'];

    $company_name = $_POST['company_name'];
    $company_address = $_POST['company_address'];
    $company_size = $_POST['company_size'];
    $company_website = $_POST['company_website'];
    $company_type = $_POST['company_type'];
    $company_details = $_POST['company_details'];
    $company_logo = $_POST['company_logo'];

    if ($method=='POST') {
        // Cập nhật người dùng
        if($data_company->create_company($company_name, $company_address, $company_size, $company_website, $company_type, $company_details, $company_logo)){
            json_encode(['message' => 'Company created']);
        }
        else{
            // Trả về thông báo lỗi nếu dữ liệu hoặc ID không đúng 
            echo json_encode(['message' => 'Invalid data']);
        }
    }
    else {
        echo json_encode(['message' => 'Invalid method']);
    }
?>