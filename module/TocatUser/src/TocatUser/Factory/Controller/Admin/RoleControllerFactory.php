<?php
namespace TocatUser\Factory\Controller\Admin;

use TocatUser\Controller\Admin\RoleController;
use TocatUser\Service\RoleService;
use Zend\Mvc\Controller\ControllerManager;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class RoleControllerFactory implements FactoryInterface
{
    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     *
     * @return RoleController
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {

        /** @var ControllerManager $serviceLocator */
        $serviceLocator = $serviceLocator->getServiceLocator();
        /**
         * @var $service RoleService
         */
        $service = $serviceLocator->get(RoleService::class);

        return new RoleController($service);

    }
}
