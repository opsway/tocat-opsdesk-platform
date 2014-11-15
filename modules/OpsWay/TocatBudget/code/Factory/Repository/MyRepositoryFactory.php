<?php

namespace OpsWay\TocatBudget\Factory\Repository;

use Doctrine\ORM\EntityManager;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject;
use OpsWay\TocatBudget\Entity\My as MyEntity;
use OpsWay\TocatBudget\Repository\MyRepository;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class MyRepositoryFactory implements FactoryInterface
{
    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     *
     * @return MyRepository
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        /**
         * @var $em             EntityManager
         * @var $MyRepository MyRepository
         */
        $em = $serviceLocator->get('doctrine.entitymanager.orm_default');
        $MyRepository = $em->getRepository(MyEntity::class);
        $hydrator = new DoctrineObject($em, MyEntity::class);
        $MyRepository->setHydrator($hydrator);

        return $MyRepository;
    }
}
