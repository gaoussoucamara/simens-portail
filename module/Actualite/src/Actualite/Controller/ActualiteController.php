<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 * 
 **/

namespace Actualite\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Actualite\Form\ActualiteForm;
use Zend\Json\Json;

class ActualiteController extends AbstractActionController
{
	protected $articleTable;
	protected $actualiteTable;
	
	public function getArticleTable()
	{
		if (!$this->articleTable) {
			$sm = $this->getServiceLocator();
			$this->articleTable = $sm->get('Maladie\Model\ArticleTable');
		}
		return $this->articleTable;
	}
	public function getActualiteTable()
	{
		if (!$this->actualiteTable) {
			$sm = $this->getServiceLocator();
			$this->actualiteTable = $sm->get('Actualite\Model\ActualiteTable');
		}
		return $this->actualiteTable;
	}
	
   
    /****** MENU Actualite ******/
    /****** MENU Actualite ******/
    public function actualiteAction()
    {
    	//@todo - Implement indexAction
    	$layout = $this->layout();
    	$layout->setTemplate('layout/layout');
    	
    	$listeArticles = $this->getArticleTable()->getListeArticle();
    	$listeActualites = $this->getActualiteTable()->getListeActualite();
    	 
    	//var_dump($listeActualites); exit();
    	$outilsutilisateurs = new ViewModel();
    	$outilsutilisateurs->setTemplate('layout/outilsutilisateurslayout');
    	 
    	$blogrightsidebar = new ViewModel();
    	$blogrightsidebar->setTemplate('layout/blogrightsidebaraccueillayout');
    	
    	$recherche = new ViewModel();
    	$recherche->setTemplate('layout/recherchelayout');
    	$motscles = new ViewModel();
    	$motscles->setTemplate('layout/motscleslayout');
    	$textwidget = new ViewModel();
    	$textwidget->setTemplate('layout/textwidgetlayout');
    	$pub = new ViewModel();
    	$pub->setTemplate('layout/pubaccueillayout');
    	$horloge = new ViewModel();
    	$horloge->setTemplate('layout/horlogelayout');
    	
    	$blogrightsidebar->addChild($recherche, 'recherche');
    	$blogrightsidebar->addChild($motscles, 'motscles');
    	$blogrightsidebar->addChild($textwidget, 'textwidget');
    	$blogrightsidebar->addChild($pub, 'pub');
    	$blogrightsidebar->addChild($horloge, 'horloge');
    	
    	
    	$layout->addChild($blogrightsidebar, 'blogrightsidebar');
    	$layout->addChild($outilsutilisateurs, 'outilsutilisateurs');
    	
    	return new ViewModel(array('listeArticle' => $listeArticles, 'listeActualites' => $listeActualites));
    }
    
    public function detailsArticleAction()
    {
    	$id = (int)$this->params ()->fromRoute ( 'val', 0 );
    	$listeArticles = $this->getArticleTable()->getArticle($id);

    	//@todo - Implement indexAction
    	$layout = $this->layout();
    	$layout->setTemplate('layout/maladielayout');
    	 
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
    	$categorie->setTemplate('layout/categoriemaladielayout');
    	 
    	$contact = new ViewModel();
    	$contact->setTemplate('layout/contactlayout');
    	 
    	$blogfooter->addChild($archive, 'archive');
    	$blogfooter->addChild($categorie, 'categorie');
    	$blogfooter->addChild($contact, 'contact');
    	 
    	 
    	//BARRE MENU ---- BARRE MENU ---- BARRE MENU
    	$layout->addChild($outilsutilisateurs, 'outilsutilisateurs');
    	$layout->addChild($blogrightsidebar, 'blogrightsidebar');
    	$layout->addChild($blogfooter, 'blogfooter');
    	
    	return new ViewModel(array( 'listeArticles' => $listeArticles, 'id' => $id, 'headtitle' => 'Système d\'Information MEdical National pour le Sénégal (SIMENS)'));
    }
    
