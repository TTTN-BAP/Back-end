<?php
    header('Access-Control-Allow-Origin:*');
    header('Content-Type: application/json');
    header("Access-Control-Allow-Methods: PUT");
    header("Access-Control-Allow-Headers: Access-Control-Allow-Headers, Access-Control-Allow-Methods, Content-Type, X-Requested-With, Authorization");

    include_once('../../config/db_connect.php');
    include_once('../../model/cv.php');

    $db = new db();
    $connect = $db->connect();
    $data_cv = new Cv($connect);

    $method = $_SERVER['REQUEST_METHOD'];
    $data = json_decode(file_get_contents("php://input"), true);

    $id_cv = $data['id_cv'];
    $cv_name = $data['cv_name'];
    $cv_birthday = $data['cv_birthday'];
    $cv_email = $data['cv_email'];
    $cv_sdt = $data['cv_sdt'];
    $cv_target = $data['cv_target'];
    $cv_academi_level = $data['cv_academi_level'];
    $cv_work_experience = $data['cv_work_experience'];
    $cv_skill = $data['cv_skill'];
    $cv_interest = $data['cv_interest'];

    if ($method=='PUT') {
        if ($id_cv !== null) {
            // Cập nhật người dùng
            $data_cv->update_cv_by_id($id_cv,$cv_name, $cv_birthday, $cv_email, $cv_sdt, $cv_target, $cv_academi_level, $cv_work_experience, $cv_skill, $cv_interest);
        } else {
            // Trả về thông báo lỗi nếu dữ liệu hoặc ID không đúng
            echo json_encode(['message' => 'Invalid data or ID']);
        }    
    }
    else {
        echo json_encode(['message' => 'Invalid method']);
    }
?>