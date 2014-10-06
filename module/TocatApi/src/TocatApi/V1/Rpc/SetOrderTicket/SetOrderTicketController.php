<?php
namespace TocatApi\V1\Rpc\SetOrderTicket;

use Zend\Mvc\Controller\AbstractActionController;
use ZF\ApiProblem\ApiProblemResponse;
use ZF\ContentNegotiation\ViewModel;
use ZF\ApiProblem\ApiProblem;
use Zend\Db\Sql\Expression;
use Zend\Db\Sql\Select;
use Zend\Json\Json;

class SetOrderTicketController extends AbstractActionController
{
    public function setOrderTicketAction()
    {
        $params = Json::decode($this->getRequest()->getContent(),Json::TYPE_ARRAY);
        $ticket = $this->getServiceLocator()->get('TocatCore\Model\TicketTableGateway');
        $rowset = $ticket->select(array('ticket_id' => $params['ticket_id']));
        if (count($rowset) < 1) {
            return new ApiProblemResponse(new ApiProblem(404, 'Not Found'));
        }
        $orderTicket = $this->getServiceLocator()->get('TocatCore\Model\OrderTicketTableGateway');
        switch ($params['method']){
            case 'DELETE':
            {
                $orderTicket->delete(array('ticket_uid' => $rowset->current()->uid, 'order_uid' => $params['order_uid']));
            } break;
            case 'INSERT':
            default:
            {
                $orderTicket->insert(array('ticket_uid' => $rowset->current()->uid, 'order_uid' => $params['order_uid']));
            } break;
        }

        
        return new ViewModel(array('result' => true));
    }
}
