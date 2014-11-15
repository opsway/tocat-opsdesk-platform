<?php

namespace OpsWay\TocatBudgetTest\Factory\Controller\Admin;

use OpsWay\TocatBudget\Factory\Controller\OtherControllerFactory;
use OpsWay\TocatBudget\Controller\OtherController;
use OpsWay\TocatBudget\Service\MyService;

class OtherControllerTest extends \PHPUnit_Framework_TestCase
{
    private $locator;
    private $sm;
    private $service;
    private $factory;

    protected function setUp()
    {
        $this->locator = $this->getMock('Zend\ServiceManager\AbstractPluginManager');
        $this->sm = $this->getMock('Zend\ServiceManager\ServiceLocatorInterface');
        $this->service = $this->getMockBuilder(MyService::class)->disableOriginalConstructor()->getMock();
        $this->factory = new OtherControllerFactory();
    }

    /**
     * @covers \OpsWay\TocatBudget\Factory\Controller\OtherControllerFactory::createService
     */
    public function testCreateService()
    {

        $this->sm->expects($this->any())
            ->method('get')
            ->with(MyService::class)
            ->will($this->returnValue($this->service));

        $this->locator->expects($this->any())
            ->method('getServiceLocator')
            ->will($this->returnValue($this->sm));

        $this->assertInstanceOf(
            OtherController::class,
            $this->factory->createService($this->locator)
        );
    }
}
