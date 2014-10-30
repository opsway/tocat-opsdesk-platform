<?php

namespace TocatUserTest\Factory\Service;

use TocatUser\Factory\Service\RoleServiceFactory;
use TocatUser\Repository\RoleRepository;

class RoleServiceTest extends \PHPUnit_Framework_TestCase
{
    private $locator;
    private $repository;
    private $factory;

    protected function setUp()
    {
        $this->locator = $this->getMock('Zend\ServiceManager\ServiceLocatorInterface');
        $this->repository = $this->getMockBuilder(RoleRepository::class)->disableOriginalConstructor()->getMock();
        $this->factory = new RoleServiceFactory();
    }

    /**
     * @covers \TocatUser\Factory\Service\RoleServiceFactory::createService
     */
    public function testCreateService()
    {
        $this->locator->expects($this->any())
            ->method('get')
            ->with(RoleRepository::class)
            ->will($this->returnValue($this->repository));

        $this->assertInstanceOf(
            'TocatUser\Service\RoleService',
            $this->factory->createService($this->locator)
        );
    }
}
