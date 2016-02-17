<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Presentation\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Presentation\Model\Contributeur\Contributeur;
use Presentation\Model\Contributeur\ContributeurTable;
use Presentation\Form\AuthForm;
use Presentation\Form\RegistrationForm;

class PresentationController extends AbstractActionController
{
	protected $contributeurTable;
	protected $partenaireTable;
	
	public function getContributeurTable()
	{
		if (!$this->contributeurTable) {
			$sm = $this->getServiceLocator();
			$this->contributeurTable = $sm->get('Presentation\Model\Contributeur\ContributeurTable');
		}
		return $this->contributeurTable;
	}
	
	public function getPartenaireTable()
	{
		if (!$this->partenaireTable) {
			$sm = $this->getServiceLocator();
			$this->partenaireTable = $sm->get('Presentation\Model\Partenaire\PartenaireTable');
		}
		return $this->partenaireTable;
	}
	
    public function resumeAction()
    {
    	// Get the "layout" view model and set an alternate template
     	$layout = $this->layout();
     	$layout->setTemplate('layout/presentationlayout');
    	
     	$outilsutilisateurs = new ViewModel();
     	$outilsutilisateurs->setTemplate('layout/outilsutilisateurslayout');
     	
     	$blogrightsidebar = new ViewModel();
     	$blogrightsidebar->setTemplate('layout/blogrightsidebarlayout');
     	
     	$recherche = new ViewModel();
     	$recherche->setTemplate('layout/recherchelayout');
     	$motscles = new ViewModel();
     	$motscles->setTemplate('layout/motscleslayout');
     	$textwidget = new ViewModel();
     	$textwidget->setTemplate('layout/textwidgetlayout');
     	$pub = new ViewModel();
     	$pub->setTemplate('layout/publayout');
     	$horloge = new ViewModel();
     	$horloge->setTemplate('layout/horlogelayout');
     	
     	$blogrightsidebar->addChild($recherche, 'recherche');
     	$blogrightsidebar->addChild($motscles, 'motscles');
     	$blogrightsidebar->addChild($textwidget, 'textwidget');
     	$blogrightsidebar->addChild($pub, 'pub');
     	$blogrightsidebar->addChild($horloge, 'horloge');
     	
     	$blogfooter = new ViewModel();
     	$blogfooter->setTemplate('layout/blogfooterlayout');
     	
     	$archive = new ViewModel();
     	$archive->setTemplate('layout/archivelayout');
     	
     	$categorie = new ViewModel();
     	$categorie->setTemplate('layout/categorielayout');
     	
     	$contact = new ViewModel();
     	$contact->setTemplate('layout/contactlayout');
     	
     	$blogfooter->addChild($archive, 'archive');
     	$blogfooter->addChild($categorie, 'categorie');
     	$blogfooter->addChild($contact, 'contact');
     	
     	$layout->addChild($outilsutilisateurs, 'outilsutilisateurs');
     	$layout->addChild($blogrightsidebar, 'blogrightsidebar');
     	$layout->addChild($blogfooter, 'blogfooter');
     	
    	// Create and return a view model for the retrieved article
    	$view = new ViewModel(array('headtitle' => 'Système d\'Information MEdical National pour le Sénégal (SIMENS)', 'subheadtitle' => 'Résumé du projet'));
    	return $view;
    }
    public function financementAction()
    {
    	// // Get the "layout" view model and set an alternate template
     	$layout = $this->layout();
     	$layout->setTemplate('layout/presentationlayout');
    	
     	$outilsutilisateurs = new ViewModel();
     	$outilsutilisateurs->setTemplate('layout/outilsutilisateurslayout');
     	
     	$blogrightsidebar = new ViewModel();
     	$blogrightsidebar->setTemplate('layout/blogrightsidebarlayout');
     	
     	$recherche = new ViewModel();
     	$recherche->setTemplate('layout/recherchelayout');
     	$motscles = new ViewModel();
     	$motscles->setTemplate('layout/motscleslayout');
     	$textwidget = new ViewModel();
     	$textwidget->setTemplate('layout/textwidgetlayout');
     	$pub = new ViewModel();
     	$pub->setTemplate('layout/publayout');
     	$horloge = new ViewModel();
     	$horloge->setTemplate('layout/horlogelayout');
     	
     	$blogrightsidebar->addChild($recherche, 'recherche');
     	$blogrightsidebar->addChild($motscles, 'motscles');
     	$blogrightsidebar->addChild($textwidget, 'textwidget');
     	$blogrightsidebar->addChild($pub, 'pub');
     	$blogrightsidebar->addChild($horloge, 'horloge');
     	
     	$blogfooter = new ViewModel();
     	$blogfooter->setTemplate('layout/blogfooterlayout');
     	
     	$archive = new ViewModel();
     	$archive->setTemplate('layout/archivelayout');
     	
     	$categorie = new ViewModel();
     	$categorie->setTemplate('layout/categorielayout');
     	
     	$contact = new ViewModel();
     	$contact->setTemplate('layout/contactlayout');
     	
     	$blogfooter->addChild($archive, 'archive');
     	$blogfooter->addChild($categorie, 'categorie');
     	$blogfooter->addChild($contact, 'contact');
     	
     	$layout->addChild($outilsutilisateurs, 'outilsutilisateurs');
     	$layout->addChild($blogrightsidebar, 'blogrightsidebar');
     	$layout->addChild($blogfooter, 'blogfooter');
     	     	
    	// Create and return a view model for the retrieved article
    	$view = new ViewModel(array('headtitle' => 'Système d\'Information MEdical National pour le Sénégal (SIMENS)', 'subheadtitle' => 'Financement du projet'));
    	return $view;
    }
    public function contributeursAction()
    {
    	// Get the "layout" view model and set an alternate template
     	$layout = $this->layout();
     	$layout->setTemplate('layout/presentationlayout');
    	
     	
     	$outilsutilisateurs = new ViewModel();
     	$outilsutilisateurs->setTemplate('layout/outilsutilisateurslayout');
     	
     	$blogrightsidebar = new ViewModel();
     	$blogrightsidebar->setTemplate('layout/blogrightsidebarlayout');
     	
     	$recherche = new ViewModel();
     	$recherche->setTemplate('layout/recherchelayout');
     	$motscles = new ViewModel();
     	$motscles->setTemplate('layout/motscleslayout');
     	$textwidget = new ViewModel();
     	$textwidget->setTemplate('layout/textwidgetlayout');
     	$pub = new ViewModel();
     	$pub->setTemplate('layout/publayout');
     	$horloge = new ViewModel();
     	$horloge->setTemplate('layout/horlogelayout');
     	
     	$blogrightsidebar->addChild($recherche, 'recherche');
     	$blogrightsidebar->addChild($motscles, 'motscles');
     	$blogrightsidebar->addChild($textwidget, 'textwidget');
     	$blogrightsidebar->addChild($pub, 'pub');
     	$blogrightsidebar->addChild($horloge, 'horloge');
     	
     	$blogfooter = new ViewModel();
     	$blogfooter->setTemplate('layout/blogfooterlayout');
     	
     	$archive = new ViewModel();
     	$archive->setTemplate('layout/archivelayout');
     	
     	$categorie = new ViewModel();
     	$categorie->setTemplate('layout/categorielayout');
     	
     	$contact = new ViewModel();
     	$contact->setTemplate('layout/contactlayout');
     	
     	$blogfooter->addChild($archive, 'archive');
     	$blogfooter->addChild($categorie, 'categorie');
     	$blogfooter->addChild($contact, 'contact');
     	
     	$layout->addChild($outilsutilisateurs, 'outilsutilisateurs');
     	$layout->addChild($blogrightsidebar, 'blogrightsidebar');
     	$layout->addChild($blogfooter, 'blogfooter');
    	
     	$resultat = $this->getContributeurTable()->fetchAll();
     	$i = 0;
     	$j = 0;
     	$tableau = array(array());
     	foreach ($resultat as $result){
     		
     		$tableau[$i][] = $result;
     		$j++;
     		if($j == 4){
     			$i++;
     			$j = 0; 
     		}
     	}
     	
    	$view = new ViewModel(
    			array('contributeurs' => $tableau, 
    					'headtitle' => 'Système d\'Information MEdical National pour le Sénégal (SIMENS)', 'subheadtitle' => 'Les contributeurs au projet')
    	);
    	return $view;
    }
    public function partenairesAction()
    {
    	// // Get the "layout" view model and set an alternate template
     	$layout = $this->layout();
     	$layout->setTemplate('layout/presentationlayout');
    	
     	$outilsutilisateurs = new ViewModel();
     	$outilsutilisateurs->setTemplate('layout/outilsutilisateurslayout');
     	
     	$blogrightsidebar = new ViewModel();
     	$blogrightsidebar->setTemplate('layout/blogrightsidebarlayout');
     	
     	$recherche = new ViewModel();
     	$recherche->setTemplate('layout/recherchelayout');
     	$motscles = new ViewModel();
     	$motscles->setTemplate('layout/motscleslayout');
     	$textwidget = new ViewModel();
     	$textwidget->setTemplate('layout/textwidgetlayout');
     	$pub = new ViewModel();
     	$pub->setTemplate('layout/publayout');
     	$horloge = new ViewModel();
     	$horloge->setTemplate('layout/horlogelayout');
     	
     	$blogrightsidebar->addChild($recherche, 'recherche');
     	$blogrightsidebar->addChild($motscles, 'motscles');
     	$blogrightsidebar->addChild($textwidget, 'textwidget');
     	$blogrightsidebar->addChild($pub, 'pub');
     	$blogrightsidebar->addChild($horloge, 'horloge');
     	
     	$blogfooter = new ViewModel();
     	$blogfooter->setTemplate('layout/blogfooterlayout');
     	
     	$archive = new ViewModel();
     	$archive->setTemplate('layout/archivelayout');
     	
     	$categorie = new ViewModel();
     	$categorie->setTemplate('layout/categorielayout');
     	
     	$contact = new ViewModel();
     	$contact->setTemplate('layout/contactlayout');
     	
     	$blogfooter->addChild($archive, 'archive');
     	$blogfooter->addChild($categorie, 'categorie');
     	$blogfooter->addChild($contact, 'contact');
     	
     	$layout->addChild($outilsutilisateurs, 'outilsutilisateurs');
     	$layout->addChild($blogrightsidebar, 'blogrightsidebar');
     	$layout->addChild($blogfooter, 'blogfooter');    	
     	
    	$view = new ViewModel(array('partenaires' => $this->getPartenaireTable()->fetchAll(), 'headtitle' => 'Système d\'Information MEdical National pour le Sénégal (SIMENS)', 'subheadtitle' => 'Les partenaires du projet'));
    	return $view;
    }
    public function contactAction()
    {
    	// // Get the "layout" view model and set an alternate template
     	$layout = $this->layout();
     	$layout->setTemplate('layout/presentationlayout');
    	
     	$outilsutilisateurs = new ViewModel();
     	$outilsutilisateurs->setTemplate('layout/outilsutilisateurslayout');
     	
     	$blogrightsidebar = new ViewModel();
     	$blogrightsidebar->setTemplate('layout/blogrightsidebarlayout');
     	
     	$recherche = new ViewModel();
     	$recherche->setTemplate('layout/recherchelayout');
     	$motscles = new ViewModel();
     	$motscles->setTemplate('layout/motscleslayout');
     	$textwidget = new ViewModel();
     	$textwidget->setTemplate('layout/textwidgetlayout');
     	$pub = new ViewModel();
     	$pub->setTemplate('layout/publayout');
     	$horloge = new ViewModel();
     	$horloge->setTemplate('layout/horlogelayout');
     	
     	$blogrightsidebar->addChild($recherche, 'recherche');
     	$blogrightsidebar->addChild($motscles, 'motscles');
     	$blogrightsidebar->addChild($textwidget, 'textwidget');
     	$blogrightsidebar->addChild($pub, 'pub');
     	$blogrightsidebar->addChild($horloge, 'horloge');
     	
     	$blogfooter = new ViewModel();
     	$blogfooter->setTemplate('layout/blogfooterlayout');
     	
     	$archive = new ViewModel();
     	$archive->setTemplate('layout/archivelayout');
     	
     	$categorie = new ViewModel();
     	$categorie->setTemplate('layout/categorielayout');
     	
     	$contact = new ViewModel();
     	$contact->setTemplate('layout/contactlayout');
     	
     	$blogfooter->addChild($archive, 'archive');
     	$blogfooter->addChild($categorie, 'categorie');
     	$blogfooter->addChild($contact, 'contact');
     	
     	$layout->addChild($outilsutilisateurs, 'outilsutilisateurs');
     	$layout->addChild($blogrightsidebar, 'blogrightsidebar');
     	$layout->addChild($blogfooter, 'blogfooter');
     	
    	// Create and return a view model for the retrieved article
    	$view = new ViewModel(array('headtitle' => 'Système d\'Information MEdical National pour le Sénégal (SIMENS)', 'subheadtitle' => 'Pour nous contacter ... '));
    	return $view;
    }
    
}