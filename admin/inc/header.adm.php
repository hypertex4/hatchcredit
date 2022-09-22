<?php ob_start(); session_start(); ?>
<?php $filepath = realpath(dirname(__FILE__));
include_once($filepath."/../../controllers/classes/GlobalApi.class.php");
define('CONTROLLER_ROOT_URL', 'http://localhost/hatchcredit/controllers');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Hatch Credit, Get an instant loan today">
    <meta name="author" content="Hatch Credit">
    <title>Hatch Credit: A Lending Services Company</title>
    <base href="http://localhost/hatchcredit/admin/">
    <link href="./assets/images/favicon.png" rel="shortcut icon" />
    <link href="./assets/images/favicon.png" rel="apple-touch-icon-precomposed">
    <link href="./assets/lib/font-awesome/css/font-awesome.css" rel="stylesheet">
    <link href="./assets/lib/Ionicons/css/ionicons.css" rel="stylesheet">
    <link href="./assets/lib/perfect-scrollbar/css/perfect-scrollbar.css" rel="stylesheet">
    <link href="./assets/lib/highlightjs/github.css" rel="stylesheet">
    <link href="./assets/lib/select2/css/select2.min.css" rel="stylesheet">
    <link href="./assets/lib/datatables/jquery.dataTables.css" rel="stylesheet">
    <link href="./assets/lib/jquery.steps/jquery.steps.css" rel="stylesheet">
    <link href="./assets/css/toastr.min.css" rel="stylesheet">
    <link href="./assets/css/jquery-confirm.min.css" rel="stylesheet">
    <link href="./assets/css/starlight.css" rel="stylesheet">
    <style>
        form .error {color: #e74c3c;border-color: #e74c3c !important;}
        form label.error{font-size: 0.72rem;}
    </style>
</head>
<body>
<div class="sl-logo text-center"><a href="index"><img src="./assets/images/HCL-Logo-2.png" alt="" style="max-width: 200px"></a></div>
<div class="sl-sideleft">
    <div class="input-group input-group-search"><span class="input-group-btn"></span></div>
    <label class="sidebar-label">Admin Account</label>
    <div class="sl-sideleft-menu">
        <a href="index" class="sl-menu-link <?php if(basename($_SERVER['PHP_SELF']) == 'dashboard.php')  echo 'active'; ?>">
            <div class="sl-menu-item">
                <i class="menu-item-icon icon ion-ios-home-outline tx-22"></i>
                <span class="menu-item-label">Dashboard</span>
            </div>
        </a>
        <a href="all-loans" class="sl-menu-link <?php if(basename($_SERVER['PHP_SELF']) == 'all-loans.php' ||
            basename($_SERVER['PHP_SELF']) == 'hatch31-loans.php' || basename($_SERVER['PHP_SELF']) == 'hatchgrwoth-loans.php' ||
            basename($_SERVER['PHP_SELF']) == 'loan-application-details.php')  echo 'active'; ?>">
            <div class="sl-menu-item">
                <i class="menu-item-icon icon ion-ios-bookmarks-outline tx-20"></i>
                <span class="menu-item-label">Loan Applications</span>
                <i class="menu-item-arrow fa fa-angle-down"></i>
            </div>
        </a>
        <ul class="sl-menu-sub nav flex-column">
            <li class="nav-item"><a href="all-loans" class="nav-link active">All Loans</a></li>
            <li class="nav-item"><a href="hatch31-loans" class="nav-link">Hatch31</a></li>
            <li class="nav-item"><a href="hatchgrwoth-loans" class="nav-link">Hatchgrowth</a></li>
        </ul>
    </div>
    <div class="input-group input-group-search"><span class="input-group-btn"></span></div>
    <label class="sidebar-label mt-4">Management</label>
    <div class="sl-sideleft-menu">

        <a href="all-members" class="sl-menu-link <?php if(basename($_SERVER['PHP_SELF']) == 'all-members.php')  echo 'active'; ?>">
            <div class="sl-menu-item">
                <i class="menu-item-icon icon ion-ios-personadd-outline tx-22"></i>
                <span class="menu-item-label">All Members</span>
            </div>
        </a>
        <a href="template-form" class="sl-menu-link <?php if(basename($_SERVER['PHP_SELF']) == 'profile-settings.php')  echo 'active'; ?>">
            <div class="sl-menu-item">
                <i class="menu-item-icon icon ion-ios-email-outline tx-20"></i>
                <span class="menu-item-label">Response Template</span>
            </div>
        </a>
    </div>
    <br>
</div>
<div class="sl-header noprint">
    <div class="sl-header-left">
        <div class="navicon-left hidden-md-down"><a id="btnLeftMenu" href="#"><i class="icon ion-navicon-round"></i></a></div>
        <div class="navicon-left hidden-lg-up"><a id="btnLeftMenuMobile" href="#"><i class="icon ion-navicon-round"></i></a></div>
    </div>
    <div class="sl-header-right">
        <nav class="nav">
            <div class="dropdown">
                <a href="#" class="nav-link nav-link-profile" data-toggle="dropdown">
                    <span class="logged-name"><?="Admin";?>
                        <span class="hidden-md-down"></span>
                    </span>
                    <img src="./assets/images/img3.png" class="wd-32 rounded-circle" alt="">
                </a>
                <div class="dropdown-menu dropdown-menu-header wd-200">
                    <ul class="list-unstyled user-profile-nav">
                        <li><a href="javascript:void(0)"><i class="icon ion-ios-person-outline"></i> <?=$_SESSION['ADMIN_LOGIN']['admin_user'];?></a></li>
                        <li><a href="all-loans"><i class="icon ion-ios-locked-outline"></i> Loan Applications</a></li>
                        <li><a href="logout"><i class="icon ion-power"></i> Sign Out</a></li>
                    </ul>
                </div>
            </div>
        </nav>
    </div>
</div>

<div class="sl-mainpanel">