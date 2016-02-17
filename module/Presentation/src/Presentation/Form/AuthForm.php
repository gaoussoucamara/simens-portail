<?php
namespace Presentation\Form;

use Zend\Form\Form;

class AuthForm extends Form
{
    public function __construct($name = null)
    {
        parent::__construct('auth');
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
            'name' => 'mot_de_passe',
            'attributes' => array(
                'type'  => 'password',
           		'placeholder' => 'Mot de passe',
           		'required' => true,
            ),
        ));
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
    }
}