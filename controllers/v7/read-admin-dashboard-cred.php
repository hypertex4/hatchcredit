<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Content-type: application/json; charset=UTF-8");

include_once('../config/database.php');
include_once('../classes/Admin.class.php');

$db = new Database();
$connection = $db->connect();
$admin = new Admin($connection);

if ($_SERVER['REQUEST_METHOD'] === "GET") {

    $count_total_members = $admin->count_total_members();
    $count_approved_loan_app = $admin->count_approved_loan_app();
    $count_pending_loan_app = $admin->count_pending_loan_app();
    $count_cancelled_loan_app = $admin->count_cancelled_loan_app();
    $count_total_loan_app = $admin->count_total_loan_app();
    $total_loan_app_amount = $admin->total_loan_app_amount();
    $count_total_hatch31_loan_app = $admin->count_total_hatch31_loan_app();
    $total_hatch31_loan_app_amount = $admin->total_hatch31_loan_app_amount();
    $count_total_hatchgrowth_loan_app = $admin->count_total_hatchgrowth_loan_app();
    $total_hatchgrowth_loan_app_amount = $admin->total_hatchgrowth_loan_app_amount();

    http_response_code(200);
    echo json_encode(array(
        "status" => 1,
        "count_total_members" => $count_total_members,
        "count_approved_loan_app" => $count_approved_loan_app,
        "count_pending_loan_app" => $count_pending_loan_app,
        "count_cancelled_loan_app" => $count_cancelled_loan_app,
        "count_total_loan_app" => $count_total_loan_app,
        "total_loan_app_amount" => $total_loan_app_amount,
        "count_total_hatch31_loan_app" => $count_total_hatch31_loan_app,
        "total_hatch31_loan_app_amount" => $total_hatch31_loan_app_amount,
        "count_total_hatchgrowth_loan_app" => $count_total_hatchgrowth_loan_app,
        "total_hatchgrowth_loan_app_amount" => $total_hatchgrowth_loan_app_amount,
    ));
} else {
    http_response_code(503);
    echo json_encode(array("status" => 503, "message" => "Access Denied"));
}