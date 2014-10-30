<?php

namespace TocatUserTest\Factory\Service;

use TocatUser\Factory\Service\GroupServiceFactory;
use TocatUser\Repository\GroupRepository;

class RGroupServiceTest extends \PHPUnit_Framework_TestCase
{
    private $locator;
    private $repository;
    private $factory;

    protected function setUp()
    {
        $this->locator = $this->getMock('Zend\ServiceManager\ServiceLocatorInterface');
        $this->repository = $this->getMockBuilder(GroupRepository::class)->disableOriginalConstructor()->getMock();
        $this->factory = new GroupServiceFactory();
    }

    /**
     * @covers \TocatUser\Factory\Service\GroupServiceFactory::createService
     */
    public function testCreateService()
    {
        $this->locator->expects($this->any())
            ->method('get')
            ->with(GroupRepository::class)
            ->will($this->returnValue($this->repository));

        $this->assertInstanceOf(
            'TocatUser\Service\GroupService',
            $this->factory->createService($this->locator)
        );
    }
}
