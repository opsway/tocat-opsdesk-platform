<?php
namespace OpsWay\AppManager;

return [
    'application_manager' => [
        'version_storage'       => [
            Provider\VersionStorage\ConfigProvider::class => [
                'path_to_file_versions' => __DIR__ . '/../../../../data/migration/current_versions.php'
            ]
        ],
    ],
];
