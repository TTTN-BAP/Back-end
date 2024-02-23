<?php
class Data{
    private $conn;
    //properties
    public $id;
    public $job_name;
    public $id_company;
    public $company_name;
    public $job_salary;
    public $job_experience;
    public $job_level;
    public $job_expired_date;
    public $job_details;
    public $job_required;
    public $company_logo;
    public $job_address;

    //connect to database
    public function __construct($db){
        $this->conn = $db;
    }
    //read data from database
    public function read(){
        $query = "SELECT * FROM data ORDER BY id ASC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    public function search_jobname(){
        $query = "SELECT * FROM data WHERE job_name LIKE ?";
        $stmt = $this->conn->prepare($query);
        // Gán giá trị cho tham số
        $stmt->bindParam (1, $this->job_name);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->id = $row['id'];
        $this->job_name = $row['job_name'];
        $this->id_company = $row['id_company'];
        $this->company_name = $row['company_name'];
        $this->job_salary = $row['job_salary'];
        $this->job_experience = $row['job_experience'];
        $this->job_level = $row['job_level'];
        $this->job_expired_date = $row['job_expired_date'];
        $this->job_details = $row['job_details'];
        $this->job_required = $row['job_required'];
        $this->company_logo = $row['company_logo'];
        $this->job_address = $row['job_address'];
    }
}
?>