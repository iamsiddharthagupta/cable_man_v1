// User search function
$(document).ready(function(){
  $("#myInput").on("keyup", function() {
    var value = $(this).val().toLowerCase();
    $("#myTable tr").filter(function() {
      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
    });
  });
});

// User Searchbar
$(function() {
 $( "#user_search" ).autocomplete({
   source: 'user_search.php',
 });
});


// Datepicker Current Date

$(document).ready(function () {
    var date = new Date();
    $(".curr_date").datepicker({
        dateFormat: 'yy-mm-dd'
    }).datepicker('setDate', date)
});