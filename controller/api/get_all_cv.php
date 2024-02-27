<?php
    header('Access-Control-Allow-Origin:*');
    header('Content-Type: application/json');

    include_once('../../config/db_connect.php');
    include_once('../../model/cv.php');

    $db = new db();
    $connect = $db->connect();

    $data_cv = new Cv($connect);
    $read = $data_cv->get_all_cv();
    $method = $_SERVER['REQUEST_METHOD'];
    if ($method=='GET') {
        echo json_encode($read,JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    }
    else {
        echo json_encode(['message' => 'Invalid method']);
    }
?>