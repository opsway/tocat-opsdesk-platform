<?php

return [
    // @todo this should split provide by specific modules
    'navigation' => [
        'top_nav' => [
            'homepage'       => [
                'label' => 'Dashboard',
                'route' => 'home',
                'icon'  => 'glyphicon glyphicon-home',
                'order' => 0,
            ],
            'teams'          => [
                'label'     => 'Teams',
                'icon'      => 'glyphicon glyphicon-flag',
                'route'     => 'stub',
                'params'    => ['id' => 'teams'],
                'resource'  => 'top_nav:teams',
                'privilege' => 'list',
                'order'     => 10,
            ],
            'staff'          => [
                'label'     => 'Staff',
                'icon'      => 'glyphicon glyphicon-user',
                'route'     => 'stub',
                'params'    => ['id' => 'staff'],
                'resource'  => 'top_nav:staff',
                'privilege' => 'list',
                'order'     => 20,
            ],
            'payment'        => [
                'label'     => 'Payments',
                'icon'      => 'glyphicon glyphicon-briefcase',
                'route'     => 'stub',
                'params'    => ['id' => 'payment'],
                'resource'  => 'top_nav:payment',
                'privilege' => 'list',
                'order'     => 40,
                'pages'     => [
                    'invoice'     => [
                        'label'  => 'Invoices',
                        'route'  => 'stub',
                        'params' => ['id' => 'invoices'],
                    ],
                    'transaction' => [
                        'label'  => 'Transactions',
                        'route'  => 'stub',
                        'params' => ['id' => 'transactions'],
                    ],
                    'balance'     => [
                        'label'  => 'Balances',
                        'route'  => 'stub',
                        'params' => ['id' => 'balances'],
                    ],
                    'bonus'       => [
                        'label'  => 'Bonuses',
                        'route'  => 'stub',
                        'params' => ['id' => 'bonuses'],
                    ],
                ],
            ],
            'administration' => [
                'label'     => 'Administration',
                'icon'      => 'glyphicon glyphicon-wrench',
                'route'     => 'zfcadmin',
                'resource'  => 'top_nav:administration',
                'privilege' => 'list',
                'order'     => 100,
            ],
        ],
    ],
];
