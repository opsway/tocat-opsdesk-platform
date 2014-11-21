<?php
namespace OpsWay\TocatUser;

use BjyAuthorize\Provider\Resource;
use BjyAuthorize\Provider\Rule;
use BjyAuthorize\Provider\Role;
use BjyAuthorize\Provider\Identity;

return [
    'doctrine'     => [
        'driver' => [
            'zfcuser_entity' => [
                'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
                'paths' => [__DIR__ . '/../code/Entity']
            ],
            'orm_default'    => [
                'drivers' => [
                    __NAMESPACE__ . '\Entity' => 'zfcuser_entity',
                ]
            ]
        ]
    ],
    'application_manager' => [
        'module_paths_migration' => [
            __NAMESPACE__ => __DIR__ . '/../migration'
        ],
    ],
    'asset_manager' => [
        'resolver_configs' => [
            'paths' => [
                __DIR__ . '/../public',
            ],
        ],
    ],
    'zfcuser' => [
        'user_entity_class'       => Entity\User::class,
        'enable_default_entities' => false,
        'UserEntityClass'         => Entity\User::class,
        'EnableDefaultEntities'   => false,
        'enable_username'         => false,
        'enable_display_name'     => true,
        'auth_identity_fields'    => ['email'],
        'login_redirect_route'    => 'zfcuser/account',
        'use_redirect_parameter_if_present' => true
    ],
    'zfcuseradmin' => [
        'user_list_elements'        => ['Id' => 'id', 'Name' => 'display_name', 'Email address' => 'email'],
        'create_user_auto_password' => true,
        'user_mapper'               => 'ZfcUserAdmin\Mapper\UserDoctrine',
    ],
    'bjyauthorize' => [
        'default_role'          => 'guest',
        'identity_provider'     => Identity\AuthenticationIdentityProvider::class,
        'authenticated_role'    => 'user',
        'unauthorized_strategy' => View\UnauthorizedStrategy::class,
        'role_providers'        => [
            Role\ObjectRepositoryProvider::class => [
                'object_manager'    => 'doctrine.entitymanager.orm_default',
                'role_entity_class' => Entity\Role::class,
            ],
        ],
        'resource_providers'    => [
            Resource\Config::class => [
                'top_nav:teams'          => [],
                'top_nav:staff'          => [],
                'top_nav:budget'         => [],
                'top_nav:payment'        => [],
                'top_nav:administration' => [],
            ],
        ],
        'rule_providers'        => [
            Rule\Config::class => [
                'allow' => [
                    [
                        ['user'],
                        [
                            'top_nav:teams',
                            'top_nav:staff',
                            'top_nav:budget',
                            'top_nav:payment',
                            'top_nav:administration'
                        ],
                        ['list']
                    ],
                ],
            ],
        ],
        'guards'                => [
            Guard\DoctrineController::class => [
                'object_manager'    => 'doctrine.entitymanager.orm_default',
                'rule_entity_class' => Entity\Permission::class
            ],
        ],
    ],
];
