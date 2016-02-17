<?php
/**
 * File for User Controller Class
 *
 * @category  User
 * @package   User_Controller
 * @author    Marco Neumann <webcoder_at_binware_dot_org>
 * @copyright Copyright (c) 2011, Marco Neumann
 * @license   http://binware.org/license/index/type:new-bsd New BSD License
 */

/**
 * @namespace
 */
namespace Admin\Controller;

/**
 * @uses Zend\Mvc\Controller\ActionController
 * @uses User\Form\Login
 */
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Json\Json;
/**
 * User Controller Class
 *
 * User Controller
 *
 * @category  User
 * @package   User_Controller
 * @copyright Copyright (c) 2011, Marco Neumann
 * @license   http://binware.org/license/index/type:new-bsd New BSD License
 */
class AdminController extends AbstractActionController
{
	protected $publiciteTable;
	protected $publiciteTable2;
	protected $imageenteteTable;
	
	public function getPubliciteTable()
	{
		if (!$this->publiciteTable) {
			$sm = $this->getServiceLocator();
			$this->publiciteTable = $sm->get('Admin\Model\PubliciteTable');
		}
		return $this->publiciteTable;
	}
	
	public function getPubliciteTable2()
	{
		if (!$this->publiciteTable2) {
			$sm = $this->getServiceLocator();
			$this->publiciteTable2 = $sm->get('Admin\Model\PubliciteTable2');
		}
		return $this->publiciteTable2;
	}
	
	public function getImageenteteTable()
	{
		if (!$this->imageenteteTable) {
			$sm = $this->getServiceLocator();
			$this->imageenteteTable = $sm->get('Admin\Model\ImageenteteTable');
		}
		return $this->imageenteteTable;
	}
	/**
	 * =========================================================================
	 * =========================================================================
	 * =========================================================================
	 */
	
    /**
     * Index Action
     */
    public function indexAction()
    {
        //@todo - Implement indexAction
    }
    
    public function parametrageAction()
    {
    	//@todo - Implement indexAction
    	$layout = $this->layout();
    	$layout->setTemplate('layout/adminlayout');
    	 
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
    	 
    	//$listePublicite = $this->getPubliciteTable()->marquerPublicite('pub_090216_214501');
    	//$ligne = $this->getImageenteteTable()->getImageEnTeteId(2);
    	//$result = $this->getImageenteteTable()->getImageEnteteOrdonnee();
//     	$pub2 = $this->getPubliciteTable2()->getPublicite2();
//     	var_dump($listePublicite); exit();
    	
    	$layout->addChild($blogrightsidebar, 'blogrightsidebar');
    	$layout->addChild($outilsutilisateurs, 'outilsutilisateurs');
    	
    	$id = "";
    	$publier = "";
    	$listeDesImages = "";
    	$listeDesLiens  = "";
    	$listeDesDescription  = "";
    	$listePublicite = $this->getPubliciteTable()->fetchAllPublicite();
    	for($i = 0; $i < count($listePublicite); $i++){
    		if($i == count($listePublicite)-1){ 
    			$id .= '"'.$listePublicite[$i]['id'].'"';
    			$publier .= '"'.$listePublicite[$i]['publier'].'"';
    			$listeDesImages .= '"'.$listePublicite[$i]['image'].'"';
    			$listeDesLiens  .= '"'.$listePublicite[$i][ 'lien'].'"';
    			$listeDesDescription .= '"'.$listePublicite[$i][ 'description'].'"';
    		}else {
    			$id .= '"'.$listePublicite[$i]['id'].'",';
    			$publier .= '"'.$listePublicite[$i]['publier'].'",';
    			$listeDesImages .= '"'.$listePublicite[$i]['image'].'",';
    			$listeDesLiens  .= '"'.$listePublicite[$i][ 'lien'].'",';
    			$listeDesDescription .= '"'.$listePublicite[$i][ 'description'].'",';
    		}
    	}
    	$lignePub = $this->getPubliciteTable()->getPubliciteActive();
    	$pub2 = $this->getPubliciteTable2()->getPublicite2(); //var_dump($pub2); exit();
    	
    	return new ViewModel(array('id' => $id, 'publier' => $publier, 'imageMarqueeRecup' => $lignePub->image, 'listeDesImages' => $listeDesImages, 'listeDesLiens' => $listeDesLiens, 'listeDesDescription' => $listeDesDescription, 'pub2' => $pub2));
    }
    
