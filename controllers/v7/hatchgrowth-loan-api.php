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

    //for business details info
    $biz_na = trim($_POST['biz_name']);
    $biz_ad = trim($_POST['biz_add']);
    $biz_no = trim($_POST['reg_num']);
    $biz_tno = trim($_POST['tax_id_no']);
    $biz_be = trim($_POST['biz_email']);
    $biz_tn = trim($_POST['tel_no']);
    $biz_yex = trim($_POST['yrs_exp']);

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
    $n=0;

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
        $docType = ($n==1)?"CAC_doc":"Bank_stat";
        $docFull = $fName."-".$sName."-".$loan_id."-".$docType."-".$lType."-".$timeStamp;

        $fileType = pathinfo($cleanName, PATHINFO_EXTENSION);
        $docFullName = $docFull.".".$fileType;
        $targetFilePath = $uploadDir . $docFullName;
        $allowTypes = array('jpg', 'png', 'jpeg','pdf');

        if (($_FILES["passport"]["size"] > 1000000)) {++$err;}
        if (($_FILES["cac_doc"]["size"] > 1000000)) {++$err;}
        if (($_FILES["bnk_stat"]["size"] > 1000000)) {++$err;}

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
    $cac_doc = isset($data['cac_doc']['src']) ? $data['cac_doc']['src'] : "";
    $bnk_stat = isset($data['bnk_stat']['src']) ? $data['bnk_stat']['src'] : "";

    if (!empty($user_id) && !empty($l_da) && !empty($l_ty) && !empty($m_ea) && !empty($d_om) && !empty($l_te) && !empty($s_ca) && !empty($pi_ti) && !empty($pi_ge) && !empty($pi_do)
        && !empty($pi_fn) && !empty($pi_ln) && !empty($pi_sn) && !empty($pi_em) && !empty($pi_mo) && !empty($pi_bvn) && !empty($pi_mid) && !empty($pi_iss)
        && !empty($pi_exp) && !empty($pi_idn) && !empty($li_ha) && !empty($li_ns) && !empty($li_rl) && !empty($li_rs) && !empty($biz_na) && !empty($biz_ad)
        && !empty($biz_no) && !empty($biz_tno) && !empty($loi_es) && !empty($loi_pl) && !empty($loi_n_fn) && !empty($loi_n_sn) && !empty($da_bn) && !empty($da_an)
        && !empty($da_acc_n)) {

        if ($passport=="" || $cac_doc=="" || $bnk_stat==""){
            http_response_code(200);
            echo json_encode(array("status" => 0, "message" => "Required Uploaded file not found."));
        } else {
            if ($da_agree == "Yes") {
                $ques_id = $member->create_loan_questionnaire($user_id,$l_da, $l_ty, $m_ea, $c_lo, $c_ld, $d_om, $l_te, $s_ca);
                if ($ques_id != false) {
                    if (
                    $member->create_loan_application_growth(
                        $loan_id, $ques_id, $pi_ti, $pi_ge, $pi_do, $pi_fn, $pi_ln, $pi_sn, $pi_em, $pi_mo, $pi_al, $pi_bvn, $pi_mid, $pi_iss, $pi_exp, $pi_idn,
                        $li_ha, $li_ns, $li_rl, $li_rs, $li_r_sta, $li_tcy, $li_tcm, $li_pa, $li_tpy, $li_tpm, $li_ms,
                        $biz_na, $biz_ad, $biz_no, $biz_tno, $biz_be, $biz_tn, $biz_yex,
                        $loi_es, $loi_pl, $loi_ox, $loi_el, $loi_nc, $loi_dd, $loi_ne_pr, $loi_ne_pa, $loi_n_fn, $loi_n_sn, $loi_n_re, $loi_n_ph, $loi_n_ad, $loi_la, $loi_lt, $loi_mr,
                        $passport,$cac_doc,$bnk_stat,$da_bn, $da_an, $da_acc_n, $da_h_abt, $da_if_news, $da_if_mag
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