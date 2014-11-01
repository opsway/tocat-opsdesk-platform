<?php
namespace TocatUser\Factory\Controller\Admin;

use TocatUser\Controller\Admin\PermissionController;
use TocatUser\Service\PermissionService;
use Zend\Mvc\Controller\ControllerManager;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class PermissionControllerFactory implements FactoryInterface
{
    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     *
     * @return PermissionController
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {

        /** @var ControllerManager $serviceLocator */
        $serviceLocator = $serviceLocator->getServiceLocator();
        /**
         * @var $service PermissionService
         */
        $service = $serviceLocator->get(PermissionService::class);

        return new PermissionController($service);

    }
}
