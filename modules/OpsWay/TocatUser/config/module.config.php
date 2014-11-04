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
        'user_entity_class'       => 'OpsWay\TocatUser\Entity\User',
        'enable_default_entities' => false,
        'UserEntityClass'         => 'OpsWay\TocatUser\Entity\User',
        'EnableDefaultEntities'   => false,
        'enable_username' => false,
        'enable_display_name' => true,
        'auth_identity_fields' => ['email'],
        //'login_redirect_route' => 'zfcuser',
    ],
    'zfcuseradmin'    => [
        'user_list_elements'        => ['Id' => 'id', 'Name' => 'display_name', 'Email address' => 'email'],
        'create_user_auto_password' => true,
        'user_mapper'               => 'ZfcUserAdmin\Mapper\UserDoctrine',
    ],
    'bjyauthorize'    => [
        'default_role'          => 'guest',
        'identity_provider'     => 'BjyAuthorize\Provider\Identity\AuthenticationIdentityProvider',
        'authenticated_role'    => 'user',
        'unauthorized_strategy' => 'OpsWay\TocatUser\View\UnauthorizedStrategy',
        'role_providers'        => [
            'BjyAuthorize\Provider\Role\ObjectRepositoryProvider' => [
                'object_manager'    => 'doctrine.entitymanager.orm_default',
                'role_entity_class' => 'OpsWay\TocatUser\Entity\Role',
            ],
        ],
        'resource_providers' => [
            \BjyAuthorize\Provider\Resource\Config::class => [
                'top_nav:teams'          => [],
                'top_nav:staff'          => [],
                'top_nav:budget'         => [],
                'top_nav:payment'        => [],
                'top_nav:administration' => [],
            ],
        ],
        'rule_providers' => [
            \BjyAuthorize\Provider\Rule\Config::class => [
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
        'guards' => [
            'OpsWay\TocatUser\Guard\DoctrineController' => [
                'object_manager'    => 'doctrine.entitymanager.orm_default',
                'rule_entity_class' => 'OpsWay\TocatUser\Entity\Permission'
            ],
        ],
    ],
];
