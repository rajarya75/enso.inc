if ($.isFunction($.validator)) {

    $.validator.addMethod('mobile', function (value, element, param) {
        if (value) {
            var pattern = /^[0-9]{10}$/;
            return pattern.test(value);
        } else {
            return true;
        }
    }, 'Please enter a valid mobile number.');


    $.validator.addMethod('validateEmail', function (value, element, param) {
        var pattern = new RegExp(/^((([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+(\.([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+)*)|((\x22)((((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(([\x01-\x08\x0b\x0c\x0e-\x1f\x7f]|\x21|[\x23-\x5b]|[\x5d-\x7e]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(\\([\x01-\x09\x0b\x0c\x0d-\x7f]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))))*(((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(\x22)))@((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?$/i);

        return this.optional(element) || pattern.test(value);
    }, ' Please enter a valid email address.');

    $.validator.addMethod("alphanumeric", function (value, element) {
        // return this.optional(element) || /^[\w.]+$/i.test(value);
        return this.optional(element) || /^[a-z0-9]+$/i.test(value);
    }, "Code must contain only letters and numbers");


    $.validator.addMethod("alphachar", function (value, element) {
        $regex = /^[a-z0-9,.?&\-\s\']+$/i;
        return this.optional(element) || $regex.test(value);
    }, "Text must contain only alphanumberic and <i> . , ? & - '</i> chars.");

    $.validator.addMethod("lettersonly", function (value, element) {
        return this.optional(element) || /^[a-z]+$/i.test(value);
    }, "Only letters are allowed");

    $.validator.addMethod("strongPass", function (value, element) {
        return this.optional(element) || nilesh.strongPass(value);
    }, "Password must be more than 8 digit and must contain atleast one lower & upper case letter, one digit and a special character");

    //custom validation
    // 25 MB = 25485760  1MB = 1024 bytes
    // Custom method for validate plugin
    $.validator.addMethod('filesize', function (value, element, param) {
        if (element.files[0] !== undefined) {
            console.log(element.files[0].size);
            const fsize = element.files[0].size;
            const fileSize = Math.round((fsize / 1024));
            const sizeMB = param * 1024;
            return this.optional(element) || (fileSize <= sizeMB)
        } else {
            return true;
        }

    }, 'File size must be less than {0} MB');

    $.validator.addMethod('pan_card', function (value, element, param) {
        if (value) {
            var pattern = /^[A-Za-z]{5}[0-9]{4}[A-Za-z]{1}$/;
            return pattern.test(value);
        } else {
            return true;
        }
    });

    $.validator.addMethod('aadhaar_card', function (value, element, param) {
        if (value) {
            var pattern = /^(\d{12}|\d{16})$/;
            return pattern.test(value);
        } else {
            return true;
        }
    }, 'Please enter valid aadhar number.');

}


function validateMobile(num) {
    var pattern = /^[0-9]{10}$/;
    return pattern.test(num);
}

function IsEmail(email) {
    var regex = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
    if (!regex.test(email)) {
        return false;
    } else {
        return true;
    }
}


$(document).ready(function () {

    // var brochure_captcha =  grecaptcha.render('brochure_captcha', {'sitekey' : '6Lc6QMofAAAAAKvz04rTE0eb_hdQ3kndtetgHqYM'});
    // var enquire_captcha =  grecaptcha.render('enquire_captcha', {'sitekey' : '6Lc6QMofAAAAAKvz04rTE0eb_hdQ3kndtetgHqYM'});

    $(".form_spinner").hide();
    // claim_your_warranty form
    $('#claim_your_warranty').validate({
        ignore: [],
        rules: {
            name: { required: true },
            email: { required: true, email: true },
            mobile: { required: true, mobile: true, minlength: 10 },
            system_size: { required: true },
            invoice_copy: { required: true, extension: "jpg|jpeg|pdf" },
            warranty_card_no: { required: true },
        },
        messages: {
        },
        errorElement: 'span',
        errorPlacement: function (error, element) {
            error.addClass('invalid-feedback');
            element.closest('.form-group').append(error);
        },
        highlight: function (element, errorClass, validClass) {
            $(element).addClass('is-invalid');
        },
        unhighlight: function (element, errorClass, validClass) {
            $(element).removeClass('is-invalid');
        },

        submitHandler: function (form) {
            var formData = new FormData(form);

            var token = grecaptcha.getResponse(1);
            if(token  == ""){
                $('.response_msg').css({"color":"#DC3545"}).html('Please validate captcha');
                return false;
            }
            // console.log(token); return false;

            formData.append('token', token);
            formData.append('resume', $('input[type=file]')[0].files[0]);

            $button = $(form).find('.btn_send');
            $button.attr('disabled', 'disabled');
            $(".form_spinner").show();
            $button.text('processing..');

            $.ajax({
                type: 'POST',
                url: "api/claimYourWarrantyApi.php",
                data: formData,
                processData: false,
                contentType: false,
                dataType: "json",
                beforeSend: function () {
                    $('.response_msg').text('');
                },
                success: function (response) {
                    $button.text('Send');
                    $button.removeAttr('disabled');

                    console.log(response);
                    // return false;
                    if (response.status == 1) {
                        $("#claim_your_warranty")[0].reset();
                        grecaptcha.reset(1);

                        $button.text('Send');
                        $button.removeAttr('disabled');

                        $('.response_msg').css({ "color": "#28A745" }).text(response.message);
                        $(".form_spinner").hide();
                        window.location=window.location.origin+'/thank-you.php';
                        setTimeout(() => {
                            $('.response_msg').text('');
                        }, 8000);
                    } else {
                        $button.text('Send');
                        $button.removeAttr('disabled');

                        $('.response_msg').css({ "color": "#DC3545" }).text(response.message);
                    }

                },
                error: function (error, textStatus, errorMessage) {
                    console.log(error);
                    console.log(textStatus);
                    console.log(errorMessage);
                    $button.text('Submit');
                    $button.removeAttr('disabled');
                    $(".form_spinner").hide();
                    alert('Some error occured.');
                    grecaptcha.reset(1);
                }
            }); //end ajax
        }
    });

    // register_your_product form
    $('#register_your_product').validate({
        ignore: [],
        rules: {
            name: { required: true },
            email: { required: true, email: true },
            mobile: { required: true, mobile: true, minlength: 10 },
            system_size: { required: true },
            invoice_no: { required: true },
            date_of_invoice: { required: true },
            invoice_copy: { required: true, extension: "jpg|jpeg|pdf" },
            channel_partner_name: { required: true },
        },
        messages: {
        },
        errorElement: 'span',
        errorPlacement: function (error, element) {
            error.addClass('invalid-feedback');
            element.closest('.form-group').append(error);
        },
        highlight: function (element, errorClass, validClass) {
            $(element).addClass('is-invalid');
        },
        unhighlight: function (element, errorClass, validClass) {
            $(element).removeClass('is-invalid');
        },

        submitHandler: function (form) {
            var formData = new FormData(form);

            var token = grecaptcha.getResponse(0);
            if(token  == ""){
                $('.response_msg').css({"color":"#DC3545"}).html('Please validate captcha');
                return false;
            }
            // console.log(token); return false;

            formData.append('token', token);
            formData.append('resume', $('input[type=file]')[0].files[0]);

            $button = $(form).find('.btn_send');
            $button.attr('disabled', 'disabled');
            $(".form_spinner").show();
            $button.text('processing..');

            $.ajax({
                type: 'POST',
                url: "api/registerYourProductApi.php",
                data: formData,
                processData: false,
                contentType: false,
                dataType: "json",
                beforeSend: function () {
                    $('.response_msg').text('');
                },
                success: function (response) {
                    $button.text('Send');
                    $button.removeAttr('disabled');

                    console.log(response);
                    // return false;
                    if (response.status == 1) {
                        $("#register_your_product")[0].reset();
                        grecaptcha.reset(0);

                        $button.text('Send');
                        $button.removeAttr('disabled');

                        $('.response_msg').css({ "color": "#28A745" }).text(response.message);
                        $(".form_spinner").hide();
                        window.location=window.location.origin+'/thank-you.php';
                        setTimeout(() => {
                            $('.response_msg').text('');
                        }, 8000);
                    } else {
                        $button.text('Send');
                        $button.removeAttr('disabled');

                        $('.response_msg').css({ "color": "#DC3545" }).text(response.message);
                    }

                },
                error: function (error, textStatus, errorMessage) {
                    console.log(error);
                    console.log(textStatus);
                    console.log(errorMessage);
                    $button.text('Submit');
                    $button.removeAttr('disabled');
                    $(".form_spinner").hide();
                    alert('Some error occured.');
                    grecaptcha.reset(0);
                }
            }); //end ajax
        }
    });


});
