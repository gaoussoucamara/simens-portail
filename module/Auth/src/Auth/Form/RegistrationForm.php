<?php
namespace Auth\Form;

use Zend\Form\Form;

class RegistrationForm extends Form
{
    public function __construct($name = null)
    {
        parent::__construct('registration');
        $this->setAttribute('method', 'post');

        $this->add(array(
            'name' => 'pseudo',
            'attributes' => array(
                'type'  => 'text',
           		'placeholder' => 'Pseudo',
            	'required' => true,
            	'id' => 'pseudo',
           		'oninput' => 'verifPseudo(this)'
            ),
        ));
		
        $this->add(array(
            'name' => 'email_personne',
            'attributes' => array(
                'type'  => 'email',
                'maxlength'  => '50',
           		'placeholder' => 'E-mail',
            	'required' => true,
           		'id' => 'email_personne',
           		'oninput' => 'verifEmail(this)'
            ),
        ));	
		
        $this->add(array(
            'name' => 'nouveau_mot_de_passe',
            'attributes' => array(
                'type'  => 'password',
           		'minlength'  => '6',
           		'placeholder' => 'Mot de passe',
            	'required' => true,
            	'id' => 'nouveau_mot_de_passe',
           		'oninput' => 'check(this)'
            ),
        ));
		
        $this->add(array(
            'name' => 'confirm_mot_de_passe',
            'attributes' => array(
                'type'  => 'password',
           		'placeholder' => 'Confirmation mot de passe',
            	'required' => true,
            	'id' => 'confirm_mot_de_passe',
           		'oninput' => 'check2(this)'
            ),
        ));	

        $this->add(array(
            'name' => 'submit',
            'attributes' => array(
                'type'  => 'submit',
                'value' => 'Enregistrer',
                'id' => 'submitbutton',
            ),
        )); 
    }
}