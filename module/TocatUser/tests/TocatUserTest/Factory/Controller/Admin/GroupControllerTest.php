<?php

namespace TocatUserTest\Factory\Controller\Admin;

use TocatUser\Factory\Controller\Admin\GroupControllerFactory;
use TocatUser\Controller\Admin\GroupController;
use TocatUser\Service\GroupService;

class GroupControllerTest extends \PHPUnit_Framework_TestCase
{
    private $locator;
    private $sm;
    private $service;
    private $factory;

    protected function setUp()
    {
        $this->locator = $this->getMock('Zend\ServiceManager\AbstractPluginManager');
        $this->sm = $this->getMock('Zend\ServiceManager\ServiceLocatorInterface');
        $this->service = $this->getMockBuilder(GroupService::class)->disableOriginalConstructor()->getMock();
        $this->factory = new GroupControllerFactory();
    }

    /**
     * @covers \TocatUser\Factory\Controller\Admin\GroupControllerFactory::createService
     */
    public function testCreateService()
    {

        $this->sm->expects($this->any())
            ->method('get')
            ->with(GroupService::class)
            ->will($this->returnValue($this->service));

        $this->locator->expects($this->any())
            ->method('getServiceLocator')
            ->will($this->returnValue($this->sm));

        $this->assertInstanceOf(
            GroupController::class,
            $this->factory->createService($this->locator)
        );
    }
}
