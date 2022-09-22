<?php
session_start();
if (isset($_SESSION['MEMBER_LOGIN']) && isset($_SESSION['MEMBER_LOGIN']['user_id'])) header("Location: account/index");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Hatch Credit, Get an instant loan today">
    <meta name="author" content="Hatch Credit">
    <title>Hatch Credit: Email Verification</title>
    <link href="./assets/images/favicon.png" rel="shortcut icon" />
    <link href="./assets/images/favicon.png" rel="apple-touch-icon-precomposed">
    <link href="./assets/lib/font-awesome/css/font-awesome.css" rel="stylesheet">
    <link href="./assets/lib/Ionicons/css/ionicons.css" rel="stylesheet">
    <link href="./assets/lib/select2/css/select2.min.css" rel="stylesheet">
    <link href="./assets/css/starlight.css" rel="stylesheet">
    <style>
        .signin-logo img{max-width: 200px;}
    </style>
</head>
<body>
<div class="d-flex align-items-center justify-content-center bg-sl-primary ht-md-100v">
    <div class="login-wrapper wd-300 wd-xs-400 pd-15 pd-xs-20 bg-white">
        <div class="signin-logo tx-center tx-24 tx-bold tx-inverse"><img src="./assets/images/HCL-Logo-2.png" alt="" /></div>
        <div class="tx-center mg-b-10 my-5"></div>
        <form id="verify_form" name="verify_form">
            <div id="response-alert"></div>
            <div class="form-group">
                <label for="">Enter verification code</label>
                <input type="text" class="form-control" title="Email Verification code" name="verify_code" id="verify_code" placeholder="Enter code" maxlength="6">
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-info btn-block" value="Activate Account"/>
            </div>
        </form>
        <div class="mg-t-40 tx-center">Already have an account? <a href="./" class="tx-info">Login</a></div>
    </div>
</div>
<script src="./assets/lib/jquery/jquery.js"></script>
<script src="./assets/lib/popper.js/popper.js"></script>
<script src="./assets/lib/bootstrap/bootstrap.js"></script>
<script src="./assets/lib/jquery-validation/jquery.validate.min.js"></script>
<script src="./assets/js/credit-reducer.js"></script>

</body>
</html>