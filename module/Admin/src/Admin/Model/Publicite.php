<?php
namespace Admin\Model;

class Publicite
{
	public $id;
	public $titre;
	public $lien;
	public $description;
	public $date_enregistrement;
	public $date_modification;
	public $image;
	public $publier;
	public $id_personne;

	public function exchangeArray($data)
	{
		$this->id     = (!empty($data['id'])) ? $data['id'] : null;
		$this->titre     = (!empty($data['titre'])) ? $data['titre'] : null;
		$this->lien = (!empty($data['lien'])) ? $data['lien'] : null;
		$this->description  = (!empty($data['description'])) ? $data['description'] : null;
		$this->date_enregistrement  = (!empty($data['date_enregistrement'])) ? $data['date_enregistrement'] : null;
		$this->date_modification  = (!empty($data['date_modification'])) ? $data['date_modification'] : null;
		$this->image  = (!empty($data['image'])) ? $data['image'] : null;
		$this->publier  = (!empty($data['publier'])) ? $data['publier'] : null;
		$this->id_personne  = (!empty($data['id_personne'])) ? $data['id_personne'] : null;
	}
}