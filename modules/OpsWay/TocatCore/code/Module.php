<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace OpsWay\TocatCore;

use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;
use Zend\Db\TableGateway;
use Zend\View\Helper\Navigation as ZendViewHelperNavigation;

class Module
{
    public function onBootstrap(MvcEvent $e)
    {
        $eventManager = $e->getApplication()->getEventManager();
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);
        if (\Zend\Console\Console::isConsole()) {
            return;
        }
        $sm = $e->getApplication()->getServiceManager();
        // Add ACL information to the Navigation view helper
        $authorize = $sm->get('BjyAuthorizeServiceAuthorize');
        $acl = $authorize->getAcl();
        $role = $authorize->getIdentity();
        ZendViewHelperNavigation::setDefaultAcl($acl);
        ZendViewHelperNavigation::setDefaultRole($role);
    }

    public function getConfig()
    {
        return include __DIR__ . '/../config/module.config.php';
    }

    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__,
                ),
            ),
        );
    }

    public function getServiceConfig()
    {
        return array(
            'factories' => array(
                'OpsWay\TocatCore\Model\ProjectTableGateway'      => $this->getCallbackTableInstance('project'),
                'OpsWay\TocatCore\Model\TicketTableGateway'       => $this->getCallbackTableInstance('ticket'),
                'OpsWay\TocatCore\Model\OrderTableGateway'        => $this->getCallbackTableInstance('order'),
                'OpsWay\TocatCore\Model\OrderTicketTableGateway'  => $this->getCallbackTableInstance('order_ticket'),
                'OpsWay\TocatCore\Model\OrderProjectTableGateway' => $this->getCallbackTableInstance('order_project'),
                'OpsWay\TocatCore\Model\TransactionsTableGateway' => $this->getCallbackTableInstance('transactions'),
                'OpsWay\TocatCore\Model\UsersTableGateway'        => $this->getCallbackTableInstance('users'),
                'OpsWay\TocatCore\Model\AccountsTableGateway'     => $this->getCallbackTableInstance('accounts'),
            ),
        );
    }

    public function getCallbackTableInstance($name)
    {
        return function ($sm) use ($name) {
            $dbAdapter = $sm->get('dbBase');
            $table = new TableGateway\TableGateway($name, $dbAdapter);
            return $table;
        };
    }
}
