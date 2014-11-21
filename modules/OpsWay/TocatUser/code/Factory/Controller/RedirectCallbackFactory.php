<?php
namespace OpsWay\TocatUser\Factory\Controller;

use Zend\Mvc\Application;
use Zend\Mvc\Controller\ControllerManager;
use Zend\Mvc\Router\RouteInterface;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use ZfcUser\Options\ModuleOptions;

class RedirectCallbackFactory implements FactoryInterface
{
    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     *
     * @return UserAccountController
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        /* @var RouteInterface $router */
        $router = $serviceLocator->get('Router');

        /* @var Application $application */
        $application = $serviceLocator->get('Application');

        /* @var ModuleOptions $options */
        $options = $serviceLocator->get('zfcuser_module_options');

        return function () use ($router, $application, $options) {
            $routeMatch = $application->getMvcEvent()->getRouteMatch();
            $redirect = $router->assemble(array(), array('name' => 'zfcuser/account'));
            $response = $application->getResponse();
            $response->getHeaders()->addHeaderLine('Location', $redirect);
            $response->setStatusCode(302);
            return $response;
        };
    }
}
