<?php


class Admin{
    private $conn;

    public function __construct($db){
        $this->conn = $db;
    }

    public function admin_login($username){
        $email_query = "SELECT * FROM tbl_admin WHERE admin_user=?";
        $user_obj = $this->conn->prepare($email_query);
        $user_obj->bind_param("s", $username);
        if ($user_obj->execute()) {
            $data = $user_obj->get_result();
            return $data->fetch_assoc();
        }
        return array();
    }

    public function create_admin($username,$password){
        $username = htmlspecialchars(strip_tags($username));
        $pass_hash= password_hash($password, PASSWORD_DEFAULT);

        $user_query = "INSERT INTO tbl_admin SET admin_user=?,admin_password=?";
        $user_obj = $this->conn->prepare($user_query);
        $user_obj->bind_param("ss", $username, $pass_hash);
        if ($user_obj->execute()) {
            return true;
        }
        return false;
    }

    public function count_total_members(){
        $cnt = mysqli_num_rows(mysqli_query($this->conn, "SELECT * FROM tbl_users"));
        if ($cnt > 0) return $cnt;
        return 0;
    }

    public function count_approved_loan_app(){
        $cnt = mysqli_num_rows(mysqli_query($this->conn, "SELECT * FROM tbl_loan_questions WHERE lq_status='Approved'"));
        if ($cnt > 0) return $cnt;
        return 0;
    }

    public function count_pending_loan_app(){
        $cnt = mysqli_num_rows(mysqli_query($this->conn, "SELECT * FROM tbl_loan_questions WHERE lq_status='Pending'"));
        if ($cnt > 0) return $cnt;
        return 0;
    }

    public function count_cancelled_loan_app(){
        $cnt = mysqli_num_rows(mysqli_query($this->conn, "SELECT * FROM tbl_loan_questions WHERE lq_status='Cancelled'"));
        if ($cnt > 0) return $cnt;
        return 0;
    }

    public function count_total_loan_app(){
        $cnt = mysqli_num_rows(mysqli_query($this->conn, "SELECT * FROM tbl_loan_questions"));
        if ($cnt > 0) return $cnt;
        return 0;
    }

    public function total_loan_app_amount(){
        $amt_query = "SELECT SUM(ln_amount) as myAmt FROM tbl_loan_application";
        $amt_query2 = "SELECT SUM(ln_amount) as myAmt FROM tbl_loan_application_growth";
        $amt_obj = $this->conn->prepare($amt_query);
        $amt_obj2 = $this->conn->prepare($amt_query2);
        if ($amt_obj->execute()) {
            $data= $amt_obj->get_result()->fetch_assoc();
             $am_1 = $data['myAmt'];
        }
        if ($amt_obj2->execute()) {
            $data2= $amt_obj2->get_result()->fetch_assoc();
            $am_2 = $data2['myAmt'];
        }
        return $am_1 + $am_2;
    }

    public function count_total_hatch31_loan_app(){
        $cnt = mysqli_num_rows(mysqli_query($this->conn, "SELECT * FROM tbl_loan_application lp INNER JOIN tbl_loan_questions lq ON lq.lq_id=lp.lq_id WHERE lq_status='Approved'"));
        if ($cnt > 0) return $cnt;
        return 0;
    }

    public function total_hatch31_loan_app_amount(){
        $amt_query = "SELECT SUM(lp.ln_amount) as myAmt FROM tbl_loan_application lp INNER JOIN tbl_loan_questions lq ON lq.lq_id=lp.lq_id WHERE lq_status='Approved'";
        $amt_obj = $this->conn->prepare($amt_query);
        if ($amt_obj->execute()) {
            $data= $amt_obj->get_result()->fetch_assoc();
             return $data['myAmt'];
        }
        return array();
    }

    public function count_total_hatchgrowth_loan_app(){
        $cnt = mysqli_num_rows(mysqli_query($this->conn, "SELECT * FROM tbl_loan_application_growth lp INNER JOIN tbl_loan_questions lq ON lq.lq_id=lp.lq_id WHERE lq_status='Approved'"));
        if ($cnt > 0) return $cnt;
        return 0;
    }

    public function total_hatchgrowth_loan_app_amount(){
        $amt_query = "SELECT SUM(ln_amount) as myAmt FROM tbl_loan_application_growth lp INNER JOIN tbl_loan_questions lq ON lq.lq_id=lp.lq_id WHERE lq_status='Approved'";
        $amt_obj = $this->conn->prepare($amt_query);
        if ($amt_obj->execute()) {
            $data= $amt_obj->get_result()->fetch_assoc();
             return $data['myAmt'];
        }
        return array();
    }

