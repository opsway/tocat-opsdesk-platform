<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace OpsWay\TocatCore\Controller;

use Herrera\Json\Exception\Exception;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Db\Sql\Expression;
use Zend\Db\Sql\Select;
use Redmine\Client;

class IndexController extends AbstractActionController
{
    public function indexAction()
    {
        $controllerManager = $this->getServiceLocator()->get('ControllerManager');
        $controllerConfig = $controllerManager->getRegisteredServices();
        $it = new \RecursiveIteratorIterator(
            new \RecursiveArrayIterator($controllerConfig)
        );
        $test = (iterator_to_array($it, false));
        $result = [];
        foreach ($test as $controllerName2) {

            $c = array_search($controllerName2, $controllerManager->getCanonicalNames());
            if ($c) {
                $controllerName = $c;
            } else {
                $controllerName = $controllerName2;
            }
            try {
                $controller = $controllerManager->get($controllerName2);
            } catch (\Exception $e) {
                $result[$controllerName] = [];
                continue;
            }
            $reflection = new \ReflectionObject($controller);
            $methods = $reflection->getMethods(\ReflectionMethod::IS_PUBLIC);
            $result[$controllerName] = array_map(
                function ($action) {
                    return str_replace('Action', '', $action);
                },
                array_filter(
                    array_map(function ($method) {
                        return $method->name;
                    }, $methods),
                    function ($action) {
                        if ($action === 'getMethodFromAction') {
                            return false;
                        }
                        return (strpos($action, 'Action') !== false);
                    }
                )
            );
        }
        $test = $result;
        $match = $this->getEvent()->getRouteMatch();
        $controller = $match->getParam('controller');
       // $test = ($controllerManager->getCanonicalNames());
        /*$order = $this->getServiceLocator()->get('OpsWay\TocatCore\Model\OrderTableGateway');
        $config = $this->getServiceLocator()->get('Config');
        $redmine = new Client($config['redmine']['url'], $config['redmine']['api_access_key']);

        $project = array();
        $limitClosure = function (Select $select) {
            $select->limit(5);
        };
        foreach ($this->getServiceLocator()->get('OpsWay\TocatCore\Model\ProjectTableGateway')->select($limitClosure) as $row) {
            $res = $redmine->api('project')->show($row->project_id);
            $projectBudget = $order->select(function (Select $select) use ($row) {
                $select->columns(array('totalBudget' => new Expression('SUM(order.budget)')));
                $select->join('order_project', 'order_project.order_uid = order.uid', array());
                $select->where(array('order_project.uid' => $row->uid));
                $select->group('order_project.uid');
            });
            $orderList = $order->select(function (Select $select) use ($row) {
                $select->join('order_project', 'order_project.order_uid = order.uid', array());
                $select->join('project', 'order_project.project_uid = project.uid');
                $select->where(array('project.uid' => $row->uid));
                $select->quantifier('DISTINCT');
            });
            $project[] = (object) ((array) $row + $res + (array) $projectBudget->current()
                + array('listOrders' => iterator_to_array($orderList)));
        }

        $ticket = array();
        foreach ($this->getServiceLocator()->get('OpsWay\TocatCore\Model\TicketTableGateway')->select($limitClosure) as $row) {
            $res = $redmine->api('issue')->show($row->ticket_id);
            $ticketTotalBudget = $order->select(function (Select $select) use ($row) {
                $select->columns(array('totalBudget' => new Expression('SUM(order.budget)')));
                $select->join('order_ticket', 'order_ticket.order_uid = order.uid', array());
                $select->where(array('order_ticket.ticket_uid' => $row->uid));
                $select->group('order_ticket.ticket_uid');
            });
            $orderList = $order->select(function (Select $select) use ($row) {
                $select->join('order_ticket', 'order_ticket.order_uid = order.uid', array());
                $select->join('ticket', 'order_ticket.ticket_uid = ticket.uid');
                $select->where(array('ticket.uid' => $row->uid));
                $select->quantifier('DISTINCT');
            });
            $ticket[] = (object) ((array) $row + $res + (array) $ticketTotalBudget->current()
                + array('listOrders' => iterator_to_array($orderList)));
        }

        return new ViewModel(
            array(
                'project'      => $project,
                'ticket'       => $ticket,
                'order'        => $order->select(),
                'orderTicket'  => $this->getServiceLocator()->get('OpsWay\TocatCore\Model\OrderTicketTableGateway')->select(),
                'orderProject' => $this->getServiceLocator()->get('OpsWay\TocatCore\Model\OrderProjectTableGateway')->select(),
                'test'         => $ticket
            )
        );*/
        return new ViewModel(['test'=>$test]);
    }

    public function orderAction()
    {
        $order = $this->getServiceLocator()->get('OpsWay\TocatCore\Model\OrderTableGateway');
        if ($this->getRequest()->isPost()) {
            $post = $this->getRequest()->getPost();
            if (isset($post['action']) && $post['action'] == 'Delete') {
                $order->delete(array('uid' => $post['uid']));
            } else {
                unset($post['uid']);
                $order->insert((array) $post);
            }

            return $this->redirect()->toRoute('home');
        }
    }

    public function stubAction()
    {
        return new ViewModel(array('uid' => $this->params()->fromRoute('id')));
    }
}
