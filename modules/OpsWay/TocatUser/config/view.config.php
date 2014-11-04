<?php
namespace OpsWay\TocatUser;

return [
    'view_manager' => [
        'template_path_stack' => [
            __DIR__ . '/../template',
        ],
        'controller_map'      => [
            __NAMESPACE__ => 'tocatuser'
        ],
    ],
];
