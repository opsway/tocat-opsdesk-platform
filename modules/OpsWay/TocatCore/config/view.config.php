<?php
namespace OpsWay\TocatCore;

return [
    'view_manager' => [
        'display_not_found_reason' => true,
        'display_exceptions'       => true,
        'doctype'                  => 'HTML5',
        'not_found_template'       => 'error/404',
        'exception_template'       => 'error/index',
        'template_map'             => [
            'layout/layout' => __DIR__ . '/../template/layout/main.phtml',
            'layout/admin'  => __DIR__ . '/../template/layout/admin.phtml',
            'error/404'     => __DIR__ . '/../template/error/404.phtml',
            'error/index'   => __DIR__ . '/../template/error/index.phtml',
        ],
        'template_path_stack'      => [
            __DIR__ . '/../template',
        ],
        'controller_map'           => [
            __NAMESPACE__ => 'tocatcore'
        ],
        'strategies'               => [
            'ViewJsonStrategy',
        ],
    ],
];
