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
    $l_app = $admin->list_all_loan_application();
    if ($l_app->num_rows > 0) {
        $l_apps_arr = array();
        while ($row = $l_app->fetch_assoc()) {
            $l_apps_arr[] = array(
                "lq_id"=>$row['lq_id'],"user_id"=>$row['user_id'],"lq_ldate"=>$row['lq_ldate'],"lq_ltype" =>$row['lq_ltype'],"lq_earn"=>$row['lq_earn'],
                "lq_curr_loan"=>$row['lq_curr_loan'],"lq_loan_dec_amt"=>$row['lq_loan_dec_amt'],"lq_d_of_mon"=>$row['lq_d_of_mon'],
                "lq_loan_tenor"=>$row['lq_loan_tenor'],"lq_sal_curr_acc"=>$row['lq_sal_curr_acc'],"lq_status"=>$row['lq_status'],
                "lq_created_on"=>$row['lq_created_on']
            );
        }
        http_response_code(200);
        echo json_encode(array("status" => 1, "loan_apps" => $l_apps_arr,));
    } else {
        http_response_code(200);
        echo json_encode(array("status" => 0, "message" => "No Record Found"));
    }
} else {
    http_response_code(503);
    echo json_encode(array("status" => 503, "message" => "Access Denied"));
}