<?php
namespace Admin\Model;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Sql;

class ImageenteteTable
{
	protected $tableGateway;

	public function __construct(TableGateway $tableGateway)
	{
		$this->tableGateway = $tableGateway;
	}
	
	public function getImageEntete()
	{
		$rowset = $this->tableGateway->select();
		$table = array();
			
		foreach ($rowset as $rows) {
			$table[] = $rows;
		}
		
		return $table;
	}
	
	public function getImageEnteteOrdonnee()
	{
		$db = $this->tableGateway->getAdapter();
		$sql = new Sql($db);
		$sQuery = $sql->select()
		->from(array('img' => 'image_entete'))->columns(array('*'))
		->order('date_enregistrement DESC');
		$stat = $sql->prepareStatementForSqlObject($sQuery);
		$resultSet = $stat->execute();
		
		$tab = array();
		foreach($resultSet as $result){
			$tab[] = $result;
		}
		return $tab;
	}
	
	public function getImageEnteteOrdonneeActif()
	{
		$db = $this->tableGateway->getAdapter();
		$sql = new Sql($db);
		$sQuery = $sql->select()
		->from(array('img' => 'image_entete'))->columns(array('*'))
		->where(array('actif' => 1))
		->order('date_enregistrement DESC');
		$stat = $sql->prepareStatementForSqlObject($sQuery);
		$resultSet = $stat->execute();
	
		$tab = array();
		foreach($resultSet as $result){
			$tab[] = $result;
		}
		return $tab;
	}
	
	public function getImageEnTeteId($id)
	{
		$rowset = $this->tableGateway->select(array('id' => $id));
		$row = $rowset->current();
		if (!$row) {
			return null;
		}
		return $row;
	}
	
	public function supprimerImageDefilante($id)
	{
		$ligne = $this->getImageEnTeteId($id);
		
		$result = $this->tableGateway->delete( array('id' => $id));
		
		if($result){
			return $ligne->image;
		}
		return null;
	}
	
	public function modifierImageDefilante($donnees, $id)
	{
		return $this->tableGateway->update($donnees, array('id' => $id));
	}
	
	public function activerImageDefilante($id_personne, $id)
	{
		return $this->tableGateway->update(array('actif' => 1, 'id_personne' => $id_personne), array('id' => $id));
	}
	
	public function desactiverImageDefilante($id_personne, $id)
	{
		return $this->tableGateway->update(array('actif' => 0, 'id_personne' => $id_personne), array('id' => $id));
	}
	
	public function ajouterImageDefilante($donnees)
	{
		return $this->tableGateway->insert($donnees);
	}
}