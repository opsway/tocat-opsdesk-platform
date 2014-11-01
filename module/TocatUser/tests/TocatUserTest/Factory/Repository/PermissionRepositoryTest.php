<?php

namespace TocatUserTest\Factory\Repository;

use TocatUser\Factory\Repository\PermissionRepositoryFactory;
use TocatUser\Repository\PermissionRepository;
use TocatUser\Entity\Permission as PermissionEntity;

class PermissionRepositoryTest extends \PHPUnit_Framework_TestCase
{
    private $locator;
    private $entityManager;
    private $repository;
    private $factory;

    protected function setUp()
    {
        $this->locator = $this->getMock('Zend\ServiceManager\ServiceLocatorInterface');
        $this->entityManager = $this->getMock('Doctrine\Common\Persistence\ObjectManager');
        $this->repository = $this->getMockBuilder(PermissionRepository::class)->disableOriginalConstructor()->getMock();
        $this->factory = new PermissionRepositoryFactory();
    }

    /**
     * @covers \TocatUser\Factory\Repository\PermissionRepositoryFactory::createService
     */
    public function testCreateService()
    {
        $this->repository->expects($this->once())
            ->method('setHydrator')
            ->with($this->isInstanceOf('Zend\Stdlib\Hydrator\HydratorInterface'));

        $this->entityManager->expects($this->once())
            ->method('getRepository')
            ->with(PermissionEntity::class)
            ->will($this->returnValue($this->repository));

        $this->locator->expects($this->any())
            ->method('get')
            ->with('doctrine.entitymanager.orm_default')
            ->will($this->returnValue($this->entityManager));

        $this->assertInstanceOf(
            PermissionRepository::class,
            $this->factory->createService($this->locator)
        );
    }
}
