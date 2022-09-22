<?php


class Member {
    private $conn;

    public function __construct($db){
        $this->conn = $db;
    }

    public function create_member($f_name,$l_name,$s_name,$email,$phone,$password) {
        //Delete any existing user token entry
        $del_user_obj = $this->conn->prepare("DELETE FROM tbl_users WHERE u_email=? AND u_active='0'");
        $del_user_obj->bind_param("s",$email);
        $del_user_obj->execute();

        $user_query = "INSERT INTO tbl_users SET user_id=?,u_fname=?,u_lname=?,u_sname=?,u_email=?,u_mobile=?,u_password=?";
        $user_obj = $this->conn->prepare($user_query);

        $user_id = rand(10000,99999);
        $f_name = htmlspecialchars(strip_tags($f_name));
        $l_name = htmlspecialchars(strip_tags($l_name));
        $s_name = htmlspecialchars(strip_tags($s_name));
        $email = htmlspecialchars(strip_tags($email));
        $phone = htmlspecialchars(strip_tags($phone));
        $password = htmlspecialchars(strip_tags($password));
        $user_obj->bind_param("sssssss",$user_id,$f_name,$l_name,$s_name,$email,$phone,$password);
        if ($user_obj->execute()){
            return true;
        }
        return false;
    }

    public function create_temp_activate_account($email,$f_name) {
        $expires = date("U") + 7200;
        $del_reset_obj = $this->conn->prepare("DELETE FROM tbl_temp_activate_account WHERE temp_email=?");
        $del_reset_obj->bind_param("s",$email);
        $del_reset_obj->execute();

        $otp= rand(100000,999999);

        $temp_query = "INSERT INTO tbl_temp_activate_account SET temp_email=?,temp_fname=?,temp_token=?,temp_expire=?";
        $temp_obj = $this->conn->prepare($temp_query);
        $temp_obj->bind_param("ssss",$email,$f_name,$otp,$expires);
        if ($temp_obj->execute()){
            $toEmail = $email;
            $subject = "Hatchcredit Account Activation";
            $content = "<html>
                        <head>
                            <meta http-equiv='Content-Type' content='text/html; charset=utf-8'>
                            <meta name='viewport' content='width=device-width, initial-scale=1.0'>
                            <title>Hatch Credit</title>
                            <style>
                            @import url('https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,300;0,500;0,700;0,900;1,300&display=swap');
                            body {font-family: 'Roboto', sans-serif;font-weight: 400}
                            .wrapper {max-width: 600px;margin: 0 auto}
                            .company-name {text-align: left;background-color: #2b333e;padding: 20px;}
                            table {width: 100%;}
                            .table-head {color: #fff;}
                            .mt-3 {margin-top: 3em;}
                            a {text-decoration: none;}
                            .not-active { pointer-events: none !important; cursor: default !important; color:#740774;font-weight:bolder; }
                        </style>
                        </head>
                        <body>
                            <div class='wrapper'>
                            <table>
                                <thead>
                                    <tr>
                                        <th class='table-head' colspan='4'><h1 class='company-name'>HatchCredit</h1></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                            <div class='mt-3'>
                                                <p>Dear ".$f_name.",</p>
                                                <p>
                                                    Welcome to HatchCredit. Thank you for joining us. Get ready to begin an exciting journey instant loan access!
                                                </p>
                                                <p>Enter the code below to complete your registration:</p>
                                                <div style='background:#E7E7E7;padding:20px 0;width:250px;margin: 0 auto;text-align:center;font-size:35px;color:#787878'>".$otp."</div>
                                                <p>NB: This OTP will expire after 2hrs.</p>
                                                <p>Thank you once again for joining us. Have a nice day.</p>
                                                <p>Regards,<br/>The HatchCredit Team</p>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        </body>
                        </html>";
            $mailHeaders ="MIME-Version: 1.0"."\r\n";
            $mailHeaders .="Content-type:text/html;charset=UTF-8"."\r\n";
            $mailHeaders .= "From: HatchCredit <info@hatchcredit.com.ng>\r\n";
            if (mail($toEmail, $subject, $content, $mailHeaders)) {
                return true;
            }
            return false;
        }
        return false;
    }

    public function check_email($email){
        $email_query = "SELECT * FROM tbl_users WHERE u_email=?";
        $user_obj = $this->conn->prepare($email_query);
        $user_obj->bind_param("s", $email);
        if ($user_obj->execute()) {
            $data = $user_obj->get_result();
            return $data->fetch_assoc();
        }
        return array();
    }

    public function check_active_account($email){
        $email_query = "SELECT * FROM tbl_users WHERE u_email=? AND u_active='1'";
        $user_obj = $this->conn->prepare($email_query);
        $user_obj->bind_param("s", $email);
        if ($user_obj->execute()) {
            $data = $user_obj->get_result();
            if ($data->num_rows > 0) {
                return $data->fetch_assoc();
            }
            return array();
        }
        return array();
    }

    public function check_account_activation_credentials($temp_token){
        $currentDate = date("U");
        $check_query = "SELECT * FROM tbl_temp_activate_account WHERE temp_token=? AND temp_expire >= ?";
        $check_obj = $this->conn->prepare($check_query);
        $check_obj->bind_param("ss", $temp_token,$currentDate);
        if ($check_obj->execute()){
            $data = $check_obj->get_result();
            return $data->fetch_assoc();
        }
        return array();
    }

    public function activate_account($email){
        $email_query = "UPDATE tbl_users SET u_active='1' WHERE u_email=? ";
        $user_obj = $this->conn->prepare($email_query);
        $user_obj->bind_param("s", $email);
        if ($user_obj->execute()){
            if ($user_obj->affected_rows > 0) {
                $del_reset_obj = $this->conn->prepare("DELETE FROM tbl_temp_activate_account WHERE temp_email=?");
                $del_reset_obj->bind_param("s",$email);
                $del_reset_obj->execute();
                return true;
            }
            return false;
        }
        return false;
    }

    public function login_user($email) {
        $email_query = "SELECT * FROM tbl_users WHERE u_email=? AND u_active='1'";
        $user_obj = $this->conn->prepare($email_query);
        $user_obj->bind_param("s", $email);
        if ($user_obj->execute()){
            $data = $user_obj->get_result();
            return $data->fetch_assoc();
        }
        return array();
    }

    public function reset_password_request($email){
        $selector = bin2hex(random_bytes(4));
        $token = random_bytes(15);

        $host = "www.$_SERVER[HTTP_HOST]/";
//        $host = "www.$_SERVER[HTTP_HOST]/loan/";
        $url= $host."/reset-password/".$selector."/".bin2hex($token);
        $expires = date("U") + 1200;

        //Delete any existing user token entry
        $del_reset_obj = $this->conn->prepare("DELETE FROM tbl_pwd_reset WHERE reset_email=?");
        $del_reset_obj->bind_param("s",$email);
        $del_reset_obj->execute();

        //Insert reset credentials
        $reset_query = "INSERT INTO tbl_pwd_reset SET reset_email=?,reset_selector=?,reset_token=?,reset_expires=?";
        $reset_obj = $this->conn->prepare($reset_query);
        $hashedToken = password_hash($token, PASSWORD_DEFAULT);
        $reset_obj->bind_param("ssss",$email,$selector,$hashedToken,$expires);
        //execute query
        if ($reset_obj->execute()) {
            $to = $email;
            $subject = "Hatchcredit password reset";
            $content = '<!DOCTYPE html>
                        <html lang="en">
                        <head>
                            <meta charset="UTF-8">
                            <meta name="viewport" content="width=device-width, initial-scale=1.0">
                            <title>Hatchcredit Reset Password</title>
                        </head>
                        <style>
                            @import url("https://fonts.googleapis.com/css2?family=Roboto:wght@100;300;400;500;700;900&display=swap");
                            * {box-sizing: border-box;}
                            body {font-family: "Roboto", sans-serif;margin: 0;padding: 0;font-size: 14px;line-height: 20px;}
                            h2 {margin: 0;}
                            table {margin: 2em;}
                            @media(min-width: 700px) {  body {font-size: 15px;}  }
                        </style>
                        <body>
                            <div style="max-width:600px;margin:0 auto;line-height:30px">
                                <table style="border: 1px solid #c4c4c4;">
                                    <thead>
                                        <tr>
                                            <th>
                                                <h2 style="text-align: center;background:#ffffff;color: #ffffff;padding:.3em .7em">
                                                    <img src="https://i.ibb.co/FYLzLMd/HCL-Logo.png" alt="HCL-Logo" style="max-width:200px;" border="0">
                                                </h2>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td style="padding: .7em 2em;">
                                                <p style="font-weight: 600">You’re receiving this mail because you requested a password reset for your
                                                    Hatchcredit.<br /><br /> Please tap the link below to create a new password :<br />
                                                    <a style="color: #2b333e;" href="'.$url.'">'.$url.'</a>
                                                </p>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </body>
                        </html>';
            $mailHeaders ="MIME-Version: 1.0"."\r\n";
            $mailHeaders .="Content-type:text/html;charset=UTF-8"."\r\n";
            $mailHeaders .= "From: HatchCredit <info@hatchcredit.com.ng>\r\n";
            if (mail($to, $subject, $content, $mailHeaders)) {
                return true;
            }
            return false;
        }
        return false;
    }

    public function check_reset_pwd_credentials($reset_selector){
        $currentDate = date("U");
        $email_query = "SELECT * FROM tbl_pwd_reset WHERE reset_selector=? AND reset_expires >= ?";
        $cust_obj = $this->conn->prepare($email_query);
        $cust_obj->bind_param("ss",$reset_selector,$currentDate);
        if ($cust_obj->execute()){
            $data = $cust_obj->get_result();
            return $data->fetch_assoc();
        }
        return array();
    }

    public function update_reset_password($password,$email) {
        $update_query = "UPDATE tbl_users SET u_password=? WHERE u_email=?";
        $update_obj = $this->conn->prepare($update_query);
        $update_obj->bind_param("ss",$password,$email);
        if ($update_obj->execute()){
            if ($update_obj->affected_rows > 0) {
                $del_reset_obj = $this->conn->prepare("DELETE FROM tbl_pwd_reset WHERE reset_email=?");
                $del_reset_obj->bind_param("s",$email);
                $del_reset_obj->execute();
                return true;
            }
            return false;
        }
        return false;
    }

    public function update_account_profile($fn,$ln,$sn,$em,$mb,$user_id){
        $update_query = "UPDATE tbl_users SET u_fname=?,u_lname=?,u_sname=?,u_email=?,u_mobile=? WHERE user_id=?";
        $update_obj = $this->conn->prepare($update_query);
        $update_obj->bind_param("ssssss",$fn,$ln,$sn,$em,$mb,$user_id);
        if ($update_obj->execute()){
            if ($update_obj->affected_rows > 0){
                return true;
            }
            return false;
        } else {
            return false;
        }
    }

    public function update_account_password($pwd,$user_id){
        $update_query = "UPDATE tbl_users SET u_password=? WHERE user_id=?";
        $update_obj = $this->conn->prepare($update_query);
        $update_obj->bind_param("ss",$pwd,$user_id);
        if ($update_obj->execute()){
            if ($update_obj->affected_rows > 0){
                return true;
            }
            return false;
        } else {
            return false;
        }
    }

    public function clean($string) {
        $string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.
        return preg_replace('/[^a-z0-9\_\-\.]/i', '', $string); // Removes special chars.
    }

    public function create_loan_questionnaire($user_id,$l_da,$l_ty,$m_ea,$c_lo,$c_ld,$d_om,$l_te,$s_ca){
        $loan_quest = "INSERT INTO tbl_loan_questions SET user_id=?,lq_ldate=?,lq_ltype=?,lq_earn=?,lq_curr_loan=?,lq_loan_dec_amt=?,lq_d_of_mon=?,lq_loan_tenor=?,lq_sal_curr_acc=?";
        $loan_quest = $this->conn->prepare($loan_quest);
        $loan_quest->bind_param("sssdsssss",$user_id,$l_da,$l_ty,$m_ea,$c_lo,$c_ld,$d_om,$l_te,$s_ca);
        if ($loan_quest->execute()){
            $qs_id = mysqli_insert_id($this->conn);
            return $qs_id;
        }
        return false;
    }

    public function create_loan_application(
        $loan_id, $ques_id, $pi_ti, $pi_ge, $pi_do, $pi_fn, $pi_ln, $pi_sn, $pi_em, $pi_mo, $pi_al, $pi_bvn, $pi_mid, $pi_iss, $pi_exp, $pi_idn,
        $li_ha, $li_ns, $li_rl, $li_rs, $li_r_sta, $li_tcy, $li_tcm, $li_pa, $li_tpy, $li_tpm, $li_ms,
        $emp_st, $emp_ce, $emp_ca, $emp_cs, $emp_cl, $emp_cst, $emp_ofn, $emp_em, $emp_sid, $emp_pn, $emp_tid, $emp_jt, $emp_de, $emp_dem,
        $emp_pen, $emp_pea, $emp_pnm, $emp_j5, $emp_ns, $emp_pd, $emp_in,
        $loi_es, $loi_pl, $loi_ox, $loi_el, $loi_nc, $loi_dd, $loi_ne_pr, $loi_ne_pa, $loi_n_fn, $loi_n_sn, $loi_n_re, $loi_n_ph, $loi_n_ad, $loi_la, $loi_lt, $loi_mr,
        $passport,$con_letter,$bnk_stat,$staff_idc,$valid_idc,$util_bill,$da_bn, $da_an, $da_acc_n, $da_h_abt, $da_if_news, $da_if_mag
    ) {
        $loan_quest = "INSERT INTO tbl_loan_application SET 
                ln_id=?,lq_id=?,ln_title=?,ln_gender=?,ln_dob=?,ln_fname=?,ln_lname=?,ln_sname=?,ln_email=?,ln_mobile=?,ln_alt_mob=?,ln_bvn=?,ln_m_of_id=?,ln_iss_dat=?,ln_exp_dat=?,ln_m_id_no=?,
                ln_h_add=?,ln_n_bstop=?,ln_r_lga=?,ln_r_state=?,ln_r_status=?,ln_tc_yrs=?,ln_tc_mon=?,ln_pre_add=?,ln_tp_yrs=?,ln_tp_mon=?,ln_mar_stat=?,
                ln_emp_sta=?,ln_cur_emp=?,ln_c_e_add=?,ln_c_e_st=?,ln_c_e_lga=?,ln_c_e_sta=?,ln_c_off_no=?,ln_c_email=?,ln_c_stf_id=?,ln_c_pen_no=?,ln_c_tax_id=?,ln_c_job_t=?,ln_c_dept=?,ln_date_emp=?,
                ln_pre_emp=?,ln_p_emp_add=?,ln_p_no_mo=?,ln_j5_years=?,ln_net_sal=?,ln_c_p_day=?,ln_industry=?,
                ln_edu_sta=?,ln_pof_loan=?,ln_o_exp=?,ln_exi_loan=?,ln_no_cars=?,ln_do_drive=?,ln_net_pro=?,ln_net_pac=?,ln_nok_fn=?,ln_nok_sn=?,ln_nok_rel=?,ln_nok_ph=?,ln_nok_add=?,ln_amount=?,ln_tenor=?,ln_mon_pay=?,
                passport=?,con_letter=?,bank_stat=?,staff_idc=?,valid_idc=?,util_bill=?,ln_bk_name=?,ln_acc_name=?,ln_acc_no=?,hr_abt_us=?,if_news_p=?,if_magazine=?";
        $loan_quest = $this->conn->prepare($loan_quest);
        $loan_quest->bind_param(
            "sisssssssssssssssssssssssssssssssssssssssssssdssssssssssssssssssssssssssssss",
            $loan_id, $ques_id, $pi_ti, $pi_ge, $pi_do, $pi_fn, $pi_ln, $pi_sn, $pi_em, $pi_mo, $pi_al, $pi_bvn, $pi_mid, $pi_iss, $pi_exp, $pi_idn,
            $li_ha, $li_ns, $li_rl, $li_rs, $li_r_sta, $li_tcy, $li_tcm, $li_pa, $li_tpy, $li_tpm, $li_ms,
            $emp_st, $emp_ce, $emp_ca, $emp_cs, $emp_cl, $emp_cst, $emp_ofn, $emp_em, $emp_sid, $emp_pn, $emp_tid, $emp_jt, $emp_de, $emp_dem,
            $emp_pen, $emp_pea, $emp_pnm, $emp_j5, $emp_ns, $emp_pd, $emp_in,
            $loi_es, $loi_pl, $loi_ox, $loi_el, $loi_nc, $loi_dd, $loi_ne_pr, $loi_ne_pa, $loi_n_fn, $loi_n_sn, $loi_n_re, $loi_n_ph, $loi_n_ad, $loi_la, $loi_lt, $loi_mr,
            $passport,$con_letter,$bnk_stat,$staff_idc,$valid_idc,$util_bill,$da_bn, $da_an, $da_acc_n, $da_h_abt, $da_if_news, $da_if_mag
        );
        if ($loan_quest->execute()){
            $this->send_loan_application_mail_to_adm($pi_fn." ".$pi_sn,$pi_mo,$pi_em,$loi_la,$loi_lt);
            return true;
        }
        return false;
    }

    public function create_loan_application_growth(
        $loan_id, $ques_id, $pi_ti, $pi_ge, $pi_do, $pi_fn, $pi_ln, $pi_sn, $pi_em, $pi_mo, $pi_al, $pi_bvn, $pi_mid, $pi_iss, $pi_exp, $pi_idn,
        $li_ha, $li_ns, $li_rl, $li_rs, $li_r_sta, $li_tcy, $li_tcm, $li_pa, $li_tpy, $li_tpm, $li_ms,
        $biz_na, $biz_ad, $biz_no, $biz_tno, $biz_be, $biz_tn, $biz_yex,
        $loi_es, $loi_pl, $loi_ox, $loi_el, $loi_nc, $loi_dd, $loi_ne_pr, $loi_ne_pa, $loi_n_fn, $loi_n_sn, $loi_n_re, $loi_n_ph, $loi_n_ad, $loi_la, $loi_lt, $loi_mr,
        $passport,$cac_doc,$bnk_stat,$da_bn, $da_an, $da_acc_n, $da_h_abt, $da_if_news, $da_if_mag
    ) {
        $loan_quest = "INSERT INTO tbl_loan_application_growth SET 
                ln_id=?,lq_id=?,ln_title=?,ln_gender=?,ln_dob=?,ln_fname=?,ln_lname=?,ln_sname=?,ln_email=?,ln_mobile=?,ln_alt_mob=?,ln_bvn=?,ln_m_of_id=?,ln_iss_dat=?,ln_exp_dat=?,ln_m_id_no=?,
                ln_h_add=?,ln_n_bstop=?,ln_r_lga=?,ln_r_state=?,ln_r_status=?,ln_tc_yrs=?,ln_tc_mon=?,ln_pre_add=?,ln_tp_yrs=?,ln_tp_mon=?,ln_mar_stat=?,
                biz_name=?,biz_add=?,reg_num=?,tax_id_no=?,biz_email=?,tel_no=?,yrs_exp=?,
                ln_edu_sta=?,ln_pof_loan=?,ln_o_exp=?,ln_exi_loan=?,ln_no_cars=?,ln_do_drive=?,ln_net_pro=?,ln_net_pac=?,ln_nok_fn=?,ln_nok_sn=?,ln_nok_rel=?,ln_nok_ph=?,ln_nok_add=?,ln_amount=?,ln_tenor=?,ln_mon_pay=?,
                passport=?,cac_doc=?,bank_stat=?,ln_bk_name=?,ln_acc_name=?,ln_acc_no=?,hr_abt_us=?,if_news_p=?,if_magazine=?";
        $loan_quest = $this->conn->prepare($loan_quest);
        $loan_quest->bind_param(
            "sisssssssssssssssssssssssssssssssssssssssssssdsssssssssssss",
            $loan_id, $ques_id, $pi_ti, $pi_ge, $pi_do, $pi_fn, $pi_ln, $pi_sn, $pi_em, $pi_mo, $pi_al, $pi_bvn, $pi_mid, $pi_iss, $pi_exp, $pi_idn,
            $li_ha, $li_ns, $li_rl, $li_rs, $li_r_sta, $li_tcy, $li_tcm, $li_pa, $li_tpy, $li_tpm, $li_ms,
            $biz_na, $biz_ad, $biz_no, $biz_tno, $biz_be, $biz_tn, $biz_yex,
            $loi_es, $loi_pl, $loi_ox, $loi_el, $loi_nc, $loi_dd, $loi_ne_pr, $loi_ne_pa, $loi_n_fn, $loi_n_sn, $loi_n_re, $loi_n_ph, $loi_n_ad, $loi_la, $loi_lt, $loi_mr,
            $passport,$cac_doc,$bnk_stat,$da_bn, $da_an, $da_acc_n, $da_h_abt, $da_if_news, $da_if_mag
        );
        if ($loan_quest->execute()){
            $this->send_loan_application_mail_to_adm($pi_fn." ".$pi_sn,$pi_mo,$pi_em,$loi_la,$loi_lt);
            return true;
        }
        return false;
    }

    public function fetch_loan_application_by_user_id_lim_10($user_id,$limit){
        $art_query = "SELECT * FROM tbl_loan_questions WHERE user_id=$user_id ORDER BY lq_id DESC LIMIT $limit";
        $art_obj = $this->conn->prepare($art_query);
        if ($art_obj->execute()) {
            return $art_obj->get_result();
        }
        return array();
    }

    public function get_loan_application_details($ln_qt, $type){
        if ($type=="Hatch31"){
            $query = "SELECT * FROM tbl_loan_application WHERE lq_id=$ln_qt LIMIT 1";
        } else {
            $query = "SELECT * FROM tbl_loan_application_growth WHERE lq_id=$ln_qt LIMIT 1";
        }
        $q_obj = $this->conn->prepare($query);
        if ($q_obj->execute()) {
            return $q_obj->get_result()->fetch_assoc();
        }
        return array();
    }

    public function send_loan_application_mail_to_adm($full_name, $phone, $email, $amt, $tenor){
//        $toEmail = 'support@liteouz.com';
        $toEmail = 'fredrickbdn@gmail.com';
        $link = "www.$_SERVER[HTTP_HOST]";
        $subject = "Hatchcredit new loan application alert!";
        $content = "<html>
                    <head>
                        <meta http-equiv='Content-Type' content='text/html; charset=utf-8'>
                        <meta name='viewport' content='width=device-width, initial-scale=1.0'>
                        <title>Hatchcredit</title>
                        <style>
                            @import url('https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,300;0,500;0,700;0,900;1,300&display=swap');
                            body {font-family: 'Roboto', sans-serif;font-weight: 400}
                            .wrapper {max-width: 600px;margin: 0 auto}
                            .company-name {text-align: left}
                            table {width: 80%;}
                        </style>
                    </head>
                    <body>
                    <div class='wrapper'>
                        <table>
                            <thead>
                            <tr><th class='table-head' colspan='4'><h1 class='company-name'>Hatchcredit</h1></th></tr>
                            </thead>
                            <tbody>
                            <div class='mt-3'>
                                <p>Hi, Admin</p>
                                <p>" . $full_name . " (" . $email . ") with Mobile number " . $phone . ", applied for a loan. </p>
                                <p>Loan details:</p>
                                <p>Amount: ₦".number_format($amt,0)."</p>
                                <p>Tenor: ".$tenor." months</p>
                                <p>Kindly login to your dashboard to see details</p>
                            </div>
                            </tbody>
                        </table>
                    </div>
                    </body>
                    </html>";
        $mailHeaders = "MIME-Version: 1.0" . "\r\n";
        $mailHeaders .= "Content-type:text/html;charset=UTF-8" . "\r\n";
        $mailHeaders .= "From: Hatchcredit <" . $email . ">\r\n";
        if (mail($toEmail, $subject, $content, $mailHeaders)) {
            return true;
        }
        return false;
    }

}

?>