    public function enregistrementImageAction() {
    	$id_personne = $this->layout()->user['id'];
    	$fileBase64 = $this->params ()->fromPost ( 'fichier_tmp' );
    	$lien = $this->params ()->fromPost ( 'lien' );
    	$description = $this->params ()->fromPost ( 'description' );
    		
    	$today = new \DateTime ( 'now' );
    	$nomfile = 'pub_'.$today->format ( 'dmy_His' );
    	$date_enregistrement = $today->format ( 'Y-m-d H:i:s' );
    	$fileBase64 = substr ( $fileBase64, 23 );
    		
    	if($fileBase64){
    		$img = imagecreatefromstring(base64_decode($fileBase64));
    	}else {
    		$img = false;
    	}
    		
    	if ($img != false) {
    		//ENREGISTREMENT DE LA PHOTO
    		imagejpeg ( $img, 'C:\wamp\www\www-simens-sn\public\img\publicite\images\\' . $nomfile . '.jpg' );
    	} 
    		
    	$donnees = array(
    			'lien' => $lien,
    			'description' => $description,
    			'image' => $nomfile,
    			'date_enregistrement' => $date_enregistrement,
    			'id_personne' => $id_personne,
    	);

    	$this->getPubliciteTable()->addPublicite($donnees);
    		
    	$this->getResponse ()->getHeaders ()->addHeaderLine ( 'Content-Type', 'application/html; charset=utf-8' );
    	return $this->getResponse ()->setContent ( Json::encode (  ) );
    }
    
    public function raffraichissementListeImagesAction() {
    	$id = "";
    	$publier = "";
    	$listeDesImages = "";
    	$listeDesLiens  = "";
    	$listeDesDescription  = "";
    	$listePublicite = $this->getPubliciteTable()->fetchAllPublicite();
    	for($i = 0; $i < count($listePublicite); $i++){
    		if($i == count($listePublicite)-1){ 
    			$id .= '"'.$listePublicite[$i]['id'].'"';
    			$publier .= '"'.$listePublicite[$i]['publier'].'"';
    			$listeDesImages .= '"'.$listePublicite[$i]['image'].'"';
    			$listeDesLiens  .= '"'.$listePublicite[$i][ 'lien'].'"';
    			$listeDesDescription .= '"'.$listePublicite[$i][ 'description'].'"';
    		}else {
    			$id .= '"'.$listePublicite[$i]['id'].'",';
    			$publier .= '"'.$listePublicite[$i]['publier'].'",';
    			$listeDesImages .= '"'.$listePublicite[$i]['image'].'",';
    			$listeDesLiens  .= '"'.$listePublicite[$i][ 'lien'].'",';
    			$listeDesDescription .= '"'.$listePublicite[$i][ 'description'].'",';
    		}
    	}
    	$lignePub = $this->getPubliciteTable()->getPubliciteActive();
    	
    	$html = '<script>'.
      	        'var ImageMarqueeRecup = "'.$lignePub->image.'";'.
      	
      	        'var Id = ['.$id.'];'.
      	        'var Publier = ['.$publier.'];'.
    	        'var ListeImages = ['.$listeDesImages.'];'.
    	        'var ListeLiens = ['.$listeDesLiens.'];'.
    	        'var ListeDescription = ['.$listeDesDescription.'];'.
    	        '</script>';
    	
    	$this->getResponse ()->getHeaders ()->addHeaderLine ( 'Content-Type', 'application/html; charset=utf-8' );
    	return $this->getResponse ()->setContent ( Json::encode ( $html ) );
    }
    
    public function marquerImagePublierAction() {
    	$image = $this->params ()->fromPost ( 'image' );
    	$listePublicite = $this->getPubliciteTable()->marquerPublicite($image);

    	$html ="<a id='pubAccueilLayoutPubManager' href='".$listePublicite->lien."'  target='_blank'> <img src='/www-simens-sn/public/img/publicite/images/".$listePublicite->image.".jpg' /> </a>";
    	$html .="<script> var description = '".$listePublicite->description."'; </script>";
    	$this->getResponse ()->getHeaders ()->addHeaderLine ( 'Content-Type', 'application/html; charset=utf-8' );
    	return $this->getResponse ()->setContent ( Json::encode ( $html ) );
    }
    
