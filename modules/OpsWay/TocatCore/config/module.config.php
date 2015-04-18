<?php
namespace OpsWay\TocatCore;

return [
    'zfcadmin'   => [
        'use_admin_layout'      => true,
        'admin_layout_template' => 'layout/admin',
    ],
    'translator' => [
        'locale'                    => 'en_US',
        'translation_file_patterns' => [
            [
                'type'     => 'gettext',
                'base_dir' => __DIR__ . '/../language',
                'pattern'  => '%s.mo',
            ],
        ],
    ],
    'application_manager' => [
        'module_paths_migration' => [
            __NAMESPACE__ => __DIR__ . '/../migration'
        ],
    ],
    'doctrine' => [
        'eventmanager' => [
            'orm_default' => [
                'subscribers' => [
                    \Gedmo\Timestampable\TimestampableListener::class,
                ],
            ],
        ],
    ],
    'asset_manager' => [
        'caching' => [
            'default' => [
                'cache'   => 'Assetic\\Cache\\FilesystemCache',
                'options' => [
                    'dir' => 'public', // path/to/cache
                ],
            ],
        ],
        'resolver_configs' => [
            'paths' => [
                __DIR__ . '/../public',
            ],
        ],
    ],
];
