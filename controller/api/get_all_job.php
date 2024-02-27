<?php
    header('Access-Control-Allow-Origin:*');
    header('Content-Type: application/json');

    include_once('../../config/db_connect.php');
    include_once('../../model/data.php');

    $db = new db();
    $connect = $db->connect();

    $data_job = new Data($connect);
    $read = $data_job->get_all_job();
    $method = $_SERVER['REQUEST_METHOD'];
    if ($method=='GET') {
        echo json_encode($read,JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    }
    else {
        echo json_encode(['message' => 'Invalid method']);
    }
?>