    public function detailsActualiteAction()
    {
    	$id = (int)$this->params ()->fromRoute ( 'val', 0 );
    	$listeActualite = $this->getActualiteTable()->getActualite($id);
    
    	//var_dump($id); exit();
    	//@todo - Implement indexAction
    	$layout = $this->layout();
    	$layout->setTemplate('layout/maladielayout');
    
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
    	$categorie->setTemplate('layout/categoriemaladielayout');
    
    	$contact = new ViewModel();
    	$contact->setTemplate('layout/contactlayout');
    
    	$blogfooter->addChild($archive, 'archive');
    	$blogfooter->addChild($categorie, 'categorie');
    	$blogfooter->addChild($contact, 'contact');
    
    
    	//BARRE MENU ---- BARRE MENU ---- BARRE MENU
    	$layout->addChild($outilsutilisateurs, 'outilsutilisateurs');
    	$layout->addChild($blogrightsidebar, 'blogrightsidebar');
    	$layout->addChild($blogfooter, 'blogfooter');
    
    	return new ViewModel(array( 'listeActualite' => $listeActualite, 'id' => $id, 'headtitle' => 'Système d\'Information MEdical National pour le Sénégal (SIMENS)'));
    }
    
    
    public function nouvelleActualiteAction()
    {
    	$form = new ActualiteForm();
    	
    	//@todo - Implement indexAction
    	$layout = $this->layout();
    	$layout->setTemplate('layout/actualitelayout');
    	
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
    	$categorie->setTemplate('layout/categoriemaladielayout');
    	
    	$contact = new ViewModel();
    	$contact->setTemplate('layout/contactlayout');
    	
    	$blogfooter->addChild($archive, 'archive');
    	$blogfooter->addChild($categorie, 'categorie');
    	$blogfooter->addChild($contact, 'contact');
    	
    	
    	//BARRE MENU ---- BARRE MENU ---- BARRE MENU
    	$layout->addChild($outilsutilisateurs, 'outilsutilisateurs');
    	$layout->addChild($blogrightsidebar, 'blogrightsidebar');
    	$layout->addChild($blogfooter, 'blogfooter');
    	 
    	return new ViewModel(array('form' => $form, 'headtitle' => 'Système d\'Information MEdical National pour le Sénégal (SIMENS)'));
    }
    
    public function enregistrerActualiteAction()
    {
    	$id_personne = $this->layout()->user['id'];
    	$request = $this->getRequest();
    	
    	if ($request->isPost()) {
    		$data = $request->getPost();
    		if ($data) {
    			 
    			$today = new \DateTime ( 'now' );
    			$nomImg = 'img_actu_'.$today->format ( 'dmy_His' ).'.jpg';
    			 
    			$fileBase64 = $data->fichier_tmp; $fileBase64 = substr ( $fileBase64, 23 );
    			if($fileBase64){ $img = imagecreatefromstring(base64_decode($fileBase64)); } else { $img = false; $nomImg="";}
    			 
    			if ($img != false) {
    				imagejpeg ( $img, 'C:\wamp\www\www-simens-sn\public\img\images_actualites\\' . $nomImg );
    			}
    			//Enregistrer l'actualite
    			$this->getActualiteTable()->addActualite($data, $id_personne, $nomImg);
    		}
    		return $this->redirect()->toRoute('actualite' , array('action' => 'liste-actualite'));
    	}
    }
    
    public function listeActualiteAction()
    {
    	$id = (int)$this->params ()->fromRoute ( 'val', 0 );
    	$listeArticles = $this->getArticleTable()->getArticle($id);
    
    	//@todo - Implement indexAction
    	$layout = $this->layout();
    	$layout->setTemplate('layout/actualitelayout');
    
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
    	$categorie->setTemplate('layout/categoriemaladielayout');
    
    	$contact = new ViewModel();
    	$contact->setTemplate('layout/contactlayout');
    
    	$blogfooter->addChild($archive, 'archive');
    	$blogfooter->addChild($categorie, 'categorie');
    	$blogfooter->addChild($contact, 'contact');
    
    
    	//BARRE MENU ---- BARRE MENU ---- BARRE MENU
    	$layout->addChild($outilsutilisateurs, 'outilsutilisateurs');
    	$layout->addChild($blogrightsidebar, 'blogrightsidebar');
    	$layout->addChild($blogfooter, 'blogfooter');
    
    	return new ViewModel(array( 'listeArticles' => $listeArticles, 'id' => $id, 'headtitle' => 'Système d\'Information MEdical National pour le Sénégal (SIMENS)'));
    }
    
    public function getListeActualiteAction()
    {
    	$role = $this->layout()->user['role_personne'];
    	$id_personne = $this->layout()->user['id'];
    	$output = $this->getActualiteTable()->getListeActualiteAjax($role, $id_personne);
    	return $this->getResponse ()->setContent ( Json::encode ( $output, array (
    			'enableJsonExprFinder' => true
    	) ) );
    }
    
    public function zoomerImageListeAction()
    {
    	$chemin = $this->getServiceLocator()->get('Request')->getBasePath();
    	$id = ( int ) $this->params ()->fromPost ( 'id', 0 );
    	
    	$actualite = $this->getActualiteTable()->getActualite($id);
    	
    	$html ='<script> 
    			   $("#hover_'.$id.'").w2overlay({ html: "<div style=\' height: 200px; width: 310px; \' > <img style=\' height: 200px; width: 310px; \' src=\''.$chemin.'/img/images_actualites/'.$actualite->image_actu.'\'>  </div>"});
    			   $(".hover_'.$id.'").hover(function(){
    			   		$("#hover_'.$id.'").w2overlay({ html: "<div style=\' height: 200px; width: 310px; \' > <img style=\' height: 200px; width: 310px; \'  src=\''.$chemin.'/img/images_actualites/'.$actualite->image_actu.'\'>  </div>"});
    			   	},function(){ $(null).w2overlay(null); });
    			</script>';
    	
    	$this->getResponse ()->getHeaders ()->addHeaderLine ( 'Content-Type', 'application/html; charset=utf-8' );
    	return $this->getResponse ()->setContent ( Json::encode ( $html ) );
    }
    
