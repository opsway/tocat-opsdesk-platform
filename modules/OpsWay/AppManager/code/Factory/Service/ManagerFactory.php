<?php
namespace OpsWay\AppManager\Factory\Service;

use OpsWay\AppManager\Service\Manager;
use Zend\EventManager\EventManagerAwareInterface;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class ManagerFactory implements FactoryInterface
{

    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     *
     * @return Manager
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        /**
         * @var $app EventManagerAwareInterface
         */
        $app = $serviceLocator->get('Application');
        return new Manager($serviceLocator, $app->getEventManager());
    }
}
