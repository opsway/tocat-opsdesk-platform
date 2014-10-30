<?php

namespace TocatUserTest\Factory\Repository;

use TocatUser\Factory\Repository\RoleRepositoryFactory;
use TocatUser\Repository\RoleRepository;
use TocatUser\Entity\Role as RoleEntity;

class RoleRepositoryTest extends \PHPUnit_Framework_TestCase
{
    private $locator;
    private $entityManager;
    private $repository;
    private $factory;

    protected function setUp()
    {
        $this->locator = $this->getMock('Zend\ServiceManager\ServiceLocatorInterface');
        $this->entityManager = $this->getMock('Doctrine\Common\Persistence\ObjectManager');
        $this->repository = $this->getMockBuilder(RoleRepository::class)->disableOriginalConstructor()->getMock();
        $this->factory = new RoleRepositoryFactory();
    }

    /**
     * @covers \TocatUser\Factory\Repository\RoleRepositoryFactory::createService
     */
    public function testCreateService()
    {
        $this->repository->expects($this->once())
            ->method('setHydrator')
            ->with($this->isInstanceOf('Zend\Stdlib\Hydrator\HydratorInterface'));

        $this->entityManager->expects($this->once())
            ->method('getRepository')
            ->with(RoleEntity::class)
            ->will($this->returnValue($this->repository));

        $this->locator->expects($this->any())
            ->method('get')
            ->with('doctrine.entitymanager.orm_default')
            ->will($this->returnValue($this->entityManager));

        $this->assertInstanceOf(
            RoleRepository::class,
            $this->factory->createService($this->locator)
        );
    }
}
