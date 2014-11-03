<?php
return [
    'bjyauthorize' => [
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