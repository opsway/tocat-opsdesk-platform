<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace OpsWay\TocatUser\Controller\Admin;

use Herrera\Json\Exception\Exception;
use OpsWay\TocatUser\Service\PermissionService;
use OpsWay\TocatUser\Service\RoleService;
use Zend\Json\Json;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\JsonModel;
use Zend\View\Model\ViewModel;

class PermissionController extends AbstractActionController
{
    /**
     * @var PermissionService
     */
    private $service;

    public function __construct($service)
    {
        $this->service = $service;
    }

    public function indexAction()
    {
        return new ViewModel();
    }

    public function pagesAction()
    {
        /**
         * @var RoleService $serviceRole
         */
        $serviceRole = $this->getServiceLocator()->get(RoleService::class);
        if ($this->getRequest()->isPost()) {
            $data = $this->params()->fromPost();
            $roleId = (int)$data['role_id'];
            try {
                $roleEntity = $serviceRole->getById($roleId);
                $this->service->updateAclByRole($roleEntity, $data['acl'], PermissionService::TYPE_GUARD);
                $this->flashMessenger()->addSuccessMessage('Permissions was saved.');
            } catch (\Exception $e) {
                $this->flashMessenger()->addErrorMessage($e->getMessage());
            }
            return $this->redirect()->toRoute('zfcadmin/permission', ['action' => 'pages', 'role_id' => $roleId]);
        }
        $roleId = $this->params('role_id', null);
        $staticResources = [];
        if ($roleId) {
            $staticResources = $this->service->getAllStaticControllerGuard();
        }

        return new ViewModel([
            'role_id'    => $roleId,
            'listRole'   => $serviceRole->getList(true),
            'staticList' => $staticResources,
            'isAccessed' => [$this->service->getIsAccessedCallback($roleId)]
        ]);
    }

    public function resourceAction()
    {
        return new ViewModel();
    }
}
