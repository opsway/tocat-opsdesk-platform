<?php
namespace OpsWay\TocatUser\Factory\Service;

use OpsWay\TocatUser\Repository\RoleRepository;
use OpsWay\TocatUser\Service\RoleService;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class RoleServiceFactory implements FactoryInterface
{
    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     *
     * @return RoleService
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {

        /**
         * @var $bookRepository RoleRepository
         */
        $bookRepository = $serviceLocator->get(RoleRepository::class);

        return new RoleService($bookRepository);
    }
}
