var base_url = window.location.toString();
var tabUrl = base_url.split("public");
var comptEntrerA = 0;
var comptEntrerB = 0;
//******** ====== Premiere fonction ======== Premiere fonction ======= Premiere fonction *******
//******** ====== Premiere fonction ======== Premiere fonction ======= Premiere fonction *******
//******** ====== Premiere fonction ======== Premiere fonction ======= Premiere fonction *******
//******** ====== Premiere fonction ======== Premiere fonction ======= Premiere fonction *******
//******** ====== Premiere fonction ======== Premiere fonction ======= Premiere fonction *******
function scriptInitialisation() {
	$("#parametrageAdmin").replaceWith("<a style='margin-left: 27px;'> <img style='position: absolute; margin-top: -7px;' src='/www-simens-sn/public/img/article/Application2.png' title='param&eacute;trage' > </a>");

	$('#ImageEnTeteDefilant').hover(function(){
		$(this).css('background','url("/www-simens-sn/public/img/article/image_2.png") no-repeat');
	},function(){
		$(this).css('background','url("/www-simens-sn/public/img/article/image_1.png") no-repeat');
	});

	$('#PubliciteMenu').hover(function(){
		$(this).css('background','url("/www-simens-sn/public/img/article/publicite_2.png") no-repeat');
	},function(){
		$(this).css('background','url("/www-simens-sn/public/img/article/publicite_1.png") no-repeat');
	});


	$('#MenuImageEnTeteDefilant, #MenuPubliciteMenu').toggle(false);

	//<!-- ***GESTION DES IMGES DE L'ENTETE*** -->
	//<!-- ***GESTION DES IMGES DE L'ENTETE*** -->
	$('#ImageEnTeteDefilant').click(function(){
		$('#face1, #MenuParametrage').fadeOut(function(){
			$('#TitreVueParametrage').html("Gestion des images de l'ent&ecirc;te");
			$('#face2').fadeIn().css({'visibility':'visible'});
			
			
			$('#MenuImageEnTeteDefilant').fadeIn(function(){
				if(comptEntrerA == 0) {
				   comptEntrerA = 1;
				//Emplacement pour ajouter de nouvelles images
				//Emplacement pour ajouter de nouvelles images
				//***********************
				//***********************
				var chemin = tabUrl[0]+'public/admin/liste-images-defilantes';
				$.ajax({
					type: 'POST',
					url: chemin ,
					data: {},
					success: function(data) {    
						var result = jQuery.parseJSON(data);   
						$('#ListeDesSliders').html(result);
					}
				});
				//***********************
				//***********************
				}
			});
			$('#RetourMenu1').click(function(){
				comptEntrerA = 0;
				$('#face2, #MenuImageEnTeteDefilant').fadeOut(function(){
					$('#TitreVueParametrage').html("Param&eacute;trage");
					$('#face1, #MenuParametrage').fadeIn();
				});
			});
			$('#AjoutImgMenu1_right').click(function(){
				if(comptEntrerB == 0) {
					comptEntrerB = 1;
					$('#AjoutImgMenu1_right').fadeOut();
					$('.modification_donnees').fadeOut();
					$('.confirmation_suppression').fadeOut();
					var chemin = tabUrl[0]+'public/admin/image-a-ajouter';
					$.ajax({
						type: 'POST',
						url: chemin ,
						data: {},
						success: function(data) {    
							var result = jQuery.parseJSON(data);   
							$('.ajouter_image_defilante').html(result);	
							$('.ajouter_image_defilante').fadeIn();
						}
					});
				}
			});
			
		});
	});

	//<!-- ***GESTION DE LA BANNIERE DE PUBLICITE*** -->
	//<!-- ***GESTION DE LA BANNIERE DE PUBLICITE*** -->
	$('#PubliciteMenu').click(function(){
		$('#face1, #MenuParametrage').fadeOut(function(){
			$('#TitreVueParametrage').html("Gestion de la banni&egrave;re de publicit&eacute;");
			$('#face2').fadeIn().css({'visibility':'visible'});
			$('#MenuPubliciteMenu').fadeIn();
			$('#RetourMenu2').click(function(){
				$('#face2, #MenuPubliciteMenu').fadeOut(function(){
					$('#TitreVueParametrage').html("Param&eacute;trage");
					$('#face1, #MenuParametrage').fadeIn();
				});
			});
		});
	});

	
	//AJOUTER UNE IMAGE
	//AJOUTER UNE IMAGE
	Recupererimage();
	
	
	//Confimation suppression
	//Confimation suppression
	$('.confirmation_suppression, .modification_donnees, .ajouter_image_defilante').toggle(false);
	
}

