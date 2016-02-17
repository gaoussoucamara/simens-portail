<?php
return array(
    'acl' => array(
    		
        'roles' => array(
        		'guest'   => null,
        		
        		'standard' => 'guest',
        		'administrateur' => 'guest',
        		'super-administrateur' => 'administrateur',
        		
        		'redacteur' => 'guest',
        		'moderateur' => 'guest',
        ),
    		
        
    		'resources' => array(
    		
    				'allow' => array(
    						
    						/***
    						 * ActualiteController
    						***/
    						'Actualite\Controller\Actualite' => array(
    						
    								'actualite' => 'guest',
    								'details-article' => 'guest',
    								'details-actualite' => 'guest',
    								
    								
    								'nouvelle-actualite' => 'moderateur',
    								'enregistrer-actualite' => 'moderateur',
    								'liste-actualite' => 'moderateur',
    								'get-liste-actualite' => 'moderateur',
    								'zoomer-image-liste' => 'moderateur',
    								'modification-actualite' => 'moderateur',
    								'enregistrer-modification-actualite' => 'moderateur',
    								'publication-actualite' => 'moderateur',
    								'depublication-actualite' => 'moderateur',
    						),
    		
    						 /***
    						 * AdminController
    		                 ***/
    						'Admin\Controller\Admin' => array(
    								'parametrage' => 'administrateur',
    								'enregistrement-image' => 'administrateur',
    								'raffraichissement-liste-images' => 'administrateur',
    								'marquer-image-publier' => 'administrateur',
    								'supprimer-image' => 'administrateur',
    								'modifier-image' => 'administrateur',
    								'modifier-contenu-image' => 'administrateur',
    								'liste-images-defilantes' => 'administrateur',
    								'recuperer-image-a-supprimer' => 'administrateur',
    								'supprimer-image-defilante' => 'administrateur',
    								'recuperer-image-a-modifier' => 'administrateur',
    								'valider-modification-image' => 'administrateur',
    								'activer-image-defilante' => 'administrateur',
    								'desactiver-image-defilante' => 'administrateur',
    								'image-a-ajouter' => 'administrateur',
    								'valider-ajout-image' => 'administrateur',
    								'raffraichir-images-defilantes-en-tete' => 'administrateur',
    								'ajouter-publicite-n2' => 'administrateur',
    								'depublier-publicite-n2' => 'administrateur',
    						),
    						
    						/***
    						 * MaladieController
    						***/
    						'Maladie\Controller\Maladie' => array(
    								
    								'maladie' => 'guest',
    								'get-liste-articles-maladies' => 'guest',
    								'zoomer-image-liste' => 'guest',
    								
    								'redaction-article' => array('redacteur','administrateur'),
    								'enregistrer-article' => array('redacteur','administrateur'),
    								'liste-article' => array('redacteur','administrateur'),
    								'get-liste-article' => array('redacteur','administrateur'),
    								'modification-article' => array('redacteur','moderateur','administrateur'),
    								'enregistrer-modification-article' => array('redacteur','moderateur','administrateur'),
    								'soumission-article' => array('redacteur','administrateur'),
    								'dessoumission-article' => array('redacteur','administrateur'),
    								
    								'liste-article-soumis' => 'moderateur',
    								'get-liste-article-soumis' => 'moderateur',
    								'publication-article' => 'moderateur',
    								'depublication-article' => 'moderateur',
    									
    						),
    						
    						/***
    						 * PresentationController
    						***/
    						'Presentation\Controller\Presentation' => array(
    								
    								'resume' => 'guest',
    								'financement' => 'guest',
    								'contributeurs' => 'guest',
    								'partenaires' => 'guest',
    								'contact' => 'guest',
    						),
    						
    						/***
    						 * AuthController
    						***/
    						'Auth\Controller\Auth' => array(
    						
    								'login' => 'guest',
    								'logout' => 'guest',
    								'inscription' => 'guest',
    								'verifier-email' => 'guest',
    								'inscrit' => 'guest',
    								'bienvenue' => 'guest',
    								
    								'admin' => 'administrateur',
    								'get-liste-personne' => 'administrateur',
    								'info-patient' => 'administrateur',
    								
    								'nouveau-profil' => 'super-administrateur',
    								'modifier-donnees-popup' => 'super-administrateur',
    								'modifier-donnees-classique' => 'super-administrateur',
    								'enregistrer-modification' => 'super-administrateur',
    								'enregistrer-modification-popup' => 'super-administrateur',
    								'supprimer-utilisateur' => 'super-administrateur',
    								
    								'standard' => 'standard',
    								
    								'redacteur' => 'redacteur',
    								
    								'moderateur' => 'moderateur',
    								
    								'administrateur' => 'administrateur',
    								
    								'super-administrateur' => 'super-administrateur',
    						),
    						
    		
    				),
    		
    		
    		
    		),
    		

    		
    		
    )
);