<?php
class Cv{
    private $conn;
    //properties
    //connect to database
    public function __construct($db){
        $this->conn = $db;
    }
    //read data from database
    public function get_all_cv($limit, $offset){
        $query = "SELECT * FROM cv_info LIMIT ? OFFSET ?";
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
        $query = "SELECT COUNT(*) as total FROM cv_info";
        $result = $this->conn->query($query);
        $row = $result->fetch_assoc();
        return $row['total'];
    }
    public function get_cv_by_id($id_cv){
        $query = "SELECT * FROM cv_info WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $id_cv);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();

        return $row;
    }

    public function update_cv_by_id($id_cv,$cv_name, $cv_birthday, $cv_email, $cv_sdt, $cv_target, $cv_academi_level, $cv_work_experience, $cv_skill, $cv_interest){
        $query = "UPDATE cv_info SET cv_name = ?, cv_birthday = ?, cv_email = ?, cv_sdt = ?, cv_target = ?, cv_academi_level = ?, cv_work_experience = ?, cv_skill = ?, cv_interest = ? WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        // Gán giá trị cho tham số
        $stmt->bind_param ("sssssssssi",$cv_name, $cv_birthday, $cv_email, $cv_sdt, $cv_target, $cv_academi_level, $cv_work_experience, $cv_skill, $cv_interest, $id_cv) ;
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
}
?>