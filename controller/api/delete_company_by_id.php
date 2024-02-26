<?php
    header('Access-Control-Allow-Origin:*');
    header('Content-Type: application/json');
    header("Access-Control-Allow-Methods: DELETE");
    header("Access-Control-Allow-Headers: Access-Control-Allow-Headers, Access-Control-Allow-Methods, Content-Type, X-Requested-With, Authorization");

    include_once('../../config/db_connect.php');
    include_once('../../model/company.php');

    $db = new db();
    $connect = $db->connect();
    $data_company = new Company($connect);

    $method = $_SERVER['REQUEST_METHOD'];
    $data = json_decode(file_get_contents("php://input"), true);

    $id_company = $data['id_company'];

    if ($method=='DELETE') {
        if ($id_company !== null) {
            // Cập nhật người dùng
            $data_company->delete_company_by_id($id_company);
        } else {
            // Trả về thông báo lỗi nếu dữ liệu hoặc ID không đúng
            echo json_encode(['message' => 'Invalid data ID']);
        }    
    }
    else {
        echo json_encode(['message' => 'Invalid method']);
    }
?>