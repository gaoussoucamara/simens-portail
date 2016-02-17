<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Auth\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Auth\Form\AuthForm;
use Auth\Form\RegistrationForm;
use Zend\Json\Json;
use Auth\Form\ProfileForm;
use Auth\View\Helper\DateHelper;
use Zend\Form\View\Helper\FormRow;
use Zend\Form\View\Helper\FormSelect;
use Zend\Form\View\Helper\FormText;
use Zend\Form\View\Helper\FormHidden;
use Zend\Form\View\Helper\FormButton;
use Zend\Form\View\Helper\FormSubmit;
use Auth\Form\ProfileModificationForm;
use Zend\Form\View\Helper\FormPassword;

class AuthController extends AbstractActionController
{
	protected $personneTable;
	protected $dateHelper;
	
	public function getPersonneTable()
	{
		if (!$this->personneTable) {
			$sm = $this->getServiceLocator();
			$this->personneTable = $sm->get('Auth\Model\PersonneTable');
		}
		return $this->personneTable;
	}
	
	Public function getDateHelper(){
		$this->dateHelper = new DateHelper();
	}
	
	public function verifierEmailAction()
	{
		$email_personne = $this->params()->fromPost('email_personne');
		
		$personne = $this->getPersonneTable()->getPersonne($email_personne);
		
		$resultComparer = 0;
		if($personne) {
			$resultComparer = 1;
		}
		 
		$this->getResponse ()->getHeaders ()->addHeaderLine ( 'Content-Type', 'application/html; charset=utf-8' );
		return $this->getResponse ()->setContent ( Json::encode ($resultComparer) );
	}
	
	public function inscritAction()
	{
		// // Get the "layout" view model and set an alternate template
		$layout = $this->layout();
		$layout->setTemplate('layout/authlayout');
		
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
		
		$blogrightsidebar->addChild($recherche, 'recherche');
		$blogrightsidebar->addChild($motscles, 'motscles');
		$blogrightsidebar->addChild($textwidget, 'textwidget');
		$blogrightsidebar->addChild($pub, 'pub');
		
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
		return new ViewModel(array('messages' => null, 'headtitle' => 'Système d\'Information MEdical National pour le Sénégal (SIMENS)', 'subheadtitle' => 'Connexion'));
		 
	}
	
    public function loginAction()
    {
    	$form = new AuthForm();
    	$form2 = new RegistrationForm();
    	
    	if ($this->identity()) {
    		return $this->redirect()->toRoute('auth', array('action' => 'bienvenue'));
    	}
    	 
    	//Envoyer en POST
    	$request = $this->getRequest();
    	if ($request->isPost()) { 
    		$data = $request->getPost();
    		if ($data) {
    			/*--------------------------*/
    			if($data->pseudo && $data->email_personne){
    				//var_dump($data); exit();
    				$this->getPersonneTable()->addUtilisateur($data);
    				return $this->redirect()->toRoute('auth' , array('action' => 'inscrit'));
    			}else {
    				
    				$uAuth = $this->getServiceLocator()->get('Admin\Controller\Plugin\UserAuthentication'); //@todo - We must use PluginLoader $this->userAuthentication()!!
    				$authAdapter = $uAuth->getAuthAdapter();
    				
    				$pseudo = $request->getPost ( 'pseudo' );
    				$mot_de_passe = $request->getPost ( 'mot_de_passe' );
    				
    				if($pseudo && $mot_de_passe) {
    					$authAdapter->setIdentity($pseudo);
    					$authAdapter->setCredential($mot_de_passe);
    					//$authAdapter->setCredential($this->getUtilisateurTable()->encryptPassword($mot_de_passe));
    					
    					 
    					if( $uAuth->getAuthService()->authenticate($authAdapter)->isValid()) {
    						return $this->redirect()->toRoute('auth', array('action' => 'bienvenue'));
    					}else {
    						return $this->redirect()->toRoute('auth', array('action' => 'login', 'id' => '1'));
    					}
    				}
    				
    				var_dump($pseudo.' ------ '.$mot_de_passe); exit();
    				//var_dump($this->getPersonneTable()->getPersonne('alkhassimdiallo@hotmail.com')); exit();
    			}
    			/*--------------------------*/
    		}
    	}
    	
    	$listePseudo = $this->getPersonneTable()->getListePseudo();
    	$listeEmail = $this->getPersonneTable()->getListeEmail();
    	
    	// // Get the "layout" view model and set an alternate template
    	$layout = $this->layout();
    	$layout->setTemplate('layout/authlayout');
    	 
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
    	//$horloge = new ViewModel();
    	//$horloge->setTemplate('layout/horlogelayout');
    	 
    	$blogrightsidebar->addChild($recherche, 'recherche');
    	$blogrightsidebar->addChild($motscles, 'motscles');
    	$blogrightsidebar->addChild($textwidget, 'textwidget');
    	$blogrightsidebar->addChild($pub, 'pub');
    	//$blogrightsidebar->addChild($horloge, 'horloge');
    	 
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
		return new ViewModel(array('form' => $form, 'form2' => $form2, 'listeEmail' => $listeEmail, 'listePseudo' => $listePseudo, 'messages' => null, 'headtitle' => 'Système d\'Information MEdical National pour le Sénégal (SIMENS)', 'subheadtitle' => 'Connexion'));
    	
    }
    
