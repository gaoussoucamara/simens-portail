//FONCTION QUI RECUPERE LA PHOTO ET LA PLACE SUR L'EMPLACEMENT SOUHAITE
    function Recupererimage(){
    	$('#photo input[type="file"]').change(function() {
    	  
    	   var file = $(this);
 		   var reader = new FileReader;
 		   
	       reader.onload = function(event) {
	    		var img = new Image();
                 
        		img.onload = function() {
				   var width  = 100;
				   var height = 105;
				
				   var canvas = $('<canvas></canvas>').attr({ width: width, height: height });
				   file.replaceWith(canvas);
				   var context = canvas[0].getContext('2d');
	        	    	context.drawImage(img, 0, 0, width, height);
			    };
			    document.getElementById('fichier_tmp').value = img.src = event.target.result;
			   
    	};
    	 $("#modifier_photo").remove(); //POUR LA MODIFICATION
    	reader.readAsDataURL(file[0].files[0]);
    	//Crï¿½ation de l'onglet de suppression de la photo
    	$("#supprimer_photo").children().remove(); //ex:: ../../../img/delete_16.png
    	$('<img id="supp_photo" style="float: right; padding-top: 5px; cursor: pointer;" src="/www-simens-sn/public/img/delete_16.png" >').appendTo($("#supprimer_photo"));
      
    	//SUPPRESSION DU PHOTO
        //SUPPRESSION DU PHOTO
          $("#supprimer_photo").click(function(e){
        	  $('#supp_photo').w2overlay({ html: "" +
      			"" +
      			"<div style='border-bottom:1px solid #49afcd; height: 30px; background: #f9f9f9; width: 180px; text-align:center; padding-top: 10px; font-size: 13px; color: #49afcd; font-weight: bold;'>Supprimer l'image</div>" +
      			"<div style='height: 50px; width: 180px; padding-top:10px; text-align:center;'>" +
      			"<button class='btn' style='cursor:pointer;' onclick='popupFermer(); return false;'>Non</button>" +
      			"<button class='btn' style='cursor:pointer;' onclick='suppression(); return false;'>Oui</button>" +
      			"</div>" +
      			"" 
      			
          	});
        	  
          });
      });
    	     
    }
    //AJOUTER LA PHOTO DU PATIENT
    //AJOUTER LA PHOTO DU PATIENT
    Recupererimage();
    
    
    function popupFermer() {
    	$(null).w2overlay(null);
    }
    
    function suppression(id) {
    	$(null).w2overlay(null); 
    	//alert('Attention vous êtes sur le point de supprimer l\'article');
    	
    	$('#photo').children().remove(); 
        $('<input type="file" name="fichier" >').appendTo($('#photo')); 
        $("#supprimer_photo").children().remove();
        Recupererimage();
    }
    
