<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Presentation;

use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\ModuleManager\Feature\ConfigProviderInterface;
use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;
use Presentation\Model\Contributeur\ContributeurTable;
use Presentation\Model\Contributeur\Contributeur;
use Presentation\Model\Partenaire\PartenaireTable;
use Presentation\Model\Partenaire\Partenaire;


class Module implements AutoloaderProviderInterface, ConfigProviderInterface
{
    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }
    
    public function getServiceConfig()
    {
    	return array(
    			'factories' => array(
    					'Presentation\Model\Contributeur\ContributeurTable' =>  function($sm) {
    						$tableGateway = $sm->get('ContributeurTableGateway');
    						$table = new ContributeurTable($tableGateway);
    						return $table;
    					},
    					'ContributeurTableGateway' => function ($sm) {
    						$dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
    						$resultSetPrototype = new ResultSet();
    						$resultSetPrototype->setArrayObjectPrototype(new Contributeur());
    						return new TableGateway('personne', $dbAdapter, null, $resultSetPrototype);
    					},
    					'Presentation\Model\Partenaire\PartenaireTable' =>  function($sm) {
    						$tableGateway = $sm->get('PartenaireTableGateway');
    						$table = new PartenaireTable($tableGateway);
    						return $table;
    					},
    					'PartenaireTableGateway' => function ($sm) {
    						$dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
    						$resultSetPrototype = new ResultSet();
    						$resultSetPrototype->setArrayObjectPrototype(new Partenaire());
    						return new TableGateway('institution', $dbAdapter, null, $resultSetPrototype);
    					},
    			),
    	);
    }
    
}
