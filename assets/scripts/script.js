  // Example starter JavaScript for disabling form submissions if there are invalid fields
  (function() {
    'use strict';
    window.addEventListener('load', function() {
      // Fetch all the forms we want to apply custom Bootstrap validation styles to
      var forms = document.getElementsByClassName('needs-validation');
      // Loop over them and prevent submission
      var validation = Array.prototype.filter.call(forms, function(form) {
        form.addEventListener('submit', function(event) {
          if (form.checkValidity() === false) {
            event.preventDefault();
            event.stopPropagation();
          }
          form.classList.add('was-validated');
        }, false);
      });
    }, false);
  })();

  // Device checker script.
  function checkAvailability() {
    $("#loaderIcon").show();
    jQuery.ajax({
    url: "user_profile_device_checker.php",
    data:'device_no='+$("#device_no").val(),
    type: "POST",
    success:function(data){
      $("#user-availability-status").html(data);
      $("#loaderIcon").hide();
    },
    error:function (){}
    });
  }

  // User search function.
  $(document).ready(function(){
    $("#myInput").on("keyup", function() {
      var value = $(this).val().toLowerCase();
      $("#myTable tr").filter(function() {
        $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
      });
    });
  });

  // Input Mask for Phone Numbers and various.
  $(document).ready(function($){
    $('#phone').mask("9999999999", {placeholder:"XXXXXXXXXX"});
  });

  // Back Button.
    function goBack() {
    window.history.back();
  }

  // Print Page.
    function printPage() {
      window.print();
  }