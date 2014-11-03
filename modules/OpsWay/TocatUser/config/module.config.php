<?php
namespace OpsWay\TocatUser;

return [
    'doctrine'        => [
        'driver' => [
            'zfcuser_entity' => [
                'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
                'paths' => [__DIR__ . '/../code/Entity']
            ],
            'orm_default'    => [
                'drivers' => [
                    'OpsWay\TocatUser\Entity' => 'zfcuser_entity',
                ]
            ]
        ]
    ],
    'zfcuser'         => [
        // telling ZfcUser to use our own class
        'user_entity_class'       => 'OpsWay\TocatUser\Entity\User',
        // telling ZfcUserDoctrineORM to skip the entities it defines
        'enable_default_entities' => false,
        'UserEntityClass'         => 'OpsWay\TocatUser\Entity\User',
        'EnableDefaultEntities'   => false,
    ],
    'zfcuseradmin'    => [
        'user_list_elements'        => ['Id' => 'id', 'Name' => 'display_name', 'Email address' => 'email'],
        'create_user_auto_password' => true,
        'user_mapper'               => 'ZfcUserAdmin\Mapper\UserDoctrine',
    ],
    'bjyauthorize'    => [
        // Using the authentication identity provider, which basically reads the roles from the auth service's identity
        'identity_provider' => 'BjyAuthorize\Provider\Identity\AuthenticationIdentityProvider',
        'role_providers'    => [
            // using an object repository (entity repository] to load all roles into our ACL
            'BjyAuthorize\Provider\Role\ObjectRepositoryProvider' => [
                'object_manager'    => 'doctrine.entitymanager.orm_default',
                'role_entity_class' => 'OpsWay\TocatUser\Entity\Role',
            ],
        ],
    ],
    'service_manager' => [
        'invokables' => [
            View\UnauthorizedStrategy::class => View\UnauthorizedStrategy::class,
        ],
        'factories' => [
            Guard\DoctrineController::class        => Factory\Guard\DoctrineControllerFactory::class,
            Repository\RoleRepository::class       => Factory\Repository\RoleRepositoryFactory::class,
            Repository\GroupRepository::class      => Factory\Repository\GroupRepositoryFactory::class,
            Repository\PermissionRepository::class => Factory\Repository\PermissionRepositoryFactory::class,
            Service\RoleService::class             => Factory\Service\RoleServiceFactory::class,
            Service\GroupService::class            => Factory\Service\GroupServiceFactory::class,
            Service\PermissionService::class       => Factory\Service\PermissionServiceFactory::class,
        ],
    ],
    'controllers'     => [
        'invokables' => [
        ],
        'factories'  => [
            'OpsWay\TocatUser\Controller\Admin\Role' => Factory\Controller\Admin\RoleControllerFactory::class,
            Controller\Admin\GroupController::class => Factory\Controller\Admin\GroupControllerFactory::class,
            Controller\Admin\PermissionController::class => Factory\Controller\Admin\PermissionControllerFactory::class,
        ],
    ],
    'router'          => [
        'routes' => [
            'zfcadmin' => [
                'child_routes' => [
                    'roles' => [
                        'type'     => 'Segment',
                        'priority' => 1000,
                        'options'  => [
                            'route'       => '/roles[/:action]',
                            'constraints' => [
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                            ],
                            'defaults'    => [
                                'controller' => 'OpsWay\TocatUser\Controller\Admin\Role',
                                'action'     => 'index',
                            ],
                        ],
                    ],
                    'groups' => [
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
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
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
    'view_manager'    => [
        'template_path_stack' => [
            __DIR__ . '/../template',
        ],
        'controller_map' => [
            'OpsWay\TocatUser' => true
        ],
    ],
    'navigation'      => [
        'admin' => [
            'roleadmin' => [
                'label'  => 'Roles',
                'route'  => 'zfcadmin/roles',
            ],
            'groupadmin' => [
                'label'  => 'Groups / Teams',
                'route'  => 'zfcadmin/groups',
            ],
            'acladmin' => [
                'label' => 'Permissions',
                'route' => 'zfcadmin/permission',
                'pages' => [
                    'guard' => [
                        'label' => 'Pages',
                        'route' => 'zfcadmin/permission',
                        'params' => ['action' => 'pages'],
                    ],
                    'resource' => [
                        'label' => 'Resource',
                        'route' => 'zfcadmin/permission',
                        'params' => ['action' => 'resource'],
                    ],
                ],
            ],
        ],
    ],
];
