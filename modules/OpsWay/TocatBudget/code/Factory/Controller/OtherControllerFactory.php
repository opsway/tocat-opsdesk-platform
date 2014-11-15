<?php
namespace OpsWay\TocatBudget\Factory\Controller;

use OpsWay\TocatBudget\Controller\OtherController;
use OpsWay\TocatBudget\Service\MyService;
use Zend\Mvc\Controller\ControllerManager;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class OtherControllerFactory implements FactoryInterface
{
    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     *
     * @return OtherController
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {

        /** @var ControllerManager $serviceLocator */
        $serviceLocator = $serviceLocator->getServiceLocator();
        /**
         * @var $service GroupService
         */
        $service = $serviceLocator->get(MyService::class);

        return new OtherController($service);

    }
}
