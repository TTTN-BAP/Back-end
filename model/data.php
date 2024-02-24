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
        $query = "SELECT * FROM data";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $result = $stmt->get_result();
        $data = [];
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
        return $data;
    }
    public function get_job_by_id($id){
        $query = "SELECT * FROM data WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();

        return $row;
    }
    public function search_job($job){
        $query = "SELECT * FROM data WHERE job_name LIKE ? OR company_name LIKE ?";
        $stmt = $this->conn->prepare($query);
        // Gán giá trị cho tham số
        $param_job_name = "%$job%";
        $stmt->bind_param ("ss", $param_job_name, $param_job_name);
        $stmt->execute();
        $result = $stmt->get_result();
        $data = [];
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
        return $data;
    }
    public function get_job_by_address($address){
        $query = "SELECT * FROM data WHERE job_address LIKE ?";
        $stmt = $this->conn->prepare($query);
        // Gán giá trị cho tham số
        $param_job_address = "%$address%";
        $stmt->bind_param ("s", $param_job_address);
        $stmt->execute();
        $result = $stmt->get_result();
        $data = [];
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
        return $data;
    }
    public function get_job_by_level($level){
        $query = "SELECT * FROM data WHERE job_level LIKE ?";
        $stmt = $this->conn->prepare($query);
        // Gán giá trị cho tham số
        $param_job_level = "%$level%";
        $stmt->bind_param ("s", $param_job_level);
        $stmt->execute();
        $result = $stmt->get_result();
        $data = [];
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
        return $data;
    }
    public function get_job_by_experience($job_experience){
        $query = "SELECT * FROM data WHERE job_experience LIKE ?";
        $stmt = $this->conn->prepare($query);
        // Gán giá trị cho tham số
        $param_job_experience = "%$job_experience%";
        $stmt->bind_param ("s", $param_job_experience);
        $stmt->execute();
        $result = $stmt->get_result();
        $data = [];
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
        return $data;
    }
}
?>