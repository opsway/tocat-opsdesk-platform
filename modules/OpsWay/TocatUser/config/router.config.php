<?php
namespace OpsWay\TocatUser;

return [
    'router' => [
        'routes' => [
            'zfcuser' => [
                'child_routes' => [
                    'account'      => [
                        'type'     => 'Segment',
                        'priority' => 1000,
                        'options'  => [
                            'route'       => '/account[/:action]',
                            'constraints' => [
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                            ],
                            'defaults'    => [
                                'controller' => Controller\UserAccountController::class,
                                'action'     => 'index',
                            ],
                        ],
                    ],
                ],
            ],
            'zfcadmin' => [
                'child_routes' => [
                    'roles'      => [
                        'type'     => 'Segment',
                        'priority' => 1000,
                        'options'  => [
                            'route'       => '/roles[/:action]',
                            'constraints' => [
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                            ],
                            'defaults'    => [
                                'controller' => Controller\Admin\RoleController::class,
                                'action'     => 'index',
                            ],
                        ],
                    ],
                    'groups'     => [
                        'type'     => 'Segment',
                        'priority' => 1000,
                        'options'  => [
                            'route'       => '/groups[/:action]',
                            'constraints' => [
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                            ],
                            'defaults'    => [
                                'controller' => Controller\Admin\GroupController::class,
                                'action'     => 'index',
                            ],
                        ],
                    ],
                    'permission' => [
                        'type'     => 'Segment',
                        'priority' => 1000,
                        'options'  => [
                            'route'       => '/permission[/:action[/:role_id]]',
                            'constraints' => [
                                'action'  => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'role_id' => '[0-9]*'
                            ],
                            'defaults'    => [
                                'controller' => Controller\Admin\PermissionController::class,
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
