<?php
namespace OpsWay\TocatBudget;

return [
    'router' => [
        'routes' => [
            'budget' => [
                'type'    => 'Zend\Mvc\Router\Http\Literal',
                'options' => [
                    'route'    => '/budget',
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
                    'ticket' => [
                        'type'     => 'Segment',
                        'priority' => 1000,
                        'options'  => [
                            'route'       => '/ticket[/:action[/:id]]',
                            'constraints' => [
                                'action'  => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'id' => '[0-9]*'
                            ],
                            'defaults'    => [
                                'controller' => Controller\TicketController::class,
                                'action'     => 'index',
                                'id'    => null
                            ],
                        ],
                    ],
                ],
            ],
        ],
    ],
];
