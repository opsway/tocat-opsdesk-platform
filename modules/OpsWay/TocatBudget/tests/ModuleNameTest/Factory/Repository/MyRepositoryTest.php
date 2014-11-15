<?php

namespace OpsWay\TocatBudgetTest\Factory\Repository;

use OpsWay\TocatBudget\Factory\Repository\MyRepositoryFactory;
use OpsWay\TocatBudget\Repository\MyRepository;
use OpsWay\TocatBudget\Entity\My as MyEntity;

class MyRepositoryTest extends \PHPUnit_Framework_TestCase
{
    private $locator;
    private $entityManager;
    private $repository;
    private $factory;

    protected function setUp()
    {
        $this->locator = $this->getMock('Zend\ServiceManager\ServiceLocatorInterface');
        $this->entityManager = $this->getMock('Doctrine\Common\Persistence\ObjectManager');
        $this->repository = $this->getMockBuilder(MyRepository::class)->disableOriginalConstructor()->getMock();
        $this->factory = new MyRepositoryFactory();
    }

    /**
     * @covers \OpsWay\TocatBudget\Factory\Repository\MyRepositoryFactory::createService
     */
    public function testCreateService()
    {
        $this->repository->expects($this->once())
            ->method('setHydrator')
            ->with($this->isInstanceOf('Zend\Stdlib\Hydrator\HydratorInterface'));

        $this->entityManager->expects($this->once())
            ->method('getRepository')
            ->with(MyEntity::class)
            ->will($this->returnValue($this->repository));

        $this->locator->expects($this->any())
            ->method('get')
            ->with('doctrine.entitymanager.orm_default')
            ->will($this->returnValue($this->entityManager));

        $this->assertInstanceOf(
            MyRepository::class,
            $this->factory->createService($this->locator)
        );
    }
}
