<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace OpsWay\TocatUser\Controller;

use DoctrineModule\Stdlib\Hydrator\DoctrineObject;
use OpsWay\TocatUser\Entity\User;
use OpsWay\TocatUser\Service\UserAccountService;
use Zend\Json\Json;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\JsonModel;
use Zend\View\Model\ViewModel;

class UserAccountController extends AbstractActionController
{
    /**
     * @var UserAccountService
     */
    private $service;

    public function __construct($service)
    {
        $this->service = $service;
    }

    public function indexAction()
    {
        $user = $this->zfcUserAuthentication()->getIdentity();
        return new ViewModel(['user' => $user]);
    }

    public function loadAction()
    {
        $userId = $this->params()->fromRoute('user_id');
        $em = $this->getServiceLocator()->get('doctrine.entitymanager.orm_default');
        $userRepository = $em->getRepository(User::class);
        $user = $userRepository->find($userId);
        $hydrator = new DoctrineObject($em, User::class);
        return new JsonModel($hydrator->extract($user));
    }
}
