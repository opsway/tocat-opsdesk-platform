<?php

namespace TocatUserTest\View;

use PHPUnit_Framework_TestCase;
use BjyAuthorize\Guard\Route;
use TocatUser\View\UnauthorizedStrategy;
use Zend\Http\Response;
use Zend\Mvc\Application;
use Zend\View\Model\ModelInterface;

class UnauthorizedStrategyTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var UnauthorizedStrategy
     */
    protected $strategy;

    /**
     * {@inheritDoc}
     *
     * @covers \TocatUser\View\UnauthorizedStrategy::__construct
     */
    public function setUp()
    {
        parent::setUp();

        $this->strategy = new UnauthorizedStrategy('template/name');
    }

    /**
     * @covers \TocatUser\View\UnauthorizedStrategy::attach
     * @covers \TocatUser\View\UnauthorizedStrategy::detach
     */
    public function testAttachDetach()
    {
        $eventManager = $this->getMock('Zend\\EventManager\\EventManagerInterface');
        $callbackMock = $this->getMock('Zend\\Stdlib\\CallbackHandler', array(), array(), '', false);
        $eventManager
            ->expects($this->once())
            ->method('attach')
            ->with()
            ->will($this->returnValue($callbackMock));
        $this->strategy->attach($eventManager);
        $eventManager
            ->expects($this->once())
            ->method('detach')
            ->with($callbackMock)
            ->will($this->returnValue(true));
        $this->strategy->detach($eventManager);
    }

    /**
     * @covers \TocatUser\View\UnauthorizedStrategy::setTemplate
     * @covers \TocatUser\View\UnauthorizedStrategy::getTemplate
     */
    public function testGetSetTemplate()
    {
        $this->assertSame('template/name', $this->strategy->getTemplate());
        $this->strategy->setTemplate('other/template');
        $this->assertSame('other/template', $this->strategy->getTemplate());
    }

    /**
     * @covers \TocatUser\View\UnauthorizedStrategy::onDispatchError
     */
    public function testOnDispatchErrorWithGenericUnAuthorizedException()
    {
        $exception = $this->getMock('BjyAuthorize\\Exception\\UnAuthorizedException');
        $viewModel = $this->getMock('Zend\\View\\Model\\ModelInterface');
        $mvcEvent = $this->getMock('Zend\\Mvc\\MvcEvent');

        $mvcEvent->expects($this->any())->method('getError')->will($this->returnValue(Application::ERROR_EXCEPTION));
        $mvcEvent->expects($this->any())->method('getViewModel')->will($this->returnValue($viewModel));
        $mvcEvent
            ->expects($this->any())
            ->method('getParam')
            ->will(
                $this->returnCallback(
                    function ($name) use ($exception) {
                        return $name === 'exception' ? $exception : null;
                    }
                )
            );

        $test = $this;

        $viewModel
            ->expects($this->any())
            ->method('addChild')
            ->will(
                $this->returnCallback(
                    function (ModelInterface $model) use ($test) {
                        // using a return callback because of a bug in HHVM
                        if ('template/name' !== $model->getTemplate()) {
                            throw new \UnexpectedValueException('Template name does not match expectations!');
                        }
                    }
                )
            );
        $mvcEvent
            ->expects($this->any())
            ->method('setResponse')
            ->will(
                $this->returnCallback(
                    function (Response $response) use ($test) {
                        // using a return callback because of a bug in HHVM
                        if (403 !== $response->getStatusCode()) {
                            throw new \UnexpectedValueException('Response code not match expectations!');
                        }
                    }
                )
            );

        $this->assertNull($this->strategy->onDispatchError($mvcEvent));
    }

    /**
     * @covers \TocatUser\View\UnauthorizedStrategy::onDispatchError
     */
    public function testIgnoresUnknownExceptions()
    {
        $exception = $this->getMock('Exception');
        $viewModel = $this->getMock('Zend\\View\\Model\\ModelInterface');
        $mvcEvent = $this->getMock('Zend\\Mvc\\MvcEvent');

        $mvcEvent->expects($this->any())->method('getError')->will($this->returnValue(Application::ERROR_EXCEPTION));
        $mvcEvent->expects($this->any())->method('getViewModel')->will($this->returnValue($viewModel));
        $mvcEvent
            ->expects($this->any())
            ->method('getParam')
            ->will(
                $this->returnCallback(
                    function ($name) use ($exception) {
                        return $name === 'exception' ? $exception : null;
                    }
                )
            );

        $viewModel->expects($this->never())->method('addChild');
        $mvcEvent->expects($this->never())->method('setResponse');

        $this->assertNull($this->strategy->onDispatchError($mvcEvent));
    }

    /**
     * @covers \TocatUser\View\UnauthorizedStrategy::onDispatchError
     */
    public function testIgnoresUnknownErrors()
    {
        $viewModel = $this->getMock('Zend\\View\\Model\\ModelInterface');
        $mvcEvent = $this->getMock('Zend\\Mvc\\MvcEvent');

        $mvcEvent->expects($this->any())->method('getError')->will($this->returnValue('unknown'));
        $mvcEvent->expects($this->any())->method('getViewModel')->will($this->returnValue($viewModel));

        $viewModel->expects($this->never())->method('addChild');
        $mvcEvent->expects($this->never())->method('setResponse');

        $this->assertNull($this->strategy->onDispatchError($mvcEvent));
    }

    /**
     * @covers \TocatUser\View\UnauthorizedStrategy::onDispatchError
     */
    public function testIgnoresOnExistingResponse()
    {
        $response = $this->getMock('Zend\\Stdlib\\ResponseInterface');
        $viewModel = $this->getMock('Zend\\View\\Model\\ModelInterface');
        $mvcEvent = $this->getMock('Zend\\Mvc\\MvcEvent');

        $mvcEvent->expects($this->any())->method('getResult')->will($this->returnValue($response));
        $mvcEvent->expects($this->any())->method('getViewModel')->will($this->returnValue($viewModel));

        $viewModel->expects($this->never())->method('addChild');
        $mvcEvent->expects($this->never())->method('setResponse');

        $this->assertNull($this->strategy->onDispatchError($mvcEvent));
    }

    /**
     * @covers \TocatUser\View\UnauthorizedStrategy::onDispatchError
     * @covers \TocatUser\View\UnauthorizedStrategy::setRedirectRoute
     * @covers \TocatUser\View\UnauthorizedStrategy::setRedirectUri
     */
    public function testWillRedirectToRouteOnSetRoute()
    {
        $this->strategy->setRedirectRoute('redirect/route');
        $this->strategy->setRedirectUri(null);

        $mvcEvent = $this->getMock('Zend\\Mvc\\MvcEvent');
        $response = $this->getMock('Zend\\Http\\Response');
        $routeMatch = $this->getMock('Zend\\Mvc\\Router\\RouteMatch', array(), array(), '', false);
        $route = $this->getMock('Zend\\Mvc\\Router\\RouteInterface');
        $headers = $this->getMock('Zend\\Http\\Headers');

        $mvcEvent->expects($this->any())->method('getResponse')->will($this->returnValue($response));
        $mvcEvent->expects($this->any())->method('getRouteMatch')->will($this->returnValue($routeMatch));
        $mvcEvent->expects($this->any())->method('getRouter')->will($this->returnValue($route));
        $mvcEvent->expects($this->any())->method('getError')->will($this->returnValue(Route::ERROR));

        $application = $this->getMockBuilder('Zend\\Mvc\\Application')->disableOriginalConstructor()->getMock();
        $serviceLocator = $this->getMock('Zend\\ServiceManager\\ServiceLocatorInterface');
        $identityProvider = $this->getMock('BjyAuthorize\\Provider\\Identity\\ProviderInterface');
        $identityProvider->expects($this->any())->method('getIdentityRoles')->will($this->returnValue([
            'guest',
            'test'
        ]));
        $serviceLocator->expects($this->at(0))->method('get')
            ->with('BjyAuthorize\\Provider\\Identity\\ProviderInterface')->will($this->returnValue($identityProvider));
        $serviceLocator->expects($this->at(1))->method('get')->with('BjyAuthorize\Config')
            ->will($this->returnValue(['template' => 'test']));
        $application->expects($this->any())->method('getServiceManager')->will($this->returnValue($serviceLocator));
        $mvcEvent->expects($this->any())->method('getParam')->with('application')
            ->will($this->returnValue($application));

        $response->expects($this->any())->method('getHeaders')->will($this->returnValue($headers));
        $response->expects($this->once())->method('setStatusCode')->with(302);

        $headers->expects($this->once())->method('addHeaderLine')->with('Location', 'http://www.example.org/');

        $route
            ->expects($this->any())
            ->method('assemble')
            ->with(array(), array('name' => 'redirect/route'))
            ->will($this->returnValue('http://www.example.org/'));

        $mvcEvent->expects($this->once())->method('setResponse')->with($response);

        $this->strategy->onDispatchError($mvcEvent);
    }

    /**
     * @covers \TocatUser\View\UnauthorizedStrategy::onDispatchError
     * @covers \TocatUser\View\UnauthorizedStrategy::setRedirectUri
     */
    public function testWillRedirectToRouteOnSetUri()
    {
        $this->strategy->setRedirectUri('http://www.example.org/');

        $mvcEvent = $this->getMock('Zend\\Mvc\\MvcEvent');
        $response = $this->getMock('Zend\\Http\\Response');
        $routeMatch = $this->getMock('Zend\\Mvc\\Router\\RouteMatch', array(), array(), '', false);
        $route = $this->getMock('Zend\\Mvc\\Router\\RouteInterface');
        $headers = $this->getMock('Zend\\Http\\Headers');

        $mvcEvent->expects($this->any())->method('getResponse')->will($this->returnValue($response));
        $mvcEvent->expects($this->any())->method('getRouteMatch')->will($this->returnValue($routeMatch));
        $mvcEvent->expects($this->any())->method('getRouter')->will($this->returnValue($route));
        $mvcEvent->expects($this->any())->method('getError')->will($this->returnValue(Route::ERROR));

        $application = $this->getMockBuilder('Zend\\Mvc\\Application')->disableOriginalConstructor()->getMock();
        $serviceLocator = $this->getMock('Zend\\ServiceManager\\ServiceLocatorInterface');
        $identityProvider = $this->getMock('BjyAuthorize\\Provider\\Identity\\ProviderInterface');
        $identityProvider->expects($this->any())->method('getIdentityRoles')->will($this->returnValue([
                    'guest',
                    'test'
                ]));
        $serviceLocator->expects($this->at(0))->method('get')
            ->with('BjyAuthorize\\Provider\\Identity\\ProviderInterface')->will($this->returnValue($identityProvider));
        $serviceLocator->expects($this->at(1))->method('get')->with('BjyAuthorize\Config')
            ->will($this->returnValue(['template' => 'test']));
        $application->expects($this->any())->method('getServiceManager')->will($this->returnValue($serviceLocator));
        $mvcEvent->expects($this->any())->method('getParam')->with('application')
            ->will($this->returnValue($application));

        $response->expects($this->any())->method('getHeaders')->will($this->returnValue($headers));
        $response->expects($this->once())->method('setStatusCode')->with(302);

        $headers->expects($this->once())->method('addHeaderLine')->with('Location', 'http://www.example.org/');

        $mvcEvent->expects($this->once())->method('setResponse')->with($response);

        $this->strategy->onDispatchError($mvcEvent);
    }

    /**
     * @covers \TocatUser\View\UnauthorizedStrategy::onDispatchError
     * @covers \TocatUser\View\UnauthorizedStrategy::setRedirectUri
     */
    public function testWillRedirectToRouteOnSetUriWithApplicationError()
    {
        $this->strategy = new UnauthorizedStrategy('template/name');
        $this->strategy->setRedirectUri('http://www.example.org/');

        $mvcEvent = $this->getMock('Zend\\Mvc\\MvcEvent');
        $response = $this->getMock('Zend\\Http\\Response');
        $routeMatch = $this->getMock('Zend\\Mvc\\Router\\RouteMatch', array(), array(), '', false);
        $route = $this->getMock('Zend\\Mvc\\Router\\RouteInterface');
        $headers = $this->getMock('Zend\\Http\\Headers');
        $exception = $this->getMock('BjyAuthorize\\Exception\\UnAuthorizedException');


        $mvcEvent->expects($this->any())->method('getResponse')->will($this->returnValue($response));
        $mvcEvent->expects($this->any())->method('getRouteMatch')->will($this->returnValue($routeMatch));
        $mvcEvent->expects($this->any())->method('getRouter')->will($this->returnValue($route));
        $mvcEvent->expects($this->any())->method('getError')->will($this->returnValue(Application::ERROR_EXCEPTION));
        //$mvcEvent->expects($this->exactly(2))->method('getParam')->with('exception')->will($this->returnValue($exception));

        $application = $this->getMockBuilder('Zend\\Mvc\\Application')->disableOriginalConstructor()->getMock();
        $serviceLocator = $this->getMock('Zend\\ServiceManager\\ServiceLocatorInterface');
        $identityProvider = $this->getMock('BjyAuthorize\\Provider\\Identity\\ProviderInterface');
        $identityProvider->expects($this->any())->method('getIdentityRoles')->will($this->returnValue([
                    'guest',
                    'test'
                ]));
        $serviceLocator->expects($this->at(0))->method('get')
            ->with('BjyAuthorize\\Provider\\Identity\\ProviderInterface')->will($this->returnValue($identityProvider));
        $serviceLocator->expects($this->at(1))->method('get')->with('BjyAuthorize\Config')
            ->will($this->returnValue(['template' => 'test']));
        $application->expects($this->any())->method('getServiceManager')->will($this->returnValue($serviceLocator));

        $mvcEvent
            ->expects($this->any())
            ->method('getParam')
            ->will(
                $this->returnCallback(
                    function ($name) use ($exception, $application) {
                        return $name === 'exception' ? $exception : $application;
                    }
                )
            );


        $response->expects($this->any())->method('getHeaders')->will($this->returnValue($headers));
        $response->expects($this->once())->method('setStatusCode')->with(302);

        $headers->expects($this->once())->method('addHeaderLine')->with('Location', 'http://www.example.org/');

        $mvcEvent->expects($this->once())->method('setResponse')->with($response);

        $this->strategy->onDispatchError($mvcEvent);
    }
}
