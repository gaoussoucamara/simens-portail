<?php

namespace Auth\Form;

use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;

/**
 * Classe exemple d'implémentation de InputFilterAwareInterface
 *
 * @author Bidoum
 */
// class Validateur implements InputFilterAwareInterface
// {
// 	/**
// 	 * @var InputFilter
// 	 */
// 	public $nouveau_mot_de_passe;
// 	protected $_inputFilter;


// 	public function exchangeArray($data)
// 	{
// 		$this->nouveau_mot_de_passe = (isset($data['nouveau_mot_de_passe'])) ? $data['nouveau_mot_de_passe'] : null;
// 	}
	
	
// 	/**
// 	 * Définit les filtres
// 	 * Non utilisé
// 	 * @param InputFilterInterface $inputFilter
// 	 * @throws \Exception
// 	 */
// 	public function setInputFilter(InputFilterInterface $inputFilter)
// 	{
// 		throw new \Exception("Not used");
// 	}
	 
	/**
	 * Obtient les filtres de contenu
	 * @return \Zend\InputFilter\InputFilter
	 */
// 	public function getInputFilter()
// 	{
// 		if (!$this->_inputFilter) {
// 			$inputFilter = new InputFilter();
			 
// 			$inputFilter->add(array(
// 					'name' => 'nouveau_mot_de_passe',
// 					'required' => true,
// 					'filters'  => array(

// 							array('name' => 'Zend\Filter\StripTags'),
// 							array('name' => 'Zend\Filter\StringTrim'),
// 					),
// 					'validators' => array(
// 							array(
// 									'name' => 'Zend\Validator\StringLength',
// 									'options' => array(
// 											'encoding' => 'UTF-8',
// 											'min' => 5,
// 											'max' => 63,
// 									),
// 								),
    					
// 				    ),
// 			));
			 
// 			$this->_inputFilter = $inputFilter;
// 		}
		 
// 		return $this->_inputFilter;
// 	}
// }