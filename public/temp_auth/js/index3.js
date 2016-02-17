var base_url = window.location.toString();
var tabUrl = base_url.split("public");

$('#message_error_email').toggle(false);
$('#email_personne').blur(function(){
	var email_personne = $("#email_personne").val(); 
	var chemin = tabUrl[0]+'public/auth/verifier-email';
	$.ajax({
		 type: 'POST',
         url: chemin ,
         data:{'email_personne': email_personne},
         success: function(data) {    
         	    var result = jQuery.parseJSON(data); 
         	    if(result == 0){
         	    	//$("#email_personne").css("border-color","#CCCCCC");
         	    	$("#message_error_email").toggle(false);
             	} else 
             		if(result == 1){
             	    	//$("#email_personne").css("border-color","#FF0000");
             	    	$("#email_personne").val('');
             	    	$("#message_error_email").html('<i>"'+email_personne+'"<i> exite d&eacute;j&agrave;');
             	    	$("#message_error_email").toggle(true);
             	    	return false;
                 	}
         	   return false;    
         }
	});
});


$('#confirmation_mot_de_passe').blur(function(){
	if($('#mot_de_passe').val() == $('#confirmation_mot_de_passe').val()){
		return true;
	}else{
		$('#confirmation_mot_de_passe').val(''); 
		return false;
	}
});
