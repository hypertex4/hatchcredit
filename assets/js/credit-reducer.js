(function($) {
    'use strict';
    // No White Space
    $.validator.addMethod("noSpace", function(value, element) {
        if( $(element).attr('required') ) {
            return value.search(/^(?! *$)[^]+$/) == 0;
        }
        return true;
    }, 'Please fill this empty field.');
    $.validator.addClassRules({
        'form-control': {noSpace: true}
    });

    $("form[name='member_registration']").validate({
        rules: {
            f_name: "required",
            l_name: "required",
            s_name: "required",
            email: {required: true, email: true},
            mobile: {required: true, digits: true},
            password: {required: true, minlength: 6},
            c_password: {equalTo: '[name="password"]'}
        },
        messages: {
            f_name: "Enter First Name",
            l_name: "Enter Last Name",
            s_name: "Enter Surname",
            email: "Enter a valid email address",
            mobile: "Enter a valid phone number",
            password: "Entered password must be min six(6) character",
            c_password: "Password not matched"
        },
        errorPlacement: function(error, element) {
            if(element.attr('type') === 'radio' || element.attr('type') === 'checkbox') {
                error.appendTo(element.closest('.form-group'));
            } else if( element.is('select') && element.closest('.custom-select-1')) {
                error.appendTo(element.closest('.form-group'));
            } else {
                if( element.closest('.form-group').length ) {
                    error.appendTo(element.closest('.form-group'));
                } else {
                    error.insertAfter(element);
                }
            }
        },
        submitHandler: function (form) {
            var $form = $(form),
                $submitButton = $(this.submitButton),
                submitButtonText = $submitButton.val();

            $submitButton.val( $submitButton.data('loading-text') ? $submitButton.data('loading-text') : 'Please wait...' ).attr('disabled', true);
            $.ajax({
                url: "controllers/v7/member-register-api.php", type: "POST", data: $form.serialize(),
                success: function (data) {
                    if (data.status === 1) {
                        document.getElementById('member_registration').reset();
                        sendSuccessResponse('Successful!',data.message);
                        setTimeout(()=>window.location.replace('account-verification'),4000);
                    } else { sendErrorResponse('Error', data.message);}
                },
                complete: function () { $submitButton.val( submitButtonText ).attr('disabled', false); }
            });
        }
    });

    $("form[name='verify_form']").validate({
        rules: {
            verify_code: {required: true, digits: true}
        },
        messages: {
            verify_code: "Enter email verification code",
        },
        errorPlacement: function(error, element) {
            if(element.attr('type') === 'radio' || element.attr('type') === 'checkbox') {
                error.appendTo(element.closest('.form-group'));
            } else if( element.is('select') && element.closest('.custom-select-1')) {
                error.appendTo(element.closest('.form-group'));
            } else {
                if( element.closest('.form-group').length ) {
                    error.appendTo(element.closest('.form-group'));
                } else {
                    error.insertAfter(element);
                }
            }
        },
        submitHandler: function (form) {
            var $form = $(form),
                $submitButton = $(this.submitButton),
                submitButtonText = $submitButton.val();

            $submitButton.val( $submitButton.data('loading-text') ? $submitButton.data('loading-text') : 'Please wait...' ).attr('disabled', true);
            $.ajax({
                url: "controllers/v7/member-verification-api.php", type: "POST", data: $form.serialize(),
                success: function (data) {
                    if (data.status === 1){
                        sendSuccessResponse("Successful",data.message);
                        document.getElementById("verify_form").reset();
                        setTimeout(()=>{window.location.replace('./');},3000);
                    } else { sendErrorResponse('Error', data.message);}
                },
                complete: function () { $submitButton.val( submitButtonText ).attr('disabled', false); }
            });
        }
    });

    $("form[name='login_form']").validate({
        rules: {email: "required", password: "required",},
        messages: {email: "Enter a valid email address", password: "Enter your password",},
        errorPlacement: function(error, element) {
            if(element.attr('type') === 'radio' || element.attr('type') === 'checkbox') {
                error.appendTo(element.closest('.form-group'));
            } else if( element.is('select') && element.closest('.custom-select-1')) {
                error.appendTo(element.closest('.form-group'));
            } else {
                if( element.closest('.form-group').length ) {
                    error.appendTo(element.closest('.form-group'));
                } else {
                    error.insertAfter(element);
                }
            }
        },
        submitHandler: function (form) {
            var $form = $(form),
                $submitButton = $(this.submitButton),
                submitButtonText = $submitButton.val();

            $submitButton.val( $submitButton.data('loading-text') ? $submitButton.data('loading-text') : 'Please wait...' ).attr('disabled', true);
            $.ajax({
                url: "controllers/v7/member-login-api.php", type: "POST", data: $form.serialize(),
                success: function (data) {
                    if (data.status === 1) {
                        document.getElementById('login_form').reset();
                        window.location.replace('account/index')
                    } else { sendErrorResponse('Error', data.message);}
                },
                complete: function () { $submitButton.val( submitButtonText ).attr('disabled', false); }
            });
        }
    });

    $("form[name='forgot_password']").validate({
        rules: {email: "required"},
        messages: {email: "Enter a valid email address"},
        errorPlacement: function(error, element) {
            if(element.attr('type') === 'radio' || element.attr('type') === 'checkbox') {
                error.appendTo(element.closest('.form-group'));
            } else if( element.is('select') && element.closest('.custom-select-1')) {
                error.appendTo(element.closest('.form-group'));
            } else {
                if( element.closest('.form-group').length ) {
                    error.appendTo(element.closest('.form-group'));
                } else {
                    error.insertAfter(element);
                }
            }
        },
        submitHandler: function (form) {
            var $form = $(form),
                $submitButton = $(this.submitButton),
                submitButtonText = $submitButton.val();

            $submitButton.val( $submitButton.data('loading-text') ? $submitButton.data('loading-text') : 'Please wait...' ).attr('disabled', true);
            $.ajax({
                url: "controllers/v7/forgot-password-api.php", type: "POST", data: $form.serialize(),
                success: function (data) {
                    if (data.status === 1) {
                        document.getElementById('forgot_password').reset();
                        sendSuccessResponse("Successful",data.message);
                    } else { sendErrorResponse('Error', data.message);}
                },
                complete: function () { $submitButton.val( submitButtonText ).attr('disabled', false); }
            });
        }
    });

    $("form[name='reset_password']").validate({
        rules: {
            password: {required: true, minlength: 6},
            c_password: {equalTo: '[name="password"]'}
        },
        messages: {
            password: "Password must be min six characters",
            c_password:"Password not matched"
        },
        errorPlacement: function(error, element) {
            if(element.attr('type') === 'radio' || element.attr('type') === 'checkbox') {
                error.appendTo(element.closest('.form-group'));
            } else if( element.is('select') && element.closest('.custom-select-1')) {
                error.appendTo(element.closest('.form-group'));
            } else {
                if( element.closest('.form-group').length ) {
                    error.appendTo(element.closest('.form-group'));
                } else {
                    error.insertAfter(element);
                }
            }
        },
        submitHandler: function (form) {
            var $form = $(form),
                $submitButton = $(this.submitButton),
                submitButtonText = $submitButton.val();

            $submitButton.val( $submitButton.data('loading-text') ? $submitButton.data('loading-text') : 'Please wait...' ).attr('disabled', true);
            $.ajax({
                url: "controllers/v7/reset-password-api.php", type: "POST", data: $form.serialize(),
                success: function (data) {
                    if (data.status === 1) {
                        document.getElementById('reset_password').reset();
                        sendSuccessResponse("Successful",data.message);
                    } else { sendErrorResponse('Error', data.message);}
                },
                complete: function () { $submitButton.val( submitButtonText ).attr('disabled', false); }
            });
        }
    });

    $("form[name='update_profile']").validate({
        rules: {
            f_name:"required",
            m_name:"required",
            s_name:"required",
            email: {required: true, email: true},
            mobile: {required: true, digits: true}
        },
        messages: {
            f_name:"First Name is required",
            m_name: "Middle Name is required",
            s_name: "Surname is required",
            email: "Enter a valid email address",
            mobile:"Enter a valid mobile number"
        },
        errorPlacement: function(error, element) {
            if(element.attr('type') === 'radio' || element.attr('type') === 'checkbox') {
                error.appendTo(element.closest('.form-group'));
            } else if( element.is('select') && element.closest('.custom-select-1')) {
                error.appendTo(element.closest('.form-group'));
            } else {
                if( element.closest('.form-group').length ) {
                    error.appendTo(element.closest('.form-group'));
                } else {
                    error.insertAfter(element);
                }
            }
        },
        submitHandler: function (form) {
            var $form = $(form),
                $submitButton = $(this.submitButton),
                submitButtonText = $submitButton.val();

            $submitButton.val( $submitButton.data('loading-text') ? $submitButton.data('loading-text') : 'Please wait...' ).attr('disabled', true);
            $.ajax({
                url: "controllers/v7/update-profile-api.php", type: "POST", data: $form.serialize(),
                success: function (data) {
                    if (data.status === 1) {
                        sendSuccessResponse("Successfully Updated",data.message);
                    } else { sendErrorResponse('Error', data.message);}
                },
                complete: function () { $submitButton.val( submitButtonText ).attr('disabled', false); }
            });
        }
    });

    $("form[name='update_password']").validate({
        rules: {
            old_password:"required",
            password: {required: true, minlength: 6},
            c_password: {equalTo: '[name="password"]'}
        },
        messages: {
            old_password:"Current password is required",
            password: "Password must be min six characters",
            c_password:"Password not matched"
        },
        errorPlacement: function(error, element) {
            if(element.attr('type') === 'radio' || element.attr('type') === 'checkbox') {
                error.appendTo(element.closest('.form-group'));
            } else if( element.is('select') && element.closest('.custom-select-1')) {
                error.appendTo(element.closest('.form-group'));
            } else {
                if( element.closest('.form-group').length ) {
                    error.appendTo(element.closest('.form-group'));
                } else {
                    error.insertAfter(element);
                }
            }
        },
        submitHandler: function (form) {
            var $form = $(form),
                $submitButton = $(this.submitButton),
                submitButtonText = $submitButton.val();

            $submitButton.val( $submitButton.data('loading-text') ? $submitButton.data('loading-text') : 'Please wait...' ).attr('disabled', true);
            $.ajax({
                url: "controllers/v7/update-password-api.php", type: "POST", data: $form.serialize(),
                success: function (data) {
                    if (data.status === 1) {
                        document.getElementById('update_password').reset();
                        sendSuccessResponse2("Successfully Updated",data.message);
                    } else { sendErrorResponse2('Error', data.message);}
                },
                complete: function () { $submitButton.val( submitButtonText ).attr('disabled', false); }
            });
        }
    });

}).apply(this, [jQuery]);