    /**
     * Logout Action
     */
    public function logoutAction()
    {
    	$uAuth = $this->getServiceLocator()->get('Admin\Controller\Plugin\UserAuthentication'); //@todo - We must use PluginLoader $this->userAuthentication()!!
    
    	$uAuth->getAuthService()->clearIdentity();
    
    	return $this->redirect()->toRoute('auth', array('action' => 'login'));
    }
    
    public function bienvenueAction()
    {
    	$uAuth = $this->getServiceLocator()->get('Admin\Controller\Plugin\UserAuthentication'); //@todo - We must use PluginLoader $this->userAuthentication()!!
    	 
    	$pseudo = $uAuth->getAuthService()->getIdentity();
    	
    	$user = $this->getPersonneTable()->getUtilisateursWithUsername($pseudo);
    	
    	if(!$user){
    		return $this->redirect()->toRoute('auth', array('action' => 'login'));
    	}
    	 
    	if($user['role_personne'] == "administrateur" || $user['role_personne'] == "super-administrateur")
    	{
    		return $this->redirect()->toRoute('auth', array('action' => 'admin'));
    	}
    	else 
    	if($user['role_personne'] == "standard")
        {
        	return $this->redirect()->toRoute('auth', array('action' => 'standard'));
    	} 
    	else 
    	if($user['role_personne'] == "redacteur")
    	{
    		return $this->redirect()->toRoute('auth', array('action' => 'redacteur'));
    	}
    	else
    	if($user['role_personne'] == "moderateur")
    	{
    		return $this->redirect()->toRoute('auth', array('action' => 'moderateur'));
    	}
    	 
    	echo '<div style="font-size: 25px; color: green; padding-bottom: 15px;" >vous n\'avez aucun privilège. Contacter l\'administrateur ----> Merci !!! </div>';
    	echo '<a style="font-size: 20px; color: red;" href="http://localhost/www-simens-sn/public/auth/logout">Terminer</a>';
    	exit();
    }
    
    public function standardAction()
    {
    	// // Get the "layout" view model and set an alternate template
    	$layout = $this->layout();
    	$layout->setTemplate('layout/authlayout');
    	
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
    	
    	$blogrightsidebar->addChild($recherche, 'recherche');
    	$blogrightsidebar->addChild($motscles, 'motscles');
    	$blogrightsidebar->addChild($textwidget, 'textwidget');
    	$blogrightsidebar->addChild($pub, 'pub');
    	
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
    	return new ViewModel(array('messages' => null, 'headtitle' => 'Système d\'Information MEdical National pour le Sénégal (SIMENS)', 'subheadtitle' => 'Connexion'));
    		
    }
    
