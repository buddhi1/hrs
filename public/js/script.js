$(function() {
  $( "#from" ).datepicker({
    defaultDate: "",
    changeMonth: true,
    numberOfMonths: 2,
    onClose: function( selectedDate ) {
      $( "#from" ).datepicker( "option", "dateFormat", "yy-mm-dd" );
      $( "#to" ).datepicker( "option", "minDate", selectedDate);
    }
  });
  $( "#to" ).datepicker({
    defaultDate: "",
    changeMonth: true,
    numberOfMonths: 2,
    onClose: function( selectedDate ) {
      $( "#to" ).datepicker( "option", "dateFormat", "yy-mm-dd" );
      $( "#from" ).datepicker( "option", "maxDate", selectedDate );
    }
  });
});