    public function supprimerImageAction() {
    	$image = $this->params ()->fromPost ( 'image' );
    	$ligneImage = $this->getPubliciteTable()->supprimerImage($image);
    	
    	unlink ( 'C:\wamp\www\www-simens-sn\public\img\publicite\images\\' . $image . '.jpg' );
    	
    	$html ="<a id='pubAccueilLayoutPubManager' href='".$ligneImage['lien']."'  target='_blank'> <img src='/www-simens-sn/public/img/publicite/images/".$ligneImage['image'].".jpg' /> </a>"; 
    	$html .="<script> var description = '".$ligneImage['description']."'; </script>";
    	$this->getResponse ()->getHeaders ()->addHeaderLine ( 'Content-Type', 'application/html; charset=utf-8' );
    	return $this->getResponse ()->setContent ( Json::encode ( $html ) );
    }
    
    public function modifierImageAction() {
    	$image = $this->params ()->fromPost ( 'image' );
    	$publicite = $this->getPubliciteTable()->getPubliciteWithImage($image);

    	//remplace les cotes ' par \' 
    	$chainePub = str_replace("'", "\'", $publicite->description) ;
    	 
    	$html ="<script> 
    			$('#lien').val('".$publicite->lien."');
    			$('#description').val('".$chainePub."');
    			$('#photo').html('<img style=\'height: 198px; width: 170px; \' src=\'/www-simens-sn/public/img/publicite/images/".$image.".jpg\' />');		
    
    			</script>";
    	$this->getResponse ()->getHeaders ()->addHeaderLine ( 'Content-Type', 'application/html; charset=utf-8' );
    	return $this->getResponse ()->setContent ( Json::encode ( $html ) );
    }
    
    public function modifierContenuImageAction() {
    	$id_personne = $this->layout()->user['id'];
    	$image = $this->params ()->fromPost ( 'image' );
    	$lien = $this->params ()->fromPost ( 'lien' );
    	$description = $this->params ()->fromPost ( 'description' );
    	$result = $this->getPubliciteTable()->updatePublicite($image, $lien, $description, $id_personne);
    	
    	$this->getResponse ()->getHeaders ()->addHeaderLine ( 'Content-Type', 'application/html; charset=utf-8' );
    	return $this->getResponse ()->setContent ( Json::encode ( $result->publier ) );
    }
    
    public function listeImagesDefilantesAction() {
    	$ligne = $this->getImageenteteTable()->getImageEnteteOrdonnee();
    	
    	$html ="
    			<div id='slider2' class='flexslider2'>
    			 <ul class='slides'>";
    	
    	for($i = 0 ; $i < count($ligne) ; $i++) {
    		$html .="<li><img src='/www-simens-sn/public/img/blog/".$ligne[$i]['image'].".JPG' >
					 <div class='inner'>
    				    <div class='iconesMenuNumero'>
					       <p> ".($i+1)." </p>
					    </div>
					    <div class='iconesMenuSup'>
					      <a href='javascript:supprimerImageDefilante(".$ligne[$i]['id'].")'>
					        <img id='1' style='width: 16px; height: 16px; position: absolute; left:5px; top: 5px;' src='/www-simens-sn/public/img/sup.png'>
					      </a>
					    </div>
					    <div class='iconesMenuModif'>
					      <a href='javascript:modifierImageDefilante(".$ligne[$i]['id'].")'>
					        <img id='1' style='width: 16px; height: 16px; position: absolute; left:5px; top: 5px;' src='/www-simens-sn/public/img/pencil_16.png'>
					      </a>
					    </div>";
    		if($ligne[$i]['actif'] == 1){
    			$html .="<div class='iconesMenuActif'>
					      <a href='javascript:desactiverImageDefilante(".$ligne[$i]['id'].")'>
					        <img id='1' style='width: 16px; height: 16px; position: absolute; left:5px; top: 5px;' src='/www-simens-sn/public/img/tick_16_4.png'>
					      </a>
					    </div>";
    		} else if($ligne[$i]['actif'] == 0){
    			$html .="<div class='iconesMenuActif'>
					      <a href='javascript:activerImageDefilante(".$ligne[$i]['id'].")'>
					        <img id='1' style='width: 16px; height: 16px; position: absolute; left:5px; top: 5px;' src='/www-simens-sn/public/img/tick_16_2.png'>
					      </a>
					    </div>";
    		}
			
			
			$html .="<h2 class='flex-caption' style='bottom: 60px;'>".$ligne[$i]['titre_1']."</h2>
						<h3 class='flex-caption' style='bottom: 20px;'>".$ligne[$i]['titre_2']."</h3>
					</div>
				  </li>";
    	}
		
		$html .="
				</ul>
    			</div>
    			
    	        <script>
				 $('#slider2').flexslider({
					controlNav: false, 
					animation: 'slide', 
					start: function(slider){ 
					  $('body').removeClass('loading');
					} 	
				 });
    			</script>
				";
    	
    	$this->getResponse ()->getHeaders ()->addHeaderLine ( 'Content-Type', 'application/html; charset=utf-8' );
    	return $this->getResponse ()->setContent ( Json::encode ( $html ) );
    }
    
