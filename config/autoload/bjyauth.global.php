<?php
return array(
    'bjyauthorize' => array(
        'default_role'       => 'guest',
        'identity_provider'  => 'BjyAuthorize\Provider\Identity\AuthenticationIdentityProvider',
        'authenticated_role' => 'user',
        'role_providers'     => array(
// using an object repository (entity repository) to load all roles into our ACL
'BjyAuthorize\Provider\Role\ObjectRepositoryProvider' => array(
    'object_manager'    => 'doctrine.entitymanager.orm_default',
    'role_entity_class' => 'TocatUser\Entity\Role',
),
        ),
        'guards'             => array(
            /* If this guard is specified here (i.e. it is enabled), it will block
            * access to all controllers and actions unless they are specified here.
            * You may omit the 'action' index to allow access to the entire controller
            * /
            'BjyAuthorize\Guard\Controller' => array(
                array(
                    'controller' => 'zfcuser',
                    'action'     => array('index'),
                    'roles'      => array('guest', 'user'),
                ),
                array(
                    'controller' => 'zfcuser',
                    'action'     => array('login', 'authenticate', 'register'),
                    'roles'      => array('guest'),
                ),
                array(
                    'controller' => 'zfcuser',
                    'action'     => array('logout'),
                    'roles'      => array('user'),
                ),
                array('controller' => 'TocatCore\Controller\Index', 'roles' => array()),
                array(
                    'controller' => 'MyBlog\Controller\BlogPost',
                    'action'     => array('index', 'view'),
                    'roles'      => array('guest', 'user'),
                ),
                array(
                    'controller' => 'MyBlog\Controller\BlogPost',
                    'action'     => array('add', 'edit', 'delete'),
                    'roles'      => array('administrator'),
                ),
            ),

            \BjyAuthorize\Guard\Route::class => [
                            ['route' => 'zfcuser', 'roles' => ['user']],
                            ['route' => 'zfcuser/logout', 'roles' => ['user']],
                            ['route' => 'zfcuser/login', 'roles' => ['guest']],
                            ['route' => 'zfcuser/register', 'roles' => ['guest']],
                            ['route' => 'scn-social-auth-hauth', 'roles' => ['guest']],
                            ['route' => 'scn-social-auth-user', 'roles' => ['guest']],
                            ['route' => 'scn-social-auth-user/authenticate', 'roles' => ['guest']],
                            ['route' => 'scn-social-auth-user/login', 'roles' => ['guest']],
                            ['route' => 'scn-social-auth-user/logout', 'roles' => ['guest']],
                            ['route' => 'scn-social-auth-user/register', 'roles' => ['guest']],
                            ['route' => 'scn-social-auth-user/add-provider', 'roles' => ['guest']],
                            // Below is the default index action used by the ZendSkeletonApplication
                            ['route' => 'home', 'roles' => ['guest', 'user']],
                        ],*/
        ),
    ),
);