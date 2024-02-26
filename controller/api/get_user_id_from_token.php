<?php
    header('Access-Control-Allow-Origin:*');
    header('Content-Type: application/json');
    header("Access-Control-Allow-Methods: POST");
    header("Access-Control-Allow-Headers: Access-Control-Allow-Headers, Access-Control-Allow-Methods, Content-Type, X-Requested-With, Authorization");

    include_once('../../config/db_connect.php');
    include_once('../../model/user.php');

    $db = new db();
    $connect = $db->connect();
    $data_acc = new User($connect);
    
    // Lấy dữ liệu từ yêu cầu POST
    $method = $_SERVER['REQUEST_METHOD'];

    if ($method=='POST') {
        $token = $_POST['token'];
        if ($token){
            $response = $data_acc->getUserIDFromToken($token);
            // if ($acc) echo json_encode(['username' => $acc['username']]);
            echo json_encode(array("id" => $response));
        }
        else {
            echo json_encode(array("message" => "Dữ liệu không hợp lệ"));
        }
    }
    

?>