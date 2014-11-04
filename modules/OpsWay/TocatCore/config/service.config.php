<?php
namespace OpsWay\TocatCore;

return [
    'service_manager' => [
        'abstract_factories' => [
            'Zend\Cache\Service\StorageCacheAbstractServiceFactory',
            'Zend\Log\LoggerAbstractServiceFactory',
        ],
        'factories'          => [
            'Zend\Session\SessionManager'         => 'Zend\Session\Service\SessionManagerFactory',
            'Zend\Session\Config\ConfigInterface' => 'Zend\Session\Service\SessionConfigFactory',
            'navigation'                          => Service\TopNavigationFactory::class,
        ],
        'aliases'            => [
            'translator' => 'MvcTranslator',
        ],
    ],
];
