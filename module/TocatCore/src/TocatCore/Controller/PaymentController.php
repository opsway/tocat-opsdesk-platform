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
use Zend\Db\Sql\Expression;
use Zend\Db\Sql\Select;

class PaymentController extends AbstractActionController
{

    public function indexAction()
    {
        $tx = $this->getServiceLocator()->get('TocatCore\Model\TransactionsTableGateway');
 
        return new ViewModel(
            array(
                'tx' => $tx->select(),
            ));
    }
    
    public function createAction()
    {
        $tx = $this->getServiceLocator()->get('TocatCore\Model\TransactionsTableGateway');
        if ($this->getRequest()->isPost()){
            $post = $this->getRequest()->getPost();
                unset($post['uid']);
                $tx->insert((array)$post);
            }
            return $this->redirect()->toRoute('payment');
    }
}