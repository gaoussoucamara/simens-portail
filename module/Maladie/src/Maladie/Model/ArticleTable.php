<?php

namespace Maladie\Model;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Sql;
use Zend\Db\Sql\Ddl\Column\Date;
use Auth\View\Helper\DateHelper;

class ArticleTable
{
	protected $tableGateway;

	public function __construct(TableGateway $tableGateway)
	{
		$this->tableGateway = $tableGateway;
	}

	public function fetchAll()
	{
		$resultSet = $this->tableGateway->select();
		return $resultSet;
	}

	public function getArticle($id)
	{
		$rowset = $this->tableGateway->select(array('code_article' => $id));
		$row = $rowset->current();
		if (!$row) {
			return null;
		}
		return $row;
	}
	

	public function addArticle($data, $id_personne, $nomImg)
	{
		$today = new \DateTime();
		$date = $today->format('Y-m-d H:i:s');
	
		$donnees = array(
				'id_personne_redact' => $id_personne,
				'titre_article' => $data->titre,
				'source_article' => $data->source,
				'description_article' => $data->description,
				'code_sous_categorie' => $data->categorie,
				'contenu_article' => $data->article,
				'date_redaction_article' => $date,
				'image_article' => $nomImg,
		);
		
		$this->tableGateway->insert($donnees);
	}
	
	public function updateArticleImg($data, $nomImg, $id_personne, $role)
	{
		$donnees = array(
				'titre_article' => $data->titre,
				'source_article' => $data->source,
				'description_article' => $data->description,
				'code_sous_categorie' => $data->categorie,
				'contenu_article' => $data->article,
				'image_article' => $nomImg,
		);
	
		$today = new \DateTime();
		$date = $today->format('Y-m-d H:i:s');
		if($role == 'redacteur'){ 
			$donnees['date_modification_article'] = $date; 
			$donnees['id_personne_redact'] = $id_personne;
		}
		else if($role == 'moderateur'){ 
			$donnees['date_modification_article_moder'] = $date; 
			$donnees['id_personne_moder'] = $id_personne;
		}
		
		$this->tableGateway->update($donnees, array('code_article' => $data->id));
	}
	
	public function updateArticle($data, $id_personne, $role)
	{
		$donnees = array(
				'titre_article' => $data->titre,
				'source_article' => $data->source,
				'description_article' => $data->description,
				'code_sous_categorie' => $data->categorie,
				'contenu_article' => $data->article,
		);
	
		$today = new \DateTime();
		$date = $today->format('Y-m-d H:i:s');
		if($role == 'redacteur'){ 
			$donnees['date_modification_article'] = $date; 
			$donnees['id_personne_redact'] = $id_personne;
		}
		else if($role == 'moderateur'){ 
			$donnees['date_modification_article_moder'] = $date; 
			$donnees['id_personne_moder'] = $id_personne;
		}
		
		$this->tableGateway->update($donnees, array('code_article' => $data->id));
	}
	
