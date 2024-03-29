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
    $id_company = $_GET['id_company'];
    
    if ($method=='GET') {
        $data = $data_job->get_job_by_id_company($id_company);
        if($data){
            echo json_encode($data,JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        }
        else {
            echo json_encode(array("message" => "Could not find job"));
        }
    }
    else {
        echo json_encode(['message' => 'Invalid method']);
    }
?>