    public function redacteurAction()
    {
    	// // Get the "layout" view model and set an alternate template
    	$layout = $this->layout();
    	$layout->setTemplate('layout/authlayout');
    	 
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
    	 
    	$blogrightsidebar->addChild($recherche, 'recherche');
    	$blogrightsidebar->addChild($motscles, 'motscles');
    	$blogrightsidebar->addChild($textwidget, 'textwidget');
    	$blogrightsidebar->addChild($pub, 'pub');
    	 
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
    	return new ViewModel(array('messages' => null, 'headtitle' => 'Système d\'Information MEdical National pour le Sénégal (SIMENS)', 'subheadtitle' => 'Connexion'));
    
    }
    
    public function moderateurAction()
    {
    	// // Get the "layout" view model and set an alternate template
    	$layout = $this->layout();
    	$layout->setTemplate('layout/authlayout');
    
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
    
    	$blogrightsidebar->addChild($recherche, 'recherche');
    	$blogrightsidebar->addChild($motscles, 'motscles');
    	$blogrightsidebar->addChild($textwidget, 'textwidget');
    	$blogrightsidebar->addChild($pub, 'pub');
    
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
    	return new ViewModel(array('messages' => null, 'headtitle' => 'Système d\'Information MEdical National pour le Sénégal (SIMENS)', 'subheadtitle' => 'Connexion'));
    
    }
    
    public function superAdministrateurAction()
    {
    	// // Get the "layout" view model and set an alternate template
    	$layout = $this->layout();
    	$layout->setTemplate('layout/authlayout');
    
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
    
    	$blogrightsidebar->addChild($recherche, 'recherche');
    	$blogrightsidebar->addChild($motscles, 'motscles');
    	$blogrightsidebar->addChild($textwidget, 'textwidget');
    	$blogrightsidebar->addChild($pub, 'pub');
    
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
    	return new ViewModel(array('messages' => null, 'headtitle' => 'Système d\'Information MEdical National pour le Sénégal (SIMENS)', 'subheadtitle' => 'Connexion'));
    
    }
    
    public function administrateurAction()
    {
    	// // Get the "layout" view model and set an alternate template
    	$layout = $this->layout();
    	$layout->setTemplate('layout/authlayout');
    
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
    
    	$blogrightsidebar->addChild($recherche, 'recherche');
    	$blogrightsidebar->addChild($motscles, 'motscles');
    	$blogrightsidebar->addChild($textwidget, 'textwidget');
    	$blogrightsidebar->addChild($pub, 'pub');
    
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
    	return new ViewModel(array('messages' => null, 'headtitle' => 'Système d\'Information MEdical National pour le Sénégal (SIMENS)', 'subheadtitle' => 'Connexion'));
    
    }
    
