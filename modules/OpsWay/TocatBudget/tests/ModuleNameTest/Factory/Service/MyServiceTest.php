<?php

namespace OpsWay\TocatBudgetTest\Factory\Service;

use OpsWay\TocatBudget\Factory\Service\MyServiceFactory;
use OpsWay\TocatBudget\Repository\MyRepository;

class MyServiceTest extends \PHPUnit_Framework_TestCase
{
    private $locator;
    private $repository;
    private $factory;

    protected function setUp()
    {
        $this->locator = $this->getMock('Zend\ServiceManager\ServiceLocatorInterface');
        $this->repository = $this->getMockBuilder(MyRepository::class)->disableOriginalConstructor()->getMock();
        $this->factory = new MyServiceFactory();
    }

    /**
     * @covers \OpsWay\TocatBudget\Factory\Service\MyServiceFactory::createService
     */
    public function testCreateService()
    {
        $this->locator->expects($this->any())
            ->method('get')
            ->with(MyRepository::class)
            ->will($this->returnValue($this->repository));

        $this->assertInstanceOf(
            'OpsWay\TocatBudget\Service\MyService',
            $this->factory->createService($this->locator)
        );
    }
}
