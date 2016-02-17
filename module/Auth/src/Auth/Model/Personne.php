<?php

namespace Auth\Model;

class Personne
{
	public $email_personne;
	public $nom_personne;
	public $prenom_personne;
	public $statut_personne;
	public $adresse_personne;
	public $telephone_personne;
	public $site_web_personne;
	public $image_personne;
	
	public $date_inscription;
	public $sexe_personne;
	public $pseudo;
	public $role_personne;
	public $usr_active;

	public function exchangeArray($data)
	{
		$this->email_personne     	= (!empty($data['email_personne'])) ? $data['email_personne'] : null;
		$this->nom_personne 		= (!empty($data['nom_personne'])) ? $data['nom_personne'] : null;
		$this->prenom_personne  	= (!empty($data['prenom_personne'])) ? $data['prenom_personne'] : null;
		$this->statut_personne     	= (!empty($data['statut_personne'])) ? $data['statut_personne'] : null;
		$this->adresse_personne 	= (!empty($data['adresse_personne'])) ? $data['adresse_personne'] : null;
		$this->telephone_personne  	= (!empty($data['telephone_personne'])) ? $data['telephone_personne'] : null;
		$this->site_web_personne  	= (!empty($data['site_web_personne'])) ? $data['site_web_personne'] : null;
		$this->image_personne  		= (!empty($data['image_personne'])) ? $data['image_personne'] : 'imagedeune.JPG';
		
		$this->date_inscription  = (!empty($data['date_inscription'])) ? $data['date_inscription'] : null;
		$this->sexe_personne  = (!empty($data['sexe_personne'])) ? $data['sexe_personne'] : null;
		$this->pseudo  = (!empty($data['pseudo'])) ? $data['pseudo'] : null;
		$this->role_personne  = (!empty($data['role_personne'])) ? $data['role_personne'] : null;
		$this->usr_active  = (!empty($data['usr_active'])) ? $data['usr_active'] : null;
	}
}