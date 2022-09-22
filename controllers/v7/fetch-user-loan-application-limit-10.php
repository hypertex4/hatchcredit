<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET");
header("Content-type: application/json; charset=UTF-8");

include_once('../config/database.php');
include_once('../classes/Member.class.php');

$db = new Database();
$connection = $db->connect();
$member = new Member($connection);

if ($_SERVER['REQUEST_METHOD'] === "GET") {
    $user_id = $_GET['user_id'];
    $limit = $_GET['limit'];
    $loan_app = $member->fetch_loan_application_by_user_id_lim_10($user_id,$limit);
    if ($loan_app->num_rows > 0) {
        $loan_app_arr = array();
        while ($row = $loan_app->fetch_assoc()) {
            $loan_app_arr[] = array(
                "lq_id"=>$row['lq_id'],"user_id"=>$row['user_id'],"lq_ldate"=>$row['lq_ldate'],"lq_ltype" =>$row['lq_ltype'],"lq_earn"=>$row['lq_earn'],
                "lq_curr_loan"=>$row['lq_curr_loan'],"lq_loan_dec_amt"=>$row['lq_loan_dec_amt'],"lq_d_of_mon"=>$row['lq_d_of_mon'],
                "lq_loan_tenor"=>$row['lq_loan_tenor'],"lq_sal_curr_acc"=>$row['lq_sal_curr_acc'],"lq_status"=>$row['lq_status'],"lq_created_on"=>$row['lq_created_on'],
            );
        }
        http_response_code(200);
        echo json_encode(array("status" => 1, "loan_app" => $loan_app_arr,));
    } else {
        http_response_code(200);
        echo json_encode(array("status" => 0, "message" => "No Record Found"));
    }
} else {
    http_response_code(503);
    echo json_encode(array("status" => 503, "message" => "Access Denied"));
}