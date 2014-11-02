<?php

namespace OpsWay\TocatUserTest\Factory\Controller\Admin;

use OpsWay\TocatUser\Factory\Controller\Admin\RoleControllerFactory;
use OpsWay\TocatUser\Controller\Admin\RoleController;
use OpsWay\TocatUser\Service\RoleService;

class RoleControllerTest extends \PHPUnit_Framework_TestCase
{
    private $locator;
    private $sm;
    private $service;
    private $factory;

    protected function setUp()
    {
        $this->locator = $this->getMock('Zend\ServiceManager\AbstractPluginManager');
        $this->sm = $this->getMock('Zend\ServiceManager\ServiceLocatorInterface');
        $this->service = $this->getMockBuilder(RoleService::class)->disableOriginalConstructor()->getMock();
        $this->factory = new RoleControllerFactory();
    }

    /**
     * @covers \OpsWay\TocatUser\Factory\Controller\Admin\RoleControllerFactory::createService
     */
    public function testCreateService()
    {

        $this->sm->expects($this->any())
            ->method('get')
            ->with(RoleService::class)
            ->will($this->returnValue($this->service));

        $this->locator->expects($this->any())
            ->method('getServiceLocator')
            ->will($this->returnValue($this->sm));

        $this->assertInstanceOf(
            RoleController::class,
            $this->factory->createService($this->locator)
        );
    }
}
