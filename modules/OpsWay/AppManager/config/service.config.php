<?php
namespace OpsWay\AppManager;

return [
    'service_manager' => [
        'factories' => [
            Service\Manager::class => Factory\Service\ManagerFactory::class,
            'version_storage'      => Factory\Provider\VersionStorageFactory::class,
        ],
    ],
];
