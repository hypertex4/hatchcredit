<?php
// include headers
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
    $f_name = trim($_POST['f_name']);
    $l_name = trim($_POST['l_name']);
    $s_name = trim($_POST['s_name']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['mobile']);
    $pwd = trim($_POST['password']);
    $rpt_pwd = trim($_POST['c_password']);
    if (!empty($f_name) && !empty($l_name) && !empty($s_name) && !empty($email) && !empty($phone) && !empty($pwd) && !empty($rpt_pwd)) {
        if ($pwd !== $rpt_pwd){
            http_response_code(200);
            echo json_encode(array("status"=>0,"message"=>"Password combination did not match, try again."));
        } else {
            $password = password_hash($pwd, PASSWORD_DEFAULT);

            $email_data = $member->check_active_account($email);
            if (empty($email_data)) {
                if ($member->create_member($f_name,$l_name,$s_name,$email,$phone,$password)) {
                    if ($member->create_temp_activate_account($email,$f_name)) {
                        http_response_code(200);
                        echo json_encode(array("status" => 1, "message" => "Almost done, confirmation code sent to your email to complete your registration. (NB: OTP will expire after 2hrs.)"));
                    } else {
                        http_response_code(200);
                        echo json_encode(array("status" => 0, "message" => "Internal server error, mail cannot be sent."));
                    }
                } else {
                    http_response_code(200);
                    echo json_encode(array("status" => 0, "message" => "Internal server error, failed to save user."));
                }
            } else {
                http_response_code(200);
                echo json_encode(array("status" => 0, "message" => "Customer email already exists, try forgot password instead"));
            }
        }
    } else {
        http_response_code(200);
        echo json_encode(array("status"=>0,"message"=>"Kindly fill the required field"));
    }
} else {
    http_response_code(200);
    echo json_encode(array("status"=>0,"message"=>"Access Denied"));
}