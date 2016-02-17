<?php
namespace Presentation\Form;

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
           		'placeholder' => 'Identifiant',
            	'required' => true,
            ),
        ));
		
        $this->add(array(
            'name' => 'email_personne',
            'attributes' => array(
                'type'  => 'email',
           		'placeholder' => 'E-mail',
            	'required' => true,
            ),
        ));	
		
        $this->add(array(
            'name' => 'mot_de_passe',
            'attributes' => array(
                'type'  => 'password',
           		'placeholder' => 'Mot de passe',
            	'required' => true,
            ),
        ));
		
        $this->add(array(
            'name' => 'confirmation_mot_de_passe',
            'attributes' => array(
                'type'  => 'password',
           		'placeholder' => 'Confirmation mot de passe',
            	'required' => true,
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