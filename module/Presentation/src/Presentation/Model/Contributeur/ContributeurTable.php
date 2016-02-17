<?php

namespace Presentation\Model\Contributeur;

use Zend\Db\TableGateway\TableGateway;

class ContributeurTable
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

	public function getContributeur($email)
	{
		//$email  = (string) $email;
		$rowset = $this->tableGateway->select(array('email_personne' => $email));
		$row = $rowset->current();
		if (!$row) {
			throw new \Exception("Could not find row $email");
		}
		return $row;
	}

}