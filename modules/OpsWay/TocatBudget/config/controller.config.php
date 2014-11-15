<?php
namespace OpsWay\TocatBudget;

return [
    'controllers' => [
        'invokables' => [
            Controller\IndexController::class       => Controller\IndexController::class,
        ],
        'factories'  => [
            Controller\OtherController::class      => Factory\Controller\OtherControllerFactory::class,
        ],
    ],
];
