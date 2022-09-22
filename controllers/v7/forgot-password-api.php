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
    $email = trim($_POST['email']);
    if (!empty($email)) {
        $email_data = $member->check_email($email);
        if (!empty($email_data)){
            if ($member->reset_password_request($email)){
                http_response_code(200);
                echo json_encode(array("status" => 1, "message" => "A Reset password link as been sent to your email address."));
            } else {
                http_response_code(200);
                echo json_encode(array("status" => 0, "message" => "Failed to send reset password link"));
            }
        } else {
            http_response_code(200);
            echo json_encode(array("status" => 0, "message" => "Invalid email address"));
        }
    } else {
        http_response_code(200);
        echo json_encode(array("status" => 0,"message" => "Invalid email address"));
    }
} else {
    http_response_code(200);
    echo json_encode(array("status" => 0, "message" => "Access Denied"));
}
