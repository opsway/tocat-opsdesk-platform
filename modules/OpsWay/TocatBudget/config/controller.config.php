<?php
namespace OpsWay\TocatBudget;

return [
    'controllers' => [
        'invokables' => [
            Controller\IndexController::class       => Controller\IndexController::class,
        ],
        'factories'  => [
            Controller\TicketController::class      => Factory\Controller\TicketControllerFactory::class,
        ],
    ],
];
