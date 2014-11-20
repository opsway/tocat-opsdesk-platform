<?php
namespace OpsWay\TocatBudget\Factory\Controller;

use OpsWay\TocatBudget\Controller\TicketController;
use OpsWay\TocatBudget\Service\MyService;
use Zend\Mvc\Controller\ControllerManager;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class TicketControllerFactory implements FactoryInterface
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
         * @var $service MyService
         */
        $service = $serviceLocator->get(MyService::class);

        return new TicketController($service);

    }
}
