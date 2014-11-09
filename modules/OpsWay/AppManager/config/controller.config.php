<?php
namespace OpsWay\AppManager;

return [
    'controllers' => [
        'factories' => [
            Controller\IndexController::class => Factory\Controller\IndexControllerFactory::class,
        ],
    ],
];
