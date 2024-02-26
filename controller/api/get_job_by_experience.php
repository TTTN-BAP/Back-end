<?php
    header('Access-Control-Allow-Origin:*');
    header('Content-Type: application/json');

    include_once('../../config/db_connect.php');
    include_once('../../model/data.php');

    $db = new db();
    $connect = $db->connect();
    $data_job = new Data($connect);

    $method = $_SERVER['REQUEST_METHOD'];
    $job_experience = $_GET['job_experience'];

    if ($method=='GET') {
        $data = $data_job->get_job_by_experience($job_experience);
        if($data){
            echo json_encode($data,JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        }
        else {
            echo json_encode(array("message" => "Could not find job"));
        }
    }
?>