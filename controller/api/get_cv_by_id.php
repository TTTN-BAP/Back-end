<?php
    header('Access-Control-Allow-Origin:*');
    header('Content-Type: application/json');

    include_once('../../config/db_connect.php');
    include_once('../../model/cv.php');

    $db = new db();
    $connect = $db->connect();
    $data_cv = new Cv($connect);

    $method = $_SERVER['REQUEST_METHOD'];
    $id_cv = $_GET['id_cv'];
    
    if ($method=='GET') {
        $data = $data_cv->get_cv_by_id($id_cv);
        if($data){
            echo json_encode($data,JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        }
        else {
            echo json_encode(array("message" => "Could not find company"));
        }
        
    }
?>