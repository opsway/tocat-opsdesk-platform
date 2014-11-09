<?php
namespace OpsWay\TocatUser;

use OpsWay\AppManager\Feature\VersionProviderInterface;
use Zend\EventManager\EventInterface;
use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\ModuleManager\Feature\BootstrapListenerInterface;
use Zend\ModuleManager\Feature\ConfigProviderInterface;
use Zend\ModuleManager\Feature\DependencyIndicatorInterface;
use Zend\View\Helper\Navigation as ZendViewHelperNavigation;
use Zend\Mvc\ModuleRouteListener;

class Module implements BootstrapListenerInterface, ConfigProviderInterface, AutoloaderProviderInterface, DependencyIndicatorInterface, VersionProviderInterface
{

    public function onBootstrap(EventInterface $e)
    {
        /* @var $application \Zend\Mvc\Application */
        $application = $e->getTarget();
        $eventManager = $application->getEventManager();
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);
        //todo Delete this hack (avoid unit tests) after update BjyAuthorize module to 2.0
        if (\Zend\Console\Console::isConsole()) {
            return;
        }

        $sm = $e->getApplication()->getServiceManager();
        // Add ACL information to the Navigation view helper
        $authorize = $sm->get('BjyAuthorizeServiceAuthorize');
        $acl = $authorize->getAcl();
        $role = $authorize->getIdentity();
        ZendViewHelperNavigation::setDefaultAcl($acl);
        ZendViewHelperNavigation::setDefaultRole($role);

        $services = $application->getServiceManager();
        $zfcServiceEvents = $services->get('zfcuser_user_service')->getEventManager();
        $zfcServiceEvents->attach('register', function ($e) use ($services) {
            $zfcUser = $e->getParam('user');
            $em = $services->get('doctrine.entitymanager.orm_default');
            $configAuth = $services->get('BjyAuthorize\Config');
            $providerConfig = $configAuth['role_providers']['BjyAuthorize\Provider\Role\ObjectRepositoryProvider'];

            $criteria = array('roleId' => $configAuth['authenticated_role']);
            $defaultUserRole = $em->getRepository($providerConfig['role_entity_class'])->findOneBy($criteria);
            if ($defaultUserRole !== null) {
                $zfcUser->addRole($defaultUserRole);
            }
        });

        $application->getEventManager()->getSharedManager()
            ->attach('ZfcUserAdmin\Form\EditUser', 'init', function ($e) {
                // $form is a ZfcUser\Form\Register
                $form = $e->getTarget();

                $sm = $form->getServiceManager();
                $om = $sm->get('Doctrine\ORM\EntityManager');

                //$form->setHydrator(new \DoctrineORMModule\Stdlib\Hydrator\DoctrineEntity($om, 'OpsWay\TocatUser\Entity\User'));

                $form->add(
                    array(
                        'name'    => 'roles',
                        'type'    => 'DoctrineModule\Form\Element\ObjectMultiCheckbox',
                        'options' => array(
                            'label'          => 'Assign Roles',
                            'object_manager' => $om,
                            'target_class'   => Entity\Role::class,
                            'property'       => 'roleId',
                        ),
                    )
                );

                $form->add(
                    array(
                        'name'    => 'groups',
                        'type'    => 'DoctrineModule\Form\Element\ObjectSelect',
                        'options' => array(
                            'label'          => 'Assign Groups',
                            'object_manager' => $om,
                            'target_class'   => Entity\Group::class,
                            'property'       => 'name',
                        ),
                        'attributes' => array(
                            'multiple'  => true,
                        ),
                    )
                );
            });

        $application->getEventManager()->getSharedManager()->attach('ZfcUserAdmin\Service\User', 'edit', function ($e) {
            $zfcUser = $e->getParam('user');
            $post = $e->getParam('data');
            $em = $e->getParam('form')->getServiceManager()->get('doctrine.entitymanager.orm_default');
            $listRoles = $em->getRepository(Entity\Role::class)->findBy(array('id' => $post['roles']));
            $zfcUser->updateRoles($listRoles);
            $listGroup = $em->getRepository(Entity\Group::class)->findBy(array('id' => $post['groups']));
            $zfcUser->updateGroups($listGroup);
        });
    }

    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__,
                ),
            ),
        );
    }

    public function getConfig()
    {
        return array_merge(
            include __DIR__ . '/../config/module.config.php',
            include __DIR__ . '/../config/controller.config.php',
            include __DIR__ . '/../config/router.config.php',
            include __DIR__ . '/../config/service.config.php',
            include __DIR__ . '/../config/view.config.php',
            include __DIR__ . '/../config/navigation.config.php'
        );
    }


    /**
     * Expected to return an array of modules on which the current one depends on
     *
     * @return array
     */
    public function getModuleDependencies()
    {
        return [
            'ZfcUser',
            'ZfcUserDoctrineORM',
            'ZfcUserAdmin',
            //'BjyAuthorize', todo Delete this hack (avoid unit tests) after update BjyAuthorize module to 2.0
            'OpsWay\TocatCore'
        ];
    }

    /**
     * Expected to return \Zend\ServiceManager\Config object or array to
     * seed such an object.
     *
     * @return string
     */
    public function getVersion()
    {
        return TOCAT_VERSION_SYNC_MODULES;
    }
}