	public function getNbJours($debut)
	{
		$today = new \DateTime();
		$fin = $today->format('Y-m-d H:i:s');
			
		$nbSecondes = 60*60*24;
			
		$debut_ts = strtotime($debut);
		$fin_ts = strtotime($fin);
		$diff = $fin_ts - $debut_ts;
			
		return round($diff / $nbSecondes);
	}
	
	
	public function getListeArticleAjax($role, $id_personne)
	{
	
		$db = $this->tableGateway->getAdapter();
	
		$aColumns = array('Titre','Date_redaction','nom_sous_categorie','Date_soumission','Id');
	
		/* Indexed column (used for fast and accurate table cardinality) */
		$sIndexColumn = "id";
	
		/*
		 * Paging
		*/
		$sLimit = array();
		if ( isset( $_GET['iDisplayStart'] ) && $_GET['iDisplayLength'] != '-1' )
		{
			$sLimit[0] = $_GET['iDisplayLength'];
			$sLimit[1] = $_GET['iDisplayStart'];
		}
	
		/*
		 * Ordering
		*/
		if ( isset( $_GET['iSortCol_0'] ) )
		{
			$sOrder = array();
			$j = 0;
			for ( $i=0 ; $i<intval( $_GET['iSortingCols'] ) ; $i++ )
			{
				if ( $_GET[ 'bSortable_'.intval($_GET['iSortCol_'.$i]) ] == "true" )
				{
					$sOrder[$j++] = $aColumns[ intval( $_GET['iSortCol_'.$i] ) ]."
								 	".$_GET['sSortDir_'.$i];
				}
			}
		}
	
		/*
		 * SQL queries
		*/
		$sql = new Sql($db);
		$sQuery = $sql->select()
		->from(array('art' => 'article'))->columns(
				array(
						'Titre'=>'titre_article',
						'Date_redaction'=>'date_redaction_article',
						'Code_categorie'=>'code_sous_categorie',
						'Date_soumission'=>'date_soumission_article',
						'Id'=>'code_article',
						
						'Article_soumis'=>'article_soumis',
						'Article_publie'=>'article_publie',
				))
				->join(array('sous_categorie' => 'sous_categorie_article'), 'art.code_sous_categorie = sous_categorie.code_sous_categorie', array('*'))
				->order('code_article DESC')
				->where(array('id_personne_redact' => $id_personne));
		/* Data set length after filtering */
		$stat = $sql->prepareStatementForSqlObject($sQuery);
		$rResultFt = $stat->execute();
		$iFilteredTotal = count($rResultFt);
	
		$rResult = $rResultFt;
	
		$output = array(
				//"sEcho" => intval($_GET['sEcho']),
				//"iTotalRecords" => $iTotal,
				"iTotalDisplayRecords" => $iFilteredTotal,
				"aaData" => array()
		);
	
		/*
		 * $Control pour convertir la date en franï¿½ais
		*/
		$Control = new DateHelper();
	
		/*
		 * ADRESSE URL RELATIF
		*/
		$baseUrl = $_SERVER['REQUEST_URI'];
		$tabURI  = explode('public', $baseUrl);
	
		/*
		 * Prï¿½parer la liste
		*/
		foreach ( $rResult as $aRow )
		{
				$row = array();
				for ( $i=0 ; $i<count($aColumns) ; $i++ )
				{
					if ( $aColumns[$i] != ' ' )
					{
						/* General output */
						if ($aColumns[$i] == 'Titre'){
							$row[] = '<div style=" height: 30px; overflow: hidden; ">'.$aRow[ $aColumns[$i]].'</div>';
						}
						
						else if ($aColumns[$i] == 'Date_redaction'){
							$row[] = $Control->convertDateTimeListeArticle($aRow[ $aColumns[$i]]);
						}
						
						else if ($aColumns[$i] == 'Date_soumission' && $aRow[ 'Article_soumis'] == 0){
							$row[] = '<span style="color: red; font-style: italic;">non soumis</span>';
						}
						
						else if ($aColumns[$i] == 'Date_soumission' && $aRow[ 'Article_soumis'] == 1){
							$row[] = $Control->convertDateTimeListeArticle($aRow[ $aColumns[$i]]);
						}
						
						else if ($aColumns[$i] == 'Id') {
							$html  ="<infoBulleVue> <a id='vue-".$aRow[ $aColumns[$i] ]."' href='javascript:visualiser(".$aRow[ $aColumns[$i] ].")' >";
							$html .="<img style='margin-right: 10%; opacity: 0.8; color: white;' src='".$tabURI[0]."public/img/voird.png' titl='d&eacute;tails'></a> </infoBulleVue>";
	
							if($role == 'redacteur'){
								if($aRow[ 'Article_soumis'] == 1){
										
									if($aRow[ 'Article_publie'] == 1){
										$html .="<infoBulleVue> ";
										//$html .="<img style='margin-right: 8%; margin-left: 5%; opacity: 0.1; color: white;' src='".$tabURI[0]."public/img/article/Draft_16.png' ></infoBulleVue>";
										$html .="<infoBulleVue> <a id='modifier-".$aRow[ $aColumns[$i] ]."' href='javascript:modifier(".$aRow[ $aColumns[$i] ].")' >";
										$html .="<img style='margin-right: 8%; margin-left: 5%; opacity: 0.8; color: white;' src='".$tabURI[0]."public/img/article/Draft_16.png' titl='modifier'></a> </infoBulleVue>";
										
										$html .="<img style='margin-right: 0%; opacity: 0.8; color: white;' src='".$tabURI[0]."public/img/article/tick_16.png' >";
										
										$html .="<span style='color: green; font-style: italic;'> publi&eacute; </span>";
									} else {
										$html .="<infoBulleVue> <a id='dessoumettre-".$aRow[ $aColumns[$i] ]."' href='javascript:dessoumettre(".$aRow[ $aColumns[$i] ].")' >";
										$html .="<img style='margin-right: 8%; margin-left: 5%; opacity: 0.8; color: white;' src='".$tabURI[0]."public/img/article/stop_16.png' titl='dessoumission'></a> </infoBulleVue>";
										
										$html .="<span style='color: green; font-style: italic;'> soumis </span>";
									}
									
								} else {
									$html .="<infoBulleVue> <a id='modifier-".$aRow[ $aColumns[$i] ]."' href='javascript:modifier(".$aRow[ $aColumns[$i] ].")' >";
									$html .="<img style='margin-right: 8%; margin-left: 5%; opacity: 0.8; color: white;' src='".$tabURI[0]."public/img/article/Draft_16.png' titl='modifier'></a> </infoBulleVue>";
										
									$html .="<infoBulleVue> <a id='supprimer-".$aRow[ $aColumns[$i] ]."' href='javascript:supprimer(".$aRow[ $aColumns[$i] ].")' >";
									$html .="<img style='margin-right: 0%; opacity: 0.8; color: white;' src='".$tabURI[0]."public/img/sup.png' titl='supprimer'></a> </infoBulleVue>";
								
									$html .="<infoBulleVue> <a id='soumettre-".$aRow[ $aColumns[$i] ]."' href='javascript:soumettre(".$aRow[ $aColumns[$i] ].")' >";
									$html .="<img style='margin-right: 0%; opacity: 0.8; color: white;' src='".$tabURI[0]."public/img/article/74bis.png' titl='supprimer'></a> </infoBulleVue>";
										
								}
	
							} else {
								$html .="<infoBulleVue> ";
								$html .="<img style='margin-right: 10%; opacity: 0.1; color: white;' src='".$tabURI[0]."public/img/article/Draft_16.png' ></infoBulleVue>";
									
								$html .="<infoBulleVue>";
								$html .="<img style='margin-right: 0%; opacity: 0.1; color: white;' src='".$tabURI[0]."public/img/sup.png' > </infoBulleVue>";
							}
	
	
							$row[] = $html;
						}
	
						else {
							$row[] = $aRow[ $aColumns[$i] ];
						}
	
					}
				}
				$output['aaData'][] = $row;
		}
		return $output;
	
	}


