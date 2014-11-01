<?php

namespace TocatUserTest\Factory\Controller\Admin;

use TocatUser\Factory\Controller\Admin\PermissionControllerFactory;
use TocatUser\Controller\Admin\PermissionController;
use TocatUser\Service\PermissionService;

class PermissionControllerTest extends \PHPUnit_Framework_TestCase
{
    private $locator;
    private $sm;
    private $service;
    private $factory;

    protected function setUp()
    {
        $this->locator = $this->getMock('Zend\ServiceManager\AbstractPluginManager');
        $this->sm = $this->getMock('Zend\ServiceManager\ServiceLocatorInterface');
        $this->service = $this->getMockBuilder(PermissionService::class)->disableOriginalConstructor()->getMock();
        $this->factory = new PermissionControllerFactory();
    }

    /**
     * @covers \TocatUser\Factory\Controller\Admin\PermissionControllerFactory::createService
     */
    public function testCreateService()
    {

        $this->sm->expects($this->any())
            ->method('get')
            ->with(PermissionService::class)
            ->will($this->returnValue($this->service));

        $this->locator->expects($this->any())
            ->method('getServiceLocator')
            ->will($this->returnValue($this->sm));

        $this->assertInstanceOf(
            PermissionController::class,
            $this->factory->createService($this->locator)
        );
    }
}
