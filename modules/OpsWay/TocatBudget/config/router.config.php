<?php
namespace OpsWay\TocatBudget;

return [
    'router' => [
        'routes' => [
            'tocatbudget' => [
                'type'    => 'Zend\Mvc\Router\Http\Literal',
                'options' => [
                    'route'    => '/tocatbudget',
                    'defaults' => [
                        'controller' => Controller\IndexController::class,
                        'action'     => 'index',
                    ],
                ],
                'child_routes' => [
                    'index'      => [
                        'type'     => 'Segment',
                        'priority' => 1000,
                        'options'  => [
                            'route'       => '/mylink[/:action]',
                            'constraints' => [
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                            ],
                            'defaults'    => [
                                'controller' => Controller\IndexController::class,
                                'action'     => 'index',
                            ],
                        ],
                    ],
                    'other' => [
                        'type'     => 'Segment',
                        'priority' => 1000,
                        'options'  => [
                            'route'       => '/other[/:action[/:id]]',
                            'constraints' => [
                                'action'  => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'id' => '[0-9]*'
                            ],
                            'defaults'    => [
                                'controller' => Controller\OtherController::class,
                                'action'     => 'index',
                                'role_id'    => null
                            ],
                        ],
                    ],
                ],
            ],
        ],
    ],
];