    public function inscriptionAction()
    {
    	$listePseudo = $this->getPersonneTable()->getListePseudo();
    	$listeEmail = $this->getPersonneTable()->getListeEmail();
    	
    	$form = new RegistrationForm();
    	$form2 = new AuthForm();
    	 
    	// // Get the "layout" view model and set an alternate template
    	$layout = $this->layout();
    	$layout->setTemplate('layout/authlayout');
    
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
    	//$horloge = new ViewModel();
    	//$horloge->setTemplate('layout/horlogelayout');
    
    	$blogrightsidebar->addChild($recherche, 'recherche');
    	$blogrightsidebar->addChild($motscles, 'motscles');
    	$blogrightsidebar->addChild($textwidget, 'textwidget');
    	$blogrightsidebar->addChild($pub, 'pub');
    	//$blogrightsidebar->addChild($horloge, 'horloge');
    
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
    	return new ViewModel(array('form' => $form, 'form2' => $form2, 'listePseudo' => $listePseudo, 'listeEmail' => $listeEmail, 'messages' => null, 'headtitle' => 'Système d\'Information MEdical National pour le Sénégal (SIMENS)', 'subheadtitle' => 'Inscription'));
    	 
    }
    
    
    public function getListePersonneAction()
    {
    	$role = $this->layout()->user['role_personne'];
    	$output = $this->getPersonneTable ()->getListePersonneAjax($role);
    	return $this->getResponse ()->setContent ( Json::encode ( $output, array (
    			'enableJsonExprFinder' => true
    	) ) );
    }
    
    
    public function adminAction()
    {
    	$role = $this->layout()->user['role_personne'];
    	
    	$layout = $this->layout();
    	$layout->setTemplate('layout/authlayout');
    
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
    
    	$blogrightsidebar->addChild($recherche, 'recherche');
    	$blogrightsidebar->addChild($motscles, 'motscles');
    	$blogrightsidebar->addChild($textwidget, 'textwidget');
    	$blogrightsidebar->addChild($pub, 'pub');
    
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
    	return new ViewModel(array( 'messages' => null, 'headtitle' => 'Système d\'Information MEdical National pour le Sénégal (SIMENS)', 'subheadtitle' => 'Inscription'));
    
    }
    
    
    public function nouveauProfilAction()
    {

    	$form = new ProfileForm();
    	
    	//Envoyer du formulaire en POST
    	$request = $this->getRequest();
    	if ($request->isPost()) {
    		$data = $request->getPost();
    		if ($data) {
     			$genre = $data->genre;
     			$nom_de_famille = $data->nom_de_famille;
     			$prenom = $data->prenom;
    			$email_personne = $data->email_personne;
    			$pseudo = $data->pseudo;
     			
    			//Génération aléatoire d'une clé
    			$cle = md5(microtime(TRUE)*100000);
    			
    			$this->getPersonneTable()->addUtilisateurNewProfile($data, $cle);
    			
    			
    			
//     			// Préparation du mail contenant le lien d'activation
//     			$destinataire = $email_personne;
//     			$sujet = "Activer votre compte" ;
//     			//$entete = "From: inscription@www.simens.sn" ;
    			
//     			$entete =
//     			'Content-type: text/html; charset=utf-8' . "\r\n" .
//     			'From: inscription@www.simens.sn' . "\r\n" .
//     			'Reply-To: email@domain.tld' . "\r\n" .
//     			'X-Mailer: PHP/' . phpversion();
    			
//     			// Le lien d'activation est composé du login(log) et de la clé(cle)
//     			$message = 'Bienvenue sur VotreSite,
    			
//     					Pour activer votre compte, veuillez cliquer sur le lien ci dessous
//     					ou copier/coller dans votre navigateur internet.

//     					http://www.simens.sn/activation.php?log='.urlencode($pseudo).'&cle='.urlencode($cle).'
    			
//     							---------------

//     							Ceci est un mail automatique, Merci de ne pas y repondre.';
    			
//     			//ini_set('SMTP','mailrelay.orange.sn');
//     			$result = mail($destinataire, $sujet, $message, $entete) ; // Envoi du mail

    			$headers  = 'MIME-Version: 1.0' . "\r\n";
    			$headers .= 'From:"inscription"<wwwsimens@sn>' . "\r\n";
    			$headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";
    			$headers .= "Content-Transfer-Encoding: 8bit";
    			$headers .= 'Reply-to: NomEntreprise <adresse@example.net>' . "\r\n" ;
    			$headers .= 'Return-path: NomEntreprise <adresse@example.net>' . "\r\n" ;
    			$message = 'Bienvenue sur SIMENS,
    
    					Pour activer votre compte, veuillez cliquer sur le lien ci dessous
    					ou copier/coller dans votre navigateur internet.
    			
    					http://www.simens.sn
    
    							---------------
    			
    							Ceci est un mail automatique, Merci de ne pas y repondre.';
    			
    			$result = mail('oumardiop20142014@gmail.com', 'Salut boy test', $message, $headers) ; // Envoi du mail
    			
    			return $this->redirect()->toRoute('auth' , array('action' => 'admin'));
    			//var_dump($result.' --***-- '.$genre.' -- '.$nom_de_famille.' -- '.$prenom.' -- '.$email_personne.' --------'); exit();
     			
    		}
    	}
    	
    	$listePseudo = $this->getPersonneTable()->getListePseudo();
    	
    	$layout = $this->layout();
    	$layout->setTemplate('layout/authlayout');
    	
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
    	
    	$blogrightsidebar->addChild($recherche, 'recherche');
    	$blogrightsidebar->addChild($motscles, 'motscles');
    	$blogrightsidebar->addChild($textwidget, 'textwidget');
    	$blogrightsidebar->addChild($pub, 'pub');
    	
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
    	return new ViewModel(array('form' => $form, 'messages' => null,  'listePseudo' => $listePseudo, 'headtitle' => 'Système d\'Information MEdical National pour le Sénégal (SIMENS)', 'subheadtitle' => 'Cr&eacute;ation d\'un nouveau profil'));
    	
    }
    
    
    public function infoPatientAction()
    {
    	$this->getDateHelper();
    	$chemin = $this->getServiceLocator()->get('Request')->getBasePath();
    	$id = (int)$this->params()->fromPost ('id');
    	
     	$infoPatient = $this->getPersonneTable()->getInfoPatient($id);
    	
     	$sexe = 'F';
     	if($infoPatient->sexe_personne == 'Masculin'){ $sexe = 'M'; 	}
    	    	
     	$html ="<div style='height: 175px; width: 685px; '>";
     	
     	$html .="<div style='width:20%; float:left;'>";
     	$html .="<div id='photo' style=' margin-left:10px; margin-top:10px; margin-right:30px;'> <img src='".$chemin."/img/personne/identite.jpg' ></div>";
     	$html .="<div style='margin-left: 15px; margin-top: 130px; font-size:13px;'>Sexe: <span style='font-family: new time romans; color: black;'>$sexe</span> </div>";
     	$html .="</div>";
     	
     	$html .="<div style='width:80%; float:left;'>";
     	$html .="<table class='info_patient' style='margin-top:15px; margin-left: 5px; width: 97%;'>";
     	$html .="<tr>";
     	$html .="<td  style='width:33%;'><a style='text-decoration:underline; font-size:13px; font-family: time new romans; font-weight: bold;'>Nom:</a><br><p style='font-weight:bol; font-size:17px; font-family: time new romans; padding-bottom: 15px; text-transform : uppercase;'> $infoPatient->nom_personne </p></td>";
     	$html .="<td  style='width:37%;'><a style='text-decoration:underline; font-size:13px; font-family: time new romans; font-weight: bold;'>Pseudo:</a><br><p style=' font-weight:bol; font-size:17px; font-family: time new romans; padding-bottom: 15px;'> $infoPatient->pseudo </p></td>";
     	$html .="<td  style='width:30%;'><a style='text-decoration:underline; font-size:13px; font-family: time new romans; font-weight: bold;'>Role:</a><br><p style='font-weight:bol; font-size:17px; font-family: time new romans; padding-bottom: 15px;'> $infoPatient->role_personne </p></td>";
     	$html .="</tr>";
     	$html .="<tr>";
     	$html .="<td style='width:33%;'><a style='text-decoration:underline; font-size:13px; font-family: time new romans; font-weight: bold;'>Pr&eacute;nom:</a><br><p style=' font-weight:bol; font-size:17px; font-family: time new romans; padding-bottom: 15px;'> $infoPatient->prenom_personne </p></td>";
     	$html .="<td style='width:37%;'><a style='text-decoration:underline; font-size:13px; font-family: time new romans; font-weight: bold;'>@email:</a><br><p style=' font-weight:bol; font-size:17px; font-family: time new romans; padding-bottom: 15px; width: 90%; word-wrap: break-word;'> $infoPatient->email_personne </p></td>";
     	$html .="<td style='width:30%;'><a style='text-decoration:underline; font-size:13px; font-family: time new romans; font-weight: bold;'>T&eacutel&eacute;phone:</a><br><p style=' font-weight:bol; font-size:17px; font-family: time new romans; padding-bottom: 15px;'> $infoPatient->telephone_personne </p></td>";
     	$html .="</tr>";
     	$html .="<tr>";
     	$html .="<td style='vertical-align: top; width:33%;'><a style='text-decoration:underline; font-size:13px; font-family: time new romans; font-weight: bold;'>Date d'inscription:</a><br><p style=' font-weight:bol; font-size:17px; font-family: time new romans; padding-bottom: 15px;'>". $this->dateHelper->convertDateTime($infoPatient->date_inscription) ."</p></td>";
     	$html .="<td style='vertical-align: top; width:37%;'><a style='text-decoration:underline; font-size:13px; font-family: time new romans; font-weight: bold;'>Statut:</a><br><p style='font-weight:bol; font-size:17px; font-family: time new romans; padding-bottom: 15px; width: 95%; word-wrap: break-word;'> $infoPatient->statut_personne </p></td>";
     	$html .="<td style='vertical-align: top; width:30%;'><a style='text-decoration:underline; font-size:13px; font-family: time new romans; font-weight: bold;'>Adresse:</a><br><p style=' font-weight:bol; font-size:17px; font-family: time new romans; padding-bottom: 15px; overflow: auto; max-height: 50px;'> $infoPatient->adresse_personne </p></td>";
     	$html .="</tr>";
    	$html .="</table>";
    	$html .="</div>";
    	
    	$html .="</div>";
    	
    	$this->getResponse ()->getHeaders ()->addHeaderLine ( 'Content-Type', 'application/html; charset=utf-8' );
    	return $this->getResponse()->setContent(Json::encode($html));
    	
    }
    
