<?php

namespace OpsWay\TocatUser\Factory\Repository;

use Doctrine\ORM\EntityManager;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject;
use OpsWay\TocatUser\Entity\Role as RoleEntity;
use OpsWay\TocatUser\Repository\RoleRepository;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class RoleRepositoryFactory implements FactoryInterface
{
    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     *
     * @return RoleRepository
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        /**
         * @var $em             EntityManager
         * @var $RoleRepository RoleRepository
         */
        $em = $serviceLocator->get('doctrine.entitymanager.orm_default');
        $RoleRepository = $em->getRepository(RoleEntity::class);
        $hydrator = new DoctrineObject($em, RoleEntity::class);
        $RoleRepository->setHydrator($hydrator);

        return $RoleRepository;
    }
}
