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
    <span class="breadcrumb-item active">Template form</span>
</nav>
<div class="sl-pagebody">
    <div class="row row-sm mg-t-20">
        <div class="col-xl-12 col-12">
            <div class="card overflow-hidden">
                <div class="card-header bg-transparent pd-y-20 d-sm-flex align-items-center justify-content-between">
                    <div class="mg-b-20 mg-sm-b-0">
                        <h6 class="card-title mg-b-5 tx-13 tx-uppercase tx-bold tx-spacing-1">Template Form</h6>
                        <span class="d-block tx-12"><?=date("F d, Y");?></span>
                    </div>
                </div>
                <div class="card-body pd-0 bd-color-gray-lighter">
                    <div class="row no-gutters tx-center">
                        <div class="col-12 pd-y-0 p-3 tx-left">
                            <div class="card mg-t-0">
                                <div class="card-header card-header-default bg-secondary">Loan Consent Form</div>
                                <div class="card-body bd bd-t-0 p-20">
                                    <form name="template_form" id="template_form" class="form-layout">
                                        <div id="response-alert"></div>
                                        <div class="row mg-b-25">
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label for="f_name" class="form-control-label">First Name: <span class="tx-danger">*</span></label>
                                                    <input class="form-control" type="text" name="f_name" id="f_name">
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label for="m_name" class="form-control-label">Middle Name: <span class="tx-danger">*</span></label>
                                                    <input class="form-control" type="text" name="m_name" id="m_name">
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label for="s_name" class="form-control-label">Surname: <span class="tx-danger">*</span></label>
                                                    <input class="form-control" type="text" name="s_name" id="s_name">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-layout-footer">
                                            <input type="submit" class="btn btn-info mg-r-5" value="Generate" />
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include_once("./inc/footer.adm.php"); ?>