    public function modifierDonneesPopupAction()
    {
    	$chemin = $this->getServiceLocator()->get('Request')->getBasePath();
    	$id = (int)$this->params()->fromPost ('id');
    	$form = new ProfileModificationForm();
    	
    	$formRow = new FormRow();
    	$formSelect = new FormSelect();
    	$formText = new FormText();
    	$formPassword = new FormPassword();
    	$formHidden = new FormHidden();
    	$formButton = new FormButton();
    	$formSubmit = new FormSubmit();
    	
    	$infoPatient = $this->getPersonneTable()->getInfoPatient($id);
    	$donnees = array(
    			'id_personne' => $id,
    			'genre' => $infoPatient->sexe_personne,
    			'nom_de_famille' => $infoPatient->nom_personne,
    			'prenom' => $infoPatient->prenom_personne,
    			'email_personne' => $infoPatient->email_personne,
    			'pseudo_tempo' => $infoPatient->pseudo,
    			'statut' => $infoPatient->statut_personne,
    			'adresse' => $infoPatient->adresse_personne,
    			'telephone' => $infoPatient->telephone_personne,
    			'site_web' => $infoPatient->site_web_personne,
    			'role' => $infoPatient->role_personne,
    	);
    	
    	$form->populateValues( $donnees );
    	
    	
    	$html ='
    			<div id="popupModification" style="display: none; width: 600px; height: 100%; overflow: auto">
                    <div rel="title">
                        Modification des donn&eacute;es
                    </div>
    			
    			    
                    <div rel="body" style="margin-top: 15px; padding-top: 15px;">
    			         
    			         <!-- *************** --><!-- *************** --><!-- *************** -->
    			         <div id="photo" style="position: absolute; margin-left:10px; margin-right:30px;"> <img src="'.$chemin.'/img/personne/identite.jpg" ></div>
    			         <form method="post" action="'.$chemin.'/auth/enregistrer-modification-popup">
    			         ' . $formHidden($form->get ( 'id_personne' )) . '
    			         <!-- *************** --><!-- *************** --><!-- *************** -->
    			         <div class="w2ui-field">
    			            <label>Genre <span style="color: red;">*</span> </label>
    			            <div>
    			            ' . $formSelect($form->get ( 'genre' )) . '
    			            </div>	
    			         </div>
    			
    			         <!-- *************** -->
    			         <div class="w2ui-field">
    			            <label>Nom de famille <span style="color: red;">*</span> </label>
    			            <div>
    			            ' . $formText($form->get ( 'nom_de_famille' )) . '
    			            </div>	
    			         </div>
    			            		
                         <!-- *************** -->
    			         <div class="w2ui-field">
    			            <label>Pr&eacute;nom <span style="color: red;">*</span> </label>
    			            <div>
    			            ' . $formText($form->get ( 'prenom' )) . '
    			            </div>	
    			         </div>
    			            		
    			         <!-- *************** -->
    			         <div class="w2ui-field">
    			            <label>Email <span style="color: red;">*</span> </label>
    			            <div>
    			            ' . $formText($form->get ( 'email_personne' )) . '
    			            </div>	
    			         </div>

    			         <!-- *************** -->
    			         <div class="w2ui-field">
    			            <label>Pseudo <span style="color: red;">*</span> </label>
    			            <div>
    			            ' . $formText($form->get ( 'pseudo_tempo' )) . '
    			            </div>	
    			         </div>
    			            		
    			         <!-- *************** -->
    			         <div class="w2ui-field">
    			            <label>Mot de passe <span style="color: red;">*</span> </label>
    			            <div>
    			            ' . $formPassword($form->get ( 'nouveau_mot_de_passe' )) . '
    			            </div>	
    			         </div>
    			            		
    			         <!-- *************** -->
    			         <div class="w2ui-field">
    			            <label>Confirmation du mot de passe <span style="color: red;">*</span> </label>
    			            <div>
    			            ' . $formPassword($form->get ( 'confirm_mot_de_passe' )) . '
    			            </div>	
    			         </div>
    			            		
    			         <!-- *************** -->
    			         <div class="w2ui-field">
    			            <label>Votre statut, grade ou poste occup&eacute; </label>
    			            <div>
    			            ' . $formText($form->get ( 'statut' )) . '
    			            </div>	
    			         </div>
    			            		
    			         <!-- *************** -->
    			         <div class="w2ui-field">
    			            <label>Adresse personnelle ou professionnelle </label>
    			            <div>
    			            ' . $formText($form->get ( 'adresse' )) . '
    			            </div>	
    			         </div>
    			            		
    			         <!-- *************** -->
    			         <div class="w2ui-field">
    			            <label>T&eacute;l&eacute;phone </label>
    			            <div>
    			            ' . $formText($form->get ( 'telephone' )) . '
    			            </div>	
    			         </div>
    			            		
    			         <!-- *************** -->
    			         <div class="w2ui-field">
    			            <label>Site web </label>
    			            <div>
    			            ' . $formText($form->get ( 'site_web' )) . '
    			            </div>	
    			         </div>
    			            		
    			         <!-- *************** -->
    			         <div class="w2ui-field">
    			            <label>Role <span style="color: red;">*</span> </label>
    			            <div>
    			            ' . $formSelect($form->get ( 'role' )) . '
    			            </div>	
    			         </div>
    			            		
    			         <div style="text-align:center;position:absolute;overflow:hidden;height:52px;left:0;right:0;bottom:0; padding:12px;border-radius:0 0 6px 6px;border-top:1px solid #49afcd;background-color:#f1f1f1;"> 		
    			            <button class="btn" onclick="w2popup.close(); return false;">Annuler</button>
                            <button class="btn" name="save" onclick="lastVerif(); return true;" >Valider</button>
    			         </div>
    			            		
    			         </form>		
                    </div>
    			   
    			    <!-- *************** --><!-- *************** --><!-- *************** -->

    			            		
    			   
                </div>';
    	
    	$html .="
    			<script>
    			function verifPseudo(id){
    			  alert(id.value);
    			}
    			
    			var confirmat_mot_de_passe = '';
    			var nouv_mot_de_passe = '';
    			var input_confirmat_mot_de_passe;
    			var input_nouv_mot_de_passe;
    			
    			function check(input) { 
    			  nouv_mot_de_passe = input.value; 
    			  input_nouv_mot_de_passe = input;
    			  $('#nouveau_mot_de_passe').val(input.value);
    			}
    			
    			function check2(input) { 
    			  confirmat_mot_de_passe = input.value;
    			  input_confirmat_mot_de_passe = input;
     			  if (input.value != document.getElementById('nouveau_mot_de_passe').value) {
    			     input.setCustomValidity('Les deux mots de passe ne correspondent pas.');
	              } else {
    			     input.setCustomValidity('');
	                }
    			
                }
    			
    			function lastVerif() {
    			  if(nouv_mot_de_passe != confirmat_mot_de_passe){
    			     input_confirmat_mot_de_passe.setCustomValidity('Les deux mots de passe ne correspondent pas.');
    			     return false;
    			  } else {
    			     return true;
    			    }
    			}
    			</script>
    			";
    	
    	$this->getResponse ()->getHeaders ()->addHeaderLine ( 'Content-Type', 'application/html; charset=utf-8' );
    	return $this->getResponse()->setContent(Json::encode($html));
    }
    