var $nbAppelAjax = 1;
var $nbAppelAjaxModif = 1;
//FONCTION QUI RECUPERE LA PHOTO ET LA PLACE SUR L'EMPLACEMENT SOUHAITE
function Recupererimage(){
	$('#photo input[type="file"]').change(function() {
	  
	   var file = $(this);
		   var reader = new FileReader;
		   
       reader.onload = function(event) {
    		var img = new Image();
             
    		img.onload = function() {
			   var width  = 170;
			   var height = 198;
			
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
	$("#supprimer_photo").children().remove(); 
	$('<img id="supp_photo" style="float: right; padding-top: 5px; cursor: pointer;" src="/www-simens-sn/public/img/delete_16.png" >').appendTo($("#supprimer_photo"));
  
	  //SUPPRESSION DE LA PHOTO
      //SUPPRESSION DE LA PHOTO
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

      //AFFICHAGE DU BOUTON
      //AFFICHAGE DU BOUTON
      $('#buttonARDesign button').fadeIn().css({'visibility':'visible'});
      $('#buttonARDesign button').click(function(){
    	  if($nbAppelAjax == 1){ //Pour limiter l'appel à un seul appel
    		  $nbAppelAjax = 0;
    		  var $fichier_tmp = $('#fichier_tmp').val(); 
        	  var $lien = $('#lien').val();
        	  var $description = $('#description').val();
        	  
        	  var chemin = tabUrl[0]+'public/admin/enregistrement-image';
        	  $.ajax({
        		  type: 'POST',
        		  url: chemin ,
        		  data: {'fichier_tmp':$fichier_tmp, 'lien':$lien, 'description':$description},
        		  success: function() {    
        			  rafraichissementListeImages();
        		  },
        	      
        		  error:function(e){console.log(e);alert("Une erreur interne est survenue!");},
        		  dataType: "html"
        	  });
        	  
    	  }
      });
      
  });
	     
}

function popupFermer() {
	$(null).w2overlay(null);
}
 
function suppression() {
	$(null).w2overlay(null); 
	
	$('#photo').children().remove(); 
    $('<input type="file" name="fichier" >').appendTo($('#photo')); 
    $("#supprimer_photo").children().remove();
    
    //Masquer LE BOUTON
    //Masquer LE BOUTON
    $('#buttonARDesign button').fadeOut().css({'visibility':'hidden'});
   	Recupererimage();
    	
}

function rafraichissementListeImages(){
	$nbAppelAjax = 1;
	$nbAppelAjaxModif = 1;
	var chemin = tabUrl[0]+'public/admin/raffraichissement-liste-images';
	 
	$.ajax({
		type: 'POST',
		url: chemin ,
		data: {},
		success: function(data) {    
			var result = jQuery.parseJSON(data);   
			$("#LesScriptsDesImages").html(result);
			scriptListeDesImages();
			$('#fichier_tmp').val(""); 
			$('#lien').val("");
			$('#description').val("");
	    	  
			$('#ZoneAjoutPhoto').html(''+
			'<div class="photo_article" id="photo">'+
	        '<input type="file" name="fichier" />'+
		    '</div>'+
		    '<input type="hidden" id="fichier_tmp" name="fichier_tmp" />'+
		    '<div class="supprimer_photo" id="supprimer_photo" style="width: 24px; height: 15px; float: left;"> </div>'
	    	);
	    	//Masquer LE BOUTON
	    	//Masquer LE BOUTON
	    	$('#buttonARDesign button').fadeOut().css({'visibility':'hidden'});
	    	$('#buttonARDesignModifier button, #buttonAnnulerModif').fadeOut().css({'visibility':'hidden'});
	    	Recupererimage();
		},
	      
		error:function(e){console.log(e);alert("Une erreur interne est survenue!");},
		dataType: "html"
	});
}

















//******** ====== Deuxieme fonction ======== Deuxieme fonction ======= Deuxieme fonction *******
//******** ====== Deuxieme fonction ======== Deuxieme fonction ======= Deuxieme fonction *******
//******** ====== Deuxieme fonction ======== Deuxieme fonction ======= Deuxieme fonction *******
//******** ====== Deuxieme fonction ======== Deuxieme fonction ======= Deuxieme fonction *******
//******** ====== Deuxieme fonction ======== Deuxieme fonction ======= Deuxieme fonction *******
function scriptListeDesImages() {
	        var imageMarquee = ImageMarqueeRecup;
            $("#splitter").jqxSplitter({  width: 140, height: 210, panels: [{ size: '96%'}] });

            // prepare the data
            var data = new Array();

            var k = 0;
            for (var i = 0; i < ListeImages.length; i++) {
                var row = {};
                row["id"] = Id[k];
                row["publier"] = Publier[k];
                row["image"] = ListeImages[k];
                row["lien"] = ListeLiens[k];
                row["description"] = ListeDescription[k];
                data[i] = row;
                k++;
            }

            var source =
            {
                localdata: data,
                datatype: "array"
            };
            var dataAdapter = new $.jqx.dataAdapter(source);

            var updatePanel = function (index) {
                var container = $('<div style="margin: 5px;"></div>');
                var leftcolumn = $('<div style="float: left; width: 100%; overflow: auto; height: 100%;"></div>'); 
                container.append(leftcolumn);

                var datarecord = data[index];
                
                var id = datarecord.id; 
                var publier = datarecord.publier;
                var image = "<div style='margin: 10px; width: 85px; float:left;'> <img class='imageDefilante' style='width: 80px; height: 90px;'  src='/www-simens-sn/public/img/publicite/images/" + datarecord.image + ".jpg' /></div>";
                if(publier == 0){
                    //image += "<div class='publier'><a href='javascript:publier(\""+datarecord.image+"\");'><img id='pub"+datarecord.image+"' style='cursor:pointer;' src='/www-simens-sn/public/img/favorite.png' /></a></div>";
                }else if(publier == 1){
                	image += "<div class='publier'><img style='cursor:pointer;' src='/www-simens-sn/public/img/tick_16.png' /></div>";
                }	
 
                var lien = "<div style='margin: 10px; font-family: time new romans; text-align: justify;' ><b style='text-decoration: underline; font-size: 12px;'>Lien:</b> <div style='font-size: 15px; color: black; overflow: auto; height: 40px;'>" + datarecord.lien + "</div></div>";
                var description = "<div style='margin: 10px; font-family: time new romans;'><b style='text-decoration: underline; font-size: 12px;'>Titre:</b> <div style='font-size: 15px; color: black; '>" + datarecord.description + "</div></div>";
                $(leftcolumn).append(image);
                $(leftcolumn).append(description);
                $(leftcolumn).append(lien);

                $("#ContentPanel").html(container.html());
            };

            $('#listbox').on('select', function (event) {
                updatePanel(event.args.index);
            });
      
            //Create jqxListBox
            $('#listbox').jqxListBox({ selectedIndex: 0,  source: dataAdapter, displayMember: "image", 
            	itemHeight: 105, height: '100%', width: '100%',
                renderer: function (index, label, value) {
                    var imgurl = '/www-simens-sn/public/img/publicite/images/' + label.toLowerCase() + '.jpg';
                    var img = '<img class="imageDefilante" style="width: 80px; height: 90px;"  src="' + imgurl + '" />';
                    var table = '<table  style="min-width: 90px;">'+
                                '<tr>'+
                                '<td style="width: 80px; height: 90px;">' + img + '</td>'+
                                '<td style="width: 13px; vertical-align: top; padding-right: 5px; ">';
                    if(imageMarquee == label){
                    	table +='<div class="icone1"><a><img style="cursor:pointer;" src="/www-simens-sn/public/img/tick_16.png" /></a></div>';
                    }else{
                    	table +='<div class="icone1"><a href="javascript:publier2(\''+label+'\');" ><img id="pub2'+label+'" style="cursor:pointer;" src="/www-simens-sn/public/img/favorite.png" /></a></div>';
                    }    
                    
                    table +='<div class="icone2"><a href="javascript:modifier(\''+label+'\');" ><img id="modif'+label+'" style="cursor:pointer;" src="/www-simens-sn/public/img/pencil_16.png" /></a></div>'+
                            '<div class="icone3"><a href="javascript:supprimer(\''+label+'\');"><img id="supp'+label+'" style="cursor:pointer;" src="/www-simens-sn/public/img/sup.png" /></a></div>'+
                            '</td>'+
                            '</tr>'+
                            '</table>';
                    return table;
                }
            });
            updatePanel(0);
            
}


function publier(image) {
   $("#pub"+image).w2overlay({ html: "" +
		"" +
		"<div style='border-bottom:1px solid #49afcd; height: 20px; background: #f9f9f9; width: 130px; text-align:center; padding-top: 3px; font-size: 14px; color: #49afcd; font-weight: bold; font-family: time new romans;'>Publication</div>" +
		"<div style='height: 40px; width: 130px; padding-top:7px; text-align:center;'>" +
		"<button class='btn' style='width:50px; min-width:50px; cursor:pointer;' onclick='popupFermer(); return false;'>Non</button>" +
		"<button class='btn' style='width:50px; min-width:50px; cursor:pointer;' onclick='publierImage(\""+image+"\"); return false;'>Oui</button>" +
		"</div>" +
		"" 
   });
}

function publierImage(image) {
	$(null).w2overlay(null);
	$("#pubAccueilLayoutPubManager").replaceWith("<img id='pubAccueilLayoutPubManager' src='/www-simens-sn/public/img/publicite/images/"+image+".jpg' />");
	$("#pub"+image).replaceWith("<img style='cursor:pointer;' src='/www-simens-sn/public/img/tick_16.png' />");
	$("#pub2"+image).replaceWith("<img style='cursor:pointer;' src='/www-simens-sn/public/img/tick_16.png' />");
	
	var chemin = tabUrl[0]+'public/admin/marquer-image-publier';
	$.ajax({
		type: 'POST',
		url: chemin ,
		data: {'image':image},
		success: function() {    
			//rafraichissementListeImages(); 
			//rafraichissementListeImages(); 
		},
	      
		error:function(e){console.log(e);alert("Une erreur interne est survenue!");},
		dataType: "html"
	
	});
}

function publier2(image) {
	   $("#pub2"+image).w2overlay({ html: "" +
			"" +
			"<div style='border-bottom:1px solid #49afcd; height: 20px; background: #f9f9f9; width: 130px; text-align:center; padding-top: 3px; font-size: 14px; color: #49afcd; font-weight: bold; font-family: time new romans;'>Publication</div>" +
			"<div style='height: 40px; width: 130px; padding-top:7px; text-align:center;'>" +
			"<button class='btn' style='width:50px; min-width:50px; cursor:pointer;' onclick='popupFermer(); return false;'>Non</button>" +
			"<button class='btn' style='width:50px; min-width:50px; cursor:pointer;' onclick='publierImage2(\""+image+"\"); return false;'>Oui</button>" +
			"</div>" +
			"" 
	   });
}

function publierImage2(image) {
	$(null).w2overlay(null);
	$("#pub"+image).replaceWith("<img style='cursor:pointer;' src='/www-simens-sn/public/img/tick_16.png' />");
	$("#pub2"+image).replaceWith("<img style='cursor:pointer;' src='/www-simens-sn/public/img/tick_16.png' />");
	
	var chemin = tabUrl[0]+'public/admin/marquer-image-publier';
	$.ajax({
		type: 'POST',
		url: chemin ,
		data: {'image':image},
		success: function(data) {  
			var result = jQuery.parseJSON(data); 
			$("#pubAccueilLayoutPubManager").replaceWith(result);
			$('#pubTitreRouge').html(description);
			rafraichissementListeImages();
		},
	      
		error:function(e){console.log(e);alert("Une erreur interne est survenue!");},
		dataType: "html"
	
	});
}
	
//**********--------*********---------**********-----------**********-----------***********---------*********----------**********
//**********--------*********---------**********-----------**********-----------***********---------*********----------**********
//**********--------*********---------**********-----------**********-----------***********---------*********----------**********

function modifier(image) {
	$("#modif"+image).w2overlay({ html: "" +
		"" +
		"<div style='border-bottom:1px solid #49afcd; height: 20px; background: #f9f9f9; width: 130px; text-align:center; padding-top: 3px; font-size: 14px; color: #49afcd; font-weight: bold; font-family: time new romans;'>Modification</div>" +
		"<div style='height: 40px; width: 130px; padding-top:7px; text-align:center;'>" +
		"<button class='btn' style='width:50px; min-width:50px; cursor:pointer;' onclick='popupFermer(); return false;'>Non</button>" +
		"<button class='btn' style='width:50px; min-width:50px; cursor:pointer;' onclick='modifierImage(\""+image+"\"); return false;'>Oui</button>" +
		"</div>" +
		"" 
  });
}

function modifierImage(image) { 
	$(null).w2overlay(null);
	var chemin = tabUrl[0]+'public/admin/modifier-image';
	$.ajax({
		type: 'POST',
		url: chemin ,
		data: {'image':image},
		success: function(data) {  
			var result = jQuery.parseJSON(data);   
			$('#ZoneDeSaisiLienDescript').html(result);
			//AFFICHAGE DU BOUTON
		    //AFFICHAGE DU BOUTON
		    $('#buttonARDesignModifier button, #buttonAnnulerModif').fadeIn().css({'visibility':'visible'});
		    $('#buttonAnnulerModif').click(function(){
		    	$('#fichier_tmp').val(""); 
				$('#lien').val("");
				$('#description').val("");
		    	  
				$('#ZoneAjoutPhoto').html(''+
				'<div class="photo_article" id="photo">'+
		        '<input type="file" name="fichier" />'+
			    '</div>'+
			    '<input type="hidden" id="fichier_tmp" name="fichier_tmp" />'+
			    '<div class="supprimer_photo" id="supprimer_photo" style="width: 24px; height: 15px; float: left;"> </div>'
		    	);
		    	//Masquer LES BOUTON
		    	//Masquer LES BOUTON
		    	$('#buttonARDesignModifier button, #buttonAnnulerModif').fadeOut().css({'visibility':'hidden'});
		    	Recupererimage();
		    	
		    });
		    if($nbAppelAjaxModif == 1){ //Pour limiter l'appel à un seul appel
		    	$nbAppelAjaxModif = 0;
		    	modification(image);
		    }
		},
		error:function(e){console.log(e);alert("Une erreur interne est survenue!");},
		dataType: "html"
	});
}

function modification(image){
	$('#buttonARDesignModifier button').click(function(){
    	var $lien = $('#lien').val();
    	var $description = $('#description').val();
    	if(image!=""){
    		var chemin = tabUrl[0]+'public/admin/modifier-contenu-image';
    		$.ajax({
        		type: 'POST',
        		url: chemin ,
        		data: {'image':image, 'lien':$lien, 'description':$description},
        		success: function(data) { 
        			var result = jQuery.parseJSON(data);
        			if(result == 1){
        				$('#pubTitreRouge').html($description);
        			}
        			
        			image="";
        			rafraichissementListeImages();
        		},
            	      
        		error:function(e){console.log(e);alert("Une erreur interne est survenue!");},
        		dataType: "html"
        	});
    	}
    });
}


function supprimer(image) {
	$("#supp"+image).w2overlay({ html: "" +
		"" +
		"<div style='border-bottom:1px solid #49afcd; height: 20px; background: #f9f9f9; width: 130px; text-align:center; padding-top: 3px; font-size: 14px; color: #49afcd; font-weight: bold; font-family: time new romans;'>Suppression</div>" +
		"<div style='height: 40px; width: 130px; padding-top:7px; text-align:center;'>" +
		"<button class='btn' style='width:50px; min-width:50px; cursor:pointer;' onclick='popupFermer(); return false;'>Non</button>" +
		"<button class='btn' style='width:50px; min-width:50px; cursor:pointer;' onclick='supprimerImage(\""+image+"\"); return false;'>Oui</button>" +
		"</div>" +
		"" 
  });
}

function supprimerImage(image) {
	$(null).w2overlay(null);
	var chemin = tabUrl[0]+'public/admin/supprimer-image';
	$.ajax({
		type: 'POST',
		url: chemin ,
		data: {'image':image},
		success: function(data) {  
			var result = jQuery.parseJSON(data); 
			$("#pubAccueilLayoutPubManager").replaceWith(result);
			$('#pubTitreRouge').html(description);
			rafraichissementListeImages();
		},
	      
		error:function(e){console.log(e);alert("Une erreur interne est survenue!");},
		dataType: "html"
	
	});
}


//*************GESTION DES PLIANTS ET DEPLIANTS******************
//*************GESTION DES PLIANTS ET DEPLIANTS******************
//*************GESTION DES PLIANTS ET DEPLIANTS******************
function initAnimation() {
	$('.contenu_niveau_1').toggle(true);
	$('.contenu_niveau_2').toggle(false);
	$('.contenu_niveau_3').toggle(false);
}

/**INFO NIVEAU 1**/
/**INFO NIVEAU 1**/
function depliantPlus1() {
	$('.niveau_1').click(function(){
		$(".niveau_1").replaceWith(
			"<div class='niveau_1'> <img src='"+tabUrl[0]+"public/img/article/minus.png' /> <span> Niveau 1</span> </div>"
			);
		animationPliantDepliant1();
		$('.contenu_niveau_1').animate({
			height : 'toggle'
		},500);
		return false;
	});
}

function animationPliantDepliant1() {
	$('.niveau_1').click(function(){
	    $(".niveau_1").replaceWith(
			"<div class='niveau_1'> <img src='"+tabUrl[0]+"public/img/article/plus.png' /> <span> Niveau 1</span> </div>"
			);
		depliantPlus1();
		$('.contenu_niveau_1').animate({
			height : 'toggle'
		},500);
		return false;
	});
}

/**INFO NIVEAU 2**/
/**INFO NIVEAU 2**/
function depliantPlus2() {
	$('.niveau_2').click(function(){
		$(".niveau_2").replaceWith(
			"<div class='niveau_2'> <img src='"+tabUrl[0]+"public/img/article/plus.png' /> <span> Niveau 2</span> </div>"
			);
		animationPliantDepliant2();
		$('.contenu_niveau_2').animate({
			height : 'toggle'
		},500);
		return false;
	});
}

function animationPliantDepliant2() {
	$('.niveau_2').click(function(){
	    $(".niveau_2").replaceWith(
			"<div class='niveau_2'> <img src='"+tabUrl[0]+"public/img/article/minus.png' /> <span> Niveau 2</span> </div>"
			);
		depliantPlus2();
		$('.contenu_niveau_2').animate({
			height : 'toggle'
		},500);
		return false;
	});
}

/**INFO NIVEAU 3**/
/**INFO NIVEAU 3**/
function depliantPlus3() {
	$('.niveau_3').click(function(){
		$(".niveau_3").replaceWith(
			"<div class='niveau_3'> <img src='"+tabUrl[0]+"public/img/article/plus.png' /> <span> Niveau 3</span> </div>"
			);
		animationPliantDepliant3();
		$('.contenu_niveau_3').animate({
			height : 'toggle'
		},500);
		return false;
	});
}

function animationPliantDepliant3() {
	$('.niveau_3').click(function(){
	    $(".niveau_3").replaceWith(
			"<div class='niveau_3'> <img src='"+tabUrl[0]+"public/img/article/minus.png' /> <span> Niveau 3</span> </div>"
			);
		depliantPlus3();
		$('.contenu_niveau_3').animate({
			height : 'toggle'
		},500);
		return false;
	});
}

/** SUPPRESSION DES IMAGES DEFILANTES **/
/** SUPPRESSION DES IMAGES DEFILANTES **/
function supprimerImageDefilante(id) { 
	$('.modification_donnees').fadeOut();
	$('.ajouter_image_defilante').fadeOut();
	$('#AjoutImgMenu1_right').fadeIn();
	comptEntrerB = 0;
	var chemin = tabUrl[0]+'public/admin/recuperer-image-a-supprimer';
	$.ajax({
		type: 'POST',
		url: chemin ,
		data: {'id':id},
		success: function(data) {  
			var result = jQuery.parseJSON(data); 
			$('.confirmation_suppression').html(result);	
			$('.confirmation_suppression').fadeIn();
		}
	});
}

function annulerImg() {
	$('.confirmation_suppression').fadeOut();
}

function supprimerImg(id) {
	
	var chemin = tabUrl[0]+'public/admin/supprimer-image-defilante';
	$.ajax({
		type: 'POST',
		url: chemin ,
		data: {'id':id},
		success: function() {  
			$('#information_suppression').html('<span style="color: green; font-size: 15px;"> Suppression effectu&eacute;e avec succ&egrave;s</span>');
			$('#bouton_supp_ann').html('<img src=\''+tabUrl[0]+'public/img/tick_32.png\' >');
			setTimeout(function(){
				$('.confirmation_suppression').fadeOut();
			}, 5000);
			/* ==================================== */
			/* ==================================== */
			var chemin = tabUrl[0]+'public/admin/liste-images-defilantes';
			$.ajax({
				type: 'POST',
				url: chemin ,
				data: {},
				success: function(data) {    
					var result = jQuery.parseJSON(data);   
					$('#ListeDesSliders').html(result);
					raffraichirImageDefilanteEnTete();
				}
			});
			/* ==================================== */
			/* ==================================== */
		}
	});
	
}

/** MODIFICATION DES IMAGES DEFILANTES **/
/** MODIFICATION DES IMAGES DEFILANTES **/
function modifierImageDefilante(id) {
	$('.confirmation_suppression').fadeOut();
	
	$('.ajouter_image_defilante').fadeOut();
	$('#AjoutImgMenu1_right').fadeIn();
	comptEntrerB = 0;
	
	var chemin = tabUrl[0]+'public/admin/recuperer-image-a-modifier';
	$.ajax({
		type: 'POST',
		url: chemin ,
		data: {'id':id},
		success: function(data) {  
			var result = jQuery.parseJSON(data);   
			$('.modification_donnees').html(result);	
			$('.modification_donnees').fadeIn();
		}
	});
}

function annulerModifImg() {
	$('.modification_donnees').fadeOut();
}

function validerModifImg(id) {
	var titre_1 = $('#titre_1').val();
	var titre_2 = $('#titre_2').val();
	var description_img = $('#description_img').val();
	var chemin = tabUrl[0]+'public/admin/valider-modification-image';
	$.ajax({
		type: 'POST',
		url: chemin ,
		data: {'id':id, 'titre_1':titre_1, 'titre_2':titre_2, 'description_img':description_img},
		success: function() {  
			$('#titre_1').attr('disabled', true).css({'background': '#f6f6f6'});
			$('#titre_2').attr('disabled', true).css({'background': '#f6f6f6'});
			$('#description_img').attr('disabled', true).css({'background': '#f6f6f6'});
			$('#information_modification').html('<span style="color: green; font-size: 15px;"> Modifications effectu&eacute;es avec succ&egrave;s</span>');
			$('#bouton_supp_ann_modif').html('<img src=\''+tabUrl[0]+'public/img/tick_32.png\' >');
			setTimeout(function(){
				$('.modification_donnees').fadeOut();
			}, 7000);
			/* ==================================== */
			/* ==================================== */
			var chemin = tabUrl[0]+'public/admin/liste-images-defilantes';
			$.ajax({
				type: 'POST',
				url: chemin ,
				data: {},
				success: function(data) {    
					var result = jQuery.parseJSON(data);   
					$('#ListeDesSliders').html(result);
					raffraichirImageDefilanteEnTete();
				}
			});
			/* ==================================== */
			/* ==================================== */
		}
	});
}

function activerImageDefilante(id) { 
	
	var chemin = tabUrl[0]+'public/admin/activer-image-defilante';
	$.ajax({
		type: 'POST',
		url: chemin ,
		data: {'id':id},
		success: function() {    
			/* ==================================== */
			/* ==================================== */
			var chemin = tabUrl[0]+'public/admin/liste-images-defilantes';
			$.ajax({
				type: 'POST',
				url: chemin ,
				data: {},
				success: function(data) {    
					var result = jQuery.parseJSON(data);   
					$('#ListeDesSliders').html(result);
					raffraichirImageDefilanteEnTete();
				}
			});
			/* ==================================== */
			/* ==================================== */
		}
	});
}


function desactiverImageDefilante(id) { 
	
	var chemin = tabUrl[0]+'public/admin/desactiver-image-defilante';
	$.ajax({
		type: 'POST',
		url: chemin ,
		data: {'id':id},
		success: function() {    
			/* ==================================== */
			/* ==================================== */
			var chemin = tabUrl[0]+'public/admin/liste-images-defilantes';
			$.ajax({
				type: 'POST',
				url: chemin ,
				data: {},
				success: function(data) {    
					var result = jQuery.parseJSON(data);   
					$('#ListeDesSliders').html(result);
					raffraichirImageDefilanteEnTete();
				}
			});
			/* ==================================== */
			/* ==================================== */
		}
	});
}


/* ===================================================================================================================== */
/* ===================================================================================================================== */
/* ===================================================================================================================== */
//FONCTION QUI RECUPERE LA PHOTO ET LA PLACE SUR L'EMPLACEMENT SOUHAITE
function RecupererImageDef(){
	$('#photo_def input[type="file"]').change(function() {
	   var file = $(this);
	   var reader = new FileReader;
		   
       reader.onload = function(event) {
    		var img = new Image();
             
    		img.onload = function() {
			   var width  = 390;
			   var height = 120;
			
			   var canvas = $('<canvas></canvas>').attr({ width: width, height: height });
			   file.replaceWith(canvas);
			   var context = canvas[0].getContext('2d');
        	    	context.drawImage(img, 0, 0, width, height);
		    };
		    document.getElementById('fichier_tmp_def').value = img.src = event.target.result;
		   
	};
	reader.readAsDataURL(file[0].files[0]);
	//Creation de l'onglet de suppression de la photo
	$("#supprimer_photo_def").children().remove(); 
	$('<img id="supp_photo_def" style="float: right; padding-top: 5px; cursor: pointer;" src="/www-simens-sn/public/img/delete_16.png" >').appendTo($("#supprimer_photo_def"));
  
	  //SUPPRESSION DE LA PHOTO
      //SUPPRESSION DE LA PHOTO
      $("#supprimer_photo_def").click(function(e){
    	  $('#supp_photo_def').w2overlay({ html: "" +
  			"" +
  			"<div style='border-bottom:1px solid #49afcd; height: 30px; background: #f9f9f9; width: 180px; text-align:center; padding-top: 10px; font-size: 13px; color: #49afcd; font-weight: bold;'>Supprimer l'image</div>" +
  			"<div style='height: 50px; width: 180px; padding-top:10px; text-align:center;'>" +
  			"<button class='btn' style='cursor:pointer;' onclick='popupFermer(); return false;'>Non</button>" +
  			"<button class='btn' style='cursor:pointer;' onclick='suppressionImageDef(); return false;'>Oui</button>" +
  			"</div>" +
  			"" 
  			
      	});
    	  
      });

  });
	     
}

function suppressionImageDef() {
	$(null).w2overlay(null); 
	
	$('#photo_def').children().remove(); 
    $('<input type="file" name="fichier" >').appendTo($('#photo_def')); 
    $("#supprimer_photo_def").children().remove();
    $('#fichier_tmp_def').val('');
    
    RecupererImageDef();
    	
}

function annulerAjoutImg() {
	comptEntrerB = 0;
	$('#AjoutImgMenu1_right').fadeIn();
	$('.ajouter_image_defilante').fadeOut();
}

function validerAjoutImg() {
	var titre_1_aj = $('#titre_1_aj').val(); 
	var titre_2_aj = $('#titre_2_aj').val();
	var description_img_aj = $('#description_img_aj').val(); 
	var fichier_tmp_def = $('#fichier_tmp_def').val();
	var chemin = tabUrl[0]+'public/admin/valider-ajout-image';
	$.ajax({
		type: 'POST',
		url: chemin ,
		data: {'titre_1_aj':titre_1_aj, 'titre_2_aj':titre_2_aj, 'description_img_aj':description_img_aj, 'fichier_tmp_def':fichier_tmp_def},
		success: function(data) {
			var result = jQuery.parseJSON(data);
			
			if(result == 1) {
				$('#supprimer_photo_def').fadeOut();
				$('#titre_1_aj').attr('disabled', true).css({'background': '#f6f6f6'});
				$('#titre_2_aj').attr('disabled', true).css({'background': '#f6f6f6'});
				$('#description_img_aj').attr('disabled', true).css({'background': '#f6f6f6'});
				$('#information_ajout_img').html('<span style="color: green; font-size: 15px;"> Ajout effectu&eacute; avec succ&egrave;s</span>');
				$('#bouton_supp_valid_ajout').html('<img src=\''+tabUrl[0]+'public/img/tick_32.png\' >');
				setTimeout(function(){
					annulerAjoutImg();
				}, 7000);
				/* ==================================== */
				/* ==================================== */
				var chemin = tabUrl[0]+'public/admin/liste-images-defilantes';
				$.ajax({
					type: 'POST',
					url: chemin ,
					data: {},
					success: function(data) {    
						var result = jQuery.parseJSON(data);   
						$('#ListeDesSliders').html(result);
						raffraichirImageDefilanteEnTete();
					}
				});
				/* ==================================== */
				/* ==================================== */
			} else {
				alert('aucune image n\'est ajoutee');
			}
			
		}
	});
}

//****** RAFFRAICHISSEMENT DES IMAGES D'EN TETE *****
//****** RAFFRAICHISSEMENT DES IMAGES D'EN TETE *****
function raffraichirImageDefilanteEnTete() {
	var chemin = tabUrl[0]+'public/admin/raffraichir-images-defilantes-en-tete';
	$.ajax({
		type: 'POST',
		url: chemin ,
		data: {},
		success: function(data) {    
			var result = jQuery.parseJSON(data);   
			$('.EmplacementLayoutImagesDefilantes').html(result);
		}
	});
}





//****** PUBLICITE NIVEAU 2 ******
//****** PUBLICITE NIVEAU 2 ******
//****** PUBLICITE NIVEAU 2 ******
//****** PUBLICITE NIVEAU 2 ******
//****** PUBLICITE NIVEAU 2 ******
//****** PUBLICITE NIVEAU 2 ******
//****** PUBLICITE NIVEAU 2 ******
//****** PUBLICITE NIVEAU 2 ******
//****** PUBLICITE NIVEAU 2 ******
//****** PUBLICITE NIVEAU 2 ******
//****** PUBLICITE NIVEAU 2 ******
//****** PUBLICITE NIVEAU 2 ******
//****** PUBLICITE NIVEAU 2 ******
//****** PUBLICITE NIVEAU 2 ******
function ajouterDonneesSaisiesN2() {
	$('#PublicationNiveau2').w2overlay({ html: "" +
			"" +
			"<div style='border-bottom:1px solid #49afcd; height: 30px; background: #f9f9f9; width: 180px; text-align:center; padding-top: 10px; font-size: 13px; color: #49afcd; font-weight: bold;'>Publication de l'info</div>" +
			"<div style='height: 50px; width: 180px; padding-top:10px; text-align:center;'>" +
			"<button class='btn' style='cursor:pointer;' onclick='popupFermer(); return false;'>Non</button>" +
			"<button class='btn' style='cursor:pointer;' onclick='publierInfoN2(); return false;'>Oui</button>" +
			"</div>" +
			"" 
  	});
}

function publierInfoN2() {
	$(null).w2overlay(null);
	var titre = $('#titre').val();
	var contenu = $('#contenu').val();
	
	var chemin = tabUrl[0]+'public/admin/ajouter-publicite-n2';
	$.ajax({
		type: 'POST',
		url: chemin ,
		data: {'titre' : titre, 'contenu':contenu},
		success: function() {    
			$('#titre').attr('disabled', true).css({'background': '#f6f6f6'});
			$('#contenu').attr('disabled', true).css({'background': '#f6f6f6'});
			$('#AffichageBoutonN2').html('<span id="infoPubN2" style="color: green; font-size: 15px; font-family: time new romans; ">' +
					                     'Informations publi&eacute;es avec succ&egrave;s<!--img src=\''+tabUrl[0]+'public/img/tick_32.png\'--> </span>'+
					                     '<div style="float: right;">'+
					                     
					                     '<button class="dePublicationNiveau2" style="cursor:pointer; height: 35px; width: 35px; background: transparent; border-radius: 50%; "  onclick="depublierDonneesSaisiesN2(); return false;">'+ 
					                     '<img id="dePublicationNiveau2" src=\''+tabUrl[0]+'public/img/tick_32.png\'>'+
			                             '</button>'+
					                     
					                     '</div>');
			setTimeout(function(){ $('#infoPubN2').fadeOut(); }, 7000);
			$('#titreContenuPubNiveau2').html(titre);
			$('#contenuPubNiveau2').html(contenu);
		}
	});
	
}


function depublierDonneesSaisiesN2() {
	$('#dePublicationNiveau2').w2overlay({ html: "" +
		"" +
		"<div style='border-bottom:1px solid #49afcd; height: 30px; background: #f9f9f9; width: 180px; text-align:center; padding-top: 10px; font-size: 13px; color: #49afcd; font-weight: bold;'>Retrait de l'info</div>" +
		"<div style='height: 50px; width: 180px; padding-top:10px; text-align:center;'>" +
		"<button class='btn' style='cursor:pointer;' onclick='popupFermer(); return false;'>Non</button>" +
		"<button class='btn' style='cursor:pointer;' onclick='dePublierInfoN2(); return false;'>Oui</button>" +
		"</div>" +
		"" 
	});
}

function dePublierInfoN2() {
	var chemin = tabUrl[0]+'public/admin/depublier-publicite-n2';
	$.ajax({
		type: 'POST',
		url: chemin ,
		data: {},
		success: function() {    
			$('#titre').attr('disabled', false).css({'background': '#ffffff'});
			$('#contenu').attr('disabled', false).css({'background': '#ffffff'});
			$('#AffichageBoutonN2').html('<span id="infoPubN2" style="color: green; font-size: 15px; font-family: time new romans; ">' +
					                     'Info retir&eacute;e avec succ&egrave;s<!--img src=\''+tabUrl[0]+'public/img/tick_32.png\'--> </span>'+
					                     '<div style="float: right;">'+
					                     
					                     '<button class="PublicationNiveau2" style="cursor:pointer; height: 35px; width: 35px; background: transparent; border-radius: 50%; "  onclick="ajouterDonneesSaisiesN2(); return false;">'+ 
					                     '<img id="PublicationNiveau2" src=\''+tabUrl[0]+'public/img/article/Favorite64.png\'>'+
			                             '</button>'+
					                     
					                     '</div>');
			setTimeout(function(){ $('#infoPubN2').fadeOut(); }, 7000);
			$('#titreContenuPubNiveau2').html("");
			$('#contenuPubNiveau2').html("");
		}
	});
}