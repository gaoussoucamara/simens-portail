<?php

namespace Presentation\Model\Partenaire;

class Partenaire
{
	public $code_institution;
	public $nom_institution;
	public $adresse_institution;
	public $telephone_institution;
	public $email_institution;
	public $site_web_institution;
	public $logo_institution;
	
	public function exchangeArray($data)
	{
		$this->code_institution     	= (!empty($data['code_institution'])) ? $data['code_institution'] : null;
		$this->nom_institution 			= (!empty($data['nom_institution'])) ? $data['nom_institution'] : null;
		$this->adresse_institution  	= (!empty($data['adresse_institution'])) ? $data['adresse_institution'] : null;
		$this->telephone_institution    = (!empty($data['telephone_institution'])) ? $data['telephone_institution'] : null;
		$this->email_institution 		= (!empty($data['email_institution'])) ? $data['email_institution'] : null;
		$this->site_web_institution  	= (!empty($data['site_web_institution'])) ? $data['site_web_institution'] : null;
		$this->logo_institution  		= (!empty($data['logo_institution'])) ? $data['logo_institution'] : 'imagedeune.JPG';
	}
}