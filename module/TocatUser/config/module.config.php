<?php
namespace TocatUser;

return array(
    'doctrine'        => array(
        'driver' => array(
            'zfcuser_entity' => array(
                'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
                //'namespace' => 'TocatUser\Entity',
                'paths' => array(__DIR__ . '/../src/TocatUser/Entity')
            ),
            'orm_default'    => array(
                'drivers' => array(
                    'TocatUser\Entity' => 'zfcuser_entity',
                )
            )
        )
    ),
    'zfcuser'         => array(
        // telling ZfcUser to use our own class
        'user_entity_class'       => 'TocatUser\Entity\User',
        // telling ZfcUserDoctrineORM to skip the entities it defines
        'enable_default_entities' => false,
        'UserEntityClass'         => 'TocatUser\Entity\User',
        'EnableDefaultEntities'   => false,
    ),
    'zfcuseradmin'    => array(
        'user_list_elements'        => array('Id' => 'id', 'Name' => 'display_name', 'Email address' => 'email'),
        'create_user_auto_password' => true,
        'user_mapper'               => 'ZfcUserAdmin\Mapper\UserDoctrine',
    ),
    'bjyauthorize'    => array(
        // Using the authentication identity provider, which basically reads the roles from the auth service's identity
        'identity_provider' => 'BjyAuthorize\Provider\Identity\AuthenticationIdentityProvider',
        'role_providers'    => array(
            // using an object repository (entity repository) to load all roles into our ACL
            'BjyAuthorize\Provider\Role\ObjectRepositoryProvider' => array(
                'object_manager'    => 'doctrine.entitymanager.orm_default',
                'role_entity_class' => 'TocatUser\Entity\Role',
            ),
        ),
    ),
    'service_manager' => array(
        'invokables' => array(
            View\UnauthorizedStrategy::class => View\UnauthorizedStrategy::class,
        ),
        'factories' => [
            Repository\RoleRepository::class       => Factory\Repository\RoleRepositoryFactory::class,
            Repository\GroupRepository::class      => Factory\Repository\GroupRepositoryFactory::class,
            Repository\PermissionRepository::class => Factory\Repository\PermissionRepositoryFactory::class,
            Service\RoleService::class             => Factory\Service\RoleServiceFactory::class,
            Service\GroupService::class            => Factory\Service\GroupServiceFactory::class,
            Service\PermissionService::class       => Factory\Service\PermissionServiceFactory::class,
        ],
    ),
    'controllers'     => array(
        'invokables' => [
        ],
        'factories'  => array(
            'TocatUser\Controller\Admin\Role' => Factory\Controller\Admin\RoleControllerFactory::class,
            Controller\Admin\GroupController::class => Factory\Controller\Admin\GroupControllerFactory::class,
            Controller\Admin\PermissionController::class => Factory\Controller\Admin\PermissionControllerFactory::class,
        ),
    ),
    'router'          => array(
        'routes' => array(
            'zfcadmin' => array(
                'child_routes' => array(
                    'roles' => array(
                        'type'     => 'Segment',
                        'priority' => 1000,
                        'options'  => array(
                            'route'       => '/roles[/:action]',
                            'constraints' => array(
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                            ),
                            'defaults'    => array(
                                'controller' => 'TocatUser\Controller\Admin\Role',
                                'action'     => 'index',
                            ),
                        ),
                    ),
                    'groups' => array(
                        'type'     => 'Segment',
                        'priority' => 1000,
                        'options'  => array(
                            'route'       => '/groups[/:action]',
                            'constraints' => array(
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                            ),
                            'defaults'    => array(
                                'controller' => Controller\Admin\GroupController::class,
                                'action'     => 'index',
                            ),
                        ),
                    ),
                    'permission' => array(
                        'type'     => 'Segment',
                        'priority' => 1000,
                        'options'  => array(
                            'route'       => '/permission[/:action]',
                            'constraints' => array(
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                            ),
                            'defaults'    => array(
                                'controller' => Controller\Admin\PermissionController::class,
                                'action'     => 'index',
                            ),
                        ),
                    ),
                ),
            ),
        ),
    ),
    'view_manager'    => array(
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
    ),
    'navigation'      => array(
        'admin' => array(
            'roleadmin' => array(
                'label'  => 'Roles',
                'route'  => 'zfcadmin/roles',
            ),
            'groupadmin' => array(
                'label'  => 'Groups / Teams',
                'route'  => 'zfcadmin/groups',
            ),
            'acladmin' => array(
                'label' => 'Permissions',
                'route' => 'zfcadmin/permission',
                'pages' => array(
                    'guard' => array(
                        'label' => 'Pages',
                        'route' => 'zfcadmin/permission',
                        'params' => array('action' => 'pages'),
                    ),
                    'resource' => array(
                        'label' => 'Resource',
                        'route' => 'zfcadmin/permission',
                        'params' => array('action' => 'resource'),
                    ),
                ),
            ),
        ),
    ),
);
