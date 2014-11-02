<?php
namespace OpsWay\TocatUser\Factory\Service;

use OpsWay\TocatUser\Repository\GroupRepository;
use OpsWay\TocatUser\Service\GroupService;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class GroupServiceFactory implements FactoryInterface
{
    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     *
     * @return GroupService
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {

        /**
         * @var $groupRepository GroupRepository
         */
        $groupRepository = $serviceLocator->get(GroupRepository::class);

        return new GroupService($groupRepository);
    }
}
