<?php

namespace TocatUserTest\Controller\Admin;

use TocatUser\Controller\Admin\PermissionController;
use Tests\Bootstrap;
use Zend\Mvc\Router\Http\TreeRouteStack as HttpRouter;
use Zend\Http\Request;
use Zend\Http\Response;
use Zend\Mvc\MvcEvent;
use Zend\Mvc\Router\RouteMatch;
use PHPUnit_Framework_TestCase;

class PermissionControllerTest extends PHPUnit_Framework_TestCase
{
    protected $controller;
    protected $request;
    protected $response;
    protected $routeMatch;
    protected $event;
    protected $service;

    protected function setUp()
    {
        $this->service = $this->getMockBuilder('TocatUser\Service\PermissionService')->disableOriginalConstructor()->getMock();
        $serviceManager = Bootstrap::getServiceManager();
        $this->controller = new PermissionController($this->service);
        $this->request    = new Request();
        $this->routeMatch = new RouteMatch(array('controller' => 'permission'));
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

    public function testPagesActionCanBeAccessed()
    {
        $this->routeMatch->setParam('action', 'pages');

        $result   = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();
        $this->assertInstanceOf('Zend\View\Model\ViewModel', $result);
        $this->assertEquals(200, $response->getStatusCode());
    }

    public function testResourceActionCanBeAccessed()
    {
        $this->routeMatch->setParam('action', 'resource');
        $this->request->setContent('{}');

        $result   = $this->controller->dispatch($this->request);
        $response = $this->controller->getResponse();
        $this->assertInstanceOf('Zend\View\Model\ViewModel', $result);
        $this->assertEquals(200, $response->getStatusCode());
    }
}
