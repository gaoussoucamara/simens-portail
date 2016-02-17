<?php

namespace Presentation\Model\Partenaire;

use Zend\Db\TableGateway\TableGateway;

class PartenaireTable
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

	public function getPartenaire($code_institution)
	{
		//$code_institution  = (string) $code_institution;
		$rowset = $this->tableGateway->select(array('code_institution' => $code_institution));
		$row = $rowset->current();
		if (!$row) {
			throw new \Exception("Could not find row $code_institution");
		}
		return $row;
	}

}