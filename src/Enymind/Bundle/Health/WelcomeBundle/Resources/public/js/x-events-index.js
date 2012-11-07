var genid_callback = function(){
  $("#p-code").load('/genid', function(){
    $("#p-code-input").val( $("#p-code").text() );
    $("#register-button").button('enable');
  });
};

var check_password_callback = function(){
  if( ( $("#password").val() != $("#password2").val() ) || $("#password").val() == "" ) {
    $("#free-popup").html( translations["pama"] );
    $("#free-popup").popup("open");
    return false;
  }
  return true;
};

$(document).delegate('#page-index', 'pageshow', function(){
  $("#new-user-coll").unbind("expand", genid_callback);
  $("#new-user-coll").bind("expand", genid_callback);
  
  $("#register-form").unbind("submit", check_password_callback);
  $("#register-form").bind("submit", check_password_callback);
  
  $("#register-button").button('disable');
});
