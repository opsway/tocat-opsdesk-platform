<?php

namespace OpsWay\TocatBudget\Factory\Repository;

use Doctrine\ORM\EntityManager;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject;
use Humus\Doctrine\Hydrator\Hydrator;
use OpsWay\TocatBudget\Entity\Issue;
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
        $MyRepository = $em->getRepository(Issue::class);
        $hydrator = new DoctrineObject($em, Issue::class); //new Hydrator($em,true, [], true);//
        $MyRepository->setHydrator($hydrator);

        return $MyRepository;
    }
}
