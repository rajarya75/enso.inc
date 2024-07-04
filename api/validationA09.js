var nilesh = {

    validateEmail : function (data) {

            var pattern = new RegExp(/^((([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+(\.([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+)*)|((\x22)((((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(([\x01-\x08\x0b\x0c\x0e-\x1f\x7f]|\x21|[\x23-\x5b]|[\x5d-\x7e]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(\\([\x01-\x09\x0b\x0c\x0d-\x7f]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))))*(((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(\x22)))@((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?$/i);

            return pattern.test(data);

       },

     validateMobile : function (data) {
            var pattern = /^[0-9]{10}$/;

            return pattern.test(data);
        },
    validateZip : function (data) {
            var pattern = /^[0-9]{6}$/;
            return pattern.test(data);
        },

    isNumber : function (data) {
           var pattern = /^\d+$/;
           return pattern.test(data);
     },
    alpha : function (data) {
           var pattern = /^[a-z\s]+$/i;
           return pattern.test(data);
    },
    alphanumeric : function (data) {
           var pattern = /^[a-z0-9]+$/i;
           return pattern.test(data);
    },
    alphanumeric_space : function (data) {
           var pattern = /^[a-z0-9\s]+$/i;
           return pattern.test(data);
    },
    alphachar : function (data) {
           var pattern = /^[a-z0-9,.?&\-\s\']+$/i;
           return pattern.test(data);
           //Text must contain only alphanumberic and <i> . , ? & - '</i> chars.
     },

};

function showLoader(){
	$('.form_loader').show();
}
function hideLoader(){
	$('.form_loader').hide();
}

hideLoader();

$('#enquiry_form').submit(function(e) { 

     // this code prevents form from actually being submitted
     e.preventDefault();
     e.returnValue = false;

     var mndFileds = new Array('Last Name','Email','Mobile');
		var fldLangVal = new Array('Name','Email','Mobile');
		for(i=0;i<mndFileds.length;i++) {
		  var fieldObj=document.forms['WebToLeads198780000000268016'][mndFileds[i]];
		  if(fieldObj) {
			if (((fieldObj.value).replace(/^\s+|\s+$/g, '')).length==0) {
			 if(fieldObj.type =='file')
				{ 
				 alert('Please select a file to upload.'); 
				 fieldObj.focus(); 
				 return false;
				} 
			alert(fldLangVal[i] +' cannot be empty.'); 
   	   	  	  fieldObj.focus();
   	   	  	  return false;
			}  else if(fieldObj.nodeName=='SELECT') {
  	   	   	 if(fieldObj.options[fieldObj.selectedIndex].value=='-None-') {
				alert(fldLangVal[i] +' cannot be none.'); 
				fieldObj.focus();
				return false;
			   }
			} else if(fieldObj.type =='checkbox'){
 	 	 	 if(fieldObj.checked == false){
				alert('Please accept  '+fldLangVal[i]);
				fieldObj.focus();
				return false;
			   } 
			 } 
			 try {
			     if(fieldObj.name == 'Last Name') {
				name = fieldObj.value;
 	 	 	    }
			} catch (e) {}
		    }
		}
		if(!validateEmail198780000000268016()){return false;}

		//new validatation
		$parent = $('#enquiry_form');
		$Last_Name = $parent.find('#Last_Name').val();
		if(!nilesh.alpha($Last_Name)){
			alert('Name must contain only alphabets');
			return false;
		}

		$mobile = $parent.find('#Mobile').val();
		if(!nilesh.validateMobile($mobile)){
			alert('Invalid mobile number');
			return false;
		}

		$city = $.trim($parent.find('#City').val());
		if($city && !nilesh.alpha($city)){
			alert('City must contain only alphabets');
			return false;
		}

		$Zip_Code = $.trim($parent.find('#Zip_Code').val());
		if($Zip_Code && !nilesh.validateZip($Zip_Code)){
			alert('Invalid pin code');
			return false;
		}

		$capacity = $.trim($parent.find('#LEADCF2').val());
		if($capacity && !nilesh.alphanumeric_space($capacity)){
			alert('Capacity must contain only alphanumeric characters');
			return false;
		}

		$area = $.trim($parent.find('#LEADCF17').val());
		if($area && !nilesh.isNumber($area)){
			alert('Area in Sq.Ft must contain only numbers');
			return false;
		}

		$bill = $.trim($parent.find('#LEADCF18').val());
		if($bill && !nilesh.isNumber($bill)){
			alert('Monthly Bill must contain only numbers');
			return false;
		}

		$Description = $.trim($parent.find('#Description').val());
		if($Description && !nilesh.alphachar($Description)){
			alert("Description must contain only alphanumberic and (. , ? & - ') special chars.");
			return false;
		}


		$('#enquiry_form .reset_button').hide();
		showLoader();
		document.querySelector('#enquiry_form .formsubmit').setAttribute('disabled', true);

        var $form = $(this);
        var data = $form.serializeArray();

         $.ajax({ 
             type: 'post',
             url: 'api/enquiryApi.php', 
             data: data,
             dataType: "json",
             success: function(response) { // your success handler
             	console.log(response); 
             	if(response.status == 1){
             		// make sure that you are no longer handling the submit event; clear handler
                	$form.off('submit');

             		// actually submit the form
                	$form.submit();
             	}else{
             		document.querySelector('#enquiry_form .formsubmit').removeAttribute('disabled');
             		$('#enquiry_form .reset_button').show();
             		hideLoader();
             		alert(response.message);
             	}              
             },
             error: function() { // your error handler
             },
             complete: function(response) {
             	
             }
       });
     
}); //end enquiry form



$('#partner_form').submit(function(e) { 

    e.preventDefault();
    e.returnValue = false;

    	var mndFileds = new Array('Last Name','Email','Mobile','LEADCF11');
		var fldLangVal = new Array('Name','Email','Mobile','Location\x20City');
		for(i=0;i<mndFileds.length;i++) {
		  var fieldObj=document.forms['WebToLeads198780000000268001'][mndFileds[i]];
		  if(fieldObj) {
			if (((fieldObj.value).replace(/^\s+|\s+$/g, '')).length==0) {
			 if(fieldObj.type =='file')
				{ 
				 alert('Please select a file to upload.'); 
				 fieldObj.focus(); 
				 return false;
				} 
			alert(fldLangVal[i] +' cannot be empty.'); 
   	   	  	  fieldObj.focus();
   	   	  	  return false;
			}  else if(fieldObj.nodeName=='SELECT') {
  	   	   	 if(fieldObj.options[fieldObj.selectedIndex].value=='-None-') {
				alert(fldLangVal[i] +' cannot be none.'); 
				fieldObj.focus();
				return false;
			   }
			} else if(fieldObj.type =='checkbox'){
 	 	 	 if(fieldObj.checked == false){
				alert('Please accept  '+fldLangVal[i]);
				fieldObj.focus();
				return false;
			   } 
			 } 
			 try {
			     if(fieldObj.name == 'Last Name') {
				name = fieldObj.value;
 	 	 	    }
			} catch (e) {}
		    }
		}
		if(!validateEmail198780000000268001()){return false;}

		//new validatation
		$parent = $('#partner_form');
		$Last_Name = $parent.find('#Last_Name').val();
		if(!nilesh.alpha($Last_Name)){
			alert('Name must contain only alphabets');
			return false;
		}
		$Company = $.trim($parent.find('#Company').val());

		if($Company && !nilesh.alphanumeric_space($Company)){
			alert('Company must contain only alphanumeric characters');
			return false;
		}

		$mobile = $parent.find('#Mobile').val();
		if(!nilesh.validateMobile($mobile)){
			alert('Invalid mobile number');
			return false;
		}

		$city = $parent.find('#LEADCF11').val();
		if(!nilesh.alpha($city)){
			alert('City must contain only alphabets');
			return false;
		}

		$exp = $.trim($parent.find('#LEADCF15').val());
		if($exp && !nilesh.alphanumeric_space($exp)){
			alert('Overall solar experience must contain only alphanumeric characters');
			return false;
		}
		

		$('#partner_form .reset_button').hide();
		document.querySelector('#partner_form .formsubmit').setAttribute('disabled', true);

		showLoader();

        var $form = $(this);
        var data = $form.serializeArray();


         $.ajax({ 
             type: 'post',
             url: 'api/partnerApi.php', 
             data: data,
             dataType: "json",
             success: function(response) { // your success handler
             	console.log(response); 
             	if(response.status == 1){
                	$form.off('submit');
                	$form.submit();
             	}else{
             		document.querySelector('#partner_form .formsubmit').removeAttribute('disabled');
             		$('#partner_form .reset_button').show();
             		hideLoader();
             		alert(response.message);
             	}              
             },
             error: function() { // your error handler
             },
             complete: function(response) {
             	
             }
       });
     
}); //end partner form



$('#newsletter_form').submit(function(e) { 

	e.preventDefault();
	e.returnValue = false;
	
	$('.news_result').empty();


    var $form = $(this);

    $email = $.trim($('#newsletter_form input[name=email]').val());
    if($email == ''){
    	alert('Email is required'); return false;
    }
    else if(!nilesh.validateEmail($email)){
        alert('Invalid Email'); return false;
    }


    var data = $form.serializeArray();

    document.querySelector('#newsletter_form .submit-btn').setAttribute('disabled', true);
    showLoader();

     $.ajax({ 
         type: 'post',
         url: $form.attr('action'), 
         data: data,
         dataType: "json",
         success: function(response) { // your success handler
         	console.log(response); 
         	if(response.status == 1){
      			$('.news_result').html('<span class="success">Subscribed Successfully.</span>');
      			$('#newsletter_form input[name=email]').val('');
         	}else{
         		$('.news_result').html('<span class="error">'+response.message+'</span>');
         	}
         	document.querySelector('#newsletter_form .submit-btn').removeAttribute('disabled');
         	hideLoader();             
         },
         error: function() { // your error handler
         },
         complete: function(response) {
         }
   });
     
});

$(document).ready(function () {

    // customer enquiry form here
    $('#customer_enq_form').validate({
        ignore: [],
        // debug: true,
        rules: {
            last_name: {required: true },
            email: {required: true, email: true },
            mobile: {required: true, minlength: 10 },
            city: {required: true },
            state: {required: true },
            zip_code: {required: true },
            customer_type: {required: true },
            size: {required: true },
            area_in_sq_ft: {required: true },
            lead_source: {required: true },
            avg_monthly_bill: {required: true },
            description: {required: true },
        },
        // messages: {
        //     // txtTokenId: "Please generate the token before creating the sales lead.",
        // },
        errorElement: 'span',
        errorPlacement: function (error, element) {
            error.addClass('invalid-feedback');
            element.closest('.inp_group').append(error);
        },
        highlight: function (element, errorClass, validClass) {
            $(element).addClass('is-invalid');
        },
        unhighlight: function (element, errorClass, validClass) {
            $(element).removeClass('is-invalid');
        },

        submitHandler: function (form) {
            var formData = new FormData(form);

            // var token = grecaptcha.getResponse();
            var token = grecaptcha.getResponse($('#customer_captcha').attr('data-widget-id'));
            if(token  == ""){
                alert('Please validate captcha');
                return false;
            }
            formData.append('token', token);

            $button = $(form).find('.formsubmit_front');
            // var form_id = $(form).attr('id');
            // console.log("# "+form_id);
            $button.attr('disabled', 'disabled');
            $button.val('processing..');
            
            $.ajax({
                type: 'POST',
                url: $(form).attr('action'),
                data: formData,
                processData: false,
                contentType: false,
                // dataType: "json",
                success: function (response) {
                    // console.log(response);
                    let resp = JSON.parse(response);
                    // console.log(resp);
                    $button.removeAttr('disabled');
                    $button.val('SUBMIT');
                    // return false;

                    if (resp.status == 1) {
                        // console.log("if");
                        $(form).find('.inp_group input').val('');
                        $(".first-form").html(resp.data);
                        $("#crm_form").submit();
                        // $('.form_response').removeClass('text-danger');
                        $('.form_response').css({"color" : "#04AA6D"}).text( resp.message );
                    } else {
                        // console.log("else");
                        // $('.form_response').removeClass('text-success');
                        $('.form_response').css({"color" : "#DC3545"}).text( resp.message );
                    }

                },
                error: function (error, textStatus, errorMessage) {
                    $button.removeAttr('disabled');
                    $button.val('SUBMIT');
                    console.log(textStatus);
                    console.log(" " + errorMessage);
                    alert('Some error occured.');
                }
            }); //end ajax         
        }

    });

    // partner with us enquiry form here
    $('#partner_with_us_form').validate({
        ignore: [],
        // debug: true,
        rules: {
            name: {required: true },
            company: {required: true },
            email: {required: true, email: true },
            mobile: {required: true, minlength: 10 },
            city: {required: true },
            segment_preference: {required: true },
            area_of_interest: {required: true },
            solar_experience: {required: true },
        },
        // messages: {
        //     // txtTokenId: "Please generate the token before creating the sales lead.",
        // },
        errorElement: 'span',
        errorPlacement: function (error, element) {
            error.addClass('invalid-feedback');
            element.closest('.inp_group').append(error);
        },
        highlight: function (element, errorClass, validClass) {
            $(element).addClass('is-invalid');
        },
        unhighlight: function (element, errorClass, validClass) {
            $(element).removeClass('is-invalid');
        },

        submitHandler: function (form) {
            var formData = new FormData(form);

            // var token = grecaptcha.getResponse();
            // console.log($('#partner_captcha').attr('data-widget-id'));
            // return false; 
            var token = grecaptcha.getResponse($('#partner_captcha').attr('data-widget-id'));
            if(token  == ""){
                // alert('Please validate captcha');
                // return false;
            }
            formData.append('token', token);

            $button = $(form).find('.formsubmit_front');
            // var form_id = $(form).attr('id');
            // console.log("# "+form_id);
            $button.attr('disabled', 'disabled');
            $button.val('processing..');
            
            $.ajax({
                type: 'POST',
                url: $(form).attr('action'),
                data: formData,
                processData: false,
                contentType: false,
                // dataType: "json",
                success: function (response) {
                    // console.log(response);
                    let resp = JSON.parse(response);
                    // console.log(resp);
                    $button.removeAttr('disabled');
                    $button.val('SUBMIT');
                    // return false;

                    if (resp.status == 1) {
                        $(form).find('.inp_group input').val('');
                        $(".second-form").html(resp.data);
                        $("#partners_form").submit();
                        $('.form_response').css({"color" : "#04AA6D"}).text( resp.message );
                    } else {
                        $('.form_response').css({"color" : "#DC3545"}).text( resp.message );
                    }

                },
                error: function (error, textStatus, errorMessage) {
                    $button.removeAttr('disabled');
                    $button.val('SUBMIT');
                    console.log(textStatus);
                    console.log(" " + errorMessage);
                    alert('Some error occured.');
                }
            }); //end ajax         
        }

    });

    /*$mobile = $parent.find('#contact_no').val();
    if(!nilesh.validateMobile($mobile)){
        $("#contact_no-error").html('Invalid mobile number');
        return false;
    }*/

    $('#frm_download_brochure').submit(function(e) {
        $mobile = $('#contact_no').val();
        if(!nilesh.validateMobile($mobile) && $mobile!=''){
            /*if($("#contact_no-error").length==0){
                $("#contact_no").after('<span id="contact_no-error" class="error invalid-feedback">Invalid mobile number</span>');
            }
            $("#contact_no-error").html('Invalid mobile number');*/
            alert('Invalid mobile number');
            return false;
        }
    });
    //download brochure
    $('#frm_download_brochure').validate({
        ignore: [],
        // debug: true,
        rules: {
            full_name: {required: true },
            contact_no: {required: true, minlength: 10 },
            email: {required: true, email: true },
        },
        // messages: {
        //     // txtTokenId: "Please generate the token before creating the sales lead.",
        // },
        errorElement: 'span',
        errorPlacement: function (error, element) {
            error.addClass('invalid-feedback');
            element.closest('.inp_group').append(error);
        },
        highlight: function (element, errorClass, validClass) {
            $(element).addClass('is-invalid');
        },
        unhighlight: function (element, errorClass, validClass) {
            $(element).removeClass('is-invalid');
        },

        submitHandler: function (form) {
            var formData = new FormData(form);

            // var token = grecaptcha.getResponse();
            // console.log($('#partner_captcha').attr('data-widget-id'));
            // return false;
            var token = grecaptcha.getResponse($('#brochure_captcha').attr('data-widget-id'));
            if(token  == ""){
                 // alert('Please validate captcha');
                 // return false;
            }
            formData.append('token', token);

            $button = $(form).find('.submit_btn_cont');
            // var form_id = $(form).attr('id');
            // console.log("# "+form_id);
            $button.attr('disabled', 'disabled');
            $button.html('processing..');

            $.ajax({
                type: 'POST',
                url: $(form).attr('action'),
                data: formData,
                processData: false,
                contentType: false,
                // dataType: "json",
                success: function (response) {
                    // console.log(response);
                    let resp = JSON.parse(response);
                    // console.log(resp);
                    $button.removeAttr('disabled');
                    $button.html('SUBMIT');
                    // return false;

                    if (resp.status == 1) {
                        $('.brochure_form_response').css({"color" : "#04AA6D"}).text( resp.message );
                        $("#lnk_download_brochure")[0].click();
                        $(".fancybox-close").trigger('click');
                    } else {
                        $('.brochure_form_response').css({"color" : "#DC3545"}).text( resp.message );
                    }

                },
                error: function (error, textStatus, errorMessage) {
                    $button.removeAttr('disabled');
                    $button.val('SUBMIT');
                    console.log(textStatus);
                    console.log(" " + errorMessage);
                    alert('Some error occured.');
                }
            }); //end ajax
        }

    });

});