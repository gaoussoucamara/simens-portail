<?php
namespace Admin\Model;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Sql;

class PubliciteTable
{
	protected $tableGateway;

	public function __construct(TableGateway $tableGateway)
	{
		$this->tableGateway = $tableGateway;
	}
	
	public function fetchAllPublicite()
	{
		$db = $this->tableGateway->getAdapter();
		$sql = new Sql($db);
		$sQuery = $sql->select()
		->from(array('pub' => 'publicite'))->columns(array('*'))
		->join(array('pers' => 'personne') ,'pers.id = pub.id_personne' , array() )
		->order('date_enregistrement DESC');
		$stat = $sql->prepareStatementForSqlObject($sQuery);
		$resultSet = $stat->execute();
		
		$tab = array();
		foreach($resultSet as $result){
			$tab[] = $result;
		}
		return $tab;
	}
	
	public function addPublicite($data)
	{
 		$this->tableGateway->insert ( 
 				array(
 						'lien' => $data['lien'] , 
 						'description' => $data['description'] , 
 						'date_enregistrement' => $data['date_enregistrement'],
 						'image' => $data['image'],
 						'id_personne' => $data['id_personne'],
 		             )
 		);

	}
	
	public function getPublicite($id)
	{
		$rowset = $this->tableGateway->select(array('id' => $id));
		$row = $rowset->current();
		if (!$row) {
			return null;
		}
		return $row;
	}
	
	public function getPubliciteActive()
	{
		$rowset = $this->tableGateway->select(array('publier' => 1));
		$row = $rowset->current();
		if (!$row) {
			return null;
		}
		return $row;
	}
	
	public function marquerPublicite($image)
	{
		$today = new \DateTime();
		$date = $today->format('Y-m-d H:i:s');
		
		$rowset = $this->tableGateway->select( array('publier' => 1) );
		$row = $rowset->current();
		if ($row) { 
			$this->tableGateway->update( array('publier' => 0), array('image'=>  $row->image)); 
		}
		$this->tableGateway->update( array('publier' => 1, 'date_modif_pub' => $date), array('image'=>  $image));
		
		return $this->tableGateway->select( array('publier' => 1) )->current();
	}
	
	public function derniereImageMarquee()
	{
		$db = $this->tableGateway->getAdapter();
		$sql = new Sql($db);
		$sQuery = $sql->select()
		->from(array('pub' => 'publicite'))->columns(array('*'))
		->order('date_modif_pub DESC');
		$stat = $sql->prepareStatementForSqlObject($sQuery)->execute()->current();
		return $stat;
	}
	
	public function supprimerImage($image)
	{
		$today = new \DateTime();
		$date = $today->format('Y-m-d H:i:s');
		
		$this->tableGateway->delete( array('image' => $image));
		
		//On marque la dernière image marquée antérieurement
		$ligneImage = $this->derniereImageMarquee();
		$this->tableGateway->update( array('publier' => 1, 'date_modif_pub' => $date), array('id'=>  $ligneImage['id']) );
		
		return $ligneImage;
	}
	
	public function getPubliciteWithImage($image)
	{
		$rowset = $this->tableGateway->select(array('image' => $image));
		$row = $rowset->current();
		if (!$row) {
			return null;
		}
		return $row;
	}
	
	public function updatePublicite($image, $lien, $description, $id_personne)
	{
		$this->tableGateway->update( array('lien' => $lien, 'description' => $description, 'id_personne' => $id_personne), array('image'=>  $image) );
		return $this->getPubliciteWithImage($image);
	}
	
}