    public function recupererImageASupprimerAction() {
    	$id = $this->params ()->fromPost ( 'id' );
    	$ligne = $this->getImageenteteTable()->getImageEnTeteId($id);
    	
    	$html ="
    			<div id='photo_confirmer_suppression'>
                   <img style='height: 100%;' src='/www-simens-sn/public/img/blog/".$ligne->image.".jpg' /> 
		        </div>
		  
		        <p id='information_suppression' style='text-align: center; font-size: 14px; font-family: time new romans; margin-top: 20px; color: #555;'>
		           Confirmation de la suppression de l'image
		        </p>
		  
		        <p id='bouton_supp_ann' style='text-align: center;'>
		           <button class='btn supprimerImg' style='cursor:pointer;'  onclick='supprimerImg(".$ligne->id."); return true;'> Supprimer </button>
		           <button class='btn annulerImg' style='cursor:pointer;'  onclick='annulerImg(); return true;' > Annuler </button>
		        </p>
		           		
    		   ";
    	
    	$this->getResponse ()->getHeaders ()->addHeaderLine ( 'Content-Type', 'application/html; charset=utf-8' );
    	return $this->getResponse ()->setContent ( Json::encode ( $html ) );
    }
    
    public function supprimerImageDefilanteAction() {
    	$id = $this->params ()->fromPost ( 'id' );
    	
    	$image = $this->getImageenteteTable()->supprimerImageDefilante($id);
    	if($image){   
    		unlink ( 'C:\wamp\www\www-simens-sn\public\img\blog\\' . $image . '.jpg' );
    	}
    	 
    	$this->getResponse ()->getHeaders ()->addHeaderLine ( 'Content-Type', 'application/html; charset=utf-8' );
    	return $this->getResponse ()->setContent ( Json::encode (  ) );
    }
    
    public function recupererImageAModifierAction() {
    	$id = $this->params ()->fromPost ( 'id' );
    	$ligne = $this->getImageenteteTable()->getImageEnTeteId($id);
    	 
    	$html ="
    			<div id='photo_modification_donnees'>
                   <img style='height: 100%;' src='/www-simens-sn/public/img/blog/".$ligne->image.".jpg' /> 
		        </div>
		  
		        <p id='information_modification' style='text-align: center; font-size: 14px; font-family: time new romans; margin-top: 20px; color: #555;'>
		           Validation des donn&eacute;es modifi&eacute;es
		        </p>
		  
		        <p id='bouton_supp_ann_modif' style='text-align: center;'>
		           <button class='btn supprimerImg' style='cursor:pointer;'  onclick='validerModifImg(".$ligne->id."); return true;'> Valider </button>
		           <button class='btn annulerImg' style='cursor:pointer;'  onclick='annulerModifImg(); return true;' > Annuler </button>
		        </p>
		      
		           		
		        <table id='tab_modification_donnees'  style='width: 97%; margin-left: 5px; margin-top: 55px;'>
                <tr style='width: 100%; '>
                 <td> 
                  <div style='width: 70%; '>
                    <label>Titre 1: </label>
                    <input type='text' id='titre_1' value='".$ligne->titre_1."'>
		          </div>
                 </td>
                
                 <td rowspan='2' >
                  <div>
                    <label>Description: </label>
                    <textarea id='description_img' >".$ligne->description."</textarea>
		          </div>
                 </td>
 
                </tr>
             
                <tr>
                 <td> 
                  <div>
                    <label>Titre 2: </label>
                    <input type='text' id='titre_2' value='".$ligne->titre_2."'>
		          </div>
                 </td>
                
                </tr>
               </table>
    		   ";
    	 
    	$this->getResponse ()->getHeaders ()->addHeaderLine ( 'Content-Type', 'application/html; charset=utf-8' );
    	return $this->getResponse ()->setContent ( Json::encode ( $html ) );
    }
    
