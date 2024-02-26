<?php
    header('Access-Control-Allow-Origin:*');
    header('Content-Type: application/json');
    header("Access-Control-Allow-Methods: POST");
    header("Access-Control-Allow-Headers: Access-Control-Allow-Headers, Access-Control-Allow-Methods, Content-Type, X-Requested-With, Authorization");

    include_once('../../config/db_connect.php');
    include_once('../../model/data.php');

    $db = new db();
    $connect = $db->connect();
    $data_job = new Data($connect);

    $method = $_SERVER['REQUEST_METHOD'];

    $job_name = $_POST['job_name'];
    $id_company = $_POST['id_company'];
    $company_name = $_POST['company_name'];
    $job_salary = $_POST['job_salary'];
    $job_experience = $_POST['job_experience'];
    $job_level = $_POST['job_level'];
    $job_expired_date = $_POST['job_expired_date'];
    $job_details = $_POST['job_details'];
    $job_required = $_POST['job_required'];
    $company_logo = $_POST['company_logo'];
    $job_address = $_POST['job_address'];

    if ($method=='POST') {
        // Cập nhật người dùng
        if($data_job->create_job($job_name, $id_company, $company_name, $job_salary, $job_experience, $job_level, $job_expired_date, $job_details, $job_required, $company_logo, $job_address)){
            json_encode(['message' => 'Data created']);
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