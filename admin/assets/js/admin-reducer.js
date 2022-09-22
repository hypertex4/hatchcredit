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

    $("form[name='adm_login_form']").validate({
        rules: {username: "required", password: "required",},
        messages: {username: "Enter your username", password: "Enter your password",},
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
                url: "../controllers/v7/admin-login-api.php", type: "POST", data: $form.serialize(),
                success: function (data) {
                    if (data.status === 1) {
                        document.getElementById('adm_login_form').reset();
                        window.location.replace('dashboard')
                    } else { sendErrorResponse('Error', data.message);}
                },
                complete: function () { $submitButton.val( submitButtonText ).attr('disabled', false); }
            });
        }
    });

    $(document).on("click", "#updateStatus", function (e) {
        e.preventDefault();
        var l_id = $(this).data("l_id");
        var status = $(this).data("status");

        $.confirm({
            title: 'Warning!',
            type: 'blue',
            typeAnimated: true,
            content: 'Are you sure you want to '+status+' loan application? <br> NB: this action cannot be undone and will be tagged '+status,
            buttons: {
                confirm: function () {
                    $.ajax({
                        url: "../controllers/v7/admin-action.php", type: "POST",
                        data: JSON.stringify({l_id:l_id,status:status,action_code:101}),
                        success: function (data) {
                            if (data.status ===1){
                                toastr["success"](data.message);
                                setTimeout(function () {window.location.reload(); }, 500);
                            } else {
                                toastr["error"](data.message);
                                setTimeout(function () {window.location.reload(); }, 500);
                            }
                        },
                        error: function (errData)  {toastr["error"](data.message); }
                    });
                },
                cancel: function () {},
            }
        });
    });

    $(document).on("click", "#deleteFile", function (e) {
        e.preventDefault();
        var field = $(this).data("field");
        var file = $(this).data("file");
        var ln_id = $(this).data("ln_id");
        var type = $(this).data("type");

        $.confirm({
            title: 'Warning!',
            type: 'orange',
            typeAnimated: true,
            content: 'Are you sure you want to delete '+field+' ?',
            buttons: {
                confirm: function () {
                    $.ajax({
                        url: "../controllers/v7/admin-action.php", type: "POST",
                        data: JSON.stringify({field, file, ln_id, type, action_code: 102}),
                        success: function (data) {
                            if (data.status ===1){
                                toastr["success"](data.message);
                                setTimeout(function () {window.location.reload();}, 500);
                            } else {
                                toastr["error"](data.message);
                            }
                        },
                        error: function (errData) {toastr["error"](data.message);}
                    });
                },
                cancel: function () {},
            }
        });
    });

    $(document).on("click", "#updateActive", function (e) {
        e.preventDefault();
        var u_sno = $(this).data("u_sno");
        var active = $(this).data("active");

        $.confirm({
            title: 'Warning!',
            type: 'blue',
            typeAnimated: true,
            content: 'Are you sure you want to update user status ?',
            buttons: {
                confirm: function () {
                    $.ajax({
                        url: "../controllers/v7/admin-action.php", type: "POST",
                        data: JSON.stringify({u_sno,active,action_code:103}),
                        success: function (data) {
                            if (data.status ===1){
                                toastr["success"](data.message);
                                setTimeout(function () {window.location.reload(); }, 500);
                            } else {
                                toastr["error"](data.message);
                                setTimeout(function () {window.location.reload(); }, 500);
                            }
                        },
                        error: function (errData)  {toastr["error"](data.message); }
                    });
                },
                cancel: function () {},
            }
        });
    });

    $("form[name='template_form']").validate({
        rules: {
            f_name: "required",
            m_name: "required",
            s_name: "required",
        },
        messages: {
            f_name: "Enter client first name",
            m_name: "Enter client middle name",
            s_name: "Enter client surname",
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
                url: "../controllers/v7/admin-action.php", type: "POST", data: $form.serialize(),
                success: function (data) {
                    if (data.status === 1) {
                        document.getElementById('template_form').reset();

                    } else { sendErrorResponse('Error', data.message);}
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