    public function validerModificationImageAction() {
    	$id_personne = $this->layout()->user['id'];
    	$id = $this->params ()->fromPost ( 'id' );
    	$titre_1 = $this->params ()->fromPost ( 'titre_1' );
    	$titre_2 = $this->params ()->fromPost ( 'titre_2' );
    	$description_img = $this->params ()->fromPost ( 'description_img' );
    	
    	$donnees = array(
    		
    			'titre_1' => $titre_1,
    			'titre_2' => $titre_2,
    			'description' => $description_img,
    			'id_personne' => $id_personne,
    	);
    	
    	$this->getImageenteteTable()->modifierImageDefilante($donnees, $id);
    	
    	$this->getResponse ()->getHeaders ()->addHeaderLine ( 'Content-Type', 'application/html; charset=utf-8' );
    	return $this->getResponse ()->setContent ( Json::encode ( ) );
    }
    
    public function activerImageDefilanteAction() {
    	$id_personne = $this->layout()->user['id'];
    	$id = $this->params ()->fromPost ( 'id' );
    	$this->getImageenteteTable()->activerImageDefilante($id_personne, $id);
    	
    	$this->getResponse ()->getHeaders ()->addHeaderLine ( 'Content-Type', 'application/html; charset=utf-8' );
    	return $this->getResponse ()->setContent ( Json::encode ( ) );
    }
    
    public function desactiverImageDefilanteAction() {
    	$id_personne = $this->layout()->user['id'];
    	$id = $this->params ()->fromPost ( 'id' );
    	$this->getImageenteteTable()->desactiverImageDefilante($id_personne, $id);
    	 
    	$this->getResponse ()->getHeaders ()->addHeaderLine ( 'Content-Type', 'application/html; charset=utf-8' );
    	return $this->getResponse ()->setContent ( Json::encode ( ) );
    }
    
    public function imageAAjouterAction() {
    
    	$html ="
    			<div id='photo_ajout_image'>
    			   <div class='photo_image_def' id='photo_def'>
    			      <!-- RECUPERER L'IMAGE -->
		              <input type='file' name='fichier' >
    			   </div>
    			   <!-- FICHIER TAMPON POUR RECUPERER L'IMAGE DANS LE CONTROLLER -->
		           <input type='hidden' id='fichier_tmp_def' name='fichier_tmp_def' >
    			
    			   <div class='supprimer_photo_def' id='supprimer_photo_def' style='width: 24px; height: 15px; float: left;'> </div>
		        </div>
    
		        <p id='information_ajout_img' style='text-align: center; font-size: 14px; font-family: time new romans; margin-top: 20px; color: #555;'>
		           Ajout de la nouvelle image
		        </p>
    
		        <p id='bouton_supp_valid_ajout' style='text-align: center;'>
		           <button class='btn supprimerImg' style='cursor:pointer;'  onclick='validerAjoutImg(); return true;'> Ajouter </button>
		           <button class='btn annulerImg' style='cursor:pointer;'  onclick='annulerAjoutImg(); return true;' > Annuler </button>
		        </p>
    
		      
		        <table id='tab_modification_donnees'  style='width: 97%; margin-left: 5px; margin-top: 55px;'>
                <tr style='width: 100%; '>
                 <td>
                  <div style='width: 70%; '>
                    <label>Titre 1: </label>
                    <input type='text' id='titre_1_aj' value=''>
		          </div>
                 </td>
    
                 <td rowspan='2' >
                  <div>
                    <label>Description: </label>
                    <textarea id='description_img_aj' ></textarea>
		          </div>
                 </td>
    
                </tr>
       
                <tr>
                 <td>
                  <div>
                    <label>Titre 2: </label>
                    <input type='text' id='titre_2_aj' value=''>
		          </div>
                 </td>
    
                </tr>
               </table>
    			<script>RecupererImageDef();</script>
    		   ";
    
    	$this->getResponse ()->getHeaders ()->addHeaderLine ( 'Content-Type', 'application/html; charset=utf-8' );
    	return $this->getResponse ()->setContent ( Json::encode ( $html ) );
    }
    
    
    public function validerAjoutImageAction() {
    	$id_personne = $this->layout()->user['id'];
    	$titre_1_aj = $this->params ()->fromPost ( 'titre_1_aj' );
    	$titre_2_aj = $this->params ()->fromPost ( 'titre_2_aj' );
    	$description_img_aj = $this->params ()->fromPost ( 'description_img_aj' );
    	$fileBase64 = $this->params ()->fromPost ( 'fichier_tmp_def' );
    	 
    	$today = new \DateTime ( 'now' );
    	$date_enregistrement = $today->format ( 'Y-m-d H:i:s' );
    	$nomImage = 'img_def_'.$today->format ( 'dmy_His' );
    	$fileBase64 = substr ( $fileBase64, 23 );
    	
    	
    	if($fileBase64){
    		$img = imagecreatefromstring(base64_decode($fileBase64));
    	}else {
    		$img = false;
    	}
    	
    	$resultatAjout = 0;
    	if ($img != false) {
    		//ENREGISTREMENT DE LA PHOTO
    		imagejpeg ( $img, 'C:\wamp\www\www-simens-sn\public\img\blog\\' . $nomImage . '.jpg' );
    		
    		$donnees = array(
    		
    				'titre_1' => $titre_1_aj,
    				'titre_2' => $titre_2_aj,
    				'description' => $description_img_aj,
    				'image' => $nomImage,
    				'date_enregistrement' => $date_enregistrement,
    				'actif' => 0,
    				'id_personne' => $id_personne,
    		);
    		 
    		 
    		$this->getImageenteteTable()->ajouterImageDefilante($donnees);
    		$resultatAjout = 1;
    	}
    	
    	 
    	$this->getResponse ()->getHeaders ()->addHeaderLine ( 'Content-Type', 'application/html; charset=utf-8' );
    	return $this->getResponse ()->setContent ( Json::encode ( $resultatAjout ) );
    }
    
