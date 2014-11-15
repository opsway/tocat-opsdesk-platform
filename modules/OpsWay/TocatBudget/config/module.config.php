<?php
namespace OpsWay\TocatBudget;

return [
    'doctrine'     => [
        'driver' => [
            'budget_entity' => [
                'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
                'paths' => [__DIR__ . '/../code/Entity']
            ],
            'orm_default'    => [
                'drivers' => [
                    __NAMESPACE__ . '\Entity' => 'budget_entity',
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
    'translator' => [
        'translation_file_patterns' => [
            [
                'type'     => 'gettext',
                'base_dir' => __DIR__ . '/../language',
                'pattern'  => '%s.mo',
            ],
        ],
    ],
];
