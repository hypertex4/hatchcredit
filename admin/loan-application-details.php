<?php
include_once("./inc/header.adm.php");
if (!isset($_SESSION['ADMIN_LOGIN']['admin_id'])) header('Location: ./');
include_once('../controllers/config/database.php');
include_once('../controllers/classes/Admin.class.php');

$db = new Database();
$connection = $db->connect();
$admin = new Admin($connection);

$question_id = isset($_GET['quest_id'])?$_GET['quest_id']:die();
?>
<?php
$url = CONTROLLER_ROOT_URL."/v7/admin-loan-application-by-lq-id.php?question_id=$question_id";
$object = $api->curlQueryGet($url);
if($object->status==1)  {
foreach ($object->loan_apps as $app) {
$loan_type = $admin->get_loan_application_details($app->lq_id,$app->lq_ltype);
?>
    <style>
        @media print {
            .noprint {
                display: none;
            }
        }
    </style>
<nav class="breadcrumb sl-breadcrumb noprint">
    <a class="breadcrumb-item" href="javascript:void(0)" onclick="window.history.go(-1)"><b>Back</b></a>
    <span class="breadcrumb-item active">All Application Details</span>
</nav>
<div class="sl-pagebody">
    <div class="row row-sm mg-t-20">
        <div class="col-sm-12 col-xl-12">
            <div class="card overflow-hidden">
                <div class="card-body pd-0 bd-color-gray-lighter">
                    <div class="row no-gutters tx-center">
                        <div class="col-12 pd-y-20 p-3 tx-left">
                            <div style="display: flex; justify-content: space-between;">
                                <div>
                                    <h4 class="text-dark font-weight-bolder">LENDING APPLICATION DETAILS</h4>
                                    <h6 class="text-dark pt-2"><span style="font-weight:normal;">Date:</span> <?=date("d M, Y", strtotime($app->lq_ldate));?>
                                    <span class="ml-md-5 noprint">
                                        <?php if ($app->lq_status == "Pending"){?>
                                            <button class="btn btn-outline-secondary btn-sm disabled px-3">Pending</button>
                                        <?php } else if ($app->lq_status == "Cancelled") { ?>
                                            <button class="btn btn-outline-danger btn-sm disabled px-3">Cancelled</button>
                                        <?php } else { ?>
                                            <button class="btn btn-outline-success btn-sm disabled px-3">Approved</button>
                                        <?php } ?>
                                    </span>
                                    </h6>
                                </div>
                                <div class="justify-content-end my_img"><img src="<?=$loan_type['passport'];?>" width="60px" alt=""></div>
                            </div>
                            <table class="table table-white table-responsive table-print mg-b-0 tx-12" style="font-size: 14px">
                            <tbody>
                            <tr><th colspan="2" class="bg-dark text-white">PERSONAL DETAILS</th></tr>
                            <tr>
                                <td><span>Title: </span><span class="font-weight-bold"><?=$loan_type['ln_title'];?></span></td>
                                <td><span>Gender: </span><span class="font-weight-bold"><?=$loan_type['ln_gender'];?></span></td>
                            </tr>
                            <tr>
                                <td><span>First Name: </span><span class="font-weight-bold"><?=$loan_type['ln_fname'];?></span></td>
                                <td><span>Middle Name: </span><span class="font-weight-bold"><?=$loan_type['ln_lname'];?></span></td>
                            </tr>
                            <tr>
                                <td><span>Surname: </span><span class="font-weight-bold"><?=$loan_type['ln_sname'];?></span></td>
                                <td><span>B.V.N (Bank Verification No): </span><span class="font-weight-bold"><?=$loan_type['ln_bvn'];?></span></td>
                            </tr>
                            <tr>
                                <td><span>Date of birth: </span><span class="font-weight-bold"><?=date("d M, Y", strtotime($loan_type['ln_dob']));?></span></td>
                                <td><span>Means of Identification: </span><span class="font-weight-bold"><?=$loan_type['ln_m_of_id'];?></span></td>
                            </tr>
                            <tr>
                                <td><span>Identification No: </span><span class="font-weight-bold"><?=$loan_type['ln_m_id_no'];?></span></td>
                                <td><span>Date Issued: </span><span class="font-weight-bold"><?=date("d/m/Y", strtotime($loan_type['ln_iss_dat']));?></span></td>
                            </tr>
                            <tr>
                                <td><span>Expiry Date: </span><span class="font-weight-bold"><?=date("d/m/Y", strtotime($loan_type['ln_exp_dat']));?></span></td>
                                <td><span>Email Address: </span><span class="font-weight-bold"><?=$loan_type['ln_email'];?></span></td>
                            </tr>
                            <tr>
                                <td><span>Mobile No: </span><span class="font-weight-bold"><?=$loan_type['ln_mobile'];?></span></td>
                                <td><span>Office No: </span><span class="font-weight-bold"><?=$loan_type['ln_alt_mob'];?></span></td>
                            </tr>
                            <tr>
                                <td colspan="2"><span>Home Address: </span><span class="font-weight-bold"><?=$loan_type['ln_h_add'];?></span></td>
                            </tr>
                            <tr>
                                <td><span>Nearest B/Stop: </span><span class="font-weight-bold"><?=$loan_type['ln_n_bstop'];?></span></td>
                                <td><span>L.G.A: </span><span class="font-weight-bold"><?=$loan_type['ln_r_lga'];?></span></td>
                            </tr>
                            <tr>
                                <td><span>State: </span><span class="font-weight-bold"><?=$loan_type['ln_r_state'];?></span></td>
                                <td><span>Residential Status: </span><span class="font-weight-bold"><?=$loan_type['ln_r_status'];?></span></td>
                            </tr>
                            <tr>
                                <td><span>Time at Current Address: </span><span class="font-weight-bold"><?=$loan_type['ln_tc_yrs'];?> years</span>
                                    <span class="font-weight-bold ml-2"><?=$loan_type['ln_tc_mon'];?> month<small>(s)</small></span></td>
                                <td><span>Previous Address: </span><span class="font-weight-bold"><?=$loan_type['ln_pre_add'];?></span></td>
                            </tr>
                            <tr>
                                <td><span>Time at Previous Address: </span><span class="font-weight-bold"><?=$loan_type['ln_tp_yrs'] !=""?$loan_type['ln_tp_yrs']."years":"";?> </span>
                                    <span class="font-weight-bold ml-2"><?=$loan_type['ln_tp_mon'] != ""?$loan_type['ln_tp_mon']."month<small>(s)</small>":"";?></span></td>
                                <td><span>Marital Status: </span><span class="font-weight-bold"><?=$loan_type['ln_mar_stat'];?></span></td>
                            </tr>
                            <?php if ($app->lq_ltype =="HatchGrowth") { ?>
                            <tr><th colspan="2" class="bg-dark text-white">BUSINESS DETAILS</th></tr>
                            <tr>
                                <td><span>Business Name: </span><span class="font-weight-bold"><?=$loan_type['biz_name'];?></span></td>
                                <td><span>Business Address: </span><span class="font-weight-bold"><?=$loan_type['biz_add'];?></span></td>
                            </tr>
                            <tr>
                                <td><span>Registration No: </span><span class="font-weight-bold"><?=$loan_type['reg_num'];?></span></td>
                                <td><span>Tax ID No: </span><span class="font-weight-bold"><?=$loan_type['tax_id_no'];?></span></td>
                            </tr>
                            <tr>
                                <td><span>Telephone No: </span><span class="font-weight-bold"><?=$loan_type['tel_no'];?></span></td>
                                <td><span>Year of Experience: </span><span class="font-weight-bold"><?=$loan_type['yrs_exp'];?></span></td>
                            </tr>
                            <tr>
                                <td colspan="2"><span>Business Email Address: </span><span class="font-weight-bold"><?=$loan_type['biz_email'];?></span></td>
                            </tr>
                            <?php } else { ?>
                            <tr><th colspan="2" class="bg-dark text-white">EMPLOYMENT DETAILS</th></tr>
                            <tr>
                                <td><span>Employment Status: </span><span class="font-weight-bold"><?=$loan_type['ln_emp_sta'];?></span></td>
                                <td><span>Current Employer: </span><span class="font-weight-bold"><?=$loan_type['ln_cur_emp'];?></span></td>
                            </tr>
                            <tr>
                                <td colspan="2"><span>Current Employer Address: </span><span class="font-weight-bold"><?=$loan_type['ln_c_e_add'];?></span></td>
                            </tr>
                            <tr>
                                <td><span>Nearest B/Stop: </span><span class="font-weight-bold"><?=$loan_type['ln_c_e_st'];?></span></td>
                                <td><span>Employer LGA: </span><span class="font-weight-bold"><?=$loan_type['ln_c_e_lga'];?></span></td>
                            </tr>
                            <tr>
                                <td><span>State: </span><span class="font-weight-bold"><?=$loan_type['ln_c_e_sta'];?></span></td>
                                <td><span>Office No: </span><span class="font-weight-bold"><?=$loan_type['ln_c_off_no'];?></span></td>
                            </tr>
                            <tr>
                                <td><span>Office Email: </span><span class="font-weight-bold"><?=$loan_type['ln_c_email'];?></span></td>
                                <td><span>Staff ID No.: </span><span class="font-weight-bold"><?=$loan_type['ln_c_stf_id'];?></span></td>
                            </tr>
                            <tr>
                                <td><span>Pension No.: </span><span class="font-weight-bold"><?=$loan_type['ln_c_pen_no'];?></span></td>
                                <td><span>Tax ID No.: </span><span class="font-weight-bold"><?=$loan_type['ln_c_tax_id'];?></span></td>
                            </tr>
                            <tr>
                                <td><span>Pension No.: </span><span class="font-weight-bold"><?=$loan_type['ln_c_pen_no'];?></span></td>
                                <td><span>Tax ID No.: </span><span class="font-weight-bold"><?=$loan_type['ln_c_tax_id'];?></span></td>
                            </tr>
                            <tr>
                                <td><span>Position/Job Title: </span><span class="font-weight-bold"><?=$loan_type['ln_c_job_t'];?></span></td>
                                <td><span>Dept. & Unit: </span><span class="font-weight-bold"><?=$loan_type['ln_c_dept'];?></span></td>
                            </tr>
                            <tr>
                                <td><span>Date Employed: </span><span class="font-weight-bold"><?=$loan_type['ln_date_emp'];?></span></td>
                                <td><span>Previous Employer: </span><span class="font-weight-bold"><?=$loan_type['ln_pre_emp'];?></span></td>
                            </tr>
                            <tr>
                                <td colspan="2"><span>Previous Employer Address: </span><span class="font-weight-bold"><?=$loan_type['ln_p_emp_add'];?></span></td>
                            </tr>
                            <tr>
                                <td><span>No of Months in Previous Employment: </span><span class="font-weight-bold"><?=$loan_type['ln_p_no_mo'];?></span></td>
                                <td><span>How Many Jobs in the last 5years: </span><span class="font-weight-bold"><?=$loan_type['ln_j5_years'];?></span></td>
                            </tr>
                            <tr>
                                <td><span>Current Net Monthly Income: </span><span class="font-weight-bold">₦<?=number_format($loan_type['ln_net_sal'],2);?></span></td>
                                <td><span>Current Pay Date: </span><span class="font-weight-bold"><?=$loan_type['ln_c_p_day'];?></span></td>
                            </tr>
                            <tr>
                                <td colspan="2"><span>Industry: </span><span class="font-weight-bold"><?=$loan_type['ln_industry'];?></span></td>
                            </tr>
                            <?php } ?>
                            <tr><th colspan="2" class="bg-dark text-white">LOAN DETAILS</th></tr>
                            <tr>
                                <td><span>Educational Status: </span><span class="font-weight-bold"><?=$loan_type['ln_edu_sta'];?></span></td>
                                <td><span>Purpose of Loan: </span><span class="font-weight-bold"><?=$loan_type['ln_pof_loan'];?></span></td>
                            </tr>
                            <tr>
                                <td><span>Other Expenses: </span><span class="font-weight-bold"><?=$loan_type['ln_o_exp'];?></span></td>
                                <td><span>Existing Loan: </span><span class="font-weight-bold"><?=$loan_type['ln_exi_loan'];?></span></td>
                            </tr>
                            <tr>
                                <td><span>No of Cars Owned?: </span><span class="font-weight-bold"><?=$loan_type['ln_no_cars'];?></span></td>
                                <td><span>Do You Have a Driver: </span><span class="font-weight-bold"><?=$loan_type['ln_do_drive'];?></span></td>
                            </tr>
                            <tr>
                                <td><span>Mobile Network Provider: </span><span class="font-weight-bold"><?=$loan_type['ln_net_pro'];?></span></td>
                                <td><span>Mobile Network Package: </span><span class="font-weight-bold"><?=$loan_type['ln_net_pac'];?></span></td>
                            </tr>
                            <tr>
                                <td><span>Loan Amount Requested: </span><span class="font-weight-bold">₦<?=number_format($loan_type['ln_amount'],2);?></span></td>
                                <td><span>Loan Tenor (Months): </span><span class="font-weight-bold"><?=$loan_type['ln_tenor'];?></span></td>
                            </tr>
                            <tr>
                                <td colspan="2"><span>Affordable Monthly Payment: </span><span class="font-weight-bold">₦<?=number_format($loan_type['ln_mon_pay'],2);?></span></td>
                            </tr>
                            <tr><th colspan="2" class="bg-dark text-white">NEXT OF KIN DETAILS</th></tr>
                            <tr>
                                <td><span>First Name: </span><span class="font-weight-bold"><?=$loan_type['ln_nok_fn'];?></span></td>
                                <td><span>Surname: </span><span class="font-weight-bold"><?=$loan_type['ln_nok_sn'];?></span></td>
                            </tr>
                            <tr>
                                <td><span>Relationship: </span><span class="font-weight-bold"><?=$loan_type['ln_nok_rel'];?></span></td>
                                <td><span>Phone No.: </span><span class="font-weight-bold"><?=$loan_type['ln_nok_ph'];?></span></td>
                            </tr>
                            <tr>
                                <td colspan="2"><span>Home Address: </span><span class="font-weight-bold"><?=$loan_type['ln_nok_add'];?></span></td>
                            </tr>
                            <tr><th colspan="2" class="bg-dark text-white">DISBURSEMENT DETAILS</th></tr>
                            <tr>
                                <td colspan="2"><span>Bank Name: </span><span class="font-weight-bold"><?=$loan_type['ln_bk_name'];?></span></td>
                            </tr>
                            <tr>
                                <td colspan="2"><span>Account Name: </span><span class="font-weight-bold"><?=$loan_type['ln_acc_name'];?></span></td>
                            </tr>
                            <tr>
                                <td colspan="2"><span>Account No.: </span><span class="font-weight-bold"><?=$loan_type['ln_acc_no'];?></span></td>
                            </tr>
                            <tr>
                                <td colspan="2"><span>Here About Us From?: </span><span class="font-weight-bold"><?=$loan_type['hr_abt_us'];?></span></td>
                            </tr>
                            </tbody>
                            </table>
                            <?php if (($app->lq_ltype =="Hatch31")) { ?>
                            <table class="table table-white mt-5 noprint" style="font-size: 14px;">
                                <tbody>
                                    <tr>
                                        <td class="bg-dark text-white">Passport</td>
                                        <td class="bg-dark text-white">Confirmation Letter</td>
                                        <td class="bg-dark text-white">Bank Statement</td>
                                        <td class="bg-dark text-white">Staff ID</td>
                                        <td class="bg-dark text-white">Means of Identification</td>
                                        <td class="bg-dark text-white">Utility Bill</td>
                                    </tr>
                                    <tr>
                                        <?php if($admin->test_if_file_exist($app->lq_ltype,$loan_type['ln_sno'],"passport") > 0){ ?>
                                        <td style="border: 0;padding: 6px 12px;"><a href="<?=$loan_type['passport'];?>" download>download</a></td>
                                        <?php } else {echo '<td style="border: 0;padding: 6px 12px;">&nbsp;</td>';} ?>
                                        <?php if($admin->test_if_file_exist($app->lq_ltype,$loan_type['ln_sno'],"con_letter") > 0){ ?>
                                        <td style="border: 0;padding: 6px 12px;"><a href="<?=$loan_type['con_letter'];?>" download>download</a></td>
                                        <?php } else {echo '<td style="border: 0;padding: 6px 12px;">&nbsp;</td>';} ?>
                                        <?php if($admin->test_if_file_exist($app->lq_ltype,$loan_type['ln_sno'],"bank_stat") > 0){ ?>
                                        <td style="border: 0;padding: 6px 12px;"><a href="<?=$loan_type['bank_stat'];?>" download>download</a></td>
                                        <?php } else {echo '<td style="border: 0;padding: 6px 12px;">&nbsp;</td>';} ?>
                                        <?php if($admin->test_if_file_exist($app->lq_ltype,$loan_type['ln_sno'],"staff_idc") > 0){ ?>
                                        <td style="border: 0;padding: 6px 12px;"><a href="<?=$loan_type['staff_idc'];?>" download>download</a></td>
                                        <?php } else {echo '<td style="border: 0;padding: 6px 12px;">&nbsp;</td>';} ?>
                                        <?php if($admin->test_if_file_exist($app->lq_ltype,$loan_type['ln_sno'],"valid_idc") > 0){ ?>
                                        <td style="border: 0;padding: 6px 12px;"><a href="<?=$loan_type['valid_idc'];?>" download>download</a></td>
                                        <?php } else {echo '<td style="border: 0;padding: 6px 12px;">&nbsp;</td>';} ?>
                                        <?php if($admin->test_if_file_exist($app->lq_ltype,$loan_type['ln_sno'],"util_bill") > 0){ ?>
                                        <td style="border: 0;padding: 6px 12px;"><a href="<?=$loan_type['util_bill'];?>" download>download</a></td>
                                        <?php } else {echo '<td style="border: 0;padding: 6px 12px;">&nbsp;</td>';} ?>
                                    </tr>
                                    <tr>
                                        <?php if($admin->test_if_file_exist($app->lq_ltype,$loan_type['ln_sno'],"passport") > 0){ ?>
                                        <td style="border: 0;padding: 0 12px;"><a href="<?=$loan_type['passport'];?>" target="_blank">view</a></td>
                                        <?php } else {echo '<td style="border: 0;padding: 0 12px;">&nbsp;</td>';} ?>
                                        <?php if($admin->test_if_file_exist($app->lq_ltype,$loan_type['ln_sno'],"con_letter") > 0){ ?>
                                        <td style="border: 0;padding: 0 12px;"><a href="<?=$loan_type['con_letter'];?>" target="_blank">view</a></td>
                                        <?php } else {echo '<td style="border: 0;padding: 0 12px;">&nbsp;</td>';} ?>
                                        <?php if($admin->test_if_file_exist($app->lq_ltype,$loan_type['ln_sno'],"bank_stat") > 0){ ?>
                                        <td style="border: 0;padding: 0 12px;"><a href="<?=$loan_type['bank_stat'];?>" target="_blank">view</a></td>
                                        <?php } else {echo '<td style="border: 0;padding: 0 12px;">&nbsp;</td>';} ?>
                                        <?php if($admin->test_if_file_exist($app->lq_ltype,$loan_type['ln_sno'],"staff_idc") > 0){ ?>
                                        <td style="border: 0;padding: 0 12px;"><a href="<?=$loan_type['staff_idc'];?>" target="_blank">view</a></td>
                                        <?php } else {echo '<td style="border: 0;padding: 0 12px;">&nbsp;</td>';} ?>
                                        <?php if($admin->test_if_file_exist($app->lq_ltype,$loan_type['ln_sno'],"valid_idc") > 0){ ?>
                                        <td style="border: 0;padding: 0 12px;"><a href="<?=$loan_type['valid_idc'];?>" target="_blank">view</a></td>
                                        <?php } else {echo '<td style="border: 0;padding: 0 12px;">&nbsp;</td>';} ?>
                                        <?php if($admin->test_if_file_exist($app->lq_ltype,$loan_type['ln_sno'],"util_bill") > 0){ ?>
                                        <td style="border: 0;padding: 0 12px;"><a href="<?=$loan_type['util_bill'];?>" target="_blank">view</a></td>
                                        <?php } else {echo '<td style="border: 0;padding: 0 12px;">&nbsp;</td>';} ?>
                                    </tr>
                                    <tr>
                                        <td style="border: 0;padding: 6px 12px;">&nbsp;</td>
                                        <?php if($admin->test_if_file_exist($app->lq_ltype,$loan_type['ln_sno'],"con_letter") > 0){ ?>
                                        <td style="border: 0;padding: 6px 12px;">
                                            <a id=deleteFile" class="text-danger" href="javascript:void(0)" data-type="<?=$app->lq_ltype;?>" data-field="con_letter" data-file="<?=$loan_type['con_letter'];?>" data-ln_id="<?=$loan_type['ln_sno'];?>">delete</a>
                                        </td>
                                        <?php } else {echo '<td style="border: 0;padding: 6px 12px;">&nbsp;</td>';} ?>
                                        <?php if($admin->test_if_file_exist($app->lq_ltype,$loan_type['ln_sno'],"bank_stat") > 0){ ?>
                                        <td style="border: 0;padding: 6px 12px;">
                                            <a id="deleteFile" class="text-danger" href="javascript:void(0)" data-type="<?=$app->lq_ltype;?>" data-field="bank_stat" data-file="<?=$loan_type['bank_stat'];?>" data-ln_id="<?=$loan_type['ln_sno'];?>">delete</a>
                                        </td>
                                        <?php } else {echo '<td style="border: 0;padding: 6px 12px;">&nbsp;</td>';} ?>
                                        <?php if($admin->test_if_file_exist($app->lq_ltype,$loan_type['ln_sno'],"staff_idc") > 0){ ?>
                                        <td style="border: 0;padding: 6px 12px;">
                                            <a id="deleteFile" class="text-danger" href="javascript:void(0)" data-type="<?=$app->lq_ltype;?>" data-field="staff_idc" data-file="<?=$loan_type['staff_idc'];?>" data-ln_id="<?=$loan_type['ln_sno'];?>">delete</a>
                                        </td>
                                        <?php } else {echo '<td style="border: 0;padding: 6px 12px;">&nbsp;</td>';} ?>
                                        <?php if($admin->test_if_file_exist($app->lq_ltype,$loan_type['ln_sno'],"valid_idc") > 0){ ?>
                                        <td style="border: 0;padding: 6px 12px;">
                                            <a id="deleteFile" class="text-danger" href="javascript:void(0)" data-type="<?=$app->lq_ltype;?>" data-field="valid_idc" data-file="<?=$loan_type['valid_idc'];?>" data-ln_id="<?=$loan_type['ln_sno'];?>">delete</a>
                                        </td>
                                        <?php } else {echo '<td style="border: 0;padding: 6px 12px;">&nbsp;</td>';} ?>
                                        <?php if($admin->test_if_file_exist($app->lq_ltype,$loan_type['ln_sno'],"util_bill") > 0){ ?>
                                        <td style="border: 0;padding: 6px 12px;">
                                            <a id="deleteFile" class="text-danger" href="javascript:void(0)" data-type="<?=$app->lq_ltype;?>" data-field="util_bill" data-file="<?=$loan_type['util_bill'];?>" data-ln_id="<?=$loan_type['ln_sno'];?>">delete</a>
                                        </td>
                                        <?php } else {echo '<td style="border: 0;padding: 6px 12px;">&nbsp;</td>';} ?>
                                    </tr>
                                </tbody>
                            </table>
                            <?php } else { ?>
                            <table class="table table-white table-responsive mg-b-0 tx-12" id="scr_bot" style="font-size: 14px">
                                <tbody>
                                <tr>
                                    <td class="bg-dark text-white">Passport</td>
                                    <td class="bg-dark text-white">CAC Documentation</td>
                                    <td class="bg-dark text-white">Bank Statement</td>
                                </tr>
                                <tr>
                                    <?php if($admin->test_if_file_exist($app->lq_ltype,$loan_type['lg_sno'],"passport") > 0){ ?>
                                        <td style="border: 0;padding: 6px 12px;"><a href="<?=$loan_type['passport'];?>" download>download</a></td>
                                    <?php } else {echo '<td style="border: 0;padding: 6px 12px;">&nbsp;</td>';} ?>
                                    <?php if($admin->test_if_file_exist($app->lq_ltype,$loan_type['lg_sno'],"cac_doc") > 0){ ?>
                                        <td style="border: 0;padding: 6px 12px;"><a href="<?=$loan_type['cac_doc'];?>" download>download</a></td>
                                    <?php } else {echo '<td style="border: 0;padding: 6px 12px;">&nbsp;</td>';} ?>
                                    <?php if($admin->test_if_file_exist($app->lq_ltype,$loan_type['lg_sno'],"bank_stat") > 0){ ?>
                                        <td style="border: 0;padding: 6px 12px;"><a href="<?=$loan_type['bank_stat'];?>" download>download</a></td>
                                    <?php } else {echo '<td style="border: 0;padding: 6px 12px;">&nbsp;</td>';} ?>
                                </tr>
                                <tr>
                                    <?php if($admin->test_if_file_exist($app->lq_ltype,$loan_type['lg_sno'],"passport") > 0){ ?>
                                        <td style="border: 0;padding: 0 12px;"><a href="<?=$loan_type['passport'];?>" target="_blank">view</a></td>
                                    <?php } else {echo '<td style="border: 0;padding: 0 12px;">&nbsp;</td>';} ?>
                                    <?php if($admin->test_if_file_exist($app->lq_ltype,$loan_type['lg_sno'],"cac_doc") > 0){ ?>
                                        <td style="border: 0;padding: 0 12px;"><a href="<?=$loan_type['cac_doc'];?>" target="_blank">view</a></td>
                                    <?php } else {echo '<td style="border: 0;padding: 0 12px;">&nbsp;</td>';} ?>
                                    <?php if($admin->test_if_file_exist($app->lq_ltype,$loan_type['lg_sno'],"bank_stat") > 0){ ?>
                                        <td style="border: 0;padding: 0 12px;"><a href="<?=$loan_type['bank_stat'];?>" target="_blank">view</a></td>
                                    <?php } else {echo '<td style="border: 0;padding: 0 12px;">&nbsp;</td>';} ?>
                                </tr>
                                <tr>
                                    <td style="border: 0;padding: 6px 12px;">&nbsp;</td>
                                    <?php if($admin->test_if_file_exist($app->lq_ltype,$loan_type['lg_sno'],"cac_doc") > 0){ ?>
                                        <td style="border: 0;padding: 6px 12px;">
                                            <a id="deleteFile" class="text-danger" href="javascript:void(0)" data-type="<?=$app->lq_ltype;?>" data-field="cac_doc" data-file="<?=$loan_type['cac_doc'];?>" data-ln_id="<?=$loan_type['lg_sno'];?>">delete</a>
                                        </td>
                                    <?php } else {echo '<td style="border: 0;padding: 6px 12px;">&nbsp;</td>';} ?>
                                    <?php if($admin->test_if_file_exist($app->lq_ltype,$loan_type['lg_sno'],"bank_stat") > 0){ ?>
                                        <td style="border: 0;padding: 6px 12px;">
                                            <a id="deleteFile" class="text-danger" href="javascript:void(0)" data-type="<?=$app->lq_ltype;?>" data-field="bank_stat" data-file="<?=$loan_type['bank_stat'];?>" data-ln_id="<?=$loan_type['lg_sno'];?>">delete</a>
                                        </td>
                                    <?php } else { echo '<td style="border: 0;padding: 6px 12px;">&nbsp;</td>'; } ?>
                                </tr>
                                </tbody>
                            </table>
                            <?php } ?>
                        </div>
                        <div class="col-12 pd-y-20 p-3 tx-left noprint">
                            <?php if ($app->lq_status == "Pending") { ?>
                            <div style="display:flex;justify-content: space-between">
                                <button id="updateStatus" class="btn btn-success btn-sm" data-l_id="<?=$app->lq_id;?>" data-status="Approved">
                                    <i class="fa fa-check-circle mg-r-2"></i> Approve
                                </button>
                                <button id="printLoanjjjj" class="btn btn-secondary justify-content-center btn-sm" onclick="window.print()">
                                    <i class="fa fa-print mg-r-2"></i>Print
                                </button>
                                <button id="updateStatus" class="btn btn-danger justify-content-end btn-sm" data-l_id="<?=$app->lq_id;?>" data-status="Cancelled">
                                    <i class="fa fa-trash mg-r-2"></i>Cancel
                                </button>
                            </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php } } ?>
<?php include_once("./inc/footer.adm.php"); ?>
<script>
    $(function () {
        var url = new URL(window.location.href);
        var scrollTo = url.searchParams.get("scrollTo");
        if (scrollTo === "scr_bot"){
            $("html, body").animate({ scrollTop: $(document).height() }, 1000);
        }
    })
</script>
