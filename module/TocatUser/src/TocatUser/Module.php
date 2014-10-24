<?php
namespace TocatUser;

use Zend\EventManager\EventInterface;
use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\ModuleManager\Feature\BootstrapListenerInterface;
use Zend\ModuleManager\Feature\ConfigProviderInterface;
use Zend\Mvc\ModuleRouteListener;

class Module implements BootstrapListenerInterface, ConfigProviderInterface, AutoloaderProviderInterface
{

    public function onBootstrap(EventInterface $e)
    {
        /* @var $application \Zend\Mvc\Application */
        $application = $e->getTarget();
        $eventManager = $application->getEventManager();
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);
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

                //$form->setHydrator(new \DoctrineORMModule\Stdlib\Hydrator\DoctrineEntity($om, 'TocatUser\Entity\User'));

                $form->add(
                    array(
                        'name'    => 'roles',
                        'type'    => 'DoctrineModule\Form\Element\ObjectMultiCheckbox',
                        'options' => array(
                            'label'          => 'Assign Roles',
                            'object_manager' => $om,
                            'target_class'   => 'TocatUser\Entity\Role',
                            'property'       => 'roleId',
                        ),
                    )
                );
            });

        $application->getEventManager()->getSharedManager()->attach('ZfcUserAdmin\Service\User', 'edit', function ($e) {
            $zfcUser = $e->getParam('user');
            $post = $e->getParam('data');
            $em = $e->getParam('form')->getServiceManager()->get('doctrine.entitymanager.orm_default');
            $listRoles = $em->getRepository('TocatUser\Entity\Role')->findBy(array('id' => $post['roles']));
            $zfcUser->updateRoles($listRoles);
        });
    }

    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/../../src/' . __NAMESPACE__,
                ),
            ),
        );
    }

    public function getConfig()
    {
        return include __DIR__ . '/../../config/module.config.php';
    }
}
