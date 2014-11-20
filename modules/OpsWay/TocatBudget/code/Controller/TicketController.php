<?php

namespace OpsWay\TocatBudget\Controller;

use OpsWay\TocatBudget\Entity\Budget;
use OpsWay\TocatBudget\Entity\Issue;
use OpsWay\TocatBudget\Entity\Order;
use OpsWay\TocatBudget\Entity\Recipient;
use OpsWay\TocatBudget\Service\MyService;
use OpsWay\TocatUser\Entity\Account;
use OpsWay\TocatUser\Entity\User;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\JsonModel;
use Zend\View\Model\ViewModel;

class TicketController extends AbstractActionController
{
    /**
     * @var MyService
     */
    private $service;

    public function __construct($service)
    {
        $this->service = $service;
    }

    public function indexAction()
    {
        /*$em = $this->getServiceLocator()->get('doctrine.entitymanager.orm_default');
        $userRepo = $em->getRepository(User::class);
        $user = $userRepo->find(7);
        $rec = new Recipient();
        $rec->setAccount((new Account())->setUser($user)->setBalance(0));
        $rec->setPerOfCom(100);
        $issue = new Issue();
        $issue->setReferenceId(10000)->setName('Test ticket')->setStatus('New')->setAccept(false);
        $issue->addRecipient($rec);

        $order = new Order();
        $order->setName('Test Order');
        $order->setTotalAmount(1000);

        $budget = new Budget();
        $budget->setIssue($issue);
        $budget->setOrder($order);
        $budget->setCost(100);

        $em->persist($budget);
        $em->flush();*/

        return new ViewModel(['variable' => 'value']);
    }

    public function otherAction()
    {
        return new ViewModel(['count_row_in_service' => count($this->service->getList())]);
    }

    public function jsonAction()
    {
        $issues = $this->service->getAll();
        $list = [];
        foreach ($issues as $issue){
            $arr = $this->service->getRepo()->extract($issue);
            $arr['budgets'] = $issue->getTotalCost();
            $list[] = $arr;
        }
        return new JsonModel(
            $list
        );
    }
}
