<?php

namespace Admin;

use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Admin\Model\UtilisateursTable;
use Zend\Db\ResultSet\ResultSet;
use Admin\Model\Utilisateurs;
use Zend\Db\TableGateway\TableGateway;
use Zend\EventManager\StaticEventManager;
use Zend\Mvc\MvcEvent;
use Admin\Model\ParametragesTable;
use Admin\Model\Parametrages;
use Admin\Model\PubliciteTable;
use Admin\Model\Publicite;
use Admin\Model\ImageenteteTable;
use Admin\Model\Imageentete;
use Admin\Model\PubliciteTable2;
use Admin\Model\Publicite2;

class Module implements AutoloaderProviderInterface
{
	
	/**
	 * Init function
	 *
	 * @return void
	 */
	public function init()
	{
		// Attach Event to EventManager
		$events = StaticEventManager::getInstance();
		$events->attach('Zend\Mvc\Controller\AbstractActionController', 'dispatch', array($this, 'mvcPreDispatch'), 100); //@todo - Go directly to User\Event\Authentication
	    
	}
	
    /**
     * Get Autoloader Configuration
     *
     * @return array
     */
    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\ClassMapAutoloader' => array(
                __DIR__ . '/autoload_classmap.php'
            ),
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__
                )
            )
        );
    }
    
    
	public function getConfig() {
		return include __DIR__ . '/config/module.config.php';
	}
	
	
	/**
	 * MVC preDispatch Event
	 *
	 * @param $event
	 * @return mixed
	 */
	public function mvcPreDispatch($event) {
		$di = $event->getTarget()->getServiceLocator();
		$auth = $di->get('Admin\Event\Authentication');
	
		return  $auth->preDispatch($event);
	}
	
	public function getServiceConfig()
	{
		return array(
				'factories' => array(
						'Admin\Model\UtilisateursTable' =>  function($sm) {
							$tableGateway = $sm->get('UtilisateursTableGateway');
							$table = new UtilisateursTable($tableGateway);
							return $table;
						},
						'UtilisateursTableGateway' => function ($sm) {
							$dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
							$resultSetPrototype = new ResultSet();
							$resultSetPrototype->setArrayObjectPrototype(new Utilisateurs());
							return new TableGateway('utilisateurs', $dbAdapter, null, $resultSetPrototype);
						},
						'Admin\Model\ParametragesTable' =>  function($sm) {
							$tableGateway = $sm->get('ParametragesTableGateway');
							$table = new ParametragesTable($tableGateway);
							return $table;
						},
						'ParametragesTableGateway' => function ($sm) {
							$dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
							$resultSetPrototype = new ResultSet();
							$resultSetPrototype->setArrayObjectPrototype(new Parametrages());
							return new TableGateway("", $dbAdapter, null, $resultSetPrototype); //Aucune table
						},
						'Admin\Model\PubliciteTable' =>  function($sm) {
							$tableGateway = $sm->get('PubliciteTableGateway');
							$table = new PubliciteTable($tableGateway);
							return $table;
						},
						'PubliciteTableGateway' => function ($sm) {
							$dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
							$resultSetPrototype = new ResultSet();
							$resultSetPrototype->setArrayObjectPrototype(new Publicite());
							return new TableGateway("publicite", $dbAdapter, null, $resultSetPrototype);
						},
						'Admin\Model\ImageenteteTable' =>  function($sm) {
							$tableGateway = $sm->get('ImageenteteTableGateway');
							$table = new ImageenteteTable($tableGateway);
							return $table;
						},
						'ImageenteteTableGateway' => function ($sm) {
							$dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
							$resultSetPrototype = new ResultSet();
							$resultSetPrototype->setArrayObjectPrototype(new Imageentete());
							return new TableGateway("image_entete", $dbAdapter, null, $resultSetPrototype);
						},
						'Admin\Model\PubliciteTable2' =>  function($sm) {
							$tableGateway = $sm->get('PubliciteTable2Gateway');
							$table = new PubliciteTable2($tableGateway);
							return $table;
						},
						'PubliciteTable2Gateway' => function ($sm) {
							$dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
							$resultSetPrototype = new ResultSet();
							$resultSetPrototype->setArrayObjectPrototype(new Publicite2());
							return new TableGateway("publicite2", $dbAdapter, null, $resultSetPrototype);
						},
				),
		);
	}
	
	
	/** UTILISER PAR TOUS LES MODULES **/
	public function onBootstrap(MvcEvent $e) {
		$serviceManager = $e->getApplication ()->getServiceManager ();
		$viewModel = $e->getApplication ()->getMvcEvent ()->getViewModel ();
	
		$uAuth = $serviceManager->get( 'Admin\Controller\Plugin\UserAuthentication' ); //@todo - We must use PluginLoader $this->userAuthentication()!!
		$pseudo = $uAuth->getAuthService()->getIdentity();
	
		//POUR LA PARTIE GESTION UTILISATEUR
		//POUR LA PARTIE GESTION UTILISATEUR
		$uTable = $serviceManager->get( 'Admin\Model\UtilisateursTable' );
		$user = $uTable->getUtilisateursWithUsername($pseudo);
	
		if($user) {
			$viewModel->user = $user;
		}
		
		//POUR LA PARTIE PUBLICITE NIVEAU 1
		//POUR LA PARTIE PUBLICITE NIVEAU 1
		$uTable2 = $serviceManager->get( 'Admin\Model\PubliciteTable' );
		$pub = $uTable2->getPubliciteActive();
		if($pub){ $viewModel->pub = $pub; }
		
		//POUR LA PARTIE PUBLICITE NIVEAU 2
		//POUR LA PARTIE PUBLICITE NIVEAU 2
		$uTable2 = $serviceManager->get( 'Admin\Model\PubliciteTable2' );
		$pub2 = $uTable2->getPublicite2();
		if($pub2){ $viewModel->pub2 = $pub2; }
		
		
		//POUR LA PARTIE IMAGE DEFILANTE
		//POUR LA PARTIE IMAGE DEFILANTE
		$uTable3 = $serviceManager->get( 'Admin\Model\ImageenteteTable' );
		$imageEntete = $uTable3->getImageEnteteOrdonneeActif();
		if($imageEntete){ $viewModel->imagesDefilantes = $imageEntete; }
		
	}
}