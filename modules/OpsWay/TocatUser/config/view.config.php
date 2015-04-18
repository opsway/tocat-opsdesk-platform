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
        'template_map'        => [
            'zfc-user/user/index' => __DIR__ . '/../template/tocatuser/user/index.phtml',
            'zfc-user-admin/user-admin/list' => __DIR__ . '/../template/tocatuser/admin/user/list.phtml',
        ],
    ],
    'view_helpers' => [
        'invokables' => [
            'userTopWidget' => View\Helper\UserTopWidget::class,
        ],
    ],
];
