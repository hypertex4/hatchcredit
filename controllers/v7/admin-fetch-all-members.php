<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET");
header("Content-type: application/json; charset=UTF-8");

include_once('../config/database.php');
include_once('../classes/Admin.class.php');

$db = new Database();
$connection = $db->connect();
$admin = new Admin($connection);

if ($_SERVER['REQUEST_METHOD'] === "GET") {
    $member = $admin->list_all_members();
    if ($member->num_rows > 0) {
        $members_arr = array();
        while ($row = $member->fetch_assoc()) {
            $members_arr[] = array(
                "u_sno"=>$row['u_sno'],"user_id"=>$row['user_id'],"u_fname"=>$row['u_fname'],"u_lname" =>$row['u_lname'],"u_sname"=>$row['u_sname'],
                "u_email"=>$row['u_email'],"u_mobile"=>$row['u_mobile'],"u_active"=>$row['u_active'], "u_created_on"=>$row['u_created_on']
            );
        }
        http_response_code(200);
        echo json_encode(array("status" => 1, "members" => $members_arr,));
    } else {
        http_response_code(200);
        echo json_encode(array("status" => 0, "message" => "No Record Found"));
    }
} else {
    http_response_code(503);
    echo json_encode(array("status" => 503, "message" => "Access Denied"));
}