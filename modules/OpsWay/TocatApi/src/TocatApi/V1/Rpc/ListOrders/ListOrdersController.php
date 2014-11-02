<?php
namespace OpsWay\TocatApi\V1\Rpc\ListOrders;

use Zend\Mvc\Controller\AbstractActionController;
use ZF\ApiProblem\ApiProblemResponse;
use ZF\ContentNegotiation\ViewModel;
use ZF\ApiProblem\ApiProblem;
use Zend\Db\Sql\Select;
use Zend\Json\Json;

class ListOrdersController extends AbstractActionController
{
    public function listOrdersAction()
    {
        $params = Json::decode($this->getRequest()->getContent(), Json::TYPE_ARRAY);
        $order = $this->getServiceLocator()->get('TocatCore\Model\OrderTableGateway');
        if (empty($params)) {
            return new ViewModel(iterator_to_array($order->select()));
        }
        if (isset($params['ticket_id'])) {
            $rowset = $order->select(function (Select $select) use ($params) {
                $select->join('order_ticket', 'order_ticket.order_uid = order.uid', array());
                $select->join('ticket', 'order_ticket.ticket_uid = ticket.uid', array());
                $select->where(array('ticket.ticket_id' => $params['ticket_id']));
                $select->quantifier('DISTINCT');
            });
            return new ViewModel(iterator_to_array($rowset));
        }
        if (isset($params['project_id'])) {
            $rowset = $order->select(function (Select $select) use ($params) {
                $select->join('order_project', 'order_project.order_uid = order.uid', array());
                $select->join('project', 'order_project.project_uid = project.uid');
                $select->where(array('project.project_id' => $params['project_id']));
                $select->quantifier('DISTINCT');
            });
            return new ViewModel(iterator_to_array($rowset));
        }
    }
}
