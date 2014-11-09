<?php
namespace OpsWay\TocatCore;

return [
    'router' => [
        'routes' => [
            'home'        => [
                'type'    => 'Zend\Mvc\Router\Http\Literal',
                'options' => [
                    'route'    => '/',
                    'defaults' => [
                        'controller' => Controller\IndexController::class,
                        'action'     => 'index',
                    ],
                ],
            ],
            'stub'        => [
                'type'    => 'Segment',
                'options' => [
                    'route'       => '/app/stub[/:id]',
                    'constraints' => [
                        'id' => '[a-zA-Z][a-zA-Z0-9_-]*',
                    ],
                    'defaults'    => [
                        'controller'    => Controller\IndexController::class,
                        'action'        => 'stub',
                        'id'            => 'null',
                    ],
                ],
            ],
            // The following is a route to simplify getting started creating
            // new controllers and actions without needing to create a new
            // module. Simply drop new controllers in, and you can access them
            // using the path /application/:controller/:action
            'application' => [
                'type'          => 'Literal',
                'options'       => [
                    'route'    => '/application',
                    'defaults' => [
                        'controller'    => Controller\IndexController::class,
                        'action'        => 'index',
                    ],
                ],
                'may_terminate' => true,
                'child_routes'  => [
                    'default' => [
                        'type'    => 'Segment',
                        'options' => [
                            'route'       => '/[:controller[/:action]]',
                            'constraints' => [
                                'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',
                            ],
                            'defaults'    => [],
                        ],
                    ],
                ],
            ],
        ],
    ],
];
