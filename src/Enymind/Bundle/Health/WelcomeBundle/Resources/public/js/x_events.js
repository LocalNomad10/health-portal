var genid_callback = function(){
  $("#p-code").load('/genid', function(){
    $("#p-code-input").val( $("#p-code").text() );
    $("#register-button").button('enable');
  });
};

var check_password_callback = function(){
  if( $("#password").val() != $("#password2").val() ) {
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
});

var bookmark_callback = function(e){
  e.preventDefault();
  var bookmarkUrl = this.href;
  var bookmarkTitle = this.title;

  if (window.sidebar) {
    window.sidebar.addPanel(bookmarkTitle, bookmarkUrl,"");
  } else if( window.external || document.all) {
    window.external.AddFavorite( bookmarkUrl, bookmarkTitle);
  } else if(window.opera) {
    $("#add-bookmark").attr("href",bookmarkUrl);
    $("#add-bookmark").attr("title",bookmarkTitle);
    $("#add-bookmark").attr("rel","sidebar");
  } else {
    $("#bookmark-not-supported-popup").popup("open");
  }
  return false;
};

var email_callback = function(e){
  e.preventDefault();
  $.post( $("#email-form").attr("action"), $("#email-form").serialize(), function( data ){
    $("#free-popup").html( data );
    $("#free-popup").popup("open");
  });
  return false;
};

$(document).delegate('#page-login', 'pageshow', function(){
  $("#bookmark-not-supported-popup").popup();      
  $("#add-bookmark").unbind("click", bookmark_callback);
  $("#add-bookmark").bind("click", bookmark_callback);

  $("#email-submit").unbind("click", email_callback);
  $("#email-submit").bind("click", email_callback);

  var focused = false;
  $("#login-form input").each(function(){
    if( !focused && $(this).val() == "" )
    {
      $(this).focus();
      focused = true;
    }
  });
});

$(document).bind('pageshow', function(){
  $(".flash-popup").each(function(){
    if( $(this).length > 0 ) {
      $(this).popup();
      $(this).popup("open");
    }
  });
  $("#free-popup").popup();
});