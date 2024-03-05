<?php
class Company{
    private $conn;
    //properties
    //connect to database
    public function __construct($db){
        $this->conn = $db;
    }
    //read data from database
    public function get_all_company($limit, $offset){
        $query = "SELECT * FROM company LIMIT ? OFFSET ?";
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
        $query = "SELECT COUNT(*) as total FROM company";
        $result = $this->conn->query($query);
        $row = $result->fetch_assoc();
        return $row['total'];
    }
    public function get_company_by_id($id_company){
        $query = "SELECT * FROM company WHERE id_company = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("s", $id_company);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();

        return $row;
    }
    public function search_company($company_name, $limit, $offset){
        $query = "SELECT * FROM company WHERE company_name LIKE ? LIMIT ? OFFSET ?";
        $stmt = $this->conn->prepare($query);
        // Gán giá trị cho tham số
        $param_company_name = "%$company_name%";
        $stmt->bind_param ("sii", $param_company_name, $limit, $offset);
        $stmt->execute();
        $result = $stmt->get_result();
        $data = [];
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
        return $data;
    }
    public function get_total_search_company($company_name){
        $query = "SELECT COUNT(*) as total FROM company WHERE company_name LIKE ?";
        $stmt = $this->conn->prepare($query);
        // Gán giá trị cho tham số
        $param_company_name = "%$company_name%";
        $stmt->bind_param("s", $param_company_name);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        return $row['total'];
    }

    public function create_company($company_name, $company_address, $company_size, $company_website, $company_type, $company_details, $company_logo){
        $query = "INSERT INTO company SET id_company = UUID(),company_name = ?, company_address = ?, company_size = ?, company_website = ?, company_type = ?, company_details = ?, company_logo = ?";
        $stmt = $this->conn->prepare($query);
        // Gán giá trị cho tham số
        $stmt->bind_param ("sssssss", $company_name, $company_address, $company_size, $company_website, $company_type, $company_details, $company_logo) ;
        if($stmt->execute()){
            return true;
        }
        else{
            echo "Error: " . $stmt->error;
            return false;
        }
    }
    public function update_company_by_id($id_company,$company_name, $company_address, $company_size, $company_website, $company_type, $company_details, $company_logo){
        $query = "UPDATE company SET company_name = ?, company_address = ?, company_size = ?, company_website = ?, company_type = ?, company_details = ?, company_logo = ? WHERE id_company = ?";
        $stmt = $this->conn->prepare($query);
        // Gán giá trị cho tham số
        $stmt->bind_param ("ssssssss", $company_name, $company_address, $company_size, $company_website, $company_type, $company_details, $company_logo, $id_company) ;
        $stmt->execute();
        #$result = $stmt->get_result();
        if ($stmt->affected_rows > 0) {
            // Cập nhật thành công
            return true;
        } else {
            // Không có dòng nào được cập nhật
            echo "Error: " . $stmt->error;
            return false;
        }
    }
    public function delete_company_by_id($id_company){
        $query = "DELETE FROM company WHERE id_company = ?";
        $stmt = $this->conn->prepare($query);
        // Gán giá trị cho tham số
        $stmt->bind_param ("s", $id_company) ;
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