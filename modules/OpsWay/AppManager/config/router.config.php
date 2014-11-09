<?php
namespace OpsWay\AppManager;

return [
    'console' => [
        'router' => [
            'routes' => [
                'update-modules'  => [
                    'options' => [
                        'route'    => 'app update [--params=] ',
                        'defaults' => [
                            'controller' => Controller\IndexController::class,
                            'action'     => 'update'
                        ]
                    ]
                ],
                'install-modules' => [
                    'options' => [
                        'route'    => 'app install [--params=] ',
                        'defaults' => [
                            'controller' => Controller\IndexController::class,
                            'action'     => 'install'
                        ]
                    ]
                ]
            ]
        ]
    ],
];
