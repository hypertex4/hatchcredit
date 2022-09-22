<?php
if (!isset($_SESSION['MEMBER_LOGIN']) && !empty($_SESSION['MEMBER_LOGIN']['user_id'])) header("Location: ../index");
include_once("../inc/header.nav.php");
?>
<style>
    @import url('https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,300;0,400;0,600;1,400;1,600&display=swap');
    :root {
        --card-line-height: 1.2em;
        --card-padding: 1em;
        --card-radius: 0.5em;
        --color-green: #ff383b;
        --color-gray: #e2ebf6;
        --color-dark-gray: #c4d1e1;
        --radio-border-width: 2px;
        --radio-size: 1.5em;
    }
    .grid { display: grid; grid-gap: var(--card-padding); max-width: 60em; padding: 0;font-family: 'Montserrat', sans-serif; }
    @media (min-width: 42em) {  .grid {grid-template-columns: repeat(2, 1fr);}  }
    .card { background-color: #fff; border-radius: var(--card-radius); position: relative; font-family: 'Montserrat', sans-serif;}
    .card:hover {box-shadow: 5px 5px 10px rgba(0, 0, 0, 0.15);}
    .radio {
        font-size: inherit;margin: 0;position: absolute;right: calc(var(--card-padding) + var(--radio-border-width));
        top: calc(var(--card-padding) + var(--radio-border-width));
    }
    @supports (-webkit-appearance: none) or (-moz-appearance: none) {
        .radio {
            -webkit-appearance: none; -moz-appearance: none; background: #fff; border: var(--radio-border-width) solid var(--color-gray);
            border-radius: 50%;cursor: pointer;height: var(--radio-size);outline: none;transition: background 0.2s ease-out, border-color 0.2s ease-out;
            width: var(--radio-size);
        }
        .radio::after {
            border: var(--radio-border-width) solid #fff;border-top: 0;border-left: 0;content: "";display: block;height: 0.75rem;
            left: 25%;position: absolute;top: 50%;transform: rotate(45deg) translate(-50%, -50%);width: 0.375rem;
        }
        .radio:checked {background: var(--color-green);border-color: var(--color-green);}
        /*.card:hover .radio {border-color: var(--color-dark-gray);}*/
        .card:hover .radio:checked {border-color: var(--color-green);}
    }
    .plan-details {
        border: var(--radio-border-width) solid var(--color-gray);border-radius: var(--card-radius);cursor: pointer;display: flex;flex-direction: column;
        padding: var(--card-padding);transition: border-color 0.2s ease-out;font-family: 'Montserrat', sans-serif; font-size: 14px;
    }
    .card:hover .plan-details {border-color: var(--color-dark-gray);}
    .radio:checked ~ .plan-details {border-color: var(--color-green);}
    /*.radio:focus ~ .plan-details {box-shadow: 0 0 0 2px var(--color-dark-gray);}*/
    .radio:disabled ~ .plan-details {color: var(--color-dark-gray);cursor: default;}
    .radio:disabled ~ .plan-details .plan-type {color: var(--color-dark-gray);}
    .card:hover .radio:disabled ~ .plan-details {border-color: var(--color-gray);box-shadow: none;}
    .card:hover .radio:disabled {border-color: var(--color-gray);}
    .plan-type {color: var(--color-green);font-size: 1.5rem;font-weight: bold;line-height: 1em;font-family: 'Montserrat', sans-serif;}
    .plan-cost {font-size: 1.6rem;font-weight: bold;padding: 0.5rem 0;font-family: 'Montserrat', sans-serif;}
    .slash {font-weight: normal;font-family: 'Montserrat', sans-serif;}
    .plan-cycle {font-size: 2rem;font-variant: none;border-bottom: none;cursor: inherit;text-decoration: none !important;font-family: 'Montserrat', sans-serif;}
</style>
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
                        <h6 class="card-title mg-b-5 tx-13 tx-uppercase tx-bold tx-spacing-1">Select Loan Type</h6>
                        <span class="d-block tx-12">Select a loan type from the options below to continue</span>
                    </div>
                </div>
                <div class="card-body pd-0 bd-color-gray-lighter">
                    <form method="post" action="account/apply-loan" class="row no-gutters tx-center">
                        <div class="col-12 px-3 py-5 tx-left">
                            <div class="grid">
                                <label class="card">
                                    <input name="loan_type" class="radio" type="radio" value="Hatch31">
                                    <span class="plan-details py-3" aria-hidden="true">
                                        <span class="plan-type">Type 01</span>
                                        <span class="plan-cost">Hatch31</span>
                                        <span>The <b>HATCH31</b> loans is tailored to meet the needs of salary earners and people in paid employment. </span>
                                        <span class="py-3"></span>
                                    </span>
                                </label>
                                <label class="card">
                                    <input name="loan_type" class="radio" type="radio" value="HatchGrowth">
                                    <span class="plan-details py-3" aria-hidden="true">
                                        <span class="plan-type">Type 02</span>
                                        <span class="plan-cost">Hatchgrowth</span>
                                        <span><b>HATCHGROWTH</b> loan is designed to suit the financial needs of SMEs, registered businesses etc.</span>
                                        <span class="py-3"></span>
                                    </span>
                                </label>
                            </div>
                        </div>
                        <div class="col-12 px-3 pb-5 tx-left myStartBtn" style="display: none">
                            <a href="account/apply-hatch31-loan" class="btn btn-primary px-5">Start Application</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include_once("../inc/footer.nav.php"); ?>
<script>
    $(document).ready(function () {
        $("input[name='loan_type']").click(function() {
            if($(this).is(':checked')) {
                $(".myStartBtn").css("display", "block");
                if ($("input[name='loan_type']:checked").val() === "Hatch31"){
                    $(".myStartBtn a").attr("href","account/apply-hatch31-loan");
                } else {
                    $(".myStartBtn a").attr("href","account/apply-hatchgrowth-loan");
                }
            }
        });
    });
</script>
