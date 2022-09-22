<?php
if (!isset($_SESSION['MEMBER_LOGIN']) && !empty($_SESSION['MEMBER_LOGIN']['user_id'])) header("Location: ../index");
include_once("../inc/header.nav.php");
include_once('../controllers/config/database.php');
include_once('../controllers/classes/Member.class.php');

$db = new Database();
$connection = $db->connect();
$member = new Member($connection);
?>
<nav class="breadcrumb sl-breadcrumb">
    <a class="breadcrumb-item" href="account/index">User Account</a>
    <span class="breadcrumb-item active">My Dashboard</span>
</nav>
<div class="sl-pagebody">
    <div class="row row-sm">
        <div class="col-sm-12 col-xl-12">
            <div class="card bg-transparent">
                <blockquote class="blockquote bd-l bd-5 pd-l-20">
                    <p class="mg-b-5 tx-inverse">Welcome Back <span class="h4"><?=$_SESSION['MEMBER_LOGIN']['u_fname'];?></span></p>
                    <footer class="blockquote-footer tx-14">Here's a quick summary of what's happening</footer>
                </blockquote>
            </div>
        </div>
    </div>
    <div class="row row-sm mg-t-20">
        <div class="col-xl-12 col-12">
            <div class="card overflow-hidden">
                <div class="card-header bg-transparent pd-y-20 d-sm-flex align-items-center justify-content-between">
                    <div class="mg-b-20 mg-sm-b-0">
                        <h6 class="card-title mg-b-5 tx-13 tx-uppercase tx-bold tx-spacing-1">Loan History Summary</h6>
                        <span class="d-block tx-12"><?=date("F d, Y");?></span>
                    </div>
                    <div><a href="account/loan-history" class="btn btn-outline-secondary px-4">View All</a></div>
                </div>
                <div class="card-body pd-0 bd-color-gray-lighter">
                    <div class="row no-gutters tx-center">
                        <div class="col-12 pd-y-20 p-3 tx-left">
                            <div class="table-wrapper">
                                <table id="loanSummary" class="table display responsive nowrap">
                                    <thead>
                                    <tr>
                                        <th class="wd-5p">#</th>
                                        <th class="wd-10p">Date</th>
                                        <th class="wd-15p">Transaction ID</th>
                                        <th class="wd-10p">Loan Type</th>
                                        <th class="wd-15p">Amount</th>
                                        <th class="wd-15p">Tenor</th>
                                        <th class="wd-15p">Status</th>
                                        <th class="wd-30p">Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    $url = CONTROLLER_ROOT_URL."/v7/fetch-user-loan-application-limit-10.php?user_id=".$_SESSION['MEMBER_LOGIN']['user_id']."&limit=10";
                                    $object = $api->curlQueryGet($url);
                                    if($object->status==1)  {$n=0;
                                    foreach ($object->loan_app as $app) {
                                        $loan_id = $member->get_loan_application_details($app->lq_id,$app->lq_ltype);
                                    ?>
                                    <tr>
                                        <td><?=++$n;?></td>
                                        <td><?=date("d/m/Y", strtotime($app->lq_created_on));?></td>
                                        <th>#<?=$loan_id['ln_id'];?></th>
                                        <td><?=$app->lq_ltype;?></td>
                                        <td>₦<?=number_format($loan_id['ln_amount'],0);?></td>
                                        <td><?=$loan_id['ln_tenor'];?> month(s)</td>
                                        <?php if ($app->lq_status == "Pending"){?>
                                        <td><button class="btn btn-default btn-sm disabled px-3">Pending</button></td>
                                        <?php } else if ($app->lq_status == "Cancelled") { ?>
                                        <td><button class="btn btn-danger btn-sm disabled px-3">Cancelled</button></td>
                                        <?php } else { ?>
                                        <td><button class="btn btn-success btn-sm disabled px-3">Approved</button></td>
                                        <?php } ?>
                                        <td></td>
                                    </tr>
                                    <?php } } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
<?php include_once("../inc/footer.nav.php"); ?>
<script src="./assets/js/ResizeSensor.js"></script>
<script src="./assets/js/dashboard.js"></script>
<script>
    $('#loanSummary').DataTable({
        bLengthChange: false,
        searching: false,
        responsive: true,
        bSort:false
    });
</script>
