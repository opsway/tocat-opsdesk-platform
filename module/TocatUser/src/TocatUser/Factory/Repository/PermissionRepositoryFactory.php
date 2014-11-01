<?php

namespace TocatUser\Factory\Repository;

use Doctrine\ORM\EntityManager;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject;
use TocatUser\Entity\Permission as PermissionEntity;
use TocatUser\Repository\PermissionRepository;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class PermissionRepositoryFactory implements FactoryInterface
{
    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     *
     * @return PermissionRepository
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        /**
         * @var $em             EntityManager
         * @var $permissionRepository PermissionRepository
         */
        $em = $serviceLocator->get('doctrine.entitymanager.orm_default');
        $permissionRepository = $em->getRepository(PermissionEntity::class);
        $hydrator = new DoctrineObject($em, PermissionEntity::class);
        $permissionRepository->setHydrator($hydrator);

        return $permissionRepository;
    }
}
