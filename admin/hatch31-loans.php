<?php
include_once("./inc/header.adm.php");
if (!isset($_SESSION['ADMIN_LOGIN']['admin_id'])) header('Location: ./');
include_once('../controllers/config/database.php');
include_once('../controllers/classes/Admin.class.php');

$db = new Database();
$connection = $db->connect();
$admin = new Admin($connection);
?>
<nav class="breadcrumb sl-breadcrumb">
    <a class="breadcrumb-item" href="dashboard">Admin</a>
    <span class="breadcrumb-item active">Hatch31 Loan Application</span>
</nav>
<div class="sl-pagebody">
    <div class="row row-sm mg-t-20">
        <div class="col-sm-12 col-xl-12">
            <div class="card overflow-hidden">
                <div class="card-header bg-transparent pd-y-20 d-sm-flex align-items-center justify-content-between">
                    <div class="mg-b-20 mg-sm-b-0">
                        <h6 class="card-title mg-b-5 tx-13 tx-uppercase tx-bold tx-spacing-1">Hatch31 Loan Application</h6>
                        <span class="d-block tx-12">Here's a summary of all hatch31 transactions</span>
                    </div>
                </div>
                <div class="card-body pd-0 bd-color-gray-lighter">
                    <div class="row no-gutters tx-center">
                        <div class="col-12 pd-y-20 p-3 tx-left">
                            <div class="table-wrapper">
                                <table id="AllLoans" class="table display responsive nowrap">
                                    <thead>
                                    <tr>
                                        <th class="wd-5p">#</th>
                                        <th class="wd-7p">Amount</th>
                                        <th class="wd-7p">Date</th>
                                        <th class="wd-15p">Email</th>
                                        <th class="wd-15p">Mobile</th>
                                        <th class="wd-10p">Loan ID</th>
                                        <th class="wd-8p">Tenor</th>
                                        <th class="wd-10p">Status</th>
                                        <th class="wd-5p">More</th>
                                        <th class="wd-23p">Action</th>
                                        <th class="wd-12p"></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    $url = CONTROLLER_ROOT_URL."/v7/admin-fetch-loan-app-type.php?type=Hatch31";
                                    $object = $api->curlQueryGet($url);
                                    if($object->status==1)  {$n=0;
                                        foreach ($object->loan_apps as $app) {
                                            $loan_type = $admin->get_loan_application_details($app->lq_id,$app->lq_ltype);
                                            ?>
                                            <tr>
                                                <td><?=++$n;?></td>
                                                <td>₦<?=number_format($loan_type['ln_amount'],0);?></td>
                                                <td><?=date("d/m/Y", strtotime($app->lq_created_on));?></td>
                                                <td><?=$loan_type['ln_email'];?></td>
                                                <td><?=$loan_type['ln_mobile'];?></td>
                                                <th>#<?=$loan_type['ln_id'];?></th>
                                                <td><?=$loan_type['ln_tenor'];?> month(s)</td>
                                                <td>
                                                    <?php if ($app->lq_status == "Pending"){?>
                                                        <span class="tx-11 d-block text-secondary"><span class="square-8 bg-secondary mg-r-5 rounded-circle"></span> Pending</span>
                                                    <?php } else if ($app->lq_status == "Cancelled") { ?>
                                                        <span class="tx-11 d-block text-danger"><span class="square-8 bg-danger mg-r-5 rounded-circle"></span> Cancelled</span>
                                                    <?php } else { ?>
                                                        <span class="tx-11 d-block text-success"><span class="square-8 bg-success mg-r-5 rounded-circle"></span> Approved</span>
                                                    <?php } ?>
                                                </td>
                                                <td><a href="loan-application-details/<?=$app->lq_id;?>">view</a></td>
                                                <td>
                                                    <?php if ($app->lq_status == "Pending"){?>
                                                        <div class="flex-row">
                                                            <button id="updateStatus" class="btn btn-danger btn-sm" data-l_id="<?=$app->lq_id;?>" data-status="Cancelled">
                                                                <i class="fa fa-trash mg-r-2"></i>D
                                                            </button>
                                                            <button id="updateStatus" class="btn btn-success btn-sm" data-l_id="<?=$app->lq_id;?>" data-status="Approved">
                                                                <i class="fa fa-check-circle mg-r-2"></i>A
                                                            </button>
                                                        </div>
                                                    <?php } ?>
                                                </td>
                                                <td>
                                                    <?php
                                                    if ($app->lq_ltype == "Hatch31"){
                                                        $result = $admin->count_num_non_null_file_upload_hatch31($loan_type['ln_sno']);
                                                        if ($result == 0) echo '';
                                                        else echo '<span class="square-8 bg-info mg-r-2 rounded-circle"></span><a href="loan-application-details?quest_id='.$app->lq_id.'&scrollTo=scr_bot">(' . $result.')</a>';
                                                    } else {
                                                        $result = $admin->count_num_non_null_file_upload_hatch_growth($loan_type['lg_sno']);
                                                        if ($result == 0) echo '';
                                                        else echo '<span class="square-8 bg-info mg-r-2 rounded-circle"></span><a href="loan-application-details?quest_id='.$app->lq_id.'&scrollTo=scr_bot">(' . $result.')</a>';
                                                    }
                                                    ?>
                                                </td>
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
<?php include_once("./inc/footer.adm.php"); ?>
<script>
    $('#AllLoans').DataTable({
        responsive: true,
        language: {
            searchPlaceholder: 'Search',
            sSearch: '',
            lengthMenu: '_MENU_ items/page',
        },
        bSort:false,
    });
</script>