function sendSuccessResponse(head,body) {
    $("#response-alert").html('' +
        '<div class="alert alert-success" role="alert">' +
        '  <button type="button" class="close" data-dismiss="alert" aria-label="Close">' +
        '    <span aria-hidden="true">&times;</span>' +
        '  </button>' +
        '  <div class="d-flex align-items-center justify-content-start">' +
        '    <i class="icon ion-ios-checkmark alert-icon tx-32 mg-t-5 mg-xs-t-0"></i>' +
        '    <span><strong>'+head+'!</strong> '+body+'</span>' +
        '  </div>' +
        '</div>'
    );
}
function sendErrorResponse(head,body) {
    $("#response-alert").html('' +
        '<div class="alert alert-danger" role="alert">' +
        '  <button type="button" class="close" data-dismiss="alert" aria-label="Close">' +
        '    <span aria-hidden="true">&times;</span>' +
        '  </button>' +
        '  <div class="d-flex align-items-center justify-content-start">' +
        '    <i class="icon ion-ios-close alert-icon tx-32 mg-t-5 mg-xs-t-0"></i>' +
        '    <span><strong>'+head+'!</strong> '+body+'</span>' +
        '  </div>' +
        '</div>'
    );
}

function sendSuccessResponse2(head,body) {
    $("#response-alert-2").html('' +
        '<div class="alert alert-success" role="alert">' +
        '  <button type="button" class="close" data-dismiss="alert" aria-label="Close">' +
        '    <span aria-hidden="true">&times;</span>' +
        '  </button>' +
        '  <div class="d-flex align-items-center justify-content-start">' +
        '    <i class="icon ion-ios-checkmark alert-icon tx-32 mg-t-5 mg-xs-t-0"></i>' +
        '    <span><strong>'+head+'!</strong> '+body+'</span>' +
        '  </div>' +
        '</div>'
    );
}
function sendErrorResponse2(head,body) {
    $("#response-alert-2").html('' +
        '<div class="alert alert-danger" role="alert">' +
        '  <button type="button" class="close" data-dismiss="alert" aria-label="Close">' +
        '    <span aria-hidden="true">&times;</span>' +
        '  </button>' +
        '  <div class="d-flex align-items-center justify-content-start">' +
        '    <i class="icon ion-ios-close alert-icon tx-32 mg-t-5 mg-xs-t-0"></i>' +
        '    <span><strong>'+head+'!</strong> '+body+'</span>' +
        '  </div>' +
        '</div>'
    );
}