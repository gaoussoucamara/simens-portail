<?php

namespace Auth\Model;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Sql;
use Zend\Db\Sql\Ddl\Column\Date;

class PersonneTable
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

	public function getPersonne($email)
	{
		$rowset = $this->tableGateway->select(array('email_personne' => $email));
		$row = $rowset->current();
		if (!$row) {
			return null;
		}
		return $row;
	}
	
	public function getInfoPatient($id_personne) {
		$rowset = $this->tableGateway->select(array('id' => $id_personne));
		$row = $rowset->current();
		if (!$row) {
			return null;
		}
		return $row;
	}
	
	public function getListePseudo() {
		$db = $this->tableGateway->getAdapter();
		$sql = new Sql($db);
		$sQuery = $sql->select()
		->from(array('pers' => 'personne'))
		->columns(array('Pseudo'=>'pseudo'));
						
		$stat = $sql->prepareStatementForSqlObject($sQuery);
		$result = $stat->execute();
		
		$listePseudo = array();
		foreach ($result as $r){
			$listePseudo[] = $r['Pseudo'];
		}
		return $listePseudo;
	}
	
	public function getListeEmail() {
		$db = $this->tableGateway->getAdapter();
		$sql = new Sql($db);
		$sQuery = $sql->select()
		->from(array('pers' => 'personne'))
		->columns(array('Email_personne'=>'email_personne'));
	
		$stat = $sql->prepareStatementForSqlObject($sQuery);
		$result = $stat->execute();
	
		$listeEmail = array();
		foreach ($result as $r){
			$listeEmail[] = $r['Email_personne'];
		}
		return $listeEmail;
	}
	
	public function addUtilisateur($data)
	{
		$today = new \DateTime();
		$date = $today->format('Y-m-d H:i:s');
		
		$donnees = array(
				'pseudo' => $data->pseudo,
				'email_personne' => $data->email_personne,
				'mot_de_passe' => $data->nouveau_mot_de_passe,
				'date_inscription' => $date,
				'role_personne' => 'standard',
		); 
		$this->tableGateway->insert($donnees);
	}
	
	public function addUtilisateurNewProfile($data, $cle)
	{
		$today = new \DateTime();
		$date = $today->format('Y-m-d H:i:s');
		$donnees = array(
				'sexe_personne' => $data->genre,
				'nom_personne' => $data->nom_de_famille,
				'prenom_personne' => $data->prenom,
				'email_personne' => $data->email_personne,
				'pseudo' => $data->pseudo,
				'mot_de_passe' => $data->nouveau_mot_de_passe,
				'statut_personne' => $data->statut,
				'adresse_personne' => $data->adresse,
				'telephone_personne' => $data->telephone,
				'site_web_personne' => $data->site_web,
				'role_personne' => $data->role,
				'date_inscription' => $date,
				'usr_registration_token' => $cle,
				
		);
		$this->tableGateway->insert($donnees);
	}
	
	public function modifierUtilisateurProfile($data, $id_personne)
	{
		$today = new \DateTime();
		$date = $today->format('Y-m-d H:i:s');
		$donnees = array(
				'sexe_personne' => $data->genre,
				'nom_personne' => $data->nom_de_famille,
				'prenom_personne' => $data->prenom,
				'email_personne' => $data->email_personne,
				'pseudo' => $data->pseudo,
			    'mot_de_passe' => $data->nouveau_mot_de_passe,
				'statut_personne' => $data->statut,
				'adresse_personne' => $data->adresse,
				'telephone_personne' => $data->telephone,
				'site_web_personne' => $data->site_web,
				'role_personne' => $data->role,
	
		);
		$this->tableGateway->update($donnees, array('id' => $id_personne));
	}
	
	
	public function modifierUtilisateurProfilePopup($data, $id_personne)
	{
		$today = new \DateTime();
		$date = $today->format('Y-m-d H:i:s');
		$donnees = array(
				'sexe_personne' => $data->genre,
				'nom_personne' => $data->nom_de_famille,
				'prenom_personne' => $data->prenom,
				'email_personne' => $data->email_personne,
				'mot_de_passe' => $data->nouveau_mot_de_passe,
				'statut_personne' => $data->statut,
				'adresse_personne' => $data->adresse,
				'telephone_personne' => $data->telephone,
				'site_web_personne' => $data->site_web,
				'role_personne' => $data->role,
	
		);
		$this->tableGateway->update($donnees, array('id' => $id_personne));
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
	
	public function getListePersonneAjax($role)
	{

		$db = $this->tableGateway->getAdapter();
		
		$aColumns = array('Nom','Prenom','Pseudo','Sexe','Id');
		
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
		->from(array('pers' => 'personne'))->columns(
				array(
						'Email'=>'email_personne',
						'Pseudo'=>'pseudo',
						'Nom'=>'nom_personne',
						'Prenom'=>'prenom_personne',
						'Sexe'=>'sexe_personne',
						'Id'=>'id',
						'Date_inscription' => 'date_inscription',
		             ))
		->order('id DESC');
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
		 * $Control pour convertir la date en fran�ais
		*/
		//$Control = new DateHelper();
		
		/*
		 * ADRESSE URL RELATIF
		*/
		$baseUrl = $_SERVER['REQUEST_URI'];
		$tabURI  = explode('public', $baseUrl);
		
		/*
		 * Pr�parer la liste
		*/
		foreach ( $rResult as $aRow )
		{
			if($aRow[ 'Id'] != 1) {
			$row = array();
			for ( $i=0 ; $i<count($aColumns) ; $i++ )
			{
				if ( $aColumns[$i] != ' ' )
				{
					/* General output */
					if ($aColumns[$i] == 'Nom'){
						$row[] = "<khass id='nomMaj'>".$aRow[ $aColumns[$i]]."</khass>";
					}
		
					else if ($aColumns[$i] == 'Sexe') {
						if($aRow[ $aColumns[$i] ] == 'Masculin'){
							$row[] = 'M';
						} else {
							$row[] = 'F';
						}
					}
		
					else if ($aColumns[$i] == 'Id') {
						$html  ="<infoBulleVue> <a id='vue-".$aRow[ $aColumns[$i] ]."' href='javascript:visualiser(".$aRow[ $aColumns[$i] ].")' >";
						$html .="<img style='margin-right: 10%; opacity: 0.8; color: white;' src='".$tabURI[0]."public/img/voird.png' titl='d&eacute;tails'></a> </infoBulleVue>";
		
						if($role == 'super-administrateur'){
							$html .="<infoBulleVue> <a id='modifier-".$aRow[ $aColumns[$i] ]."' href='javascript:modifier(".$aRow[ $aColumns[$i] ].")' >";
							$html .="<img style='margin-right: 10%; opacity: 0.8; color: white;' src='".$tabURI[0]."public/img/pencil_16.png' titl='modifier'></a> </infoBulleVue>";
							
							if($this->getNbJours($aRow['Date_inscription']) < 1){
								$html .="<infoBulleVue> <a id='supprimer-".$aRow[ $aColumns[$i] ]."' href='javascript:supprimer(".$aRow[ $aColumns[$i] ].")' >";
								$html .="<img style='margin-right: 0%; opacity: 0.8; color: white;' src='".$tabURI[0]."public/img/sup.png' titl='supprimer'></a> </infoBulleVue>";
							} else {
								$html .="<infoBulleVue>";
								$html .="<img style='margin-right: 0%; opacity: 0.1; color: white;' src='".$tabURI[0]."public/img/sup.png' > </infoBulleVue>";
							}

						} else {
							$html .="<infoBulleVue> ";
							$html .="<img style='margin-right: 10%; opacity: 0.1; color: white;' src='".$tabURI[0]."public/img/pencil_16.png' ></infoBulleVue>";
							
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
		}
		return $output;
		
	}
	
	public function getUtilisateursWithUsername($pseudo)
	{
		$db = $this->tableGateway->getAdapter();
		$sql = new Sql($db);
		$sQuery = $sql->select()
	
		->from(array('p' => 'personne')) -> columns(array('*') )
		->where(array('pseudo'=>$pseudo));
	
		$stat = $sql->prepareStatementForSqlObject($sQuery);
		$Result = $stat->execute()->current();
		return $Result;
	}

	public function deletePersonne($id)
	{
		$result = $this->tableGateway->delete(array('id' => $id));
		return $result;
	}
}