<?php
/**
 * File for Login Form Class
 *
 * @category  User
 * @package   User_Form
 * @author    Marco Neumann <webcoder_at_binware_dot_org>
 * @copyright Copyright (c) 2011, Marco Neumann
 * @license   http://binware.org/license/index/type:new-bsd New BSD License
 */

/**
 * @namespace
 */
namespace Maladie\Form;

/**
 * @uses Zend\Form\Form
 */
use Zend\Form\Form;

/**
 * Login Form Class
 *
 * Login Form
 *
 * @category  User
 * @package   User_Form
 * @copyright Copyright (c) 2011, Marco Neumann
 * @license   http://binware.org/license/index/type:new-bsd New BSD License
 */
class ArticleForm extends Form
{
    /**
     * Initialize Form
     */
	
	public function __construct($name = null)
	{
		// we want to ignore the name passed
		parent::__construct();
	
		$this->add(array(
				'name' => 'id',
				'type' => 'Hidden',
				'attributes' => array(
						'id' => 'id',
				),
		));
		
		
		$this->add(array(
				'name' => 'titre',
				'type' => 'Text',
				'options' => array (
						'label' => 'Titre'
				),
				'attributes' => array(
						'id' => 'titre',
						'required' => true,
						'maxlength' => '100',
						'size' => '60'
				),
		));
		
		$this->add(array(
				'name' => 'source',
				'type' => 'Text',
				'options' => array (
						'label' => 'Source'
				),
				'attributes' => array(
						'id' => 'source',
						'required' => true,
				),
		));
		
		$this->add(array(
				'name' => 'categorie',
				'type' => 'Zend\Form\Element\Select',
				'options' => array (
						'label' => iconv ( 'ISO-8859-1', 'UTF-8','Catégorie'),
						'value_options' => array(
								'' => '',
								'1' => iconv ( 'ISO-8859-1', 'UTF-8','Maladie') ,
								'2' => 'Divers',
						),
				),
				'attributes' => array(
						'id' => 'categorie',
						'required' => true,
				),
		));
		
		$this->add(array(
				'name' => 'description',
				'type' => 'TextArea',
				'options' => array (
						'label' => 'Description'
				),
				'attributes' => array(
						'id' => 'description',
						'required' => true,
				),
		));
		
		$this->add(array(
				'name' => 'article',
				'type' => 'Hidden',
				'attributes' => array(
						'id' => 'article',
				),
		));
		
	}
}
