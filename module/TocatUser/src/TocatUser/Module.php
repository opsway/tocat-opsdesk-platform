<?php
namespace TocatUser;

use DoctrineModule\Persistence\ObjectManagerAwareInterface;
use Zend\EventManager\EventInterface;
use Zend\Form\FormElementManager;
use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\ModuleManager\Feature\BootstrapListenerInterface;
use Zend\ModuleManager\Feature\ConfigProviderInterface;
use Zend\ModuleManager\Feature\FormElementProviderInterface;
use Zend\Mvc\ModuleRouteListener;
use Zend\ServiceManager\ServiceLocatorInterface;

class Module implements BootstrapListenerInterface,
    ConfigProviderInterface,
    AutoloaderProviderInterface
{

    public function onBootstrap(EventInterface $e)
    {
        /* @var $application \Zend\Mvc\Application */
        $application         = $e->getTarget();
        $eventManager        = $application->getEventManager();
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);
        $services = $application->getServiceManager();
        $zfcServiceEvents = $services->get('zfcuser_user_service')->getEventManager();
        $zfcServiceEvents->attach('register',function ($e) use ($services) {
                $zfcUser = $e->getParam('user');
                $em = $services->get('doctrine.entitymanager.orm_default');
                $configAuth = $services->get('BjyAuthorize\Config');
                $providerConfig = $configAuth['role_providers']['BjyAuthorize\Provider\Role\ObjectRepositoryProvider'];

                $criteria = array('roleId' => $configAuth['authenticated_role']);
                $defaultUserRole = $em->getRepository($providerConfig['role_entity_class'])->findOneBy($criteria);
                if ($defaultUserRole !== null)
                {
                    $zfcUser->addRole($defaultUserRole);
                }
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