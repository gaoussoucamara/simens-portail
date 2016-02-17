<?php

return array(
		
	'controllers' => array(
		'invokables' => array(
			'Actualite\Controller\Actualite' => 'Actualite\Controller\ActualiteController'
		),
	),
		
    'router' => array(
        'routes' => array(
        			
        			'actualite' => array(
        					'type'    => 'Segment',
        					'options' => array(
        							'route'    => '/actualite[/][:action][/:id][/:val]',
        							'constraints' => array(
        									'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
        									'id' => '[a-zA-Z][a-zA-Z0-9_-]*',
        									'val' => '[0-9]+'
        							),
        							'defaults' => array(
        									'controller' => 'Actualite\Controller\Actualite',
        									'action'     => 'actualite',
        							),
        					),
        			
        			),
        			
             ),
        ),
	    
		'view_manager' => array(
				'template_map' => array(
// 						'actualite/actualite/index' 			=> __DIR__ . '/../view/actualite/actualite/index.phtml',
				),
				'template_path_stack' => array(
						'actualite' => __DIR__ . '/../view',
				),
		),
);
