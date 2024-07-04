var nilesh = {

    validateEmail : function (data) {
            var pattern = new RegExp(/^((([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+(\.([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+)*)|((\x22)((((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(([\x01-\x08\x0b\x0c\x0e-\x1f\x7f]|\x21|[\x23-\x5b]|[\x5d-\x7e]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(\\([\x01-\x09\x0b\x0c\x0d-\x7f]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))))*(((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(\x22)))@((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?$/i);
            return pattern.test(data);
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