<?php

namespace OpsWay\TocatBudget\Controller;

use OpsWay\TocatBudget\Service\MyService;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\JsonModel;
use Zend\View\Model\ViewModel;

class OtherController extends AbstractActionController
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
        return new ViewModel(['variable' => 'value']);
    }

    public function otherAction()
    {
        return new ViewModel(['count_row_in_service' => count($this->service->getList())]);
    }

    public function jsonAction()
    {
        return new JsonModel(
            ['id' => 1, 'name' => 'name']
        );
    }
}
