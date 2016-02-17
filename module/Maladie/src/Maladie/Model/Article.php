<?php

namespace Maladie\Model;

class Article
{
	public $code_article;
	public $code_sous_categorie;
	public $id_personne_redact;
	public $id_personne_moder;
	public $titre_article;
	public $source_article;
	public $resume_article;
	public $description_article;
	public $image_article;
	public $contenu_article;
	public $date_redaction_article;
	public $date_modification_article;
	public $date_modification_article_moder;
	public $date_soumission_article;
	public $date_publication_article;
	public $article_soumis;
	public $article_publie;
	
	public function exchangeArray($data)
	{
		$this->code_article     	= (!empty($data['code_article'])) ? $data['code_article'] : null;
		$this->code_sous_categorie 	= (!empty($data['code_sous_categorie'])) ? $data['code_sous_categorie'] : null;
		$this->id_personne_redact  	    = (!empty($data['id_personne_redact'])) ? $data['id_personne_redact'] : null;
		$this->id_personne_moder  	    = (!empty($data['id_personne_moder'])) ? $data['id_personne_moder'] : null;
		$this->titre_article     	= (!empty($data['titre_article'])) ? $data['titre_article'] : null;
		$this->source_article     	= (!empty($data['source_article'])) ? $data['source_article'] : null;
		$this->resume_article 	    = (!empty($data['resume_article'])) ? $data['resume_article'] : null;
		$this->description_article  = (!empty($data['description_article'])) ? $data['description_article'] : null;
		$this->image_article  	    = (!empty($data['image_article'])) ? $data['image_article'] : null;
		$this->contenu_article  	= (!empty($data['contenu_article'])) ? $data['contenu_article'] : null;
		$this->date_redaction_article  	= (!empty($data['date_redaction_article'])) ? $data['date_redaction_article'] : 'imagedeune.JPG';
		$this->date_modification_article = (!empty($data['date_modification_article'])) ? $data['date_modification_article'] : null;
		$this->date_modification_article_moder = (!empty($data['date_modification_article_moder'])) ? $data['date_modification_article_moder'] : null;
		$this->date_soumission_article = (!empty($data['date_soumission_article'])) ? $data['date_soumission_article'] : null;
		$this->date_publication_article = (!empty($data['date_publication_article'])) ? $data['date_publication_article'] : null;
		$this->article_soumis = (!empty($data['article_soumis'])) ? $data['article_soumis'] : null;
		$this->article_publie = (!empty($data['article_publie'])) ? $data['article_publie'] : null;
		
	}
}