	//Function utilisée dans Actualite
	public function getListeArticle() {
		$db = $this->tableGateway->getAdapter();
		$sql = new Sql($db);
		$sQuery = $sql->select()
		->from(array('art' => 'article'))
		->columns(array('*'))
		->where(array('article_publie'=>1))
		->order('date_publication_article DESC');
	
		$stat = $sql->prepareStatementForSqlObject($sQuery);
		$result = $stat->execute();
	
		$listeArticle = array();
		foreach ($result as $r){
			$listeArticle[] = $r;
		}
		return $listeArticle;
	}
	
    public function soumissionArticle($code_article)
	{
		$today = new \DateTime();
		$date = $today->format('Y-m-d H:i:s');
		
		$donnees = array(
				'date_soumission_article' => $date,
				'article_soumis' => 1,
		);
	
		$this->tableGateway->update($donnees, array('code_article' => $code_article));
	}
	
	public function dessoumissionArticle($code_article)
	{
		$donnees = array(
				'date_soumission_article' => '0000-00-00 00:00:00',
				'article_soumis' => 0,
		);
	
		$this->tableGateway->update($donnees, array('code_article' => $code_article));
	}
	
	public function publicationArticle($id_personne, $code_article)
	{
		$today = new \DateTime();
		$date = $today->format('Y-m-d H:i:s');
	
		$donnees = array(
				'id_personne_moder' => $id_personne,
				'date_publication_article' => $date,
				'article_publie' => 1,
		);
	
		$this->tableGateway->update($donnees, array('code_article' => $code_article));
	}
	
