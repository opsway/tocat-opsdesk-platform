<?php
namespace TocatUser\Factory\Service;

use TocatUser\Repository\GroupRepository;
use TocatUser\Service\GroupService;
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
