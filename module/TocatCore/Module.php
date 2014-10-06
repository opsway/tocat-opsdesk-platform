<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace TocatCore;

use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;
use Zend\Db\TableGateway;

class Module
{
    public function onBootstrap(MvcEvent $e)
    {
        $eventManager        = $e->getApplication()->getEventManager();
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);
    }

    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }

    public function getServiceConfig()
    {
        return array(
            'factories' => array(
                'TocatCore\Model\ProjectTableGateway' => $this->getCallbackTableInstance('project'),
                'TocatCore\Model\TicketTableGateway' => $this->getCallbackTableInstance('ticket'),
                'TocatCore\Model\OrderTableGateway' => $this->getCallbackTableInstance('order'),
                'TocatCore\Model\OrderTicketTableGateway' => $this->getCallbackTableInstance('order_ticket'),
                'TocatCore\Model\OrderProjectTableGateway' => $this->getCallbackTableInstance('order_project'),
                'TocatCore\Model\TransactionsTableGateway' => $this->getCallbackTableInstance('transactions'),
                'TocatCore\Model\UsersTableGateway' => $this->getCallbackTableInstance('users'),
                'TocatCore\Model\AccountsTableGateway' => $this->getCallbackTableInstance('accounts'),
            ),
        );
    }

    public function getCallbackTableInstance($name){
        return function($sm) use ($name) {
            $dbAdapter = $sm->get('dbBase');
            $table = new TableGateway\TableGateway($name, $dbAdapter);
            return $table;
        };
    }
}
