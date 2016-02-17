<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Maladie\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Maladie\Form\ArticleForm;
use Zend\Json\Json;

class MaladieController extends AbstractActionController
{
	protected $articleTable;
	
	public function getArticleTable()
	{
		if (!$this->articleTable) {
			$sm = $this->getServiceLocator();
			$this->articleTable = $sm->get('Maladie\Model\ArticleTable');
		}
		return $this->articleTable;
	}
	
    /**** MENU Maladie ****/
    /**** MENU Maladie ****/
    public function maladieAction()
    {
    	//@todo - Implement indexAction
    	$layout = $this->layout();
    	$layout->setTemplate('layout/maladielayout');
    	
    	$listeArticle = $this->getArticleTable()->getListeArticleAuteur();
    	
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
    	 
    	return new ViewModel(array('listeArticle' => $listeArticle));
    }
    
    public function getListeArticlesMaladiesAction()
    {
    	$output = $this->getArticleTable() ->getListeArticlesMaladiesAjax();
    	return $this->getResponse ()->setContent ( Json::encode ( $output, array (
    			'enableJsonExprFinder' => true
    	) ) );
    }
    
    public function redactionArticleAction()
    {
    	$form = new ArticleForm();
    	
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
    	
		return new ViewModel(array('form' => $form, 'headtitle' => 'Système d\'Information MEdical National pour le Sénégal (SIMENS)'));
    }
    
    public function enregistrerArticleAction()
    {
    	$id_personne = $this->layout()->user['id'];
    	$request = $this->getRequest();
    	
    	if ($request->isPost()) {
    		$data = $request->getPost();
    		if ($data) {
    			
    			$today = new \DateTime ( 'now' );
    			$nomImg = 'img_art_'.$today->format ( 'dmy_His' ).'.jpg';
    			
    			$fileBase64 = $data->fichier_tmp; $fileBase64 = substr ( $fileBase64, 23 );
    			if($fileBase64){ $img = imagecreatefromstring(base64_decode($fileBase64)); } else { $img = false; $nomImg="";}
    			
    			if ($img != false) {
    				imagejpeg ( $img, 'C:\wamp\www\www-simens-sn\public\img\images_articles\\' . $nomImg );
    			}
    			
    			//Enregistrer l'article
    			$this->getArticleTable()->addArticle($data, $id_personne, $nomImg);
    		}
    		return $this->redirect()->toRoute('maladie' , array('action' => 'liste-article'));
    	}    	
    }
    
    public function listeArticleAction()
    {

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
    	 
    	return new ViewModel(array( 'headtitle' => 'Système d\'Information MEdical National pour le Sénégal (SIMENS)'));
    }
    
    //LISTE DES ARTICLES DU REDACTEUR
    //LISTE DES ARTICLES DU REDACTEUR
    //LISTE DES ARTICLES DU REDACTEUR
    public function getListeArticleAction()
    {
    	$role = $this->layout()->user['role_personne'];
    	$id_personne = $this->layout()->user['id'];
    	$output = $this->getArticleTable() ->getListeArticleAjax($role, $id_personne);
    	return $this->getResponse ()->setContent ( Json::encode ( $output, array (
    			'enableJsonExprFinder' => true
    	) ) );
    }
    
    public function modificationArticleAction()
    {
    	$form = new ArticleForm();
    	
    	$id = (int)$this->params ()->fromRoute ( 'val', 0 );
    	
    	$article = $this->getArticleTable()->getArticle($id);
    	$donnees = array(
    			'id' =>$article->code_article,
    			'titre' =>$article->titre_article,
    			'source' =>$article->source_article,
    			'categorie' =>$article->code_sous_categorie,
    			'description' =>$article->description_article,
    			'article' =>$article->contenu_article,
    	);
    	//var_dump($article->image_article); exit();
    	$form->populateValues( $donnees );
    	
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
    
    	return new ViewModel(array('form' => $form, 'image' => $article->image_article, 'headtitle' => 'Système d\'Information MEdical National pour le Sénégal (SIMENS)'));
    }
    
    
    public function enregistrerModificationArticleAction()
    {
    	$id_personne = $this->layout()->user['id'];
    	$role = $this->layout()->user['role_personne'];
    	$request = $this->getRequest();
    	
    	$today = new \DateTime ( 'now' ); 
    	$nomImg = 'img_art_'.$today->format ( 'dmy_His' ).'.jpg';
    	
    	
    	if ($request->isPost()) {
    		$data = $request->getPost();
    		if ($data) {
    			
    			$fileBase64 = $data->fichier_tmp; $fileBase64 = substr ( $fileBase64, 23 );
    			if($fileBase64){ $img = imagecreatefromstring(base64_decode($fileBase64)); } else { $img = false; }
    			
    			if ($img != false) {
    				$article = $this->getArticleTable()->getArticle( $data->id ); 
    				$ancienneImage = $article->image_article;
    				if($ancienneImage) {
    					unlink ( 'C:\wamp\www\www-simens-sn\public\img\images_articles\\' . $ancienneImage );
    				}
    				imagejpeg ( $img, 'C:\wamp\www\www-simens-sn\public\img\images_articles\\' . $nomImg );
    				//Mise à jour de l'article
    				$this->getArticleTable()->updateArticleImg($data, $nomImg, $id_personne, $role);
    			
    			} else {
    				//Mise à jour de l'article
    				$this->getArticleTable()->updateArticle($data, $id_personne, $role);
    			}
    			
    		}
    		
    		
    		if($role == 'redacteur'){
    			return $this->redirect()->toRoute('maladie' , array('action' => 'liste-article'));
    		}else if($role == 'moderateur' ){
    			return $this->redirect()->toRoute('maladie' , array('action' => 'liste-article-soumis'));
    		}

    	}    	
    }
    
