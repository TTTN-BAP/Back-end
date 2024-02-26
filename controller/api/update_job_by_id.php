<?php
    header('Access-Control-Allow-Origin:*');
    header('Content-Type: application/json');
    header("Access-Control-Allow-Methods: PUT");
    header("Access-Control-Allow-Headers: Access-Control-Allow-Headers, Access-Control-Allow-Methods, Content-Type, X-Requested-With, Authorization");

    include_once('../../config/db_connect.php');
    include_once('../../model/data.php');

    $db = new db();
    $connect = $db->connect();
    $data_job = new Data($connect);

    $method = $_SERVER['REQUEST_METHOD'];
    $data = json_decode(file_get_contents("php://input"), true);

    $job_id = $data['job_id'];
    $job_name = $data['job_name'];
    $id_company = $data['id_company'];
    $company_name = $data['company_name'];
    $job_salary = $data['job_salary'];
    $job_experience = $data['job_experience'];
    $job_level = $data['job_level'];
    $job_expired_date = $data['job_expired_date'];
    $job_details = $data['job_details'];
    $job_required = $data['job_required'];
    $company_logo = $data['company_logo'];
    $job_address = $data['job_address'];


    if ($method=='PUT') {
        if ($job_id !== null) {
            // Cập nhật người dùng
            $data_job->update_job_by_id($job_id, $job_name, $id_company, $company_name, $job_salary, $job_experience, $job_level, $job_expired_date, $job_details, $job_required, $company_logo, $job_address);
        } else {
            // Trả về thông báo lỗi nếu dữ liệu hoặc ID không đúng
            echo json_encode(['message' => 'Invalid data or user ID']);
        }    
    }
    else {
        echo json_encode(['message' => 'Invalid method']);
    }
?>