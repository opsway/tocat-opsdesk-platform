<?php
namespace OpsWay\TocatBudget;

return [
    'view_manager' => [
        'template_path_stack' => [
            __DIR__ . '/../template',
        ],
        'controller_map'      => [
            __NAMESPACE__ => 'tocatbudget'
        ],
    ],
    'view_helpers' => [
        'invokables' => [
            'mySuperHelper' => View\MyHelper::class,
        ],
    ],
];
