<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace TocatCore\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Db\Sql\Select;

class IndexController extends AbstractActionController
{
    public function indexAction()
    {
        //$order = $this->getServiceLocator()->get('TocatCore\Model\OrderTableGateway');
        //$order->insert(array('name' => 'Create TOCAT redmine plugin', 'budget' => 120));

        return new ViewModel(
            array(
                'project' => $this->getServiceLocator()->get('TocatCore\Model\ProjectTableGateway')->select(),
                'ticket' => $this->getServiceLocator()->get('TocatCore\Model\TicketTableGateway')->select(),
                'order' => $this->getServiceLocator()->get('TocatCore\Model\OrderTableGateway')->select(),
                'orderTicket' => $this->getServiceLocator()->get('TocatCore\Model\OrderTicketTableGateway')->select(),
                'orderProject' => $this->getServiceLocator()->get('TocatCore\Model\OrderProjectTableGateway')->select(),
            ));
    }
}
