$(document).bind('pageshow', function(){
  $(".flash-popup").each(function(){
    if( $(this).length > 0 ) {
      $(this).popup();
      $(this).popup("open");
    }
  });
  $("#free-popup").popup();
});