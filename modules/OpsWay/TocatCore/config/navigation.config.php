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
            'calendar'       => [
                'label' => 'Booking Time',
                'route' => 'calendar',
                'icon'  => 'glyphicon glyphicon-calendar',
                'order' => 5,
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