	public function depublicationArticle($id_personne, $code_article)
	{
		$today = new \DateTime();
		$date = $today->format('Y-m-d H:i:s');
	
		$donnees = array(
				'id_personne_moder' => $id_personne,
				'date_publication_article' => '0000-00-00 00:00:00',
				'date_depublication_article' => $date,
				'article_publie' => 0
		);
	
		$this->tableGateway->update($donnees, array('code_article' => $code_article));
	}
	
	
	public function getListeArticleSoumisAjax($role)
	{

		$db = $this->tableGateway->getAdapter();
		
		$aColumns = array('Titre','Date_soumission','nom_sous_categorie','Date_publication','Id');
		
		/* Indexed column (used for fast and accurate table cardinality) */
		$sIndexColumn = "id";
		
		/*
		 * Paging
		*/
		$sLimit = array();
		if ( isset( $_GET['iDisplayStart'] ) && $_GET['iDisplayLength'] != '-1' )
		{
			$sLimit[0] = $_GET['iDisplayLength'];
			$sLimit[1] = $_GET['iDisplayStart'];
		}
		
		/*
		 * Ordering
		*/
		if ( isset( $_GET['iSortCol_0'] ) )
		{
			$sOrder = array();
			$j = 0;
			for ( $i=0 ; $i<intval( $_GET['iSortingCols'] ) ; $i++ )
			{
				if ( $_GET[ 'bSortable_'.intval($_GET['iSortCol_'.$i]) ] == "true" )
				{
					$sOrder[$j++] = $aColumns[ intval( $_GET['iSortCol_'.$i] ) ]."
								 	".$_GET['sSortDir_'.$i];
				}
			}
		}
		
		/*
		 * SQL queries
		*/
		$sql = new Sql($db);
		$sQuery = $sql->select()
		->from(array('art' => 'article'))->columns(
				array(
						'Titre'=>'titre_article',
						'Date_redaction'=>'date_redaction_article',
						'Code_categorie'=>'code_sous_categorie',
						'Date_soumission'=>'date_soumission_article',
						'Date_publication'=>'date_publication_article',
						'Id'=>'code_article',
		
						'Article_soumis'=>'article_soumis',
						'Article_publie'=>'article_publie',
				))
				->join(array('sous_categorie' => 'sous_categorie_article'), 'art.code_sous_categorie = sous_categorie.code_sous_categorie', array('*'))
				->where(array('article_soumis' => 1))
		        ->order('date_soumission_article DESC');
		/* Data set length after filtering */
		$stat = $sql->prepareStatementForSqlObject($sQuery);
		$rResultFt = $stat->execute();
		$iFilteredTotal = count($rResultFt);
		
		$rResult = $rResultFt;
		
		$output = array(
				//"sEcho" => intval($_GET['sEcho']),
				//"iTotalRecords" => $iTotal,
				"iTotalDisplayRecords" => $iFilteredTotal,
				"aaData" => array()
		);
		
		/*
		 * $Control pour convertir la date en franï¿½ais
		*/
		$Control = new DateHelper();
		
		/*
		 * ADRESSE URL RELATIF
		*/
		$baseUrl = $_SERVER['REQUEST_URI'];
		$tabURI  = explode('public', $baseUrl);
		
		/*
		 * Prï¿½parer la liste
		*/
		foreach ( $rResult as $aRow )
		{
			$row = array();
			for ( $i=0 ; $i<count($aColumns) ; $i++ )
			{
				if ( $aColumns[$i] != ' ' )
				{
					/* General output */
					if ($aColumns[$i] == 'Titre'){
						$row[] = '<div style=" height: 30px; overflow: hidden; ">'.$aRow[ $aColumns[$i]].'</div>';
					}
		
					else if ($aColumns[$i] == 'Date_soumission'){
						$row[] = $Control->convertDateTimeListeArticle($aRow[ $aColumns[$i]]);
					}
		
					else if ($aColumns[$i] == 'Date_publication' && $aRow[ 'Article_publie'] == 0){
						$row[] = '<span style="color: red; font-style: italic;">non publi&eacute;</span>';
					}
		
					else if ($aColumns[$i] == 'Date_publication' && $aRow[ 'Article_publie'] == 1){
						$row[] = $Control->convertDateTimeListeArticle($aRow[ $aColumns[$i]]);
					}
		
					else if ($aColumns[$i] == 'Id') {
						$html  ="<infoBulleVue> <a id='vue-".$aRow[ $aColumns[$i] ]."' href='javascript:visualiser(".$aRow[ $aColumns[$i] ].")' >";
						$html .="<img style='margin-right: 10%; opacity: 0.8; color: white;' src='".$tabURI[0]."public/img/voird.png' titl='d&eacute;tails'></a> </infoBulleVue>";
		
						if($role == 'moderateur'){
							if($aRow[ 'Article_publie'] == 1){
								$html .="<infoBulleVue> <a id='modifier-".$aRow[ $aColumns[$i] ]."' href='javascript:modifier(".$aRow[ $aColumns[$i] ].")' >";
								$html .="<img style='margin-right: 10%; opacity: 0.8; color: white;' src='".$tabURI[0]."public/img/article/Draft_16.png' titl='modifier'></a> </infoBulleVue>";
								
								$html .="<infoBulleVue>";
								$html .="<img style='margin-right: 0%; opacity: 0.8; color: white;' src='".$tabURI[0]."public/img/article/tick_16.png' > </infoBulleVue>";

								$html .="<infoBulleVue> <a id='depublier-".$aRow[ $aColumns[$i] ]."' href='javascript:depublier(".$aRow[ $aColumns[$i] ].")' >";
								$html .="<img style='margin-left: 5%; margin-top: 5%; margin-right: 12%; opacity: 0.8; color: white;' src='".$tabURI[0]."public/img/article/stop_16.png' titl='depublie'></a> </infoBulleVue>";
								
							} else {
								$html .="<infoBulleVue> <a id='modifier-".$aRow[ $aColumns[$i] ]."' href='javascript:modifier(".$aRow[ $aColumns[$i] ].")' >";
								$html .="<img style='margin-right: 10%; opacity: 0.8; color: white;' src='".$tabURI[0]."public/img/article/Draft_16.png' titl='modifier'></a> </infoBulleVue>";
		
								$html .="<infoBulleVue> <a id='supprimer-".$aRow[ $aColumns[$i] ]."' href='javascript:supprimer(".$aRow[ $aColumns[$i] ].")' >";
								$html .="<img style='margin-right: 0%; opacity: 0.8; color: white;' src='".$tabURI[0]."public/img/sup.png' titl='supprimer'></a> </infoBulleVue>";
		
								$html .="<infoBulleVue> <a id='publier-".$aRow[ $aColumns[$i] ]."' href='javascript:publier(".$aRow[ $aColumns[$i] ].")' >";
								$html .="<img style='margin-right: 0%; opacity: 0.8; color: white;' src='".$tabURI[0]."public/img/article/Favorite22.png' titl='publie'></a> </infoBulleVue>";
		
							}
		
						} else {
							$html .="<infoBulleVue> ";
							$html .="<img style='margin-right: 10%; opacity: 0.1; color: white;' src='".$tabURI[0]."public/img/article/Draft_16.png' ></infoBulleVue>";
								
							$html .="<infoBulleVue>";
							$html .="<img style='margin-right: 0%; opacity: 0.1; color: white;' src='".$tabURI[0]."public/img/sup.png' > </infoBulleVue>";
						}
		
		
						$row[] = $html;
					}
		
					else {
						$row[] = $aRow[ $aColumns[$i] ];
					}
		
				}
			}
			$output['aaData'][] = $row;
		}
		return $output;
		
	}
	

