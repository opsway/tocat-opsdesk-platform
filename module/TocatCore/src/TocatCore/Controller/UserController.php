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

class UserController extends AbstractActionController
{

    public function indexAction()
    {
        return new ViewModel();
    }


    public function loginAction()
    {
        $userService = $this->getServiceLocator()->get('TocatCore\Model\UsersTableGateway');
        $samlData = $_SESSION["samlUserdata"];
        if (isset($samlData['User.Username'][0]) && isset($samlData['User.email'][0])){
            //TODO Check that users exists in Redmine
            //TODO create group and link user to group
                $currentUser = $userService->select(array('email' => trim($samlData['User.email'][0])));
            if (!$currentUser->uid) {
                echo "No user!";
                $userService->insert(array("name" => $samlData['User.FirstName'][0] . " " . $samlData['User.LastName'][0],
                                     "email" => trim($samlData['User.email'][0])));
            } else {
                echo "Hello $currentUser->name !";
                die;
            }
            return $this->redirect()->toRoute('home');
        }
        return new ViewModel();
    }

}

