<?php

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
    $f_name = trim($_POST['f_name']);
    $m_name = trim($_POST['m_name']);
    $s_name = trim($_POST['s_name']);
    $email = trim($_POST['email']);
    $mobile = trim($_POST['mobile']);

    if (!empty($f_name) && !empty($m_name) && !empty($s_name) && !empty($email) && !empty($mobile)) {
        $user_id = $_SESSION['MEMBER_LOGIN']['user_id'];
        if ($member->update_account_profile($f_name,$m_name,$s_name,$email,$mobile,$user_id)){
            http_response_code(200);
            echo json_encode(array("status"=>1,"message"=>"Your account has been updated. N.B.Changes will take effect on your next login."));
        } else {
            http_response_code(200);
            echo json_encode(array("status" =>0,"message"=>"Failed to update user profile, no changes detected. (Contact admin)"));
        }
    } else {
        http_response_code(200);
        echo json_encode(array("status" =>0, "message" => "Kindly fill the required field"));
    }
} else {
    http_response_code(503);
    echo json_encode(array("status" => 503, "message" => "Access Denied"));
}