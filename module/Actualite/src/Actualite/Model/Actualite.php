<?php

namespace Actualite\Model;

class Actualite
{
	public $id;
	public $titre;
	public $source;
	public $source_web;
	public $code_sous_categorie;
	public $description;
	public $contenu;
	public $image_actu;
	public $actu_publie;
	public $id_personne;
	public $date_enregistrement;
	public $date_modification;
	public $date_publication;
	public $date_depublication;
	
	public function exchangeArray($data)
	{
		$this->id     	  = (!empty($data['id'])) ? $data['id'] : null;
		$this->titre 	  = (!empty($data['titre'])) ? $data['titre'] : null;
		$this->source  	  = (!empty($data['source'])) ? $data['source'] : null;
		$this->source_web = (!empty($data['source_web'])) ? $data['source_web'] : null;
		$this->code_sous_categorie  = (!empty($data['code_sous_categorie'])) ? $data['code_sous_categorie'] : null;
		$this->description = (!empty($data['description'])) ? $data['description'] : null;
		$this->contenu 	   = (!empty($data['contenu'])) ? $data['contenu'] : null;
		$this->image_actu  = (!empty($data['image_actu'])) ? $data['image_actu'] : null;
		$this->actu_publie = (!empty($data['actu_publie'])) ? $data['actu_publie'] : null;
		$this->id_personne = (!empty($data['id_personne'])) ? $data['id_personne'] : null;
		$this->date_enregistrement = (!empty($data['date_enregistrement'])) ? $data['date_enregistrement'] : null;
		$this->date_modification = (!empty($data['date_modification'])) ? $data['date_modification'] : null; 
		$this->date_publication = (!empty($data['date_publication'])) ? $data['date_publication'] : null;
		$this->date_depublication = (!empty($data['date_depublication'])) ? $data['date_depublication'] : null;
	}
}