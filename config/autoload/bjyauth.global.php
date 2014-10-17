<?php
return array(
    'bjyauthorize' => array(
        'default_role'       => 'guest',
        'identity_provider'  => 'BjyAuthorize\Provider\Identity\AuthenticationIdentityProvider',
        'authenticated_role' => 'user',
        'unauthorized_strategy' => 'TocatUser\View\UnauthorizedStrategy',
        'role_providers'     => array(
// using an object repository (entity repository) to load all roles into our ACL
'BjyAuthorize\Provider\Role\ObjectRepositoryProvider' => array(
    'object_manager'    => 'doctrine.entitymanager.orm_default',
    'role_entity_class' => 'TocatUser\Entity\Role',
),
        ),

        'resource_providers' => array(
            \BjyAuthorize\Provider\Resource\Config::class => array(
                'top_nav:teams' => array(),
                'top_nav:staff' => array(),
                'top_nav:budget' => array(),
                'top_nav:payment' => array(),
                'top_nav:administration' => array(),
            ),
        ),

        'rule_providers' => array(
            \BjyAuthorize\Provider\Rule\Config::class => array(
                'allow' => array(
                    array(array('user'), array('top_nav:teams','top_nav:staff','top_nav:budget', 'top_nav:payment', 'top_nav:administration'), array('list')),
                ),
            ),
        ),

        'guards'             => array(
            /* If this guard is specified here (i.e. it is enabled), it will block
            * access to all controllers and actions unless they are specified here.
            * You may omit the 'action' index to allow access to the entire controller
            */
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
                    'roles'      => array('user','admin'),
                ),
                array('controller' => 'TocatCore\Controller\Index', 'action' => array('index','stub'), 'roles' => array('user')),
                array(
                    'controller' => 'ZfcUserOnelogin\OneloginController',
                    'action'     => array('index', 'auth'),
                    'roles'      => array('guest', 'user'),
                ),

                array(
                    'controller' => 'zfcuseradmin',
                    'roles'      => array('admin'),
                ),
                array(
                    'controller' => 'ZfcAdmin\Controller\AdminController',
                    'action'     => array('index'),
                    'roles'      => array('admin'),
                ),
            ),

            /*'BjyAuthorize\Guard\Route' => [
                            // Below is the default index action used by the ZendSkeletonApplication
                            ['route' => 'home', 'roles' => ['user']],
                            ['route' => 'stub', 'roles' => ['user']],
                            ['route' => 'zfcadmin', 'roles' => ['admin']],
                            ['route' => 'zfcuseradmin', 'roles' => ['admin']],
                            ['route' => 'zfcuser', 'roles' => ['user','guest']],
                            ['route' => 'zfcuser/logout', 'roles' => ['user','guest']],
                            ['route' => 'zfcuser/login', 'roles' => ['guest']],
                        ],*/
        ),
    ),
);