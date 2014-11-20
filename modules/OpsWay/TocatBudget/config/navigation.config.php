<?php
namespace OpsWay\TocatBudget;

return [
    'navigation'      => [
        'top_nav' => [
            'budget'         => [
                'label'     => 'Budgets',
                'icon'      => 'glyphicon glyphicon-usd',
                'route'     => 'stub',
                'params'    => ['id' => 'budget'],
                'resource'  => 'top_nav:budget',
                'privilege' => 'list',
                'order'     => 30,
                'pages'     => [
                    'ticket' => [
                        'label'  => 'Ticket',
                        'route'  => 'budget/ticket',
                        'params' => ['action' => 'index'],
                    ],
                    'order'  => [
                        'label'  => 'Order',
                        'route'  => 'stub',
                        'params' => ['id' => 'order'],
                    ],
                ],
            ],
        ],
    ],
];
