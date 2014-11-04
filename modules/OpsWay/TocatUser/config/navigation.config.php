<?php
namespace OpsWay\TocatUser;

return [
    'navigation'      => [
        'admin' => [
            'roleadmin' => [
                'label'  => 'Roles',
                'route'  => 'zfcadmin/roles',
            ],
            'groupadmin' => [
                'label'  => 'Groups / Teams',
                'route'  => 'zfcadmin/groups',
            ],
            'acladmin' => [
                'label' => 'Permissions',
                'route' => 'zfcadmin/permission',
                'pages' => [
                    'guard' => [
                        'label' => 'Pages',
                        'route' => 'zfcadmin/permission',
                        'params' => ['action' => 'pages'],
                    ],
                    'resource' => [
                        'label' => 'Resource',
                        'route' => 'zfcadmin/permission',
                        'params' => ['action' => 'resource'],
                    ],
                ],
            ],
        ],
    ],
];
