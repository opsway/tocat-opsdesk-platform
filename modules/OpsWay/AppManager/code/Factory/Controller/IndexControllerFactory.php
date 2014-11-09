<?php
namespace OpsWay\AppManager\Factory\Controller;

use OpsWay\AppManager\Controller\IndexController;
use OpsWay\AppManager\Service\Manager;
use Zend\Mvc\Controller\ControllerManager;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class IndexControllerFactory implements FactoryInterface
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
        /** @var ControllerManager $serviceLocator */
        $serviceLocator = $serviceLocator->getServiceLocator();
        /**
         * @var $service Manager
         */
        $service = $serviceLocator->get(Manager::class);
        return new IndexController($service);
    }
}
