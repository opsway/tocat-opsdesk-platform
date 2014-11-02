<?php
namespace OpsWay\TocatUser\Factory\Controller\Admin;

use OpsWay\TocatUser\Controller\Admin\GroupController;
use OpsWay\TocatUser\Service\GroupService;
use Zend\Mvc\Controller\ControllerManager;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class GroupControllerFactory implements FactoryInterface
{
    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     *
     * @return GroupController
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {

        /** @var ControllerManager $serviceLocator */
        $serviceLocator = $serviceLocator->getServiceLocator();
        /**
         * @var $service GroupService
         */
        $service = $serviceLocator->get(GroupService::class);

        return new GroupController($service);

    }
}
