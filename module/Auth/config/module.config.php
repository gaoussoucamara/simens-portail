<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

return array(
		'controllers' => array(
				'invokables' => array(
						'Auth\Controller\Auth' => 'Auth\Controller\AuthController'
				),
		),
		
		'router' => array (
				'routes' => array (
						'auth' => array (
								'type' => 'segment',
								'options' => array (
										'route' => '/auth[/][:action][/:id][/:val]', 
										'constraints' => array (
												'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
												'id' => '[a-zA-Z][a-zA-Z0-9_-]*',
												'val' => '[0-9]+'
										),
										'defaults' => array (
												'controller' => 'Auth\Controller\Auth',
												'action' => 'login'
										)
								)
						)
				)
		),

        'view_manager' => array(
        		'template_path_stack' => array(
        				__DIR__ . '/../view',
        		),
        ),
);
