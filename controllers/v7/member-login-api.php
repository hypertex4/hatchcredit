<?php
// include headers
session_start();
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Content-type: application/json; charset=UTF-8");

include_once('../config/database.php');
include_once('../classes/Member.class.php');

//create object for db
$db = new Database();
$connection = $db->connect();
$member = new Member($connection);

if ($_SERVER['REQUEST_METHOD'] === "POST") {
    $email = trim($_POST['email']);
    $pwd = trim($_POST['password']);
    if (!empty($email) && !empty($pwd)){
        $user_data = $member->login_user($email);
        if (!empty($user_data)){
            $email = $user_data['u_email'];
            $password = $user_data['u_password'];
            if (password_verify($pwd,$password)) {
                $account_arr = array(
                    "user_id"=>$user_data['user_id'],
                    "u_fname"=>$user_data['u_fname'],
                    "u_lname"=>$user_data['u_lname'],
                    "u_sname"=>$user_data['u_sname'],
                    "u_email"=>$user_data['u_email'],
                    "u_mobile"=>$user_data['u_mobile'],
                    "u_active"=>$user_data['u_active']
                );
                http_response_code(200);
                echo json_encode(array("status"=>1, "user_details"=>$account_arr, "message"=>"User logged in successfully"));
                $_SESSION['MEMBER_LOGIN'] = $account_arr;
            } else {
                http_response_code(200);
                echo json_encode(array("status"=>0,"message"=>"Invalid credentials, password incorrect. Try resetting your password."));
            }
        } else {
            http_response_code(200);
            echo json_encode(array("status"=>0,"message"=>"Invalid credentials, email does not match any record."));
        }
    } else {
        http_response_code(200);
        echo json_encode(array("status"=>0,"message"=>"Kindly fill the required field"));
    }
} else {
    http_response_code(200);
    echo json_encode(array("status"=>0,"message"=>"Access Denied"));
}