<?php
namespace OpsWay\TocatApi\V1\Rpc\GetBudget;

use Zend\Mvc\Controller\AbstractActionController;
use ZF\ApiProblem\ApiProblemResponse;
use ZF\ContentNegotiation\ViewModel;
use ZF\ApiProblem\ApiProblem;
use Zend\Db\Sql\Expression;
use Zend\Db\Sql\Select;
use Zend\Json\Json;
use Redmine\Client;

class GetBudgetController extends AbstractActionController
{
    public function getBudgetAction()
    {
        $params = Json::decode($this->getRequest()->getContent(), Json::TYPE_ARRAY);
        $config = $this->getServiceLocator()->get('Config');
        $redmine = new Client($config['redmine']['url'], $config['redmine']['api_access_key']);

        switch ($params['type']) {
            case 'project':
                $project = $this->getServiceLocator()->get('TocatCore\Model\ProjectTableGateway');
                $rowset = $project->select(array('project_id' => $params['id']));
                if (count($rowset) < 1) {
                    //return new ApiProblemResponse(new ApiProblem(404, 'Not Found'));
                    $project->insert(array('project_id' => $params['id']));
                    $rowset = $project->select(array('project_id' => $params['id']));
                }
                $order = $this->getServiceLocator()->get('TocatCore\Model\OrderTableGateway');
                $orderList = $order->select(function (Select $select) use ($rowset) {
                    $select->columns(array('totalBudget' => new Expression('SUM(order.budget)')));
                    $select->join('order_project', 'order_project.order_uid = order.uid', array());
                    $select->where(array('order_project.uid' => $rowset->current()->uid));
                    $select->group('order_project.uid');
                });

                return new ViewModel((array) $rowset->current() + (array) $orderList->current());
            break;
            case 'ticket':
            default:
                $ticket = $this->getServiceLocator()->get('TocatCore\Model\TicketTableGateway');
                $rowset = $ticket->select(array('ticket_id' => $params['id']));
                if (count($rowset) < 1) {
                    //return new ApiProblemResponse(new ApiProblem(404, 'Not Found'));
                    $ticket->insert(array('ticket_id' => $params['id']));
                    $rowset = $ticket->select(array('ticket_id' => $params['id']));
                }
                $order = $this->getServiceLocator()->get('TocatCore\Model\OrderTableGateway');
                $orderList = $order->select(function (Select $select) use ($rowset) {
                    $select->columns(array('totalBudget' => new Expression('SUM(order.budget)')));
                    $select->join('order_ticket', 'order_ticket.order_uid = order.uid', array());
                    $select->where(array('order_ticket.ticket_uid' => $rowset->current()->uid));
                    $select->group('order_ticket.ticket_uid');
                });

                return new ViewModel((array) $rowset->current() + (array) $orderList->current());
             break;

        }

    }
}
