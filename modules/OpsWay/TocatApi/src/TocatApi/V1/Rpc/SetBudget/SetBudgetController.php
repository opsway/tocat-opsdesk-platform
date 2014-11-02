<?php
namespace OpsWay\TocatApi\V1\Rpc\SetBudget;

use Zend\Mvc\Controller\AbstractActionController;
use ZF\ApiProblem\ApiProblemResponse;
use ZF\ContentNegotiation\ViewModel;
use ZF\ApiProblem\ApiProblem;
use Zend\Db\Sql\Expression;
use Zend\Db\Sql\Select;
use Zend\Json\Json;

class SetBudgetController extends AbstractActionController
{
    public function setBudgetAction()
    {
        $params = Json::decode($this->getRequest()->getContent(), Json::TYPE_ARRAY);

        switch ($params['type']) {
            case 'project':
                return new ApiProblemResponse(new ApiProblem(406, 'Not Implemented'));

            break;
            case 'ticket':
            default:
                $ticket = $this->getServiceLocator()->get('TocatCore\Model\TicketTableGateway');
                $rowset = $ticket->select(array('ticket_id' => $params['id']));
                if (count($rowset) < 1) {
                    return new ApiProblemResponse(new ApiProblem(404, 'Not Found'));
                }
                $order = $this->getServiceLocator()->get('TocatCore\Model\OrderTableGateway');
                $orderList = $order->select(function (Select $select) use ($rowset) {
                    $select->columns(array('totalBudget' => new Expression('SUM(order.budget)')));
                    $select->join('order_ticket', 'order_ticket.order_uid = order.uid', array());
                    $select->where(array('order_ticket.uid' => $rowset->current()->uid));
                    $select->group('order_ticket.uid');
                });
                if ($params['budget'] > $orderList->current()->totalBudget) {
                    return new ApiProblemResponse(new ApiProblem(406, 'Budget value bigger then total budget'));
                }
                $ticket->update(array('budget' => $params['budget']), array('uid' => $rowset->current()->uid));
                $rowset = $ticket->select(array('ticket_id' => $params['id']));

                return new ViewModel((array) $rowset->current() + (array) $orderList->current());
                break;

        }
    }
}
