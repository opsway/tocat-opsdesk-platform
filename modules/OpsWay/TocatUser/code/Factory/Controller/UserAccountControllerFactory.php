<?php
namespace OpsWay\TocatUser\Factory\Controller;

use OpsWay\TocatUser\Controller\UserAccountController;
use OpsWay\TocatUser\Service\UserAccountService;
use Zend\Mvc\Controller\ControllerManager;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class UserAccountControllerFactory implements FactoryInterface
{
    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     *
     * @return UserAccountController
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {

        /** @var ControllerManager $serviceLocator */
        $serviceLocator = $serviceLocator->getServiceLocator();
        /**
         * @var $service UserAccountService
         */
        $service = $serviceLocator->get(UserAccountService::class);

        return new UserAccountController($service);

    }
}
