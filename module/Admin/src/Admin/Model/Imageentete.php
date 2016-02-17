<?php
namespace Admin\Model;

class Imageentete
{
	public $id;
	public $titre_1;
	public $titre_2;
	public $image; 
	public $description;
	public $date_enregistrement;
	public $date_modification;
	public $actif;
	public $id_personne;

	public function exchangeArray($data)
	{
		$this->id     = (!empty($data['id'])) ? $data['id'] : null;
		$this->titre_1 = (!empty($data['titre_1'])) ? $data['titre_1'] : null;
		$this->titre_2  = (!empty($data['titre_2'])) ? $data['titre_2'] : null;
		$this->image  = (!empty($data['image'])) ? $data['image'] : null;
		$this->description  = (!empty($data['description'])) ? $data['description'] : null;
		$this->date_enregistrement  = (!empty($data['date_enregistrement'])) ? $data['date_enregistrement'] : null;
		$this->date_modification  = (!empty($data['date_modification'])) ? $data['date_modification'] : null;
		$this->actif  = (!empty($data['actif'])) ? $data['actif'] : null;
		$this->id_personne  = (!empty($data['id_personne'])) ? $data['id_personne'] : null;
	}
}