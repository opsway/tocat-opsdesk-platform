<?php

namespace OpsWay\TocatBudget\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\JsonModel;
use Zend\View\Model\ViewModel;

class IndexController extends AbstractActionController
{

    public function indexAction()
    {
        return new ViewModel(['my_variable' => 'value']);
    }

    public function otherAction()
    {
        return new ViewModel(['count' => 2]);
    }

    public function jsonAction()
    {
        return new JsonModel(
            ['id' => 1, 'name' => 'name']
        );
    }
}
