<?php

namespace OpsWay\TocatUserTest\Factory\Repository;

use OpsWay\TocatUser\Factory\Repository\GroupRepositoryFactory;
use OpsWay\TocatUser\Repository\GroupRepository;
use OpsWay\TocatUser\Entity\Group as GroupEntity;

class GroupRepositoryTest extends \PHPUnit_Framework_TestCase
{
    private $locator;
    private $entityManager;
    private $repository;
    private $factory;

    protected function setUp()
    {
        $this->locator = $this->getMock('Zend\ServiceManager\ServiceLocatorInterface');
        $this->entityManager = $this->getMock('Doctrine\Common\Persistence\ObjectManager');
        $this->repository = $this->getMockBuilder(GroupRepository::class)->disableOriginalConstructor()->getMock();
        $this->factory = new GroupRepositoryFactory();
    }

    /**
     * @covers \OpsWay\TocatUser\Factory\Repository\GroupRepositoryFactory::createService
     */
    public function testCreateService()
    {
        $this->repository->expects($this->once())
            ->method('setHydrator')
            ->with($this->isInstanceOf('Zend\Stdlib\Hydrator\HydratorInterface'));

        $this->entityManager->expects($this->once())
            ->method('getRepository')
            ->with(GroupEntity::class)
            ->will($this->returnValue($this->repository));

        $this->locator->expects($this->any())
            ->method('get')
            ->with('doctrine.entitymanager.orm_default')
            ->will($this->returnValue($this->entityManager));

        $this->assertInstanceOf(
            GroupRepository::class,
            $this->factory->createService($this->locator)
        );
    }
}
