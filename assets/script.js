// JQuery script for user search function (Both)
$(document).ready(function(){
  $("#myInput").on("keyup", function() {
    var value = $(this).val().toLowerCase();
    $("#myTable tr").filter(function() {
      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
    });
  });
});

// Script for User Search. (Cable ERP)
$(function() {
 $( "#user_search" ).autocomplete({
   source: 'user_search.php',
 });
});