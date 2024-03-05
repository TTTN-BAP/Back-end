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
    public function get_all_job($limit, $offset){
        $query = "SELECT * FROM data LIMIT ? OFFSET ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("ii", $limit, $offset);
        $stmt->execute();
        $result = $stmt->get_result();
        $data = [];
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
        return $data;
    }
    public function get_total_data(){
        $query = "SELECT COUNT(*) as total FROM data";
        $result = $this->conn->query($query);
        $row = $result->fetch_assoc();
        return $row['total'];
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
    public function get_job_by_id_company($id_company){
        $query = "SELECT * FROM data WHERE id_company = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("s", $id_company);
        $stmt->execute();
        $result = $stmt->get_result();
        $data = [];
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
        return $data;
    }
    public function search_job($job, $limit, $offset){
        $query = "SELECT * FROM data WHERE job_name LIKE ? OR company_name LIKE ? LIMIT ? OFFSET ?";
        $stmt = $this->conn->prepare($query);
        // Gán giá trị cho tham số
        $param_job_name = "%$job%";
        $stmt->bind_param("ssii", $param_job_name, $param_job_name, $limit, $offset);
        $stmt->execute();
        $result = $stmt->get_result();
        $data = [];
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
        $stmt->close();
        return $data;
    }
    public function get_total_search_job($job){
        $query = "SELECT COUNT(*) as total FROM data WHERE job_name LIKE ? OR company_name LIKE ?";
        $stmt = $this->conn->prepare($query);
        // Gán giá trị cho tham số
        $param_job_name = "%$job%";
        $stmt->bind_param("ss", $param_job_name, $param_job_name);

        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        return $row['total'];
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
    public function get_job_by_salary($job_salary){
        $query = "SELECT * FROM data WHERE CAST(SUBSTRING_INDEX(SUBSTRING_INDEX(job_salary, ' ', 1), ' ', -1) AS UNSIGNED) >= ?";
        $stmt = $this->conn->prepare($query);
        // Gán giá trị cho tham số
        $param_job_salary = "$job_salary";
        $stmt->bind_param ("s", $param_job_salary);
        $stmt->execute();
        $result = $stmt->get_result();
        $data = [];
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
        return $data;
    }
    public function create_job($job_name, $id_company, $company_name, $job_salary, $job_experience, $job_level, $job_expired_date, $job_details, $job_required, $company_logo, $job_address){
        $query = "INSERT INTO data SET job_name = ?, id_company = ?, company_name = ?, job_salary = ?, job_experience = ?, job_level = ?, job_expired_date = ?, job_details = ?, job_required = ?, company_logo = ?, job_address = ?";
        $stmt = $this->conn->prepare($query);
        // Gán giá trị cho tham số
        $stmt->bind_param ("sssssssssss", $job_name, $id_company, $company_name, $job_salary, $job_experience, $job_level, $job_expired_date, $job_details, $job_required, $company_logo, $job_address) ;
        if($stmt->execute()){
            return true;
        }
        else{
            echo "Error: " . $stmt->error;
            return false;
        }
    }
    public function update_job_by_id($job_id, $job_name, $id_company, $company_name, $job_salary, $job_experience, $job_level, $job_expired_date, $job_details, $job_required, $company_logo, $job_address){
        $query = "UPDATE data SET job_name = ?, id_company = ?, company_name = ?, job_salary = ?, job_experience = ?, job_level = ?, job_expired_date = ?, job_details = ?, job_required = ?, company_logo = ?, job_address = ? WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        // Gán giá trị cho tham số
        $stmt->bind_param ("sssssssssssi", $job_name, $id_company, $company_name, $job_salary, $job_experience, $job_level, $job_expired_date, $job_details, $job_required, $company_logo, $job_address, $job_id) ;
        $stmt->execute();
        #$result = $stmt->get_result();
        if ($stmt->affected_rows > 0) {
            // Cập nhật thành công
            json_encode(['message' => 'Data updated']);
        } else {
            // Không có dòng nào được cập nhật
            echo json_encode(['message' => 'Invalid data']);
        }
    }
    public function delete_job_by_id($job_id){
        $query = "DELETE FROM data WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        // Gán giá trị cho tham số
        $stmt->bind_param ("i", $job_id) ;
        if($stmt->execute()){
            return true;
        }
        else{
            echo "Error: " . $stmt->error;
            return false;
        }
    }
}
?>