$(document).bind("mobileinit", function(){
  $.mobile.pageLoadErrorMessage = '{% trans %}Requested page not found!{% endtrans %}';
});