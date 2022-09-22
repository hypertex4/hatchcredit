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
    <span class="breadcrumb-item active">All Members</span>
</nav>
<div class="sl-pagebody">
    <div class="row row-sm mg-t-20">
        <div class="col-sm-12 col-xl-12">
            <div class="card overflow-hidden">
                <div class="card-header bg-transparent pd-y-20 d-sm-flex align-items-center justify-content-between">
                    <div class="mg-b-20 mg-sm-b-0">
                        <h6 class="card-title mg-b-5 tx-13 tx-uppercase tx-bold tx-spacing-1">All Members</h6>
                        <span class="d-block tx-12">All registered members</span>
                    </div>
                </div>
                <div class="card-body pd-0 bd-color-gray-lighter">
                    <div class="row no-gutters tx-center">
                        <div class="col-12 pd-y-20 p-3 tx-left">
                            <div class="table-wrapper">
                                <table id="AllMembers" class="table display responsive nowrap">
                                    <thead>
                                    <tr>
                                        <th class="wd-5p">#</th>
                                        <th class="wd-7p">User ID</th>
                                        <th class="wd-15p">First Name</th>
                                        <th class="wd-7p">Last Name</th>
                                        <th class="wd-10p">Surname</th>
                                        <th class="wd-15p">Email</th>
                                        <th class="wd-8p">Mobile</th>
                                        <th class="wd-8p">Created On</th>
                                        <th class="wd-10p">Status</th>
                                        <th class="wd-35p">Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    $url = CONTROLLER_ROOT_URL."/v7/admin-fetch-all-members.php";
                                    $object = $api->curlQueryGet($url);
                                    if($object->status==1)  {$n=0;
                                        foreach ($object->members as $member) {
                                            ?>
                                            <tr>
                                                <td><?=++$n;?></td>
                                                <td>#<?=$member->user_id;?></td>
                                                <td><?=$member->u_fname;?></td>
                                                <td><?=$member->u_lname;?></td>
                                                <td><?=$member->u_sname;?></td>
                                                <td><?=$member->u_email;?></td>
                                                <td><?=$member->u_mobile;?></td>
                                                <td><?=date("d/M/Y H:i", strtotime($member->u_created_on));?></td>
                                                <td>
                                                    <?php if ($member->u_active == "0"){?>
                                                    <span class="tx-11 d-block text-danger"><span class="square-8 bg-danger mg-r-5 rounded-circle"></span> Inactive</span>
                                                    <?php } else { ?>
                                                    <span class="tx-11 d-block text-success"><span class="square-8 bg-success mg-r-5 rounded-circle"></span> Active</span>
                                                    <?php } ?>
                                                </td>
                                                <td>
                                                    <?php if ($member->u_active == "0"){?>
                                                    <button id="updateActive" class="btn btn-success btn-sm" data-u_sno="<?=$member->u_sno;?>" data-active="1">
                                                        <i class="fa fa-trash mg-r-2"></i>Activate
                                                    </button>
                                                    <?php } else { ?>
                                                    <button id="updateActive" class="btn btn-secondary btn-sm" data-u_sno="<?=$member->u_sno;?>" data-active="0">
                                                        <i class="fa fa-check-circle mg-r-2"></i> Deactivate
                                                    </button>
                                                    <?php } ?>
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
    $('#AllMembers').DataTable({
        responsive: true,
        language: {
            searchPlaceholder: 'Search',
            sSearch: '',
            lengthMenu: '_MENU_ items/page',
        },
        bSort:false,
    });
</script>