    public function modifierDonneesClassiqueAction(){
    	//Verification de l'utilisateur
    	//$role = $this->layout()->user['role_personne'];
    	
    	$form = new ProfileModificationForm();
    	$id = (int)$this->params ()->fromRoute ( 'val', 0 );

    	
    	$infoPatient = $this->getPersonneTable()->getInfoPatient($id);
    	$donnees = array(
    			'id_personne' => $id,
    			'genre' => $infoPatient->sexe_personne,
    			'nom_de_famille' => $infoPatient->nom_personne,
    			'prenom' => $infoPatient->prenom_personne,
    			'email_personne' => $infoPatient->email_personne,
    			'pseudo' => $infoPatient->pseudo,
    			'statut' => $infoPatient->statut_personne,
    			'adresse' => $infoPatient->adresse_personne,
    			'telephone' => $infoPatient->telephone_personne,
    			'site_web' => $infoPatient->site_web_personne,
    			'role' => $infoPatient->role_personne,
    	);
    	 
    	$listePseudo = $this->getPersonneTable()->getListePseudo();
    	
    	$form->populateValues( $donnees ); 

    	$layout = $this->layout();
    	$layout->setTemplate('layout/authlayout');
    	 
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
    	 
    	$blogrightsidebar->addChild($recherche, 'recherche');
    	$blogrightsidebar->addChild($motscles, 'motscles');
    	$blogrightsidebar->addChild($textwidget, 'textwidget');
    	$blogrightsidebar->addChild($pub, 'pub');
    	 
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
    	return new ViewModel(array('role' => $donnees['role'], 'form' => $form, 'listePseudo' => $listePseudo, 'messages' => null, 'headtitle' => 'Système d\'Information MEdical National pour le Sénégal (SIMENS)', 'subheadtitle' => 'Modification du profil'));
    	 
    }
    
    public function enregistrerModificationAction(){
    	$request = $this->getRequest();
    	if ($request->isPost()) {
    		$data = $request->getPost();
    		if ($data) {
    			$this->getPersonneTable()->modifierUtilisateurProfile($data, $data->id_personne);
    		}
    		return $this->redirect()->toRoute('auth' , array('action' => 'admin'));
    	}
    }
    
    public function enregistrerModificationPopupAction(){
    	$request = $this->getRequest();
    	if ($request->isPost()) {
    		$data = $request->getPost();
    		if ($data) {
    			$this->getPersonneTable()->modifierUtilisateurProfilePopup($data, $data->id_personne);
    		}
    		return $this->redirect()->toRoute('auth' , array('action' => 'admin'));
    	}
    }
    
    public function supprimerUtilisateurAction(){
    	$id = (int)$this->params()->fromPost ('id');
    	$this->getPersonneTable()->deletePersonne($id);
    	
    	$this->getResponse ()->getHeaders ()->addHeaderLine ( 'Content-Type', 'application/html; charset=utf-8' );
    	return $this->getResponse()->setContent(Json::encode());
    }
}