    public function modificationActualiteAction()
    {
    	$form = new ActualiteForm();
    	 
    	$id = (int)$this->params ()->fromRoute ( 'val', 0 );
    	 
    	$actualite = $this->getActualiteTable()->getActualite($id);
    	$donnees = array(
    			'id' =>$actualite->id,
    			'titre' =>$actualite->titre,
    			'source' =>$actualite->source,
    			'source_web' =>$actualite->source_web,
    			'categorie' =>$actualite->code_sous_categorie,
    			'description' =>$actualite->description,
    			'article' =>$actualite->contenu,
    	);
    	$form->populateValues( $donnees );
    	 
    	//var_dump($donnees); exit();
    	//@todo - Implement indexAction
    	$layout = $this->layout();
    	$layout->setTemplate('layout/actualitelayout');
    
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
    	$categorie->setTemplate('layout/categoriemaladielayout');
    
    	$contact = new ViewModel();
    	$contact->setTemplate('layout/contactlayout');
    
    	$blogfooter->addChild($archive, 'archive');
    	$blogfooter->addChild($categorie, 'categorie');
    	$blogfooter->addChild($contact, 'contact');
    
    
    	//BARRE MENU ---- BARRE MENU ---- BARRE MENU
    	$layout->addChild($outilsutilisateurs, 'outilsutilisateurs');
    	$layout->addChild($blogrightsidebar, 'blogrightsidebar');
    	$layout->addChild($blogfooter, 'blogfooter');
    
    	return new ViewModel(array('form' => $form, 'image' => $actualite->image_actu, 'headtitle' => 'Système d\'Information MEdical National pour le Sénégal (SIMENS)'));
    }
    
    public function enregistrerModificationActualiteAction()
    {
    	$id_personne = $this->layout()->user['id'];
    	$role = $this->layout()->user['role_personne'];
    	$request = $this->getRequest();
    	 
    	$today = new \DateTime ( 'now' );
    	$nomImg = 'img_actu_'.$today->format ( 'dmy_His' ).'.jpg';
    	 
    	 
    	if ($request->isPost()) {
    		$data = $request->getPost();
    		if ($data) {
    			 
    			$fileBase64 = $data->fichier_tmp; $fileBase64 = substr ( $fileBase64, 23 );
    			if($fileBase64){ $img = imagecreatefromstring(base64_decode($fileBase64)); } else { $img = false; $nomImg = false; }
    			 
    			if ($img != false) {
    				$actualite = $this->getActualiteTable()->getActualite( $data->id );
    				$ancienneImage = $actualite->image_actu;
    				if($ancienneImage) {
    					unlink ( 'C:\wamp\www\www-simens-sn\public\img\images_actualites\\' . $ancienneImage );
    				}
    				imagejpeg ( $img, 'C:\wamp\www\www-simens-sn\public\img\images_actualites\\' . $nomImg );
    				 
    			} 
    			//Mise à jour de l'actualite
    			$this->getActualiteTable()->updateActualite($data, $nomImg, $id_personne);
    			 
    		}
    
    		return $this->redirect()->toRoute('actualite' , array('action' => 'liste-actualite'));
    	}
    }
    
    public function publicationActualiteAction()
    {
    	$id_personne = $this->layout()->user['id'];
    	$id = ( int ) $this->params ()->fromPost ( 'id', 0 );
    	 
    	$actualite = $this->getActualiteTable()->publicationActualite($id_personne, $id);
    	     	 
    	$this->getResponse ()->getHeaders ()->addHeaderLine ( 'Content-Type', 'application/html; charset=utf-8' );
    	return $this->getResponse ()->setContent ( Json::encode ( $id ) );
    }
    
    public function depublicationActualiteAction()
    {
    	$id_personne = $this->layout()->user['id'];
    	$id = ( int ) $this->params ()->fromPost ( 'id', 0 );
    
    	$actualite = $this->getActualiteTable()->depublicationActualite($id_personne, $id);
    
    	$this->getResponse ()->getHeaders ()->addHeaderLine ( 'Content-Type', 'application/html; charset=utf-8' );
    	return $this->getResponse ()->setContent ( Json::encode ( $id ) );
    }
}