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
    $job_info = $_GET['job_info'];

    if ($method=='GET') {
        $data = $data_job->search_job($job_info);
        if($data){
            echo json_encode($data,JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        }
        else {
            echo json_encode(array("message" => "Could not find job"));
        }
    }
    // while ($row = $read->fetch(PDO::FETCH_ASSOC)) {
    //     extract($row);
    //     //var_dump($row);
    //     $job_item = array(
    //             'id_job' => $id,
    //             'job_name' => $job_name,
    //             'id_company' => $id_company,
    //             'company_name' => $company_name,
    //             'job_salary' => $job_salary,
    //             'job_experience' => $job_experience,
    //             'job_level' => $job_level,
    //             'job_expired_date' => $job_expired_date,
    //             'job_details' => $job_details,
    //             'job_required' => $job_required,
    //             'company_logo' => $company_logo,
    //             'job_address' => $job_address
    //     );
    //         array_push($job_array['job'], $job_item);
    //     }
    //     echo json_encode($job_array,JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

?>