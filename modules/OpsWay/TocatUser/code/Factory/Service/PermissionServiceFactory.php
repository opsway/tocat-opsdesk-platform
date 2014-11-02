<?php
namespace OpsWay\TocatUser\Factory\Service;

use OpsWay\TocatUser\Repository\PermissionRepository;
use OpsWay\TocatUser\Service\PermissionService;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class PermissionServiceFactory implements FactoryInterface
{
    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     *
     * @return PermissionService
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {

        /**
         * @var $permissionRepository PermissionRepository
         */
        $permissionRepository = $serviceLocator->get(PermissionRepository::class);

        return new PermissionService($permissionRepository);
    }
}
