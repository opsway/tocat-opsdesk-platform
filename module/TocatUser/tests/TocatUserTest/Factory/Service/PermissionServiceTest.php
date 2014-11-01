<?php

namespace TocatUserTest\Factory\Service;

use TocatUser\Factory\Service\PermissionServiceFactory;
use TocatUser\Repository\PermissionRepository;

class PermissionServiceTest extends \PHPUnit_Framework_TestCase
{
    private $locator;
    private $repository;
    private $factory;

    protected function setUp()
    {
        $this->locator = $this->getMock('Zend\ServiceManager\ServiceLocatorInterface');
        $this->repository = $this->getMockBuilder(PermissionRepository::class)->disableOriginalConstructor()->getMock();
        $this->factory = new PermissionServiceFactory();
    }

    /**
     * @covers \TocatUser\Factory\Service\PermissionServiceFactory::createService
     */
    public function testCreateService()
    {
        $this->locator->expects($this->any())
            ->method('get')
            ->with(PermissionRepository::class)
            ->will($this->returnValue($this->repository));

        $this->assertInstanceOf(
            'TocatUser\Service\PermissionService',
            $this->factory->createService($this->locator)
        );
    }
}