	public function getListeArticlesMaladiesAjax()
	{
	
		$db = $this->tableGateway->getAdapter();
	
		$aColumns = array('Titre','Date_soumission','Date_publication','Id');
	
		/* Indexed column (used for fast and accurate table cardinality) */
		$sIndexColumn = "id";
	
		/*
		 * Paging
		*/
		$sLimit = array();
		if ( isset( $_GET['iDisplayStart'] ) && $_GET['iDisplayLength'] != '-1' )
		{
			$sLimit[0] = $_GET['iDisplayLength'];
			$sLimit[1] = $_GET['iDisplayStart'];
		}
	
		/*
		 * Ordering
		*/
		if ( isset( $_GET['iSortCol_0'] ) )
		{
			$sOrder = array();
			$j = 0;
			for ( $i=0 ; $i<intval( $_GET['iSortingCols'] ) ; $i++ )
			{
				if ( $_GET[ 'bSortable_'.intval($_GET['iSortCol_'.$i]) ] == "true" )
				{
					$sOrder[$j++] = $aColumns[ intval( $_GET['iSortCol_'.$i] ) ]."
								 	".$_GET['sSortDir_'.$i];
				}
			}
		}
	
		/*
		 * SQL queries
		*/
		$sql = new Sql($db);
		$sQuery = $sql->select()
		->from(array('art' => 'article'))->columns(
				array(
						'Titre'=>'titre_article',
						'Date_redaction'=>'date_redaction_article',
						'Code_categorie'=>'code_sous_categorie',
						'Date_soumission'=>'date_soumission_article',
						'Date_publication'=>'date_publication_article',
						'Id'=>'code_article',
	
						'Article_soumis'=>'article_soumis',
						'Article_publie'=>'article_publie',
				))
				->join(array('sous_categorie' => 'sous_categorie_article'), 'art.code_sous_categorie = sous_categorie.code_sous_categorie', array('*'))
				->where(array('article_soumis' => 1))
				->order('date_soumission_article DESC');
		/* Data set length after filtering */
		$stat = $sql->prepareStatementForSqlObject($sQuery);
		$rResultFt = $stat->execute();
		$iFilteredTotal = count($rResultFt);
	
		$rResult = $rResultFt;
	
		$output = array(
				//"sEcho" => intval($_GET['sEcho']),
				//"iTotalRecords" => $iTotal,
				"iTotalDisplayRecords" => $iFilteredTotal,
				"aaData" => array()
		);
	
		/*
		 * $Control pour convertir la date en franï¿½ais
		*/
		$Control = new DateHelper();
	
		/*
		 * ADRESSE URL RELATIF
		*/
		$baseUrl = $_SERVER['REQUEST_URI'];
		$tabURI  = explode('public', $baseUrl);
	
		/*
		 * Prï¿½parer la liste
		*/
		foreach ( $rResult as $aRow )
		{
			$row = array();
			for ( $i=0 ; $i<count($aColumns) ; $i++ )
			{
				if ( $aColumns[$i] != ' ' )
				{
					/* General output */
					if ($aColumns[$i] == 'Titre'){
						$row[] = '<div style=" height: 30px; overflow: hidden; ">'.$aRow[ $aColumns[$i]].'</div>';
					}
	
					else if ($aColumns[$i] == 'Date_soumission'){
						$row[] = $Control->convertDateTimeListeArticle($aRow[ $aColumns[$i]]);
					}
	
					else if ($aColumns[$i] == 'Date_publication'){
						$row[] = $Control->convertDateTimeListeArticle($aRow[ $aColumns[$i]]);
					}
	
					else {
						$row[] = $aRow[ $aColumns[$i] ];
					}
	
				}
			}
			$output['aaData'][] = $row;
		}
		return $output;
	
	}
	
	
	public function getListeArticleAuteur() {
		$db = $this->tableGateway->getAdapter();
		$sql = new Sql($db);
		$sQuery = $sql->select()
		->from(array('art' => 'article'))
		->columns(array('*'))
		->join(array('pers' => 'personne'), 'pers.id = art.id_personne_redact', array('*'))
		->join(array('csc' => 'sous_categorie_article'), 'csc.code_sous_categorie = art.code_sous_categorie', array('*'))
		->where(array('article_publie' => 1))
		->order('date_publication_article DESC');
	
		$stat = $sql->prepareStatementForSqlObject($sQuery);
		$result = $stat->execute();
	
		$listeArticle = array();
		foreach ($result as $r){
			$listeArticle[] = $r;
		}
		return $listeArticle;
	}

}