    public function soumissionArticleAction(){
    	$id = (int)$this->params()->fromPost ('id');
    	$this->getArticleTable()->soumissionArticle($id);
    	 
    	$this->getResponse ()->getHeaders ()->addHeaderLine ( 'Content-Type', 'application/html; charset=utf-8' );
    	return $this->getResponse()->setContent(Json::encode());
    }
    
    //LISTE DES ARTICLES DU MODERATEUR
    //LISTE DES ARTICLES DU MODERATEUR
    //LISTE DES ARTICLES DU MODERATEUR
    public function getListeArticleSoumisAction()
    {
    	$role = $this->layout()->user['role_personne'];
    	$output = $this->getArticleTable() ->getListeArticleSoumisAjax($role);
    	return $this->getResponse ()->setContent ( Json::encode ( $output, array (
    			'enableJsonExprFinder' => true
    	) ) );
    }
    
    public function listeArticleSoumisAction()
    {
    
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
    
    	return new ViewModel(array( 'headtitle' => 'Système d\'Information MEdical National pour le Sénégal (SIMENS)'));
    }
    
    public function  publicationArticleAction()
    {
    	$id_personne = $this->layout()->user['id'];
    	$id = (int)$this->params()->fromPost ('id');
    	$this->getArticleTable()->publicationArticle($id_personne, $id);
    	
    	$this->getResponse ()->getHeaders ()->addHeaderLine ( 'Content-Type', 'application/html; charset=utf-8' );
    	return $this->getResponse()->setContent(Json::encode());
    }
    
    public function  depublicationArticleAction()
    {
    	$id_personne = $this->layout()->user['id'];
    	$id = (int)$this->params()->fromPost ('id');
    	$this->getArticleTable()->depublicationArticle($id_personne, $id);
    	 
    	$this->getResponse ()->getHeaders ()->addHeaderLine ( 'Content-Type', 'application/html; charset=utf-8' );
    	return $this->getResponse()->setContent(Json::encode());
    }
    
    public function dessoumissionArticleAction(){
    	$id = (int)$this->params()->fromPost ('id');
    	$this->getArticleTable()->dessoumissionArticle($id);
    
    	$this->getResponse ()->getHeaders ()->addHeaderLine ( 'Content-Type', 'application/html; charset=utf-8' );
    	return $this->getResponse()->setContent(Json::encode());
    }
    
    public function zoomerImageListeAction()
    {
    	$chemin = $this->getServiceLocator()->get('Request')->getBasePath();
    	$id = ( int ) $this->params ()->fromPost ( 'id', 0 );
    	 
    	$article = $this->getArticleTable()->getArticle($id);
    	 
    	$html ='<script>
    			   $("#hover_'.$id.'").w2overlay({ html: "<div style=\' height: 200px; width: 310px; \' > <img style=\' height: 200px; width: 310px; \' src=\''.$chemin.'/img/images_articles/'.$article->image_article.'\'>  </div>"});
    			   $(".hover_'.$id.'").hover(function(){
    			   		$("#hover_'.$id.'").w2overlay({ html: "<div style=\' height: 200px; width: 310px; \' > <img style=\' height: 200px; width: 310px; \'  src=\''.$chemin.'/img/images_articles/'.$article->image_article.'\'>  </div>"});
    			   	},function(){ $(null).w2overlay(null); });
    			</script>';
    	 
    	$this->getResponse ()->getHeaders ()->addHeaderLine ( 'Content-Type', 'application/html; charset=utf-8' );
    	return $this->getResponse ()->setContent ( Json::encode ( $html ) );
    }
    
}