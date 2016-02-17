    var nb="_TOTAL_";
    var asInitVals = new Array();
    var base_url = window.location.toString();
	var tabUrl = base_url.split("public");
	//BOITE DE DIALOG POUR LA CONFIRMATION DE SUPPRESSION
    function confirmation(id){
	  $( "#confirmation" ).dialog({
	    resizable: false,
	    height:170,
	    width:485,
	    autoOpen: false,
	    modal: true,
	    buttons: {
	        "Oui": function() {
	            $( this ).dialog( "close" );
	            
	            var cle = id;
	            var chemin = tabUrl[0]+'public/facturation/supprimer';
	            $.ajax({
	                type: 'POST',
	                url: chemin ,
	                data: $(this).serialize(),  
	                data:'id='+cle,
	                success: function(data) {
	                	     var result = jQuery.parseJSON(data);  
	                	     nb = result;
	                	     $("#"+cle).parent().parent().fadeOut(function(){
		                	 	 $("#"+cle).empty();
		                	    	 //vart=tabUrl[0]+'public/facturation/liste-patient';
			                         //$(location).attr("href",vart);
		                	 });
	                },
	                error:function(e){console.log(e);alert("Une erreur interne est survenue!");},
	                dataType: "html"
	            });
	    	    // return false;
	        },
	        "Annuler": function() {
                $(this).dialog( "close" );
            }
	   }
	  });
    }
    
    function envoyer(id){
     //e.preventDefault();
   	 confirmation(id);
     $("#confirmation").dialog('open');
   	}
    
   
    /**********************************************************************************/
    
       
    
    function initialisation(){
    var oTable = $('#personne').dataTable
    ( {
    					"sPaginationType": "full_numbers",
    					"aLengthMenu": [5,7,10,15],
    					"aaSorting": [], //On ne trie pas la liste automatiquement
    					"oLanguage": {
    						"sInfo": "_START_ &agrave; _END_ sur _TOTAL_ &eacute;l&eacute;ments",
    						"sInfoEmpty": "0 &eacute;l&eacute;ment &agrave; afficher",
    						"sInfoFiltered": "",
    						"sUrl": "",
    						"oPaginate": {
    							"sFirst":    "|<",
    							"sPrevious": "<",
    							"sNext":     ">",
    							"sLast":     ">|"
    							}
    					   },

    					   "sAjaxSource": ""+tabUrl[0]+"public/auth/get-liste-personne", 

    } );
    	
     var asInitVals = new Array();
	
	//le filtre du select
	$('#filter_statut').change(function() 
	{					
		oTable.fnFilter( this.value );
	});
	
	$("tfoot input").keyup( function () {
		/* Filter on the column (the index) of this element */
		oTable.fnFilter( this.value, $("tfoot input").index(this) );
	} );
	
	/*
	 * Support functions to provide a little bit of 'user friendlyness' to the textboxes in 
	 * the footer
	 */
	$("tfoot input").each( function (i) {
		asInitVals[i] = this.value;
	} );
	
	$("tfoot input").focus( function () {
		if ( this.className == "search_init" )
		{
			this.className = "";
			this.value = "";
		}
	} );
	
	$("tfoot input").blur( function (i) {
		if ( this.value == "" )
		{
			this.className = "search_init";
			this.value = asInitVals[$("tfoot input").index(this)];
		}
	} );
	
	
    }
    
    function visualiser (id){
    	$.ajax({
            type: 'POST',
            url: tabUrl[0]+'public/auth/info-patient',
            data:'id='+id,
            success: function(data) {    
            	    var result = jQuery.parseJSON(data);  
            	    result+='<style> .w2ui-overlay{ margin-left:-600px; margin-right:500px; } </style>';
               	    $('#vue-'+id).w2overlay({ html: result});
            	       
            },
            error:function(e){console.log(e);alert("Une erreur interne est survenue!");},
            dataType: "html"
        });
    }
    
    function modifier (id){
    	
    	$('#modifier-'+id).w2overlay({ html: "" +
    			"" +
    			"<div style='border-bottom:1px solid #49afcd; height: 30px; background: #f9f9f9; width: 200px; text-align:center; padding-top: 10px; font-size: 14px; color: #49afcd; font-weight: bold;'>Choix du formulaire</div>" +
    			"<div style='height: 50px; width: 200px; padding-top:10px; text-align:center;'>" +
    			"<button class='btn' onclick='formulaireClassique("+id+"); return false;'>Classique</button>" +
    			"<button class='btn' onclick='formulairePopup("+id+"); return false;'>Pop-up</button>" +
    			"</div>" +
    			"" 
    			});

    }
    
    function formulairePopup (id){
    	
    	$.ajax({
            type: 'POST',
            url: tabUrl[0]+'public/auth/modifier-donnees-popup',
            data:'id='+id,
            success: function(data) {    
            	    var result = jQuery.parseJSON(data); 
            	     
            	   
            	    $('#Popup-Modification-Donner').empty().html(result);
            	    $('#popupModification').w2popup();
            	       
            },
            error:function(e){console.log(e);alert("Une erreur interne est survenue!");},
            dataType: "html"
        });
    	
    }
    
    function formulaireClassique (id){
    	vart=tabUrl[0]+'public/auth/modifier-donnees-classique/val/'+id;
        $(location).attr("href",vart);
    }
    
    function scriptControleSaisi (){
    	//EMPECHER LA TOUCHE ENTREE DE SOUMETTRE LE FORMULAIRE 
		setTimeout(function(){ alert('c bon');
          $('#telephone').focus(function(event) { alert('c bon');
            if (event.keyCode == 13) { alert('c bon');
              return false;
            }
          }); 
		
		}, 2000);
    }

    
    function supprimer (id){
    	$('#supprimer-'+id).w2overlay({ html: "" +
			"" +
			"<div style='border-bottom:1px solid #49afcd; height: 30px; background: #f9f9f9; width: 200px; text-align:center; padding-top: 10px; font-size: 13px; color: #49afcd; font-weight: bold;'>Confirmer la suppression</div>" +
			"<div style='height: 50px; width: 200px; padding-top:10px; text-align:center;'>" +
			"<button class='btn' onclick='popupFermer(); return false;'>Annuler</button>" +
			"<button class='btn' onclick='suppression("+id+"); return false;'>Supprimer</button>" +
			"</div>" +
			"" 
			
    	});
    }
    
    function popupFermer() {
    	$(null).w2overlay(null);
    }
    
    function suppression(id) {
    	$(null).w2overlay(null);
    	$.ajax({
            type: 'POST',
            url: tabUrl[0]+'public/auth/supprimer-utilisateur',
            data:'id='+id,
            success: function() {    
            	   
            	    $("#supprimer-"+id).parent().parent().parent().fadeOut(function(){
            	    	vart=tabUrl[0]+'public/auth/admin';
            	        $(location).attr("href",vart);
            	    });
            	       
            },
            error:function(e){console.log(e);alert("Une erreur interne est survenue!");},
            dataType: "html"
        });
    }
    
    