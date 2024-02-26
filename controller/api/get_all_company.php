<?php
    header('Access-Control-Allow-Origin:*');
    header('Content-Type: application/json');

    include_once('../../config/db_connect.php');
    include_once('../../model/company.php');

    $db = new db();
    $connect = $db->connect();

    $data_company = new Company($connect);
    $read = $data_company->get_all_company();
    $method = $_SERVER['REQUEST_METHOD'];
    if ($method=='GET') {
        echo json_encode($read,JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    }
?>