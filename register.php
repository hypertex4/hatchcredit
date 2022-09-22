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
    <title>Hatch Credit: A Lending Services Company</title>
    <link href="./assets/images/favicon.png" rel="shortcut icon" />
    <link href="./assets/images/favicon.png" rel="apple-touch-icon-precomposed">
    <link href="./assets/lib/font-awesome/css/font-awesome.css" rel="stylesheet">
    <link href="./assets/lib/Ionicons/css/ionicons.css" rel="stylesheet">
    <link href="./assets/css/starlight.css" rel="stylesheet">
    <style>
        .signin-logo img{max-width: 200px;}
        form .error {color: #e74c3c;border-color: #e74c3c !important;}
        form label.error{font-size: 0.72rem;}
    </style>
</head>
<body>
<div class="d-flex align-items-center justify-content-center bg-sl-primary ht-md-100v">
    <div class="login-wrapper wd-300 wd-xs-500 pd-15 pd-xs-20 bg-white">
        <div class="signin-logo tx-center tx-24 tx-bold tx-inverse"><img src="./assets/images/HCL-Logo-2.png" width="300px" alt="" /></div>
        <div class="tx-center mg-b-10 my-5"></div>
        <form name="member_registration" id="member_registration">
            <div id="response-alert"></div>
            <div class="row row-xs">
                <div class="form-group col-sm-6">
                    <input type="text" class="form-control" title="User First Name" id="f_name" name="f_name" placeholder="Enter your First Name">
                </div>
                <div class="form-group col-sm-6">
                    <input type="text" class="form-control" title="User Last Name" id="l_name" name="l_name" placeholder="Enter your Last name">
                </div>
            </div>
            <div class="form-group">
                <input type="text" class="form-control" title="User Surname" id="s_name" name="s_name" placeholder="Enter your Surname">
            </div>
            <div class="form-group">
                <input type="email" class="form-control" title="User Email Address" id="email" name="email" placeholder="Enter your Email Address">
            </div>
            <div class="form-group">
                <input type="text" class="form-control" title="User Mobile Number" id="mobile" name="mobile" maxlength="11" placeholder="Enter your Mobile Number">
            </div>
            <div class="form-group">
                <input type="password" class="form-control" title="Create account password" id="password" name="password" placeholder="Create account password">
            </div>
            <div class="form-group">
                <input type="password" class="form-control" title="Confirm password" id="c_password" name="c_password" placeholder="Repeat password">
            </div>
            <div class="form-group tx-12">By clicking the Sign Up button below, you agreed to our privacy policy and terms of use of our website.</div>
            <div class="form-group">
                <input type="submit" class="btn btn-info btn-block" value="Sign Up" />
            </div>
        </form>
        <div class="mg-t-40 tx-center">Already have an account? <a href="./" class="tx-info">Sign In</a></div>
    </div>
</div>
<script src="./assets/lib/jquery/jquery.js"></script>
<script src="./assets/lib/popper.js/popper.js"></script>
<script src="./assets/lib/bootstrap/bootstrap.js"></script>
<script src="./assets/lib/jquery-validation/jquery.validate.min.js"></script>
<script src="./assets/js/credit-reducer.js"></script>
</body>
</html>