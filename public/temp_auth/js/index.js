var base_url = window.location.toString();
var tabUrl = base_url.split("public");

var connexion = "Se connecter";
var inscrire = "S'inscrire";
var k = 0;
// Toggle Function
$('.toggle').click(function(){
  // Switches the Icon
  if(k == 0){
	  $(this).children('i').text(connexion);
	  $('.cta').children('a').text('');
	  k = 1;
  }
  else if(k == 1){
	  $(this).children('i').text(inscrire);
	  $('.cta').children('a').html('Mot de passe oubli&eacute;');
	  k = 0;
  }
  // Switches the forms  
  $('.form').animate({
    height: "toggle",
    'padding-top': 'toggle',
    'padding-bottom': 'toggle',
    opacity: "toggle"
  }, "slow");
});

