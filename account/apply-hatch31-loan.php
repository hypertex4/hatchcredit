<?php
if (!isset($_SESSION['MEMBER_LOGIN']) && !empty($_SESSION['MEMBER_LOGIN']['user_id'])) header("Location: ../index");
include_once("../inc/header.nav.php");
?>
<nav class="breadcrumb sl-breadcrumb">
    <a class="breadcrumb-item" href="account/index">User Account</a>
    <span class="breadcrumb-item active">Apply for Loan</span>
</nav>
<div class="sl-pagebody">
    <div class="row row-sm mg-t-20">
        <div class="col-xl-12 col-12">
            <div class="card overflow-hidden">
                <div class="card-header bg-transparent pd-y-20 d-sm-flex align-items-center justify-content-between">
                    <div class="mg-b-20 mg-sm-b-0">
                        <h6 class="card-title mg-b-5 tx-13 tx-uppercase tx-bold tx-spacing-1">Apply for Hatch31 Loan</h6>
                        <span class="d-block tx-12"><?=date("F d, Y");?></span>
                    </div>
                </div>
                <div class="card-body pd-0 bd-color-gray-lighter">
                    <div class="row no-gutters tx-center">
                        <div class="col-12 pd-y-0 tx-left">
                            <div class="card pd-20 pd-sm-40 mg-t-0">
                                <form id="applyLoanWizard" name="applyLoanWizard">
                                    <h3>Loan Questionnaire</h3>
                                    <section class="p-3">
                                        <h6>Kindly answer this questions correctly as it will enable us to determine if you are eligible for a loan.</h6>
                                        <div class="row row-xs mg-t-10">
                                            <div class="form-group col-sm-6 col-md-6">
                                                <label for="l_date" class="form-control-label">Loan Date? <span class="tx-danger">*</span></label>
                                                <input type="text" id="l_date" class="form-control" name="l_date" value="<?=date("m-d-Y");?>" readonly>
                                                <input type="hidden" id="loan_type" name="loan_type" value="Hatch31">
                                                <input type="hidden" id="user_id" name="user_id" value="<?=$_SESSION['MEMBER_LOGIN']['user_id']?>">
                                            </div>
                                            <div class="form-group col-sm-6 col-md-6">
                                                <label for="u_earn" class="form-control-label">How much do you earn Monthly after tax? <span class="tx-danger">*</span></label>
                                                <input type="text" id="u_earn" class="form-control" name="u_earn" required>
                                            </div>
                                        </div>
                                        <div class="row row-xs mg-t-10">
                                            <div class="form-group2 col-sm-12 col-md-12">
                                                <label for="curr_loan" class="form-control-label">
                                                    Do you currently have any ongoing loan with any financial or non-financial institutions
                                                    for example Banks, Micro-finance, Credit Companies, Co-operatives)?
                                                    <span class="tx-danger">*</span>
                                                </label>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <label class="rdiobox">
                                                    <input name="curr_loan" type="radio" value="Yes" style="display: unset">
                                                    <span>Yes</span>
                                                </label>
                                            </div>
                                            <div class="col-lg-6">
                                                <label class="rdiobox">
                                                    <input name="curr_loan" type="radio" value="No" style="display: unset" checked>
                                                    <span>No</span>
                                                </label>
                                            </div>
                                        </div>
                                        <div class="row row-xs mg-t-10">
                                            <div class="form-group col-sm-6 col-md-6">
                                                <label for="cur_loan_d" class="form-control-label" style="font-size: 10.6px">IF YES how much is deducted from your account monthly?</label>
                                                <input type="number" id="cur_loan_d" class="form-control" name="cur_loan_d" data-parsley-type="digits">
                                            </div>
                                            <div class="form-group col-sm-6 col-md-6">
                                                <label for="d_of_mon" class="form-control-label">What day of the month is your salary paid monthly?</label>
                                                <input type="text" id="d_of_mon" class="form-control" data-parsley-range="[1,31]" name="d_of_mon" required>
                                            </div>
                                        </div>
                                        <div class="row row-xs mg-t-10">
                                            <div class="form-group col-sm-6 col-md-6">
                                                <label for="loan_tenor" class="form-control-label">What Tenor do you need the loan for (Months)?</label>
                                                <input type="text" id="loan_tenor" class="form-control" data-parsley-range="[1,12]" name="loan_tenor" required>
                                            </div>
                                            <div class="form-group col-sm-6 col-md-6">
                                                <label for="sal_curr_acc" class="form-control-label">Is your salary account a current account?</label>
                                                <select class="form-control " id="sal_curr_acc" name="sal_curr_acc" required>
                                                    <option value=""></option>
                                                    <option value="Yes">Yes</option>
                                                    <option value="No">No</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row row-xs mt-2"></div>
                                    </section>
                                    <h3>Personal Information</h3>
                                    <section class="p-3">
                                        <div class="row row-xs">
                                            <div class="form-group col-sm-6 col-md-3">
                                                <label for="l_type" class="form-control-label">Loan Type: <span class="tx-danger">*</span></label>
                                                <select class="form-control" data-placeholder="Select Loan Type" id="l_type" name="l_type" required>
                                                    <option value="Hatch31">Hatch31 Loan</option>
                                                </select>
                                            </div>
                                            <div class="form-group col-sm-4 col-md-3">
                                                <label for="title" class="form-control-label">Title: <span class="tx-danger">*</span></label>
                                                <select class="form-control" id="title" name="title" required>
                                                    <option value="Mr">Mr.</option>
                                                    <option value="Mrs">Mrs.</option>
                                                    <option value="Miss">Miss</option>
                                                </select>
                                            </div>
                                            <div class="form-group col-sm-4 col-md-3">
                                                <label for="gender" class="form-control-label">Gender: <span class="tx-danger">*</span></label>
                                                <select class="form-control select2" data-placeholder="Select Gender" id="gender" name="gender" required>
                                                    <option value="">Select Gender</option>
                                                    <option value="Female">Female</option>
                                                    <option value="Male">Male</option>
                                                    <option value="Other">Other</option>
                                                </select>
                                            </div>
                                            <div class="form-group col-sm-4 col-md-3">
                                                <label for="dob" class="form-control-label">D.O.B: <span class="tx-danger">*</span></label>
                                                <input type="date" class="form-control"  id="dob" name="dob" value="10/22/1990" required>
                                            </div>
                                        </div>
                                        <div class="row row-xs">
                                            <div class="form-group col-sm-6 col-md-4">
                                                <label for="f_name" class="form-control-label">First Name: <span class="tx-danger">*</span></label>
                                                <input type="text" class="form-control"  id="f_name" name="f_name" required>
                                            </div>
                                            <div class="form-group col-sm-6 col-md-4">
                                                <label for="l_name" class="form-control-label">Middle Name: <span class="tx-danger">*</span></label>
                                                <input type="text" class="form-control" id="l_name" name="l_name" required>
                                            </div>
                                            <div class="form-group col-sm-6 col-md-4">
                                                <label for="s_name" class="form-control-label">Surname: <span class="tx-danger">*</span></label>
                                                <input type="text" class="form-control" id="s_name" name="s_name" required>
                                            </div>
                                            <div class="form-group col-sm-6 col-md-8">
                                                <label for="email" class="form-control-label">Email Address: <span class="tx-danger">*</span></label>
                                                <input type="email" class="form-control" id="email" name="email" required>
                                            </div>
                                            <div class="form-group col-sm-6 col-md-4">
                                                <label for="mobile" class="form-control-label">Mobile Number: <span class="tx-danger">*</span></label>
                                                <input type="text" class="form-control" id="mobile" name="mobile" data-parsley-type="digits" required>
                                            </div>
                                            <div class="form-group col-sm-6 col-md-4">
                                                <label for="alt_num" class="form-control-label">Alt Number: </label>
                                                <input type="text" class="form-control" id="alt_num" name="alt_num">
                                            </div>
                                            <div class="form-group col-sm-6 col-md-4">
                                                <label for="bvn" class="form-control-label">B.V.N: <span class="tx-danger">*</span></label>
                                                <input type="text" class="form-control" id="bvn" name="bvn" data-parsley-type="digits" required>
                                            </div>
                                            <div class="form-group col-sm-6 col-md-4">
                                                <label for="m_id" class="form-control-label">Means of ID: <span class="tx-danger">*</span></label>
                                                <select class="form-control select2" data-placeholder="Select ID" id="m_id" name="m_id" required>
                                                    <option value="">Select ID</option>
                                                    <option value="Intl Passport">Intl Passport</option>
                                                    <option value="Voters Card">Voters Card</option>
                                                    <option value="Drivers Licence">Drivers Licence</option>
                                                    <option value="National ID">National ID</option>
                                                </select>
                                            </div>
                                            <div class="form-group col-sm-6 col-md-6">
                                                <label for="d_iss" class="form-control-label">Date Issued: <span class="tx-danger">*</span></label>
                                                <input type="date" class="form-control"  id="d_iss" name="d_iss" required>
                                            </div>
                                            <div class="form-group col-sm-6 col-md-6">
                                                <label for="ex_date" class="form-control-label">Expiry Date: <span class="tx-danger">*</span></label>
                                                <input type="date" class="form-control" id="ex_date" name="ex_date" required>
                                            </div>
                                            <div class="form-group col-sm-6 col-md-4">
                                                <label for="id_no" class="form-control-label">Identification No: <span class="tx-danger">*</span></label>
                                                <input type="text" class="form-control" id="id_no" name="id_no" data-parsley-type="digits" required>
                                            </div>
                                        </div>
                                    </section>
                                    <h3>Location Information</h3>
                                    <section class="p-3">
                                        <div class="row row-xs">
                                            <div class="form-group col-sm-6 col-md-8">
                                                <label for="h_add" class="form-control-label">Home Address: <span class="tx-danger">*</span></label>
                                                <input type="text" class="form-control"  id="h_add" name="h_add" required>
                                            </div>
                                            <div class="form-group col-sm-6 col-md-4">
                                                <label for="nb_stop" class="form-control-label">Nearest B/Stop: <span class="tx-danger">*</span></label>
                                                <input type="text" class="form-control" id="nb_stop" name="nb_stop" required>
                                            </div>
                                            <div class="form-group col-sm-6 col-md-4">
                                                <label for="r_lga" class="form-control-label">LGA (Residence): <span class="tx-danger">*</span></label>
                                                <input type="text" class="form-control" id="r_lga" name="r_lga" required>
                                            </div>
                                            <div class="form-group col-sm-6 col-md-4">
                                                <label for="r_state" class="form-control-label">State: <span class="tx-danger">*</span></label>
                                                <input type="text" class="form-control" id="r_state" name="r_state" required>
                                            </div>
                                            <div class="form-group col-sm-6 col-md-4">
                                                <label for="r_status" class="form-control-label">Residential Status: <span class="tx-danger">*</span></label>
                                                <select class="form-control" data-placeholder="Select Status" id="r_status" name="r_status" required>
                                                    <option value="">Select Status</option>
                                                    <option value="Tenant">Tenant</option>
                                                    <option value="Owner">Owner</option>
                                                    <option value="With Relative">With Relative</option>
                                                </select>
                                            </div>
                                            <div class="form-group col-sm-12 col-md-8">
                                                <label for="tc_yrs" class="form-control-label">Time Spent at Current Address: <span class="tx-danger">*</span></label>
                                                <div style="display:flex;justify-content: space-between">
                                                    <div class="input-group pr-3">
                                                        <input type="text" class="form-control" name="tc_yrs" id="tc_yrs" data-parsley-type="digits" data-parsley-errors-messages-disabled required>
                                                        <span class="input-group-addon"><b>Years</b></span>
                                                    </div>
                                                    <div class="input-group pl-3">
                                                        <input type="text" class="form-control" name="tc_mon" id="tc_mon" title="Months spent at current address" data-parsley-type="digits" data-parsley-errors-messages-disabled required>
                                                        <span class="input-group-addon"><b>Months</b></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group col-sm-12 col-md-12">
                                                <label for="p_add" class="form-control-label">Previous Address(If resident at the Current Address for less than 3years):</label>
                                                <input type="text" class="form-control" id="p_add" name="p_add">
                                            </div>
                                            <div class="form-group col-sm-12 col-md-8">
                                                <label for="tp_yrs" class="form-control-label">Time Spent at Previous Address:</label>
                                                <div style="display:flex;justify-content: space-between">
                                                    <div class="input-group pr-3">
                                                        <input type="text" class="form-control" name="tp_yrs" id="tp_yrs">
                                                        <span class="input-group-addon"><b>Years</b></span>
                                                    </div>
                                                    <div class="input-group pl-3">
                                                        <input type="text" class="form-control" name="tp_mon" id="tp_mon" title="Months spent at previous address">
                                                        <span class="input-group-addon"><b>Months</b></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group col-sm-12 col-md-4">
                                                <label for="m_stat" class="form-control-label">Marital Status: <span class="tx-danger">*</span></label>
                                                <select class="form-control" data-placeholder="Select Status" id="m_stat" name="m_stat" required>
                                                    <option value="">Marital Status</option>
                                                    <option value="Single">Single</option>
                                                    <option value="Married">Married</option>
                                                    <option value="Separated">Separated</option>
                                                    <option value="Divorced">Divorced</option>
                                                    <option value="Widowed">Widowed</option>
                                                </select>
                                            </div>
                                        </div>
                                    </section>
                                    <h3>Employment Details</h3>
                                    <section class="p-3">
                                        <div class="row row-xs">
                                            <div class="form-group col-sm-6 col-md-3">
                                                <label for="em_sta" class="form-control-label">Employment Status: <span class="tx-danger">*</span></label>
                                                <select class="form-control" data-placeholder="Employment Status" id="em_sta" name="em_sta" required>
                                                    <option value="">Select status</option>
                                                    <option value="Full Time">Full Time</option>
                                                    <option value="Part Time">Part Time</option>
                                                    <option value="Retired">Retired</option>
                                                    <option value="Self Employed">Self Employed</option>
                                                    <option value="Temp Contract">Temp Contract</option>
                                                    <option value="Unemployed">Unemployed</option>
                                                    <option value="Student">Student</option>
                                                    <option value="House Wife">House Wife</option>
                                                    <option value="Outsourced Contract">Outsourced Contract</option>
                                                    <option value="Public">Public</option>
                                                    <option value="Private">Private</option>
                                                </select>
                                            </div>
                                            <div class="form-group col-sm-6 col-md-4">
                                                <label for="c_emp" class="form-control-label">Current Employer <span class="tx-danger">*</span></label>
                                                <input type="text" id="c_emp" class="form-control" name="c_emp" required>
                                            </div>
                                            <div class="form-group col-sm-12 col-md-5">
                                                <label for="c_e_add" class="form-control-label">Current Employer Address <span class="tx-danger">*</span></label>
                                                <input type="text" id="c_e_add" class="form-control" name="c_e_add" required>
                                            </div>
                                        </div>
                                        <div class="row row-xs">
                                            <div class="form-group col-sm-6 col-md-3">
                                                <label for="c_em_st" class="form-control-label">Nearest B/Stop <span class="tx-danger">*</span></label>
                                                <input type="text" id="c_em_st" class="form-control" name="c_em_st" required>
                                            </div>
                                            <div class="form-group col-sm-6 col-md-3">
                                                <label for="c_em_lga" class="form-control-label">LGA (of office) <span class="tx-danger">*</span></label>
                                                <input type="text" id="c_em_lga" class="form-control" name="c_em_lga" required>
                                            </div>
                                            <div class="form-group col-sm-6 col-md-3">
                                                <label for="c_em_sta" class="form-control-label">State <span class="tx-danger">*</span></label>
                                                <input type="text" id="c_em_sta" class="form-control" name="c_em_sta" required>
                                            </div>
                                            <div class="form-group col-sm-6 col-md-3">
                                                <label for="c_em_ono" class="form-control-label">Office Number <span class="tx-danger">*</span></label>
                                                <input type="text" id="c_em_ono" class="form-control" name="c_em_ono" data-parsley-type="digits" required>
                                            </div>
                                        </div>
                                        <div class="row row-xs">
                                            <div class="form-group col-sm-12 col-md-6">
                                                <label for="c_email" class="form-control-label">Email Address <span class="tx-danger">*</span></label>
                                                <input type="text" id="c_email" class="form-control" name="c_email" data-parsley-type="email" required>
                                            </div>
                                            <div class="form-group col-sm-6 col-md-3">
                                                <label for="c_st_id" class="form-control-label">Staff ID No. <span class="tx-danger">*</span></label>
                                                <input type="text" id="c_st_id" class="form-control" name="c_st_id" data-parsley-type="digits" required>
                                            </div>
                                            <div class="form-group col-sm-6 col-md-3">
                                                <label for="c_pen_no" class="form-control-label">Pension No. <span class="tx-danger">*</span></label>
                                                <input type="text" id="c_pen_no" class="form-control" name="c_pen_no" data-parsley-type="digits" required>
                                            </div>
                                        </div>
                                        <div class="row row-xs">
                                            <div class="form-group col-sm-6 col-md-6">
                                                <label for="c_tax_id" class="form-control-label">Tax ID No. <span class="tx-danger">*</span></label>
                                                <input type="text" id="c_tax_id" class="form-control" name="c_tax_id" data-parsley-type="digits" required>
                                            </div>
                                            <div class="form-group col-sm-6 col-md-6">
                                                <label for="c_job_t" class="form-control-label">Job Title/Position <span class="tx-danger">*</span></label>
                                                <input type="text" id="c_job_t" class="form-control" name="c_job_t" required>
                                            </div>
                                            <div class="form-group col-sm-6 col-md-6">
                                                <label for="c_de_un" class="form-control-label">Dept. & Unit <span class="tx-danger">*</span></label>
                                                <input type="text" id="c_de_un" class="form-control" name="c_de_un" required>
                                            </div>
                                            <div class="form-group col-sm-6 col-md-6">
                                                <label for="c_da_em" class="form-control-label">Date Employed <span class="tx-danger">*</span></label>
                                                <input type="date" id="c_da_em" class="form-control" name="c_da_em" required>
                                            </div>
                                        </div>
                                        <div class="row row-xs">
                                            <div class="col-sm-12"><label>(If previous employment is for less than 1 years)</label></div>
                                        </div>
                                        <div class="row row-xs">
                                            <div class="form-group col-sm-6 col-md-5">
                                                <label for="p_emp_na" class="form-control-label">Previous Employer</label>
                                                <input type="text" id="p_emp_na" class="form-control" name="p_emp_na">
                                            </div>
                                            <div class="form-group col-sm-6 col-md-7">
                                                <label for="p_emp_add" class="form-control-label">Previous Employer Address</label>
                                                <input type="text" id="p_emp_add" class="form-control" name="p_emp_add">
                                            </div>
                                        </div>
                                        <div class="row row-xs">
                                            <div class="form-group col-sm-6 col-md-4">
                                                <label for="p_no_mo" class="form-control-label" style="font-size: 11px">No. of months in prev. employment</label>
                                                <input type="text" id="p_no_mo" class="form-control" name="p_no_mo" data-parsley-type="digits">
                                            </div>
                                            <div class="form-group col-sm-6 col-md-4">
                                                <label for="j5_yrs" class="form-control-label">How many jobs in last 5yrs</label>
                                                <input type="text" id="j5_yrs" class="form-control" name="j5_yrs" data-parsley-type="digits" required>
                                            </div>
                                            <div class="form-group col-sm-6 col-md-4">
                                                <label for="n_sala" class="form-control-label">Current net month salary</label>
                                                <input type="text" id="n_sala" class="form-control" name="n_sala" data-parsley-type="digits" required>
                                            </div>
                                        </div>
                                        <div class="row row-xs">
                                            <div class="form-group col-sm-6 col-md-6">
                                                <label for="cu_p_day" class="form-control-label">Current pay date</label>
                                                <input type="date" id="cu_p_day" class="form-control" name="cu_p_day" required>
                                            </div>
                                            <div class="form-group col-sm-6 col-md-6">
                                                <label for="industry" class="form-control-label">Industry</label>
                                                <select class="form-control" data-placeholder="Employment Status" id="industry" name="industry" required>
                                                    <option value="">Select Industry</option>
                                                    <option value="Agric">Agric</option>
                                                    <option value="Banking">Banking</option>
                                                    <option value="Finance">Finance</option>
                                                    <option value="Power">Power</option>
                                                    <option value="Construction Engineering">Construction Engineering</option>
                                                    <option value="Real Estate">Real Estate</option>
                                                    <option value="Military">Military</option>
                                                    <option value="Manufacturing">Manufacturing</option>
                                                    <option value="Oil / Gas">Oil / Gas</option>
                                                    <option value="Retail / Sale">Retail / Sale</option>
                                                    <option value="Telecoms">Telecoms</option>
                                                    <option value="Media / Entertainment">Media / Entertainment</option>
                                                    <option value="Other Financial Institutions">Other Financial Institutions</option>
                                                    <option value="Health / Education / Government">Health / Education / Government</option>
                                                </select>
                                            </div>
                                        </div>
                                    </section>
                                    <h3>Loan Request Details</h3>
                                    <section class="p-3">
                                        <div class="row row-xs">
                                            <div class="form-group col-sm-6 col-md-3">
                                                <label for="edu_sta" class="form-control-label">Educational Status: <span class="tx-danger">*</span></label>
                                                <select class="form-control" data-placeholder="Employment Status" id="edu_sta" name="edu_sta" required>
                                                    <option value="">Select status</option>
                                                    <option value="Primary">Primary</option>
                                                    <option value="Secondary">Secondary</option>
                                                    <option value="Graduate">Graduate</option>
                                                    <option value="Post Graduate">Post Graduate</option>
                                                </select>
                                            </div>
                                            <div class="form-group col-sm-6 col-md-4">
                                                <label for="pof_loan" class="form-control-label">Purpose of Loan: <span class="tx-danger">*</span></label>
                                                <select class="form-control" data-placeholder="Employment Status" id="pof_loan" name="pof_loan" required>
                                                    <option value="">Select Purpose</option>
                                                    <option value="Portable Goods">Portable Goods</option>
                                                    <option value="Travel/Holiday">Travel/Holiday</option>
                                                    <option value="Medical">Medical</option>
                                                    <option value="Household Maintenance">Household Maintenance</option>
                                                    <option value="Rent">Rent</option>
                                                    <option value="School Fees">School Fees</option>
                                                    <option value="Wedding/Events">Wedding/Events</option>
                                                    <option value="Fashion Goods">Fashion Goods</option>
                                                </select>
                                            </div>
                                            <div class="form-group col-sm-12 col-md-5">
                                                <label for="o_exp" class="form-control-label">Other Expenses:</label>
                                                <input type="text" id="o_exp" class="form-control" name="o_exp">
                                            </div>
                                        </div>
                                        <div class="row row-xs">
                                            <div class="form-group col-sm-6 col-md-5">
                                                <label for="exi_loan" class="form-control-label">Do you have an existing loan? If yes pls specify:</label>
                                                <select class="form-control" id="exi_loan" name="exi_loan">
                                                    <option value=""></option>
                                                    <option value="Mortgage">Mortgage</option>
                                                    <option value="Overdraft">Overdraft</option>
                                                    <option value="Car Loan">Car Loan</option>
                                                    <option value="Business Loan">Business Loan</option>
                                                    <option value="Credit Loan">Credit Loan</option>
                                                    <option value="Personal Loan">Personal Loan</option>
                                                </select>
                                            </div>
                                            <div class="form-group col-sm-6 col-md-3">
                                                <label for="no_cars" class="form-control-label mb-2">No of cars owned:</label>
                                                <input type="text" id="no_cars" class="form-control" name="no_cars" required>
                                            </div>
                                            <div class="form-group col-sm-6 col-md-4">
                                                <label for="do_drive" class="form-control-label mb-2">Do you have a driver?</label>
                                                <select class="form-control" id="do_drive" name="do_drive">
                                                    <option value=""></option>
                                                    <option value="Yes">Yes</option>
                                                    <option value="No">No</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row row-xs">
                                            <div class="form-group col-sm-6 col-md-6">
                                                <label for="net_pro" class="form-control-label">Who is your network provider?</label>
                                                <select class="form-control" id="net_pro" name="net_pro" required>
                                                    <option value=""></option>
                                                    <option value="Mtn">Mtn</option>
                                                    <option value="Glo">Glo</option>
                                                    <option value="Airtel">Airtel</option>
                                                    <option value="Etisalat">Etisalat</option>
                                                </select>
                                            </div>
                                            <div class="form-group col-sm-6 col-md-6">
                                                <label for="net_pac" class="form-control-label">What is your mobile network package</label>
                                                <select class="form-control" id="net_pac" name="net_pac" required>
                                                    <option value=""></option>
                                                    <option value="Post Paid">Post Paid</option>
                                                    <option value="Pre Paid">Pre Paid</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row row-xs">
                                            <div class="col-sm-12 font-weight-bold"><label>NEXT OF KIN DETAILS : <span class="tx-danger">*</span></label></div>
                                        </div>
                                        <div class="row row-xs">
                                            <div class="form-group col-sm-6 col-md-4">
                                                <label for="nok_fname" class="form-control-label">N.O.K First Name</label>
                                                <input type="text" id="nok_fname" class="form-control" name="nok_fname" required>
                                            </div>
                                            <div class="form-group col-sm-6 col-md-5">
                                                <label for="nok_sname" class="form-control-label">N.O.K Surname</label>
                                                <input type="text" id="nok_sname" class="form-control" name="nok_sname" required>
                                            </div>
                                            <div class="form-group col-sm-6 col-md-3">
                                                <label for="nok_rela" class="form-control-label">N.O.K Relationship</label>
                                                <input type="text" id="nok_rela" class="form-control" name="nok_rela" data-parsley-errors-messages-disabled required>
                                            </div>
                                        </div>
                                        <div class="row row-xs">
                                            <div class="form-group col-sm-6 col-md-4">
                                                <label for="nok_phone" class="form-control-label">N.O.K Phone No</label>
                                                <input type="text" id="nok_phone" class="form-control" name="nok_phone" data-parsley-type="digits" required>
                                            </div>
                                            <div class="form-group col-sm-6 col-md-8">
                                                <label for="nok_address" class="form-control-label">Next of kin home address</label>
                                                <input type="text" id="nok_address" class="form-control" name="nok_address" required>
                                            </div>
                                        </div>
                                        <div class="row row-xs">
                                            <div class="form-group col-sm-6 col-md-4">
                                                <label for="loan_amt" class="form-control-label">Loan Amount</label>
                                                <input type="text" id="loan_amt" class="form-control" name="loan_amt" data-parsley-type="digits" required>
                                            </div>
                                            <div class="form-group col-sm-6 col-md-4">
                                                <label for="loan_ten" class="form-control-label">Loan Tenor (Months)</label>
                                                <input type="text" id="loan_ten" class="form-control" name="loan_ten" data-parsley-type="digits" required>
                                            </div>
                                            <div class="form-group col-sm-6 col-md-4">
                                                <label for="mon_rep" class="form-control-label">Affordable Monthly Repayment</label>
                                                <input type="text" id="mon_rep" class="form-control" name="mon_rep" data-parsley-type="digits" required>
                                            </div>
                                        </div>
                                    </section>
                                    <h3>Upload Files and Necessary document</h3>
                                    <section class="p-3">
                                        <div class="row row-xs">
                                            <div class="form-group col-sm-12 col-md-12">
                                                <label for="passport" class="form-control-label">Upload Passport Here <span class="tx-danger">*</span></label>
                                                <input type="file" class="form-control" id="passport" name="passport" accept="image/jpeg,image/jpg,image/png" required>
                                            </div>
                                        </div>
                                        <div class="row row-xs">
                                            <div class="form-group col-sm-12 col-md-12">
                                                <label for="con_letter" class="form-control-label">Employment, Promotion or Confirmation Letter <span class="tx-danger">*</span></label>
                                                <input type="file" class="form-control" id="con_letter" name="con_letter" accept="application/pdf,image/jpeg,image/jpg,image/png" required>
                                            </div>
                                        </div>
                                        <div class="row row-xs">
                                            <div class="form-group col-sm-12 col-md-12">
                                                <label for="bnk_stat" class="form-control-label">Bank Statement for the previous 6 months (recent) <span class="tx-danger">*</span></label>
                                                <input type="file" class="form-control" id="bnk_stat" name="bnk_stat" accept="application/pdf,image/jpeg,image/jpg,image/png" required>
                                            </div>
                                        </div>
                                        <div class="row row-xs">
                                            <div class="form-group col-sm-12 col-md-12">
                                                <label for="staff_idc" class="form-control-label">Staff ID Card <span class="tx-danger">*</span></label>
                                                <input type="file" class="form-control" id="staff_idc" name="staff_idc" accept="application/pdf,image/jpeg,image/jpg,image/png" required>
                                            </div>
                                        </div>
                                        <div class="row row-xs">
                                            <div class="form-group col-sm-12 col-md-12">
                                                <label for="valid_idc" class="form-control-label">
                                                    Valid Identification Doc (e.g Driver’s License, Int'l Passport, Tax ID, Voter’s Card) <span class="tx-danger">*</span>
                                                </label>
                                                <input type="file" class="form-control" id="valid_idc" name="valid_idc" accept="application/pdf,image/jpeg,image/jpg,image/png" required>
                                            </div>
                                        </div>
                                        <div class="row row-xs">
                                            <div class="form-group col-sm-12 col-md-12">
                                                <label for="util_bill" class="form-control-label">Recent Utility Bill. <span class="tx-danger">*</span></label>
                                                <input type="file" class="form-control" id="util_bill" name="util_bill" accept="application/pdf,image/jpeg,image/jpg,image/png" required>
                                            </div>
                                        </div>
                                    </section>
                                    <h3>Disbursement Details, Confirmation & Acceptance</h3>
                                    <section class="p-3">
                                        <div class="row row-xs">
                                            <div class="form-group col-sm-12 col-md-4">
                                                <label for="bk_name" class="form-control-label">Bank Name <span class="tx-danger">*</span></label>
                                                <input type="text" id="bk_name" class="form-control" name="bk_name" required>
                                            </div>
                                            <div class="form-group col-sm-6 col-md-4">
                                                <label for="acc_name" class="form-control-label">Account Name <span class="tx-danger">*</span></label>
                                                <input type="text" id="acc_name" class="form-control" name="acc_name" required>
                                            </div>
                                            <div class="form-group col-sm-6 col-md-4">
                                                <label for="acc_no" class="form-control-label">Account Number <span class="tx-danger">*</span></label>
                                                <input type="text" id="acc_no" class="form-control" name="acc_no" maxlength="10" data-parsley-type="digits" required>
                                            </div>
                                        </div>
                                        <div class="row row-xs"><div class="col-sm-12"><label class="font-weight-bold">HOW DID YOU HEAR ABOUT US ?</label></div></div>
                                        <div class="row row-xs">
                                            <div class="form-group col-sm-6 col-md-4">
                                                <label for="hr_abt_us" class="form-control-label">What means?</label>
                                                <select class="form-control" id="hr_abt_us" name="hr_abt_us">
                                                    <option value=""></option>
                                                    <option value="LEAFLET">LEAFLET</option>
                                                    <option value="SALESMAN">SALESMAN</option>
                                                    <option value="ONLINE">ONLINE</option>
                                                    <option value="SS CINEMA WEBSITE">SS CINEMA WEBSITE</option>
                                                    <option value="RADIO">RADIO</option>
                                                    <option value="TELESALES">TELESALES</option>
                                                    <option value="BILLBOARD">BILLBOARD</option>
                                                    <option value="FRIENDLY REFERRAL">FRIENDLY REFERRAL</option>
                                                    <option value="BRT">BRT</option>
                                                </select>
                                            </div>
                                            <div class="form-group col-sm-6 col-md-4">
                                                <label for="if_news_p" class="form-control-label">If Newspaper (Pls Specify)</label>
                                                <input type="text" id="if_news_p" class="form-control" name="if_news_p">
                                            </div>
                                            <div class="form-group col-sm-6 col-md-4">
                                                <label for="if_magaz" class="form-control-label">If Magazine (Pls Specify)</label>
                                                <input type="text" id="if_magaz" class="form-control" name="if_magaz">
                                            </div>
                                        </div>
                                        <div class="row row-xs">
                                            <div class="col-sm-12"><label class="font-weight-bold">CONFIRMATION & ACCEPTANCE</label></div>
                                        </div>
                                        <div class="row row-xs">
                                            <div class="form-group col-sm-12 col-md-12">
                                                <label class="form-control-label" style="font-size:13px;">
                                                    I <b><?=$_SESSION['MEMBER_LOGIN']['u_fname']." ".$_SESSION['MEMBER_LOGIN']['u_lname']." ".$_SESSION['MEMBER_LOGIN']['u_sname'];?></b>
                                                    hereby confirm my application for the above facility and certify that all information provided by me above and attached thereto is
                                                    correct and complete. i authorize you to make any enquiry you consider necessary and appropriate for the purpose of evaluating
                                                    the application.
                                                </label>
                                            </div>
                                            <div class="form-group col-sm-12 col-md-12">
                                                <label class="ckbox" style="font-size:13px;">
                                                    <input type="checkbox" name="agree_cond" id="agree_cond" value="Yes"
                                                           data-parsley-error-message="Agree to terms & conditions to complete application" required>
                                                    <span>
                                                        By Checking this, I agree to be bound by the
                                                        <a href="terms-and-conditions" target="_blank" class="font-italic" style="text-decoration:underline">terms and conditions</a>
                                                        governing my application for a loan.
                                                    </span>
                                                </label>
                                            </div>
                                        </div>
                                        <div class="row row-xs mt-4"></div>
                                    </section>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="hatch31Modal" class="modal fade">
    <div class="modal-dialog modal-dialog-vertical-center" role="document">
        <div class="modal-content bd-0 tx-14">
            <div class="modal-header pd-y-20 pd-x-25">
                <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold">Important Notice Preview</h6>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body pd-25">
                <h4 class="lh-3 mg-b-20"><a href="#" class="tx-inverse hover-primary">Hatch31 Loan</a></h4>
                <p class="mg-b-5">The HATCH31 loans is tailored to meet the needs of salary earners and people in paid employment.</p>
                <p class="mg-b-5"><b>Eligibility & Requirements</b> are as follows:</p>
                <ul>
                    <li>Must live and work in Lagos.</li>
                    <li>Must been in paid employment.</li>
                    <li>A valid employment, promotion or confirmation letter.</li>
                    <li>6 months bank statements of salary account (Most recent).</li>
                    <li>Staff ID CARD.</li>
                    <li>Another valid identification document (e.g., Driver’s License, International Passport, Tax ID, Voter’s Card).</li>
                    <li>Pension account (Conditional).</li>
                    <li>Recent Utility Bill.</li>
                </ul>
            </div>
            <div class="modal-footer"><button type="button" class="btn btn-secondary pd-x-20" data-dismiss="modal">Close</button></div>
        </div>
    </div>
</div>

<div class="modal fade" id="progressModal" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-dialog-vertical-center" role="document">
        <div class="modal-content bd-0">
            <div class="modal-header pd-y-20 pd-x-25">
                <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold">Please wait, file upload in progress..</h6>
            </div>
            <div class="modal-body pd-25">
                <div id="process" style="display: none;">
                    <div class="progress mt-3" style="height: 20px;">
                        <div class="progress-bar progress-bar-striped" role="progressbar" aria-valuemin="0" aria-valuemax="100">0%</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include_once("../inc/footer.nav.php"); ?>
<script src="./assets/js/moment.min.js"></script>
<script>
    $(document).ready(function(){
        // $('#progressModal').modal('show');
        'use strict';
        $('#applyLoanWizard').steps({
            headerTag: 'h3',
            bodyTag: 'section',
            autoFocus: true,
            stepsOrientation: 1,
            titleTemplate: '<span class="number">#index#</span> <span class="title">#title#</span>',
            onStepChanging: function (event, currentIndex, newIndex) {
                if(currentIndex < newIndex) {
                    // Step 1 form validation
                    if(currentIndex === 0) {
                        var u_earn = $('#u_earn').parsley();
                        if ($('input[name=curr_loan]:checked', '#applyLoanWizard').val() === "Yes"){
                            $("input[name=cur_loan_d]").prop('required',true);
                            var cur_loan_d = $('#cur_loan_d').parsley();
                        } else {
                            $("input[name=cur_loan_d]").prop('required',false);
                            $('#cur_loan_d').parsley().destroy();
                        }
                        var d_of_mon = $('#d_of_mon').parsley();
                        var loan_tenor = $('#loan_tenor').parsley();
                        var sal_curr_acc = $('#sal_curr_acc').parsley();

                        if(u_earn.isValid() && loan_tenor.isValid()  && d_of_mon.isValid() && sal_curr_acc.isValid()) {
                            return true;
                        } else {
                            u_earn.validate();
                            if ($('input[name=curr_loan]:checked', '#applyLoanWizard').val() === "Yes"){cur_loan_d.validate(); }
                            d_of_mon.validate();
                            loan_tenor.validate();
                            sal_curr_acc.validate();
                        }
                    }

                    // Step 2 form validation
                    if(currentIndex === 1) {
                        var l_type = $('#l_type').parsley();
                        var gender = $('#gender').parsley();
                        var dob = $('#dob').parsley();
                        var f_name = $('#f_name').parsley();
                        var l_name = $('#l_name').parsley();
                        var s_name = $('#s_name').parsley();
                        var email = $('#email').parsley();
                        var mobile = $('#mobile').parsley();
                        var alt_num = $('#alt_num').parsley();
                        var bvn = $('#bvn').parsley();
                        var m_id = $('#m_id').parsley();
                        var id_no = $('#id_no').parsley();
                        var d_iss = $('#d_iss').parsley();
                        var ex_date = $('#ex_date').parsley();

                        if(l_type.isValid() && f_name.isValid() && l_name.isValid() && s_name.isValid() && email.isValid() && mobile.isValid() && alt_num.isValid()
                        && bvn.isValid() && m_id.isValid() && id_no.isValid() && gender.isValid() && dob.isValid() && d_iss.isValid() && ex_date.isValid()) {
                            return true;
                        } else {
                            l_type.validate();gender.validate();dob.validate();f_name.validate();l_name.validate();s_name.validate();email.validate();
                            mobile.validate();alt_num.validate();bvn.validate();m_id.validate();id_no.validate();d_iss.validate();ex_date.validate();
                        }
                    }

                    // Step 3 form validation
                    if(currentIndex === 2) {
                        var h_add = $('#h_add').parsley();
                        var nb_stop = $('#nb_stop').parsley();
                        var r_lga = $('#r_lga').parsley();
                        var r_state = $('#r_state').parsley();
                        var r_status = $('#r_status').parsley();
                        var tc_yrs = $('#tc_yrs').parsley();
                        var tc_mon = $('#tc_mon').parsley();
                        var m_stat = $('#m_stat').parsley();
                        if (parseInt($("input[name=tc_yrs]").val()) < 3 ){
                            $("input[name=p_add]").prop('required',true);
                            $("input[name=tp_yrs]").prop('required',true);
                            $("input[name=tp_mon]").prop('required',true);
                            $('#tp_yrs').attr('data-parsley-errors-messages-disabled',true);
                            $('#tp_mon').attr('data-parsley-errors-messages-disabled',true);
                            var p_add = $('#p_add').parsley();
                            var tp_yrs = $('#tp_yrs').parsley();
                            var tp_mon = $('#tp_mon').parsley();
                        } else {
                            $("input[name=p_add]").prop('required',false);
                            $("input[name=tp_yrs]").prop('required',false);
                            $("input[name=tp_mon]").prop('required',false);
                            $("input[name=tp_yrs]").attr('data-parsley-errors-messages-disabled',false);
                            $("input[name=tp_mon]").attr('data-parsley-errors-messages-disabled',false);
                            $('#p_add').parsley().destroy();
                            $('#tp_yrs').parsley().destroy();
                            $('#tp_mon').parsley().destroy();
                        }

                        if(h_add.isValid() && nb_stop.isValid() && r_lga.isValid() && r_state.isValid() && r_status.isValid() && tc_yrs.isValid() && tc_mon.isValid()
                            && m_stat.isValid()) {
                            return true;
                        } else {
                            h_add.validate(); nb_stop.validate(); r_lga.validate(); r_state.validate(); r_status.validate(); tc_yrs.validate(); tc_mon.validate();
                            m_stat.validate();
                            if (parseInt($("input[name=tc_yrs]").val()) < 3 ) {
                                p_add.validate();tp_yrs.validate();tp_mon.validate();
                            }
                        }
                    }

                    // Step 4 form validation
                    if(currentIndex === 3) {
                        var em_sta = $('#em_sta').parsley();
                        var c_emp = $('#c_emp').parsley();
                        var c_e_add = $('#c_e_add').parsley();
                        var c_em_st = $('#c_em_st').parsley();
                        var c_em_lga = $('#c_em_lga').parsley();
                        var c_em_sta = $('#c_em_sta').parsley();
                        var c_em_ono = $('#c_em_ono').parsley();
                        var c_email = $('#c_email').parsley();
                        var c_st_id = $('#c_st_id').parsley();
                        var c_pen_no = $('#c_pen_no').parsley();
                        var c_tax_id = $('#c_tax_id').parsley();
                        var c_job_t = $('#c_job_t').parsley();
                        var c_de_un = $('#c_de_un').parsley();
                        var c_da_em = $('#c_da_em').parsley();

                        var j5_yrs = $('#j5_yrs').parsley();
                        var n_sala = $('#n_sala').parsley();
                        var cu_p_day = $('#cu_p_day').parsley();
                        var industry = $('#industry').parsley();

                        //test date less than a year
                        var d = new Date($("#c_da_em").val());
                        var emp_date_f = d.getDate()+"/"+(d.getMonth()+1)+"/"+d.getFullYear();

                        var today = moment().startOf('day');
                        var emp_date = moment(emp_date_f,'M/D/YYYY');
                        const diffDays = Math.abs(moment.duration(emp_date.diff(today)).asDays());
                        if (diffDays <= 365) {
                            $("input[name=p_emp_na]").prop('required',true);
                            $("input[name=p_emp_add]").prop('required',true);
                            $("input[name=p_no_mo]").prop('required',true);
                            var p_emp_na = $('#p_emp_na').parsley();
                            var p_emp_add = $('#p_emp_add').parsley();
                            var p_no_mo = $('#p_no_mo').parsley();
                        } else {
                            $("input[name=p_emp_na]").prop('required',false);
                            $("input[name=p_emp_add]").prop('required',false);
                            $("input[name=p_no_mo]").prop('required',false);
                            $('#p_emp_na').parsley().destroy();
                            $('#p_emp_add').parsley().destroy();
                            $('#p_no_mo').parsley().destroy();
                        }

                        if(em_sta.isValid() && c_emp.isValid() && c_e_add.isValid() && c_em_st.isValid() && c_em_lga.isValid() && c_em_sta.isValid() && c_em_ono.isValid()
                            && c_email.isValid() && c_st_id.isValid() && c_pen_no.isValid() && c_tax_id.isValid() && c_job_t.isValid() && c_de_un.isValid() && c_da_em.isValid()
                            && j5_yrs.isValid() && n_sala.isValid() && cu_p_day.isValid() && industry.isValid()
                        ) {
                            return true;
                        } else {
                            em_sta.validate();c_emp.validate();c_e_add.validate();c_em_st.validate();c_em_lga.validate();c_em_sta.validate();c_em_ono.validate();
                            c_email.validate();c_st_id.validate();c_pen_no.validate();c_tax_id.validate();c_job_t.validate();c_de_un.validate();c_da_em.validate();
                            j5_yrs.validate();n_sala.validate();cu_p_day.validate();industry.validate();
                            if (diffDays <= 365) {
                                p_emp_na.validate();p_emp_add.validate();p_no_mo.validate();
                            }
                        }
                    }

                    // Step 5 form validation loan details
                    if(currentIndex === 4) {
                        var edu_sta = $('#edu_sta').parsley();
                        var pof_loan = $('#pof_loan').parsley();
                        var no_cars = $('#no_cars').parsley();
                        var net_pro = $('#net_pro').parsley();
                        var net_pac = $('#net_pac').parsley();
                        var nok_fname = $('#nok_fname').parsley();
                        var nok_sname = $('#nok_sname').parsley();
                        var nok_rela = $('#nok_rela').parsley();
                        var nok_phone = $('#nok_phone').parsley();
                        var nok_address = $('#nok_address').parsley();
                        var loan_amt = $('#loan_amt').parsley();
                        var loan_ten = $('#loan_ten').parsley();
                        var mon_rep = $('#mon_rep').parsley();

                        if(edu_sta.isValid() && pof_loan.isValid()  && no_cars.isValid() && net_pro.isValid() && net_pac.isValid()  && nok_fname.isValid() && nok_sname.isValid()
                            && nok_rela.isValid() && nok_phone.isValid()  && nok_address.isValid() && loan_amt.isValid() && loan_ten.isValid()  && mon_rep.isValid()
                        ) {
                            return true;
                        } else {
                            edu_sta.validate();
                            pof_loan.validate();
                            no_cars.validate();
                            net_pro.validate();
                            net_pac.validate();
                            nok_fname.validate();
                            nok_sname.validate();
                            nok_rela.validate();
                            nok_phone.validate();
                            nok_address.validate();
                            loan_amt.validate();
                            loan_ten.validate();
                            mon_rep.validate();
                        }
                    }

                    // step 6 file upload
                    if(currentIndex === 5) {
                        // step 6 acceptance
                        var passport = $('#passport').parsley();
                        var con_letter = $('#con_letter').parsley();
                        var bnk_stat = $('#bnk_stat').parsley();
                        var staff_idc = $('#staff_idc').parsley();
                        var valid_idc = $('#valid_idc').parsley();
                        var util_bill = $('#util_bill').parsley();

                        if(passport.isValid() && con_letter.isValid() && bnk_stat.isValid() && staff_idc.isValid() && valid_idc.isValid() && util_bill.isValid()) {
                            return true;
                        } else {
                            passport.validate();
                            con_letter.validate();
                            bnk_stat.validate();
                            staff_idc.validate();
                            valid_idc.validate();
                            util_bill.validate();
                        }
                    }

                    // Always allow step back to the previous step even if the current step is not valid.
                } else { return true; }
            },
            onFinishing: function (event, currentIndex) {
                // step 6 acceptance
                var bk_name = $('#bk_name').parsley();
                var acc_name = $('#acc_name').parsley();
                var acc_no = $('#acc_no').parsley();
                var agree_cond = $('#agree_cond').parsley();

                if(bk_name.isValid() && acc_name.isValid()  && acc_no.isValid() && agree_cond.isValid()) {
                    return true;
                } else {
                    bk_name.validate();
                    acc_name.validate();
                    acc_no.validate();
                    agree_cond.validate();
                }
            },
            onFinished: function (event, currentIndex) {
                var formData = new FormData(this);
                $(this).find('a[href="#finish"]').text("please wait..");
                $(this).find('a[href="#finish"]').css("pointer-events","none");
                $(this).find('a[href="#finish"]').addClass("disabled");
                $('#progressModal').modal('show');
                $.ajax({
                    xhr: function() {
                        var xhr = new window.XMLHttpRequest();
                        xhr.upload.addEventListener("progress", function(evt) {
                            if (evt.lengthComputable) {
                                var percentComplete = (evt.loaded / evt.total) * 100;
                                $(".progress-bar").css("width", percentComplete+'%');
                                $(".progress-bar").text(parseInt(percentComplete)+'%');
                            }
                        }, false);
                        return xhr;
                    },
                    url:"controllers/v7/hatch31-loan-api.php",
                    method:"POST",
                    data: formData,
                    dataType: 'json',
                    contentType: false,
                    cache: false,
                    processData: false,
                    beforeSend: function(){
                        $("#process").css("display", "block");
                    },
                    success:function(data){
                        if (data.status === 1){
                            $.alert({
                                title: 'Application Successful', content: data.message, type: 'green', typeAnimated: true,
                                buttons: {ok: { text:"OK", action: function () {window.location.replace('account/loan-history');}} }
                            });
                        } else {
                            $.alert({title: 'Error!', content: data.message, type: 'red', typeAnimated: true,});
                        }
                    },
                    complete: function () {
                        $(this).find('a[href="#finish"]').text("finish");
                        $(this).find('a[href="#finish"]').css("pointer-events","unset");
                        $(this).find('a[href="#finish"]').removeClass("disabled");
                    }
                });
            }
        });
        if ($("#loan_type").val() ==='Hatch31') {
            $('#hatchGrowthModal').modal('hide');
            $('#hatch31Modal').modal('show');
        } else {
            $('#hatch31Modal').modal('hide');
            $('#hatchGrowthModal').modal('show');
        }
    });
</script>
<script>

</script>
