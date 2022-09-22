<?php ob_start(); session_start(); ?>
<?php $filepath = realpath(dirname(__FILE__));
include_once($filepath."/../controllers/classes/GlobalApi.class.php");
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
    <base href="http://localhost/hatchcredit/">
    <link href="./assets/images/favicon.png" rel="shortcut icon" />
    <link href="./assets/images/favicon.png" rel="apple-touch-icon-precomposed">
    <link href="./assets/lib/font-awesome/css/font-awesome.css" rel="stylesheet">
    <link href="./assets/lib/Ionicons/css/ionicons.css" rel="stylesheet">
    <link href="./assets/lib/perfect-scrollbar/css/perfect-scrollbar.css" rel="stylesheet">
    <link href="./assets/lib/highlightjs/github.css" rel="stylesheet">
    <link href="./assets/lib/datatables/jquery.dataTables.css" rel="stylesheet">
    <link href="./assets/lib/jquery.steps/jquery.steps.css" rel="stylesheet">
    <link href="./assets/css/jquery-confirm.min.css" rel="stylesheet">
    <link href="./assets/css/starlight.css" rel="stylesheet">
    <style>
        form .error {color: #e74c3c;border-color: #e74c3c !important;}
        form label.error{font-size: 0.72rem;}
    </style>
</head>
<body>
<div class="sl-logo text-center"><a href="account/index"><img src="./assets/images/HCL-Logo-2.png" alt="" style="max-width: 200px"></a></div>
<div class="sl-sideleft">
    <div class="input-group input-group-search"><span class="input-group-btn"></span></div>
    <label class="sidebar-label">User Account</label>
    <div class="sl-sideleft-menu">
        <a href="account/index" class="sl-menu-link <?php if(basename($_SERVER['PHP_SELF']) == 'index.php')  echo 'active'; ?>">
            <div class="sl-menu-item">
                <i class="menu-item-icon icon ion-ios-home-outline tx-22"></i>
                <span class="menu-item-label">Home</span>
            </div>
        </a>
        <a href="account/application" class="sl-menu-link <?php if(basename($_SERVER['PHP_SELF']) == 'apply-hatch31-loan.php' ||
            basename($_SERVER['PHP_SELF']) == 'apply-hatchgrowth-loan.php' || basename($_SERVER['PHP_SELF']) == 'application.php')  echo 'active'; ?>">
            <div class="sl-menu-item">
                <i class="menu-item-icon icon ion-ios-locked-outline tx-20"></i>
                <span class="menu-item-label">Loan Application</span>
            </div>
        </a>
        <a href="account/loan-history" class="sl-menu-link <?php if(basename($_SERVER['PHP_SELF']) == 'loan-history.php')  echo 'active'; ?>">
            <div class="sl-menu-item">
                <i class="menu-item-icon icon ion-ios-paper-outline tx-20"></i>
                <span class="menu-item-label">Loan History</span>
            </div>
        </a>
    </div>
    <div class="input-group input-group-search"><span class="input-group-btn"></span></div>
    <label class="sidebar-label mt-4">Profile Management</label>
    <div class="sl-sideleft-menu">
        <a href="account/profile-settings" class="sl-menu-link <?php if(basename($_SERVER['PHP_SELF']) == 'profile-settings.php')  echo 'active'; ?>">
            <div class="sl-menu-item">
                <i class="menu-item-icon icon ion-ios-person-outline tx-20"></i>
                <span class="menu-item-label">Profile Settings</span>
            </div>
        </a>

    </div>
    <br>
</div>
<div class="sl-header">
    <div class="sl-header-left">
        <div class="navicon-left hidden-md-down"><a id="btnLeftMenu" href="#"><i class="icon ion-navicon-round"></i></a></div>
        <div class="navicon-left hidden-lg-up"><a id="btnLeftMenuMobile" href="#"><i class="icon ion-navicon-round"></i></a></div>
    </div>
    <div class="sl-header-right">
        <nav class="nav">
            <div class="dropdown">
                <a href="#" class="nav-link nav-link-profile" data-toggle="dropdown">
                    <span class="logged-name"><?=$_SESSION['MEMBER_LOGIN']['u_fname'];?>
                        <span class="hidden-md-down"> <?=$_SESSION['MEMBER_LOGIN']['u_sname']?></span>
                    </span>
                    <img src="./assets/images/img3.png" class="wd-32 rounded-circle" alt="">
                </a>
                <div class="dropdown-menu dropdown-menu-header wd-200">
                    <ul class="list-unstyled user-profile-nav">
                        <li><a href="account/profile-settings"><i class="icon ion-ios-person-outline"></i> Profile Settings</a></li>
                        <li><a href="account/application"><i class="icon ion-ios-locked-outline"></i> Apply Loan</a></li>
                        <li><a href="account/loan-history"><i class="icon ion-ios-paper-outline"></i> Loan History</a></li>
                        <li><a href="logout"><i class="icon ion-power"></i> Sign Out</a></li>
                    </ul>
                </div>
            </div>
        </nav>
    </div>
</div>

<div class="sl-mainpanel">