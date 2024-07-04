<form class="enquire_form09" action="api/enquiryApi.php" id="contact_us">
  <div class="future-dubai-heading" data-aos="fade-up">
    <div class="heading-sub">
      <h2>Enquire Now</h2>
    </div>
  </div>
  <div class="form-group getintouch_hf">
    <input id="fullname" name="name" type="text" placeholder="Full Name" class="form-control">
  </div>
  <br>
  <div class="form-group getintouch_hf mobile">
    <input id="phone" name="mobile" type="text" placeholder="Phone No" class="form-control">
    <input id="dialCode" name="code" type="hidden">
  </div>
  <!-- <div class="form-group getintouch_hf">
    <input name="phone" type="text" id="phonez" class="form-control" placeholder="Phone No."/> 
  </div> --><br>
  <div class="form-group getintouch_hf">
    <input id="email" name="email" type="text" placeholder="Email" class="form-control">
  </div><br>
  <div class="form-group getintouch_hf">
    <select name="toe" id="toe" class="form-control ">
        <option selected="" disabled="">Type of Enquiry</option>
        <option value="sales">Sales</option>
        <option value="Customer care">Customer care</option>
        <option value="Press and media">Press and media</option>
        <option value="Investor relations">Investor relations</option>
        <option value="Agent relations">Agent relations</option>
    </select>
  </div>
  <div class="form-group getintouch_hf">
    <textarea id="message" placeholder="Message" name="message" class="form-control"></textarea>
  </div>
  <div class="getintouch" style="text-align: -webkit-center;">
     <div class="g-recaptcha brochure__form__captcha" id="captcha_token" name="captcha_token" data-sitekey="6LdKt3opAAAAADl_aZJ8nTWjg8KyzrCxEk2M3pHF"></div>
 </div>
  <div class="submit-btn">
    <button type="submit" class="btn09 sbtn" id="contact_us-submit">Submit</button>
  </div>
</form>
<script src="https://www.google.com/recaptcha/api.js" async defer></script>
<link rel="stylesheet" href="https://cdn.tutorialjinni.com/intl-tel-input/17.0.19/css/intlTelInput.css"/>
<script src="https://cdn.tutorialjinni.com/intl-tel-input/17.0.19/js/intlTelInput.min.js"></script>
<script type="text/javascript">
document.addEventListener("DOMContentLoaded", function() {
    var input = document.querySelector("#phone");
    var iti = window.intlTelInput(input, {
        separateDialCode: true,
        initialCountry: "ae" // ae is the country code for United Arab Emirates
    });
    // Function to update hidden input value with selected dial code
    function updateDialCode() {
        var countryCode = iti.getSelectedCountryData().dialCode;
        document.getElementById('dialCode').value = countryCode;
    }
    
    // Call the function on page load
    updateDialCode();
    
    // Add event listener to update hidden input value when selected dial code changes
    input.addEventListener('countrychange', function(e) {
        updateDialCode();
    });
});
// Add the name attribute to the selected dial code element
</script>