    public function raffraichirImagesDefilantesEnTeteAction() {
    	$ligne = $this->getImageenteteTable()->getImageEnteteOrdonneeActif();
    	 
    	$html ="<div id='slider' class='flexslider'>
    			 <ul class='slides'>";
    	 
    	for($i = 0 ; $i < count($ligne) ; $i++) {
    		$html .="<li><img src='/www-simens-sn/public/img/blog/".$ligne[$i]['image'].".jpg' >
					  <div class='inner'>
    		            <h2 class='flex-caption' style='bottom: 60px;'>".$ligne[$i]['titre_1']."</h2>
						<h3 class='flex-caption' style='bottom: 20px;'>".$ligne[$i]['titre_2']."</h3>
					  </div>
				     </li>";
    	}
    	
    	$html .=" </ul>
    			 </div>
    			
    			<script>
				   $('.flexslider').flexslider({
					 controlNav: false, 
					 animation: 'slide', 
					 start: function(slider){ 
					   $('body').removeClass('loading');
					 } 	
				   });
    			  </script>
    			
    			";
    	
    	
    	$this->getResponse ()->getHeaders ()->addHeaderLine ( 'Content-Type', 'application/html; charset=utf-8' );
    	return $this->getResponse ()->setContent ( Json::encode ( $html ) );
    }
    
    public function ajouterPubliciteN2Action() {
    	$id_personne = $this->layout()->user['id'];
    	$titre = $this->params ()->fromPost ( 'titre' );
    	$contenu = $this->params ()->fromPost ( 'contenu' );
    	$data = array(
    			'titre' => $titre,
    			'contenu' => $contenu,
    			'id_personne' => $id_personne,
    	);
    	
    	$listePublicite = $this->getPubliciteTable2()->updatePubliciteN2($data);
    
    	$this->getResponse ()->getHeaders ()->addHeaderLine ( 'Content-Type', 'application/html; charset=utf-8' );
    	return $this->getResponse ()->setContent ( Json::encode ( ) );
    }
    
    public function depublierPubliciteN2Action() {
    	$id_personne = $this->layout()->user['id'];
    	$titre = $this->params ()->fromPost ( 'titre' );
    	$contenu = $this->params ()->fromPost ( 'contenu' );
    	$data = array(
    			'id_personne' => $id_personne,
    	);
    	 
    	$listePublicite = $this->getPubliciteTable2()->depubliciteN2($data);
    
    	$this->getResponse ()->getHeaders ()->addHeaderLine ( 'Content-Type', 'application/html; charset=utf-8' );
    	return $this->getResponse ()->setContent ( Json::encode ( ) );
    }
    
}
