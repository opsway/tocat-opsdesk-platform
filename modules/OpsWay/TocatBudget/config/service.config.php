<?php
namespace OpsWay\TocatBudget;

return [
    'service_manager' => [
        'invokables' => [
            //Any\Other::class => Any\Other::class, this for just creating object class through new operator
        ],
        'factories'  => [
            Repository\MyRepository::class       => Factory\Repository\MyRepositoryFactory::class,
            Service\MyService::class             => Factory\Service\MyServiceFactory::class,
        ],
    ],
];
