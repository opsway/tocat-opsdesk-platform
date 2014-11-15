<?php

namespace OpsWay\TocatBudgetTest\Controller\Admin;

use OpsWay\TocatBudget\Controller\Admin\MyController;
use Tests\Bootstrap;
use Zend\Mvc\Router\Http\TreeRouteStack as HttpRouter;
use Zend\Http\Request;
use Zend\Http\Response;
use Zend\Mvc\MvcEvent;
use Zend\Mvc\Router\RouteMatch;
use PHPUnit_Framework_TestCase;

class MyControllerTest extends PHPUnit_Framework_TestCase
{
    protected $controller;
    protected $request;
    protected $response;
    protected $routeMatch;
    protected $event;
    protected $service;

    protected function setUp()
    {
        $this->service = $this->getMockBuilder('OpsWay\TocatBudget\Service\MyService')->disableOriginalConstructor()->getMock();
        $serviceManager = Bootstrap::getServiceManager();
        $this->controller = new MyController($this->service);
        $this->request    = new Request();
        $this->routeMatch = new RouteMatch(array('controller' => 'other'));
        $this->event      = new MvcEvent();
        $config = $serviceManager->get('Config');
        $routerConfig = isset($config['router']) ? $config['router'] : array();
        $router = HttpRouter::factory($routerConfig);

        $this->event->setRouter($router);
        $this->event->setRouteMatch($this->routeMatch);
        $this->controller->setEvent($this->event);
        $this->controller->setServiceLocator($serviceManager);
    }

    public function testIndexActionCanBeAccessed()
    {
        $this->routeMatch->setParam('action', 'index');

        $result   = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();
        $this->assertInstanceOf('Zend\View\Model\ViewModel', $result);
        $this->assertEquals(200, $response->getStatusCode());
    }

    public function testOtherActionCanBeAccessed()
    {
        $this->routeMatch->setParam('action', 'other');

        $result   = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();
        $this->assertInstanceOf('Zend\View\Model\JsonModel', $result);
        $this->assertEquals(200, $response->getStatusCode());
    }
}
