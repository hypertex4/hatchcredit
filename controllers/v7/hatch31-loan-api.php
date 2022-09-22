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
    //for questionnaire table
    $user_id = trim($_POST['user_id']);

    $l_da = trim($_POST['l_date']);
    $l_ty = trim($_POST['loan_type']);
    $m_ea = trim($_POST['u_earn']);
    $c_lo = trim($_POST['curr_loan']);
    $c_ld = trim($_POST['cur_loan_d']);
    $d_om = trim($_POST['d_of_mon']);
    $l_te = trim($_POST['loan_tenor']);
    $s_ca = trim($_POST['sal_curr_acc']);

    //for personal info
    $loan_id = rand(10000000,99999999);
    $pi_ti = trim($_POST['title']);
    $pi_ge = trim($_POST['gender']);
    $pi_do= trim($_POST['dob']);
    $pi_fn = trim($_POST['f_name']);
    $pi_ln = trim($_POST['l_name']);
    $pi_sn = trim($_POST['s_name']);
    $pi_em = trim($_POST['email']);
    $pi_mo = trim($_POST['mobile']);
    $pi_al = trim($_POST['alt_num']);
    $pi_bvn = trim($_POST['bvn']);
    $pi_mid = trim($_POST['m_id']);
    $pi_iss = trim($_POST['d_iss']);
    $pi_exp = trim($_POST['ex_date']);
    $pi_idn = trim($_POST['id_no']);

    //for location info
    $li_ha = trim($_POST['h_add']);
    $li_ns = trim($_POST['nb_stop']);
    $li_rl = trim($_POST['r_lga']);
    $li_rs = trim($_POST['r_state']);
    $li_r_sta = trim($_POST['r_status']);
    $li_tcy = trim($_POST['tc_yrs']);
    $li_tcm = trim($_POST['tc_mon']);
    $li_pa = trim($_POST['p_add']);
    $li_tpy = trim($_POST['tp_yrs']);
    $li_tpm = trim($_POST['tp_mon']);
    $li_ms = trim($_POST['m_stat']);

    //for employment info
    $emp_st = trim($_POST['em_sta']);
    $emp_ce = trim($_POST['c_emp']);
    $emp_ca = trim($_POST['c_e_add']);
    $emp_cs = trim($_POST['c_em_st']);
    $emp_cl = trim($_POST['c_em_lga']);
    $emp_cst = trim($_POST['c_em_sta']);
    $emp_ofn = trim($_POST['c_em_ono']);
    $emp_em = trim($_POST['c_email']);
    $emp_sid = trim($_POST['c_st_id']);
    $emp_pn = trim($_POST['c_pen_no']);
    $emp_tid = trim($_POST['c_tax_id']);
    $emp_jt = trim($_POST['c_job_t']);
    $emp_de = trim($_POST['c_de_un']);
    $emp_dem = trim($_POST['c_da_em']);
    $emp_pen = trim($_POST['p_emp_na']);
    $emp_pea = trim($_POST['p_emp_add']);
    $emp_pnm = trim($_POST['p_no_mo']);
    $emp_j5 = trim($_POST['j5_yrs']);
    $emp_ns = trim($_POST['n_sala']);
    $emp_pd = trim($_POST['cu_p_day']);
    $emp_in = trim($_POST['industry']);

    //for loan details info
    $loi_es = trim($_POST['edu_sta']);
    $loi_pl = trim($_POST['pof_loan']);
    $loi_ox = trim($_POST['o_exp']);
    $loi_el = trim($_POST['exi_loan']);
    $loi_nc = trim($_POST['no_cars']);
    $loi_dd = trim($_POST['do_drive']);
    $loi_ne_pr = trim($_POST['net_pro']);
    $loi_ne_pa = trim($_POST['net_pac']);
    $loi_n_fn = trim($_POST['nok_fname']);
    $loi_n_sn = trim($_POST['nok_sname']);
    $loi_n_re = trim($_POST['nok_rela']);
    $loi_n_ph = trim($_POST['nok_phone']);
    $loi_n_ad = trim($_POST['nok_address']);
    $loi_la = trim($_POST['loan_amt']);
    $loi_lt = trim($_POST['loan_ten']);
    $loi_mr = trim($_POST['mon_rep']);

    //for disbursement & acceptance
    $da_bn = trim($_POST['bk_name']);
    $da_an = trim($_POST['acc_name']);
    $da_acc_n = trim($_POST['acc_no']);
    $da_h_abt = trim($_POST['hr_abt_us']);
    $da_if_news = trim($_POST['if_news_p']);
    $da_if_mag = trim($_POST['if_magaz']);
    $da_agree = trim($_POST['agree_cond']);

    //file
    $uploadDir = '../../admin/documents/';
    $err = 0;

    $images = $_FILES;
    $data = [];
    $n=0;
    foreach ($images as $key => $image) {++$n;
        $name = $image['name'];

        $fileName = basename($name);
        $cleanName = $member->clean($fileName);
        $fName = $member->clean($pi_fn);
        $sName = $member->clean($pi_sn);
        $lType = $member->clean($l_ty);
        $timeStamp = date("d-m-Y-H-i-s");

        if($n==1) $docType = "Passport";
        if($n==2) $docType = "Confirm_Letter";
        if($n==3) $docType = "Bank_stat";
        if($n==4) $docType = "Staff_ID";
        if($n==5) $docType = "Valid_ID";
        if($n==6) $docType = "Util_Bill";

        $docFull = $fName."-".$sName."-".$loan_id."-".$docType."-".$lType."-".$timeStamp;

        $fileType = pathinfo($cleanName, PATHINFO_EXTENSION);
        $docFullName = $docFull.".".$fileType;
        $targetFilePath = $uploadDir . $docFullName;
        $allowTypes = array('jpg', 'png', 'jpeg','pdf');

        if (($_FILES["passport"]["size"] > 1000000)) {++$err;}
        if (($_FILES["con_letter"]["size"] > 1000000)) {++$err;}
        if (($_FILES["bnk_stat"]["size"] > 1000000)) {++$err;}
        if (($_FILES["staff_idc"]["size"] > 1000000)) {++$err;}
        if (($_FILES["valid_idc"]["size"] > 1000000)) {++$err;}
        if (($_FILES["util_bill"]["size"] > 1000000)) {++$err;}

        if (!in_array($fileType, $allowTypes)) {++$err;}


        if ($err == 0) {
            if (move_uploaded_file($image['tmp_name'], $targetFilePath)) {
                $data[$key]['success'] = true;
                $data[$key]['src'] = 'documents/'.$docFullName;
            } else {
                $data[$key]['success'] = false;
                $data[$key]['src'] = 'documents/'.$docFullName;
            }
        } else {
            http_response_code(200);
            echo json_encode(array("status" => 0, "message" => "** Invalid file upload type (png,jpg,jpeg,pdf only) <br>** One or more file exceed 1MB.)"));
            die();
        }
    }

    $passport = isset($data['passport']['src']) ? $data['passport']['src'] : "";
    $con_letter = isset($data['con_letter']['src']) ? $data['con_letter']['src'] : "";
    $bnk_stat = isset($data['bnk_stat']['src']) ? $data['bnk_stat']['src'] : "";
    $staff_idc = isset($data['staff_idc']['src']) ? $data['staff_idc']['src'] : "";
    $valid_idc = isset($data['valid_idc']['src']) ? $data['staff_idc']['src'] : "";
    $util_bill = isset($data['util_bill']['src']) ? $data['util_bill']['src'] : "";

    if (!empty($user_id) && !empty($l_da) && !empty($l_ty) && !empty($m_ea) && !empty($d_om) && !empty($l_te) && !empty($s_ca) && !empty($pi_ti) && !empty($pi_ge) && !empty($pi_do)
        && !empty($pi_fn) && !empty($pi_ln) && !empty($pi_sn) && !empty($pi_em) && !empty($pi_mo) && !empty($pi_bvn) && !empty($pi_mid) && !empty($pi_iss)
        && !empty($pi_exp) && !empty($pi_idn) && !empty($li_ha) && !empty($li_ns) && !empty($li_rl) && !empty($li_rs) && !empty($emp_st) && !empty($emp_ce)
        && !empty($emp_ca) && !empty($emp_cs) && !empty($loi_es) && !empty($loi_pl) && !empty($loi_n_fn) && !empty($loi_n_sn) && !empty($da_bn) && !empty($da_an)
        && !empty($da_acc_n)) {

        if ($passport=="" || $con_letter=="" || $bnk_stat=="" || $staff_idc=="" || $valid_idc=="" || $util_bill==""){
            http_response_code(200);
            echo json_encode(array("status" => 0, "message" => "Kindly Upload all required file."));
        } else {
            if ($da_agree == "Yes") {
                $ques_id = $member->create_loan_questionnaire($user_id, $l_da, $l_ty, $m_ea, $c_lo, $c_ld, $d_om, $l_te, $s_ca);
                if ($ques_id != false) {
                    if (
                    $member->create_loan_application(
                        $loan_id, $ques_id, $pi_ti, $pi_ge, $pi_do, $pi_fn, $pi_ln, $pi_sn, $pi_em, $pi_mo, $pi_al, $pi_bvn, $pi_mid, $pi_iss, $pi_exp, $pi_idn,
                        $li_ha, $li_ns, $li_rl, $li_rs, $li_r_sta, $li_tcy, $li_tcm, $li_pa, $li_tpy, $li_tpm, $li_ms,
                        $emp_st, $emp_ce, $emp_ca, $emp_cs, $emp_cl, $emp_cst, $emp_ofn, $emp_em, $emp_sid, $emp_pn, $emp_tid, $emp_jt, $emp_de, $emp_dem,
                        $emp_pen, $emp_pea, $emp_pnm, $emp_j5, $emp_ns, $emp_pd, $emp_in,
                        $loi_es, $loi_pl, $loi_ox, $loi_el, $loi_nc, $loi_dd, $loi_ne_pr, $loi_ne_pa, $loi_n_fn, $loi_n_sn, $loi_n_re, $loi_n_ph, $loi_n_ad, $loi_la, $loi_lt, $loi_mr,
                        $passport,$con_letter,$bnk_stat,$staff_idc,$valid_idc,$util_bill,$da_bn, $da_an, $da_acc_n, $da_h_abt, $da_if_news, $da_if_mag
                    )
                    ) {
                        http_response_code(200);
                        echo json_encode(array("status" => 1, "message" => "Loan application submitted successfully, kindly wait while our team review your loan application."));
                    } else {
                        http_response_code(200);
                        echo json_encode(array("status" => 0, "message" => "Internal server error, unable to submit application."));
                    }
                } else {
                    http_response_code(200);
                    echo json_encode(array("status" => 0, "message" => "Internal server error, failed to save questionnaire."));
                }
            } else {
                http_response_code(200);
                echo json_encode(array("status" => 0, "message" => "Error, you need to agree to our terms and conditions to complete loan application form."));
            }
        }
    } else {
        http_response_code(200);
        echo json_encode(array("status"=>0,"message"=>"Kindly fill the required field"));
    }
} else {
    http_response_code(403);
    echo json_encode(array("status"=>403,"message"=>"Access Denied"));
}