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
    // Placeholder for console routes
    'console'    => [
        'router' => [
            'routes' => [],
        ],
    ],
];
