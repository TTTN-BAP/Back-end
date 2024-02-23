<?php
    header('Access-Control-Allow-Origin:*');
    header('Content-Type: application/json');

    include_once('../../config/db_connect.php');
    include_once('../../model/data.php');

    $db = new db();
    $connect = $db->connect();

    $data_job = new Data($connect);
    $data_job->job_name = isset($_GET['job_name']) ? $_GET:die();
    $data_job->search_jobname();

    while ($row = $read->fetch(PDO::FETCH_ASSOC)) {
        extract($row);
        //var_dump($row);
        $job_item = array(
                'id_job' => $id,
                'job_name' => $job_name,
                'id_company' => $id_company,
                'company_name' => $company_name,
                'job_salary' => $job_salary,
                'job_experience' => $job_experience,
                'job_level' => $job_level,
                'job_expired_date' => $job_expired_date,
                'job_details' => $job_details,
                'job_required' => $job_required,
                'company_logo' => $company_logo,
                'job_address' => $job_address
        );
            array_push($job_array['job'], $job_item);
        }
        echo json_encode($job_array,JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

?>