    public function list_all_loan_application(){
        $query = "SELECT * FROM tbl_loan_questions";
        $obj = $this->conn->prepare($query);
        if ($obj->execute()) {
            return $obj->get_result();
        }
        return array();
    }

    public function get_loan_application_by_id($lq_id){
        $query = "SELECT * FROM tbl_loan_questions WHERE lq_id=$lq_id";
        $obj = $this->conn->prepare($query);
        if ($obj->execute()) {
            return $obj->get_result();
        }
        return array();
    }

    public function get_loan_application_details($ln_qt, $type){
        if ($type=="Hatch31"){
            $query = "SELECT * FROM tbl_loan_application WHERE lq_id=$ln_qt LIMIT 1";
        } else {
            $query = "SELECT * FROM tbl_loan_application_growth WHERE lq_id=$ln_qt LIMIT 1";
        }
        $q_obj = $this->conn->prepare($query);
        if ($q_obj->execute()) {
            return $q_obj->get_result()->fetch_assoc();
        }
        return array();
    }

    public function list_type_loan_application($Hatch31){
        $query = "SELECT * FROM tbl_loan_questions WHERE lq_ltype='$Hatch31'";
        $obj = $this->conn->prepare($query);
        if ($obj->execute()) {
            return $obj->get_result();
        }
        return array();
    }

    public function update_loan_application_status($lq_id,$status){
        $query = "UPDATE tbl_loan_questions SET lq_status='$status' WHERE lq_id=$lq_id";
        $obj = $this->conn->prepare($query);
        if ($obj->execute()){
            if ($obj->affected_rows > 0){return true;}
            return false;
        }
        return false;
    }

    public function test_if_file_exist($type,$ln_id,$field){
        if ($type=="Hatch31"){
            $cnt = mysqli_num_rows(mysqli_query($this->conn, "SELECT * FROM tbl_loan_application WHERE ln_sno=$ln_id AND $field IS NOT NULL"));
        } else {
            $cnt = mysqli_num_rows(mysqli_query($this->conn, "SELECT * FROM tbl_loan_application_growth WHERE lg_sno=$ln_id AND $field IS NOT NULL"));
        }
        if ($cnt > 0) return $cnt;
        return 0;
    }

    public function update_loan_deleted($file,$type,$ln_id,$field){
        if ($type=="Hatch31"){
            $_query = "UPDATE tbl_loan_application SET $field=NULL WHERE ln_sno=$ln_id";
        } else {
            $_query = "UPDATE tbl_loan_application_growth SET $field=NULL WHERE lg_sno=$ln_id";
        }
        $obj = $this->conn->prepare($_query);
        if ($obj->execute()){
            if ($obj->affected_rows > 0){return true;}
            return false;
        }
        return false;
    }

    public function list_all_members(){
        $query = "SELECT * FROM tbl_users";
        $obj = $this->conn->prepare($query);
        if ($obj->execute()) {
            return $obj->get_result();
        }
        return array();
    }

    public function update_member_status($u_sno,$active){
        $query = "UPDATE tbl_users SET u_active='$active' WHERE u_sno=$u_sno";
        $obj = $this->conn->prepare($query);
        if ($obj->execute()){
            if ($obj->affected_rows > 0){return true;}
            return false;
        }
        return false;
    }

    public function count_num_non_null_file_upload_hatch_growth($lg_sno){
        $num_query = "SELECT cac_doc,bank_stat,isnull(cac_doc)+isnull(bank_stat) AS NumberofNULLS FROM tbl_loan_application_growth
                    WHERE lg_sno=$lg_sno";
        $num_obj = $this->conn->prepare($num_query);
        if ($num_obj->execute()) {
            $data= $num_obj->get_result()->fetch_assoc();
            return 2 - $data['NumberofNULLS'];
        }
        return array();
    }

    public function count_num_non_null_file_upload_hatch31($ln_sno){
        $num_query = "SELECT con_letter,bank_stat,staff_idc,valid_idc,util_bill,isnull(con_letter)+isnull(bank_stat)+isnull(staff_idc)+isnull(valid_idc)+isnull(bank_stat) 
                    AS NumberofNULLS FROM tbl_loan_application WHERE ln_sno=$ln_sno";
        $num_obj = $this->conn->prepare($num_query);
        if ($num_obj->execute()) {
            $data= $num_obj->get_result()->fetch_assoc();
            return 5 - $data['NumberofNULLS'];
        }
        return array();
    }

}