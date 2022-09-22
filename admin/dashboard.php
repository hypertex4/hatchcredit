<?php
include_once("./inc/header.adm.php");
if (!isset($_SESSION['ADMIN_LOGIN']['admin_id'])) header('Location: ./');
?>
<nav class="breadcrumb sl-breadcrumb">
    <a class="breadcrumb-item" href="dashboard">Admin</a>
    <span class="breadcrumb-item active">Dashboard</span>
</nav>
<div class="sl-pagebody">
    <div class="row row-sm mg-t-20">
        <div class="col-sm-6 col-xl-3">
            <div class="card pd-20 pd-sm-25">
                <div class="d-flex align-items-center justify-content-between mg-b-10">
                    <h6 class="card-body-title tx-12 tx-spacing-1">Pending Loan</h6>
                </div>
                <h2 class="tx-purple tx-lato tx-center mg-b-15">
                    <?php
                    $url = CONTROLLER_ROOT_URL."/v7/read-admin-dashboard-cred.php";
                    $object = $api->curlQueryGet($url);
                    echo $object->count_pending_loan_app;
                    ?>
                </h2>
                <p class="mg-b-0 tx-12">Pending Loan Application</p>
            </div>
        </div>
        <div class="col-sm-6 col-xl-3 mg-t-20 mg-xl-t-0">
            <div class="card bg-info tx-white pd-25">
                <div class="d-flex align-items-center justify-content-between mg-b-10">
                    <h6 class="card-body-title tx-12 tx-white-8 tx-spacing-1">Approved Loan</h6>
                </div>
                <h2 class="tx-lato tx-center mg-b-15">
                    <?php
                    $url = CONTROLLER_ROOT_URL."/v7/read-admin-dashboard-cred.php";
                    $object = $api->curlQueryGet($url);
                    echo $object->count_approved_loan_app;
                    ?>
                </h2>
                <p class="mg-b-0 tx-12 op-8">Approved Loan Application</p>
            </div>
        </div>
        <div class="col-sm-6 col-xl-3 mg-t-20 mg-xl-t-0">
            <div class="card bg-danger tx-white pd-25">
                <div class="d-flex align-items-center justify-content-between mg-b-10">
                    <h6 class="card-body-title tx-12 tx-white tx-spacing-1">Cancelled Loan</h6>
                </div>
                <h2 class="tx-lato tx-center mg-b-15">
                    <?php
                    $url = CONTROLLER_ROOT_URL."/v7/read-admin-dashboard-cred.php";
                    $object = $api->curlQueryGet($url);
                    echo $object->count_cancelled_loan_app;
                    ?>
                </h2>
                <p class="mg-b-0 tx-12 op-8">Cancelled Loan Application</p>
            </div>
        </div>
        <div class="col-sm-6 col-xl-3 mg-t-20 mg-xl-t-0">
            <div class="card bg-teal tx-white pd-25">
                <div class="d-flex align-items-center justify-content-between mg-b-10">
                    <h6 class="card-body-title tx-12 tx-white-8 tx-spacing-1">Total Customers</h6>
                </div>
                <h2 class="tx-lato tx-center mg-b-15">
                    <?php
                    $url = CONTROLLER_ROOT_URL."/v7/read-admin-dashboard-cred.php";
                    $object = $api->curlQueryGet($url);
                    echo $object->count_total_members;
                    ?>
                </h2>
                <p class="mg-b-0 tx-12 op-8">Current Total Member</p>
            </div>
        </div>
    </div>

    <div class="row row-sm mg-t-20">
        <div class="col-md-6 col-xl-4">
            <div class="card pd-20 pd-sm-25">
                <div class="d-flex justify-content-between align-items-center mg-b-15">
                    <h6 class="card-body-title tx-12 mg-b-5">Approved Hatch 31 Loan</h6>
                    <p class="tx-13 mg-b-0"><?=date("M d-Y");?></p>
                </div>
                <div class="bg-primary-light"><div id="rickshaw1" class="wd-100p ht-100"></div></div>
                <div class="row no-gutters mg-t-1">
                    <div class="col-4 tx-center bg-gray-200 pd-y-20">
                        <h5 class="tx-lato tx-inverse tx-bold mg-b-5">
                            <?php
                            $url = CONTROLLER_ROOT_URL."/v7/read-admin-dashboard-cred.php";
                            $object = $api->curlQueryGet($url);
                            echo $object->count_total_hatch31_loan_app;
                            ?>
                        </h5>
                        <p class="tx-11 tx-spacing-1 mg-b-0 tx-uppercase">Total</p>
                    </div>
                    <div class="col tx-center bg-gray-200 pd-y-20 mg-l-1">
                        <h5 class="tx-lato tx-inverse tx-bold mg-b-5">
                            ₦<?php
                            $url = CONTROLLER_ROOT_URL."/v7/read-admin-dashboard-cred.php";
                            $object = $api->curlQueryGet($url);
                            echo number_format($object->total_hatch31_loan_app_amount,0);
                            ?>
                        </h5>
                        <p class="tx-11 tx-spacing-1 mg-b-0 tx-uppercase">Total Amount</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-xl-4 mg-t-20 mg-md-t-0">
            <div class="card pd-20 pd-sm-25">
                <div class="d-flex justify-content-between align-items-center mg-b-15">
                    <h6 class="card-body-title tx-12 mg-b-5">Approved Hatch Growth Loan</h6>
                    <p class="tx-13 mg-b-0"><?=date("M d-Y");?></p>
                </div>
                <div class="bg-success-light"><div id="rickshaw2" class="wd-100p ht-100"></div></div>
                <div class="row no-gutters mg-t-1">
                    <div class="col-4 tx-center bg-gray-200 pd-y-20">
                        <h5 class="tx-lato tx-inverse tx-bold mg-b-5">
                            <?php
                            $url = CONTROLLER_ROOT_URL."/v7/read-admin-dashboard-cred.php";
                            $object = $api->curlQueryGet($url);
                            echo $object->count_total_hatchgrowth_loan_app;
                            ?>
                        </h5>
                        <p class="tx-11 tx-spacing-1 mg-b-0 tx-uppercase">Total</p>
                    </div>
                    <div class="col tx-center bg-gray-200 pd-y-20 mg-l-1">
                        <h5 class="tx-lato tx-inverse tx-bold mg-b-5">
                            ₦<?php
                            $url = CONTROLLER_ROOT_URL."/v7/read-admin-dashboard-cred.php";
                            $object = $api->curlQueryGet($url);
                            echo number_format($object->total_hatchgrowth_loan_app_amount,0);
                            ?>
                        </h5>
                        <p class="tx-11 tx-spacing-1 mg-b-0 tx-uppercase">Total Amount</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-xl-4 mg-t-20 mg-xl-t-0">
            <div class="card pd-20 pd-sm-25 bg-sl-primary">
                <div class="d-flex justify-content-between align-items-center mg-b-15">
                    <h6 class="card-body-title tx-white tx-12 mg-b-5">All Approved Loan</h6>
                    <p class="tx-13 mg-b-0"><?=date("M d-Y");?></p>
                </div>
                <div class="bg-black-2"><div id="rickshaw3" class="wd-100p ht-100"></div></div>
                <div class="row no-gutters mg-t-1">
                    <div class="col-4 tx-center bg-black-3 pd-y-20">
                        <h5 class="tx-lato tx-white tx-bold mg-b-5">
                            <?php
                            $url = CONTROLLER_ROOT_URL."/v7/read-admin-dashboard-cred.php";
                            $object = $api->curlQueryGet($url);
                            echo $object->count_total_loan_app;
                            ?>
                        </h5>
                        <p class="tx-11 tx-spacing-1 mg-b-0 tx-uppercase">Total</p>
                    </div>
                    <div class="col tx-center bg-black-3 pd-y-20 mg-l-1">
                        <h5 class="tx-lato tx-white tx-bold mg-b-5">
                            ₦<?php
                            $url = CONTROLLER_ROOT_URL."/v7/read-admin-dashboard-cred.php";
                            $object = $api->curlQueryGet($url);
                            echo number_format($object->total_loan_app_amount,0);
                            ?>
                        </h5>
                        <p class="tx-11 tx-spacing-1 mg-b-0 tx-uppercase">Total Amount</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include_once("./inc/footer.adm.php"); ?>