  // User search function
  $(document).ready(function(){
    $("#myInput").on("keyup", function() {
      var value = $(this).val().toLowerCase();
      $("#myTable tr").filter(function() {
        $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
      });
    });
  });

  // Default Date (Datepicker)
  $(function() {
      $( "#date" ).datepicker({
          dateFormat: 'yy-mm-dd'
      });
  });

  // Current Date (Datepicker)
  $(document).ready(function () {
      var date = new Date();
      $("#today").datepicker({
          dateFormat: 'yy-mm-dd'
      }).datepicker('setDate', date)
  });

  // Input Mask for Phone Numbers and various.
  $(document).ready(function($){
    $('#phone').mask("9999999999", {placeholder:"XXXXXXXXXX"});
  });

  // Back Button.
    function goBack() {
    window.history.back();
  }

  // Print Page Trigger.
    function printPage() {
      window.print();
  }