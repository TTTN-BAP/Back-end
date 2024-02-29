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
    $data = json_decode(file_get_contents("php://input"), true);

    $username = addslashes(strip_tags($data['username']));
    $password = addslashes(strip_tags($data['password']));

    if ($method=='POST') {
        if (($username) && ($password)){
            $response = $data_acc->login($username,$password);
            // if ($acc) echo json_encode(['username' => $acc['username']]);
            echo $response;
        }
        else {
            echo json_encode(array("message" => "Dữ liệu không hợp lệ"));
        }
    }
    else {
        echo json_encode(array("message" => "Wrong method!"));
    }

?>