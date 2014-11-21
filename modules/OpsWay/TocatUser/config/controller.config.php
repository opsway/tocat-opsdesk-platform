<?php
namespace OpsWay\TocatUser;

return [
    'controllers' => [
        'invokables' => [
        ],
        'factories'  => [
            Controller\UserAccountController::class      => Factory\Controller\UserAccountControllerFactory::class,
            Controller\Admin\RoleController::class       => Factory\Controller\Admin\RoleControllerFactory::class,
            Controller\Admin\GroupController::class      => Factory\Controller\Admin\GroupControllerFactory::class,
            Controller\Admin\PermissionController::class => Factory\Controller\Admin\PermissionControllerFactory::class,
        ],
    ],
];
