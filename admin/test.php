<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET");
header("Content-type: application/json; charset=UTF-8");

include_once('../controllers/config/database.php');
include_once('../controllers/classes/Admin.class.php');

$db = new Database();
$connection = $db->connect();
$admin = new Admin($connection);

echo $admin->count_num_non_null_file_upload_hatch_growth(3);
?>