<?php

return array(
		
	'controllers' => array(
		'invokables' => array(
			'Maladie\Controller\Maladie' => 'Maladie\Controller\MaladieController'
		),
	),
		
    'router' => array(
        'routes' => array(
        			
        			'maladie' => array(
        					'type'    => 'Segment',
        					'options' => array(
        							'route' => '/maladie[/][:action][/:id][/:val]', 
										'constraints' => array (
												'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
												'id' => '[a-zA-Z][a-zA-Z0-9_-]*',
												'val' => '[0-9]+'
										),
        							'defaults' => array(
        									'controller' => 'Maladie\Controller\Maladie',
        									'action'     => 'maladie',
        							),
        					),
        			
        			),
        			
             ),
        ),
	    
		'view_manager' => array(
				'template_map' => array(
// 						'maladie/maladie/index' 			=> __DIR__ . '/../view/maladie/maladie/index.phtml',
				),
				'template_path_stack' => array(
						'maladie' => __DIR__ . '/../view',
				),
		),
);
