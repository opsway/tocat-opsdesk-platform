<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

return array(
    'zfcadmin'        => array(
        'use_admin_layout'      => true,
        'admin_layout_template' => 'layout/admin',
    ),
    'router'          => array(
        'routes' => array(
            'home'        => array(
                'type'    => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route'    => '/',
                    'defaults' => array(
                        'controller' => 'TocatCore\Controller\Index',
                        'action'     => 'index',
                    ),
                ),
            ),
            'payment'     => array(
                'type'    => 'segment',
                'options' => array(
                    'route'       => '/payment[/:action]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                    ),
                    'defaults'    => array(
                        'controller' => 'TocatCore\Controller\Payment',
                        'action'     => 'index',
                    ),
                ),
            ),
            'user'        => array(
                'type'    => 'segment',
                'options' => array(
                    'route'       => '/user[/:action]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                    ),
                    'defaults'    => array(
                        'controller' => 'TocatCore\Controller\User',
                        'action'     => 'index',
                    ),
                ),
            ),
            'stub'        => array(
                'type'    => 'Segment',
                'options' => array(
                    'route'       => '/app/stub[/:id]',
                    'constraints' => array(
                        'id' => '[a-zA-Z][a-zA-Z0-9_-]*',
                    ),
                    'defaults'    => array(
                        '__NAMESPACE__' => 'TocatCore\Controller',
                        'controller'    => 'Index',
                        'action'        => 'stub',
                        'id'            => 'null',
                    ),
                ),
            ),
            // The following is a route to simplify getting started creating
            // new controllers and actions without needing to create a new
            // module. Simply drop new controllers in, and you can access them
            // using the path /application/:controller/:action
            'application' => array(
                'type'          => 'Literal',
                'options'       => array(
                    'route'    => '/application',
                    'defaults' => array(
                        '__NAMESPACE__' => 'TocatCore\Controller',
                        'controller'    => 'Index',
                        'action'        => 'index',
                    ),
                ),
                'may_terminate' => true,
                'child_routes'  => array(
                    'default' => array(
                        'type'    => 'Segment',
                        'options' => array(
                            'route'       => '/[:controller[/:action]]',
                            'constraints' => array(
                                'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',
                            ),
                            'defaults'    => array(),
                        ),
                    ),
                ),
            ),
        ),
    ),
    'service_manager' => array(
        'abstract_factories' => array(
            'Zend\Cache\Service\StorageCacheAbstractServiceFactory',
            'Zend\Log\LoggerAbstractServiceFactory',
        ),
        'factories'          => array(
            'navigation' => 'TocatCore\Service\TopNavigationFactory',
        ),
        'aliases'            => array(
            'translator' => 'MvcTranslator',
        ),
    ),
    'translator'      => array(
        'locale'                    => 'en_US',
        'translation_file_patterns' => array(
            array(
                'type'     => 'gettext',
                'base_dir' => __DIR__ . '/../language',
                'pattern'  => '%s.mo',
            ),
        ),
    ),
    'controllers'     => array(
        'invokables' => array(
            'TocatCore\Controller\Index'   => 'TocatCore\Controller\IndexController',
            'TocatCore\Controller\Payment' => 'TocatCore\Controller\PaymentController',
            'TocatCore\Controller\User'    => 'TocatCore\Controller\UserController',
        ),
    ),
    'view_manager'    => array(
        'display_not_found_reason' => true,
        'display_exceptions'       => true,
        'doctype'                  => 'HTML5',
        'not_found_template'       => 'error/404',
        'exception_template'       => 'error/index',
        'template_map'             => array(
            'layout/layout'          => __DIR__ . '/../view/layout/main.phtml',
            'layout/admin'           => __DIR__ . '/../view/layout/admin.phtml',
            'tocat-core/index/index' => __DIR__ . '/../view/tocat-core/index/index.phtml',
            'tocat-core/index/stub'  => __DIR__ . '/../view/tocat-core/index/stub.phtml',
            'error/404'              => __DIR__ . '/../view/error/404.phtml',
            'error/index'            => __DIR__ . '/../view/error/index.phtml',
        ),
        'template_path_stack'      => array(
            __DIR__ . '/../view',
        ),
    ),
    // Placeholder for console routes
    'console'         => array(
        'router' => array(
            'routes' => array(),
        ),
    ),
);
