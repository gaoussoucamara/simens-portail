<?php
namespace Auth\Form;

use Zend\Form\Form;

class ProfileModificationForm extends Form 
{
    public function __construct($name = null)
    {
        parent::__construct('auth');
        $this->setAttribute('method', 'post');
        
        $this->add(array(
        		'name' => 'id_personne',
        		'attributes' => array(
        				'type'  => 'Zend\Form\Element\hidden',
        				'id' => 'id_personne',
        		),
        ));

        $this->add ( array (
        		'name' => 'genre',
        		'type' => 'Zend\Form\Element\Select',
        		'options' => array (
    				 	'value_options' => array (
    				 			''=>'',
    				 			'Feminin' => iconv ( 'ISO-8859-1', 'UTF-8', 'Féminin' ),
    				 			'Masculin' => 'Masculin',
    				 	),
        				'label' => 'Genre *'
        		),
        		'attributes' => array (
        				'id' => 'genre',
        				'required' => true,
        		)
        ) );
        
        $this->add(array(
        		'name' => 'nom_de_famille',
        		'options' => array (
        				'label' => 'Nom de famille *'
        		),
        		'attributes' => array(
        				'type'  => 'text',
        				'required' => true,
        		),
        ));
        
        $this->add(array(
        		'name' => 'prenom',
        		'options' => array (
        				'label' => iconv ( 'ISO-8859-1', 'UTF-8', 'Prénom *' ),
        		),
        		'attributes' => array(
        				'type'  => 'text',
        				'required' => true,
        		),
        ));
        
        $this->add(array(
        		'name' => 'email_personne',
        		'options' => array (
        				'label' => 'E-mail *'
        		),
        		'attributes' => array(
        				'type'  => 'email',
        				'placeholder' => 'mail@domain.com',
        				'required' => true,
        		),
        ));
        
        $this->add(array(
            'name' => 'pseudo',
        	'options' => array (
        			'label' => 'Pseudo *'
        	),
            'attributes' => array(
            	'id' => 'pseudo',
                'type'  => 'text',
            	'required' => true,
           		'oninput' => 'verifPseudo(this)'
            ),
        ));
        
        $this->add(array(
        		'name' => 'pseudo_tempo',
        		'options' => array (
        				'label' => 'Pseudo *'
        		),
        		'attributes' => array(
        				'id' => 'pseudo_tempo',
        				'readonly' => true,
        				'type'  => 'text',
        		),
        ));
        
        /****=====******** ======= ========= ********=====***/
        /****=====******** ======= ========= ********=====***/
        /****=====******** ======= ========= ********=====***/
        $this->add(array(
            'name' => 'ancien_mot_de_passe',
        	'options' => array (
        			'label' => 'Ancien mot de passe *'
        	),
            'attributes' => array(
                'type'  => 'password',
           		//'required' => true,
            ),
        ));
        
        $this->add(array(
        		'name' => 'nouveau_mot_de_passe',
        		'options' => array (
        				'label' => 'Mot de passe *'
        		),
        		'attributes' => array(
        				'type'  => 'password',
        				'id' => 'nouveau_mot_de_passe',
        				'required' => true,
        				'oninput' => 'check(this)'
        		),
        ));
        
        $this->add(array(
        		'name' => 'confirm_mot_de_passe',
        		'type'  => 'password',
        		'options' => array (
        				'label' => 'Confirmation du mot de passe *'
        		),
        		'attributes' => array(
        				'id' => 'confirm_mot_de_passe',
        				'required' => true,
        				'oninput' => 'check2(this)'
        		),
        ));
        
        /****=====******** ======= ========= ********=====***/
        /****=====******** ======= ========= ********=====***/
        /****=====******** ======= ========= ********=====***/
        $this->add(array(
        		'name' => 'statut',
        		'options' => array (
        				'label' => iconv ( 'ISO-8859-1', 'UTF-8', 'Votre statut, grade ou poste occupé')
        		),
        		'attributes' => array(
        				'type'  => 'text',
        		),
        ));
        
        $this->add(array(
        		'name' => 'adresse',
        		'options' => array (
        				'label' => iconv ( 'ISO-8859-1', 'UTF-8', 'Adresse personnelle ou professionnelle')
        		),
        		'attributes' => array(
        				'type'  => 'text',
        		),
        ));
        
        $this->add(array(
        		'name' => 'telephone',
        		'options' => array (
        				'label' => iconv ( 'ISO-8859-1', 'UTF-8', 'Téléphone')
        		),
        		'attributes' => array(
        				'type'  => 'text',
        				'id'  => 'telephone',
        				'pattern' => '[0-9]{2} [0-9]{3} [0-9]{2} [0-9]{2}',
        				 'title' => '99 999 99 99'
        		),
        ));
        
        $this->add(array(
        		'name' => 'site_web',
        		'options' => array (
        				'label' => iconv ( 'ISO-8859-1', 'UTF-8', 'Site web')
        		),
        		'attributes' => array(
        				'type'  => 'text',
        				'pattern'  => '^http:\/\/(.*)$',
        				'placeholder' => 'http://',
        		),
        ));
        
        $this->add ( array (
        		'name' => 'role',
        		'type' => 'Zend\Form\Element\Select',
        		'options' => array (
        				'value_options' => array (
        						'standard'=> iconv ( 'ISO-8859-1', 'UTF-8', 'Standard (Par défaut)' ),
        						'redacteur' => iconv ( 'ISO-8859-1', 'UTF-8', 'Rédacteur' ),
        						'moderateur' => iconv ( 'ISO-8859-1', 'UTF-8', 'Modérateur' ),
        						'administrateur' => iconv ( 'ISO-8859-1', 'UTF-8', 'Administrateur' ),
        				),
        				'label' => iconv ( 'ISO-8859-1', 'UTF-8', 'Rôle *'),
        		),
        		'attributes' => array (
        				'id' => 'role',
        				'required' => true,
        		)
        ) );
        
        $this->add(array(
            'name' => 'sesouvenirdemoi',
			'type' => 'checkbox', 
            'options' => array(
                'label' => 'Se souvenir de moi?',
            ),
        ));			
        $this->add(array(
            'name' => 'submit',
       		'type'  => 'button',
            'attributes' => array(
                'value' => 'Connexion',
                'id' => 'submitbutton',
            ),
        )); 
        
        //Pour la modification
        $this->add(array(
        		'name' => 'button',
        		'type'  => 'button',
        		'attributes' => array(
        				'value' => 'Fermer',
        				'class' => 'btn',
        				
        				'registerInArrrayValidator' => false,
        				'onclick' => 'w2popup.close()',
        		),
        ));
    }
    
}