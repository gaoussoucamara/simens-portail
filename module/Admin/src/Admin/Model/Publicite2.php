<?php
namespace Admin\Model;

class Publicite2
{
	public $id;
	public $titre;
	public $contenu;
	public $date_enregistrement;
	public $actif;
	public $id_personne;

	public function exchangeArray($data)
	{
		$this->id     = (!empty($data['id'])) ? $data['id'] : null;
		$this->titre = (!empty($data['titre'])) ? $data['titre'] : null;
		$this->contenu = (!empty($data['contenu'])) ? $data['contenu'] : null;
		$this->date_enregistrement  = (!empty($data['date_enregistrement'])) ? $data['date_enregistrement'] : null;
		$this->actif = (!empty($data['actif'])) ? $data['actif'] : null;
		$this->id_personne  = (!empty($data['id_personne'])) ? $data['id_personne'] : null;
	}
}