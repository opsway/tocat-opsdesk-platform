<?php
return array(
    'doctrine' => array(
        'driver' => array(
            'zfcuser_entity' => array(
                'class' =>'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
                //'namespace' => 'TocatUser\Entity',
                'paths' => array(__DIR__ . '/../src/TocatUser/Entity')
            ),

            'orm_default' => array(
                'drivers' => array(
                    'TocatUser\Entity' => 'zfcuser_entity',
                )
            )
        )
    ),

    'zfcuser' => array(
        // telling ZfcUser to use our own class
        'user_entity_class'       => 'TocatUser\Entity\User',
        // telling ZfcUserDoctrineORM to skip the entities it defines
        'enable_default_entities' => false,
        'UserEntityClass' => 'TocatUser\Entity\User',
        'EnableDefaultEntities' => false,
    ),

    'zfcuseradmin' => array(
        'user_list_elements' => array('Id' => 'id',  'Name' => 'display_name', 'Email address' => 'email'),
        'create_user_auto_password' => true,
        'user_mapper' => 'ZfcUserAdmin\Mapper\UserDoctrine',
    ),

    'bjyauthorize' => array(
        // Using the authentication identity provider, which basically reads the roles from the auth service's identity
        'identity_provider' => 'BjyAuthorize\Provider\Identity\AuthenticationIdentityProvider',

        'role_providers'        => array(
            // using an object repository (entity repository) to load all roles into our ACL
            'BjyAuthorize\Provider\Role\ObjectRepositoryProvider' => array(
                'object_manager'    => 'doctrine.entitymanager.orm_default',
                'role_entity_class' => 'TocatUser\Entity\Role',
            ),
        ),
    ),

    'service_manager' => array(
        'invokables' => array(
            'TocatUser\View\UnauthorizedStrategy' => 'TocatUser\View\UnauthorizedStrategy',
        ),
    ),
    'navigation' => array(
        'admin' => array(
            'roleadmin' => array(
                'label' => 'Roles',
                'route' => 'stub',
                'params' => array('id' => 'RoleTree'),
                'pages' => array(
                    'create' => array(
                        'label' => 'New Role',
                        'route' => 'stub',
                        'params' => array('id' => 'NewRole'),
                    ),
                ),
            ),
        ),
    ),
);