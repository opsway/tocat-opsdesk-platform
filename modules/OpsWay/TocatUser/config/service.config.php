<?php
namespace OpsWay\TocatUser;

return [
    'service_manager' => [
        'invokables' => [
            View\UnauthorizedStrategy::class => View\UnauthorizedStrategy::class,
        ],
        'factories'  => [
            Guard\DoctrineController::class        => Factory\Guard\DoctrineControllerFactory::class,
            Repository\RoleRepository::class       => Factory\Repository\RoleRepositoryFactory::class,
            Repository\GroupRepository::class      => Factory\Repository\GroupRepositoryFactory::class,
            Repository\PermissionRepository::class => Factory\Repository\PermissionRepositoryFactory::class,
            Service\RoleService::class             => Factory\Service\RoleServiceFactory::class,
            Service\GroupService::class            => Factory\Service\GroupServiceFactory::class,
            Service\PermissionService::class       => Factory\Service\PermissionServiceFactory::class,
        ],
    ],
];
